@props(['item', 'route', 'title', 'message'])
<form method="POST" action="{{ route($route, ['id' => $item->id]) }}" class="mt-4">
    @method('DELETE')
    @csrf
    <button id="openModalDeleteButton" data-modal-id="deleteModal" type="button" class="button delete">{{ $title }}</button>
    <x-modal id="deleteModal" title="{{ $title }}" message="{{ $message }}" />
</form>
