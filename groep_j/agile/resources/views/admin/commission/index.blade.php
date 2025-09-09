@extends("admin.index")

@section("title", "Commissies")

@section("content")
    <x-admin.datatable
        :searchAction="route('admin.commission.index')"
        :createUrl="route('admin.commission.create')"
        createLabel="Voeg commissie toe"
        tableId="commissions-table"
        searchPlaceholder="Zoeken..."
    >
        <x-slot:thead>
            <th>Naam</th>
            <th>Omschrijving</th>
            <th>Acties</th>
        </x-slot:thead>

        <x-slot:tbody>
            @foreach ($commissions as $commission)
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2">{{ $commission->name }}</td>
                    <td class="px-4 py-2">{{ $commission->description }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.commission.show', ['id' => $commission->id]) }}" class="text-blue-600 hover:underline">Bewerk</a>
                    </td>
                </tr>
            @endforeach
        </x-slot:tbody>
    </x-admin.datatable>

    <div class="mt-4">
        {{ $commissions->links() }}
    </div>
@endsection
