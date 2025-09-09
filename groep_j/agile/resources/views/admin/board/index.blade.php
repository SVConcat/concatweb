@extends("admin.index")

@section("title", "Board Members")

@section("content")
    <x-admin.datatable
        :searchAction="route('admin.board.index')"
        :createUrl="route('admin.board.create')"
        createLabel="Voeg bestuur lid toe"
        tableId="board-table"
        searchPlaceholder="Zoeken..."
    >
        <x-slot:thead>
            <th>Rol</th>
            <th>Naam</th>
            <th>Foto</th>
            <th>Acties</th>
        </x-slot:thead>

        <x-slot:tbody>
            @foreach ($boardMembers as $boardMember)
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2">{{ $boardMember->name }}</td>
                    <td class="px-4 py-2">{{ $boardMember->role }}</td>
                    <td class="px-4 py-2">
                        <img src="{{ asset($boardMember->image_url) }}" width="50" height="50" class="rounded-md object-cover" />
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route("admin.board.show", ["id" => $boardMember->id]) }}" class="text-blue-600 hover:underline">Bewerk</a>
                    </td>
                </tr>
            @endforeach
        </x-slot:tbody>
    </x-admin.datatable>

    <div class="mt-4">
        {{ $boardMembers->links() }}
    </div>
@endsection
