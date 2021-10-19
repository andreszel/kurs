<tr id="row-idx-{{ $loop->index }}">
    <td>{{ $loop->iteration }}</td>
    <td>{{ $userData['id'] }}</td>
    <td>{{ $userData['name'] }}</td>
    <td>{{ $userData['email'] }}</td>
    <td>
        @can('view', $user)
            <a href="{{ route('get.user.show', [
                    'userId' => $userData['id']
                ])
            }}">Szczegóły</a>
        @endcan
    </td>
</tr>