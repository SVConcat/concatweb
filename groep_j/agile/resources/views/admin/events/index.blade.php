@extends("admin.index")

@section("title", "Events")

@section("content")
    <div class="container has-sliders">
        <x-admin.datatable
            :searchAction="route('admin.events.index')"
            :createUrl="route('admin.event.create')"
            createLabel="Event aanmaken"
            tableId="events-table"
            searchPlaceholder="Zoek op titel..."
            :bindings="$bindings"
        >
            <x-slot:filters>
                <x-filters.dropdown :onchange="'this.form.submit()'" default="Alle statussen" name="status" enum="{{\App\Enums\ActiveTypeEnum::class}}" value="{{ request('status') }}" :params="$bindings"/>
            </x-slot:filters>

            <x-slot:thead>
                <th>Titel</th>
                <th>Datum / Start datum</th>
                <th>Categorie</th>
                <th>Registraties</th>
                <th>Aangemaakt op</th>
                <th>Bijgewerkt op</th>
                <th>Banner</th>
                <th>Acties</th>
            </x-slot:thead>

            <x-slot:tbody>
                @foreach ($events as $event)
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2">
                            {{ Str::of($event->title)->words(5, '...') }}
                            <span>{{ $event->status->name === 'ARCHIVED' ? '(' . __('ARCHIVED') . ')' : '' }}</span>
                        </td>
                        <td class="px-4 py-2">{{ $event->getFormattedDate($event->start_date) }}</td>
                        <td class="px-4 py-2">{{ __($event->category->value) }}</td>
                        <td class="availability">
                            {{$event->registry_count}}
                            @if($event->registry_percentage !== null)
                                <span class="percentage-meter {{$event->registry_percentage < 25 ? 'low' : ($event->registry_percentage > 25 && $event->registry_percentage < 75 ? 'medium' : 'high') }}">
                                {{$event->registry_percentage}}%
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $event->getFormattedDate($event->created_at) }}</td>
                        <td class="px-4 py-2">{{ $event->getFormattedDate($event->updated_at) }}</td>
                        <td class="px-4 py-2">
                            <img src="{{ asset($event->banner_url) }}" class="w-12 h-12 object-cover rounded-md" />
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.event.show', ['id' => $event->id]) }}" class="text-blue-600 hover:underline">Bewerken</a>
                        </td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-admin.datatable>

        <div class="sliders">
            <x-forms.input-dropzone attribute="gallery" :model="$gallery" id="homeGallery" label="Home gallerij"/>
        </div>
    </div>
@endsection
