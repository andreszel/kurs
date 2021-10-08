<?php

namespace App\Console\Commands\Steam;

use Illuminate\Console\Command;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Http;

class UpdateGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // argument opcjonalny
    //protected $signature = 'steam:update-game {game?}';
    // argument domyślny
    //protected $signature = 'steam:update-game {game=FIFA}';
    // argument wymagany
    protected $signature = 'steam:update-game {game}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Steam - update game';

    private Factory $httpClient;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Factory $httpClient)
    {
        $this->httpClient = $httpClient;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* $game = $this->argument('game');
        dump($game); */

        // pytanie do user_agent
        /* $answer  = $this->ask("Czy to Twoja ulubiona gra?");
        dump($answer);

        if($answer === 'Tak'){

        } */

        // czy dane operacji jest pewny, żeby to robić, czy chcesz
        /* $result = $this->confirm("Czy chcesz zaktualizować grę?");
        dump($result);

        if($result) {
            dump("Zrobiles to!");
        } */

        // prawilnym sposobem do zakomunikowania czegoś userowi to nie dump
        // metody dostępne do komunikatów to: line, info, comment, question, error
        // w tych metodach dodatkowo wyświetlany jest background

        /* $this->error('Error!');
        $this->question('Question');
        $this->comment('Comment');
        $this->info('Info :)');
        $this->line('Line'); */

        // Biblioteka http client, która umożliwia połączenie się z API, w naszym przypadku udostępnionym przez Steama, przez sieć
        // Kolejnym krokiem w definiowaniu naszej komendy będzie poznanie tej biblioteki
        // Ta biblioteka jest tak naprawdę nakładką Laravela na Guzzle, oryginalna biblioteka
        // Dzięki tej bibliotece możemy wysyłać pliki na serwer, pobierać pliki z serwera, możemy definiować nagłówki, które będą wysyłane na ten serwer.
        // Dzięki nagłówkom możemy używać autoryzacji poprzez tokeny OAuth, jwt, przeprowadzać procesy autentykacji, można zamokować zewnętrzne API
        // Dzięki temu możemy korzystać z wszystkich typów requestów do API
        // parametry to url i parametry query, które biblioteka dokleja do url, a następnie jest wywoływany
        // w odpowiedzi jest obiekt Illuminate\Http\Client\Response
        // obiekt udostępnia nam zbiór metod, poniżej najważniejsze
        /**
            $response->body() : string; //jeżeli odpowiedzią będzie html
            $response->json() : array|mixed; //jeżeli odpowiedzią będzie json
            $response->status() : int; //
            $response->ok() : bool; //czy powodzenie, kod z 200
            $response->successful() : bool;
            $response->failed() : bool;//requestzakończył się niepowodzeniem
            $response->serverError : bool;//kod z rodziny 500
            $response->clientError() : bool;//kod z rodziny 400
            $response->header($header) : string;//konkretny nagłówek - pobranie
            $response->headers() : array;//wszstkie nagłówki
         */
        // wywołanie takie jak pod spodem to jest wywołąnie poprzez Facade
        /* $response = Http::get('https://postman-echo.com/get', [
            'foo' => 'bar',
            'alpha' => 'omega'
        ]); */
        //możemy również zrobić dependency injection i użyć obiektu
        /* $response = $this->httpClient->get('https://postman-echo.com/get', [
            'foo' => 'bar',
            'alpha' => 'omega'
        ]); */
        // metoda POST oraz analogicznie pozostałe metody PUT, PATCH, DELETE itp
        $response = $this->httpClient->post('https://postman-echo.com/post', [
            'foo' => 'bar',
            'alpha' => 'omega',
            'post' => true
        ]);
        
        dump($response->status());
        dump($response->json());

        /* if($response->failed()) {
            $this->error("Error!");
        } */


        return 0;
    }
}
