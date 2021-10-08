<?php

namespace App\Console\Commands\Steam;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\Factory;

class LoadGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'steam:load-games {steep=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load steam games';

    private Factory $httpClient;

    // ścieżka, gdzie będzie zapisywany plik z grami
    private string $temporaryGamesList = './storage/app/steam';

    private array $genres = [];
    private array $publishers = [];
    private array $developers = [];

    public function __construct(Factory $httpClient)
    {
        parent::__construct();
        $this->httpClient = $httpClient;
    }

    private function loadGameList(): void
    {
        //pobieramy url
        $steamAllGamesUrl = config('steam.api.games.all');
        //pobieramy jsona
        $response = $this->httpClient->get($steamAllGamesUrl);

        //jeżeli błąd przy pobieraniu
        if ($response->failed()) {
            $this->error('Request failed. Status code: ' . $response->status());
            exit;
        }

        //pobieramy jsona
        $responseContent = $response->json();
        //lista wszystkich gier
        $apps = $responseContent['applist']['apps'];
        $jsonApps = json_encode($apps);
        //zapis do pliku
        $res = file_put_contents($this->temporaryGamesList, $jsonApps);
        $this->info('LOADED!!!');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // https://partner.steamgames.com/doc/webapi_overview
        // https://partner.steamgames.com/doc/webapi/ISteamApps#GetAppList
        // https://store.steampowered.com/api/appdetails?appids=1095320
        // https://wiki.teamfortress.com/wiki/User:RJackson/StorefrontAPI#appdetails


        //pobieramy argment
        $steep = $this->argument('steep');
        //jeżeli krok === 1
        if ($steep == 1) {
            $this->loadGameList();
            return 0;
        }

        $gameList = file_get_contents($this->temporaryGamesList);
        $gameList = json_decode($gameList, true);

        //pobieramy listę gier, które znajdują się w naszej bazie danych
        // potrzebne jest to do sprawdzania później w pętki, czy dana gra jest już w naszej bazie danych
        // żeby jej nie dodawać
        // robimy tak, ponieważ skrypt pobiera 127 tyś gier, nie zrobić tego za jednym razem, jednego dnia itd., więc trzeba to robić na raty
        //pobieramy, spłaszczamy, robimy z tego tablicę
        $savedGames = DB::table('games')
            ->select('steam_appid')
            ->pluck('steam_appid')
            ->toArray();
        //przetasowanie
        $savedGames = array_flip($savedGames);

        //tutaj pobieramy dane o gratunkach do sprawdzania
        $genres = DB::table('genres')
            ->select()
            ->get()
            ->toArray();
        //przygotowujemy sobie gatunki, unique genre name, uzupełniamy właściwość tymczasową $this->genre[]
        foreach ($genres ?? [] as $row) {
            $this->genres[$row->id] = (array) $row;
        }

        //pasek postępu, argument to liczba do której będzie odliczanie
        $progressDb = $this->output->createProgressBar(count($gameList));

        foreach ($gameList as $row) {
            // {"appid":216938,"name":"Pieterw"}
            $appId = $row['appid'];

            //jeżeli gra już istnieje pomijamy, zwiększamy licznik, przechodzimy do następnego loopa
            if (array_key_exists($appId, $savedGames)) {
                $progressDb->advance();
                $this->info(' - ' . $appId);
                continue;
            }

            //kaganiec, żeby za szybko nie wyczerpać limitu
            sleep(1);

            // pobieramy szczegóły gry
            $steamGameDetailsUrl = config('steam.api.games.details');
            $response = $this->httpClient->get(
                $steamGameDetailsUrl, [
                    'appids' => $appId,
                    'l' => 'en'
                ]
            );

            if ($response->failed()) {
                $this->error("ERROR: Game: $appId HTTP Code {$response->status()}");
                continue;
            }

            //odczytujemy dane z jsona
            $data = $response->json();

            // jeżeli błąd
            if ($data[$row['appid']]['success'] === false) {
                $this->error("ERROR: Game: $appId Data is empty");
                continue;
            }

            try {
                //tworzymy grę, dodajemy do bazy
                $this->create($data);
            } catch (\Throwable $e) {
                dump($data);
                dump($e);
                continue;
            }

            //zwiększamy progress bar
            $progressDb->advance();
            $this->info(" - " . $appId . ": " .$data[$appId]['data']['name']);
        }

        $progressDb->finish();

        $this->info('End from DB');

        return 0;
    }

    private function create($data)
    {
        //wrzucamy wszystko w trasakcję bazodanową, żeby nie zapisywać danych szczątkowych
        $result = DB::transaction(function () use ($data) {

            //usuwamy pierwszy element tablicy
            $data = array_shift($data);
            if ($data['success'] !== true) {
                return;
            }

            $data = $data['data'];
            $game = [
                'steam_appid' => $data['steam_appid'],
                'relation_id' => !empty($data['fullgame']) ? (int) $data['fullgame']['appid'] : null,
                'name' => $data['name'],
                'type' => $data['type'],

                'description' => $data['detailed_description'],
                'short_description' => $data['short_description'],
                'about' => $data['about_the_game'],
                'image' => $data['header_image'],
                'website' => $data['website'],

                'price_amount' => $data['price_overview']['initial'] ?? null,
                'price_currency' => $data['price_overview']['currency'] ?? null,

                'metacritic_score' => $data['metacritic']['score'] ?? null,
                'metacritic_url' => $data['metacritic']['url'] ?? null,
                'release_date' => $data['release_date']['date'],
                'languages' => $data['supported_languages'] ?? null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            // dodajemy wpis i mamy ID
            $gameId = DB::table('games')->insertGetId($game);

            //sprawdzamy, czy istnieje gatunek w naszej bazie, jeżeli nie to dodajemy
            foreach ($data['genres'] ?? [] as $genre) {
                if (empty($this->genres[$genre['id']])) {
                    $genreData = [
                        'id' => $genre['id'],
                        'name' => $genre['description'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                    $result = DB::table('genres')->insert($genreData);
                    $this->genres[$genreData['id']] = $genreData;
                }

                //dodajemy info do tabeli pomocniczej
                DB::table('gameGenres')->insert([
                    'game_id' => $gameId,
                    'genre_id' => $genre['id']
                ]);
            }

            //sprawdzamy, czy istnieje w bazie wydawca
            foreach ($data['publishers'] ?? [] as $publisher) {
                if (empty($this->publishers[$publisher])) {
                    $publisherData = [
                        'name' => $publisher,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                    $publisherId = DB::table('publishers')->insertGetId($publisherData);
                    $publisherData['id'] = $publisherId;
                    $this->publishers[$publisher] = $publisherData;
                }

                $publisherId = $this->publishers[$publisher]['id'];

                //dodajemy do bazy info do tabeli łączącej
                DB::table('gamePublishers')->insert([
                    'game_id' => $gameId,
                    'publisher_id' => $publisherId
                ]);
            }

            //sprawdzamy, czy istnieje developer
            foreach ($data['developers'] ?? [] as $developer) {
                if (empty($this->developers[$developer])) {
                    $developerData = [
                        'name' => $developer,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                    $developerId = DB::table('developers')->insertGetId($developerData);
                    $developerData['id'] = $developerId;
                    $this->developers[$developer] = $developerData;
                }

                $developerId = $this->developers[$developer]['id'];

                DB::table('gameDevelopers')->insert([
                    'game_id' => $gameId,
                    'developer_id' => $developerId
                ]);
            }

            //dodajemy screenshots jeżeli jakieś są
            foreach ($data['screenshots'] ?? [] as $screenshot) {
                DB::table('screenshots')->insert([
                    'game_id' => $gameId,
                    'thumbnail' => $screenshot['path_thumbnail'],
                    'url' => $screenshot['path_full'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            // dodajemy filmy jeżeli jakieś są
            foreach ($data['movies'] ?? [] as $movie) {
                DB::table('movies')->insertOrIgnore([
                    'game_id' => $gameId,
                    'original_id' => $movie['id'],
                    'name' => $movie['name'],
                    'highlight' => $movie['highlight'],
                    'thumbnail' => $movie['thumbnail'],
                    'webm_480' => $movie['webm']['480'],
                    'webm_url' => $movie['webm']['max'],
                    'mp4_480' => $movie['mp4']['480'],
                    'mp4_url' => $movie['mp4']['max'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        });
    }
}
