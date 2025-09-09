@extends("admin.index")

@section("title", "Assignments")

@section("content")
    <div class="container">
        <x-admin.datatable
            :searchAction="route('admin.assignments.index')"
            :createUrl="route('admin.assignment.create')"
            createLabel="Opdracht aanmaken"
            tableId="assignments-table"
            searchPlaceholder="Zoek op titel..."
            :bindings="$bindings"
        >
            <x-slot:filters>
                <x-filters.dropdown
                    :onchange="'this.form.submit()'"
                    default="Alle statussen"
                    name="active"
                    :list="[
                        '1' => 'Actief',
                        '0' => 'Niet Actief'
                    ]"
                    value="{{ request('active') }}"
                    :params="$bindings"
                />
            </x-slot:filters>

            <x-slot:thead>
                <th>Titel</th>
                <th>Email</th>
                <th>Telefoonnummer</th>
                <th>Beloning</th>
                <th>Actief</th>
                <th>Bewerken</th>
            </x-slot:thead>

            <x-slot:tbody>
                @foreach ($assignments as $assignment)
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2">{{ Str::limit($assignment->title, 15) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($assignment->contact_email, 30) }}</td>
                        <td class="px-4 py-2">{{ $assignment->contact_phone }}</td>
                        @if(!$assignment->reward)
                            <td class="px-4 py-2">-</td>
                        @else
                            <td class="px-4 py-2">€{{ $assignment->reward }}</td>
                        @endif
                        <td class="px-4 py-2">{{ $assignment->active ? __('Ja') : __('Nee') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.assignment.show', ['id' => $assignment->id]) }}" class="text-blue-600 hover:underline">Bewerken</a>
                        </td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-admin.datatable>
    </div>
@endsection
