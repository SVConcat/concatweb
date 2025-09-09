@extends("admin.index")

@section("title", "Oude Besturen")

@section("content")
    <x-admin.datatable
        :searchAction="route('admin.old_boards.index')"
        :createUrl="route('admin.old_boards.create')"
        createLabel="Voeg oud bestuur toe"
        tableId="old-boards-table"
        searchPlaceholder="Zoeken..."
    >
        <x-slot:thead>
            <th>Namen</th>
            <th>Termijn</th>
            <th>Foto</th>
            <th>Acties</th>
        </x-slot:thead>

        <x-slot:tbody>
            @foreach ($oldBoards as $oldBoard)
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2">{{ $oldBoard->names }}</td>
                    <td class="px-4 py-2">{{ $oldBoard->term }}</td>
                    <td class="px-4 py-2">
                        <img src="{{ asset($oldBoard->image_url) }}" width="50" height="50" class="rounded-md object-cover" />
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.old_boards.show', ['id' => $oldBoard->id]) }}" class="text-blue-600 hover:underline">Bewerk</a>
                    </td>
                </tr>
            @endforeach
        </x-slot:tbody>
    </x-admin.datatable>

    <div class="mt-4">
        {{ $oldBoards->links() }}
    </div>
@endsection
