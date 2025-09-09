@extends("admin.index")

@section("content")
    <x-admin.datatable
        :searchAction="route('admin.announcements.index')"
        :createUrl="route('admin.announcements.create')"
        createLabel="Announcement Aanmaken"
        tableId="announcement-table"
        searchPlaceholder="Zoek op titel of omschrijving..."
    >
        <x-slot:thead>
            <th>Datum & Tijd Aangemaakt</th>
            <th>Titel</th>
            <th>Omschrijving</th>
            <th>Afbeelding</th>
            <th></th>
            <th></th>
        </x-slot:thead>

        <x-slot:tbody>
            @foreach ($announcements as $announcement)
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2">{{ $announcement->created_at->format('d M, Y H:i') }}</td>
                    <td class="px-4 py-2">{{ $announcement->title }}</td>
                    <td class="px-4 py-2">{{ Str::limit($announcement->description, 100) }}</td>
                    <td class="px-4 py-2">
                        @if ($announcement->image)
                            <img src="{{ asset($announcement->banner_url) }}" class="w-12 h-12 object-cover rounded-md" />
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.announcements.edit', ['announcement' => $announcement->id]) }}" class="text-blue-600 hover:underline">
                            Bewerk
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-slot:tbody>
    </x-admin.datatable>
@endsection