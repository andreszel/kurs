<tr id="row-idx-{{ $loop->index }}">
    <td>{{ $loop->iteration }}</td>
    <td>{{ $userData['id'] }}</td>
    <td>{{ $userData['name'] }}</td>
    <td>
        <a href="{{ route('get.user.show', [
                'userId' => $userData['id']
            ])
        }}">Szczegóły</a>
    </td>
</tr>