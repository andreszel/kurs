<h2>Games list</h2>

<table class="table" border="1" width="100%">
<tr>
            <th>Name</th>
            <th>Number left</th>
        </tr>
    @foreach($games AS $game)
        <tr>
            <td>{{ $game['name'] }}</td>
            <td>{{ $game['copies'] }}</td>
        </tr>
    @endforeach
</table>