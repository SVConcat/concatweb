@props(
['id',
'gallery',
'image']
)

<div class="modal fade gallery-modal" id="exampleModal{{$id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="menu-close"></span>
                </button>
            </div>
            <div class="modal-body d-flex justify-center align-middle">
                <div class="w-100 h-100 overflow-hidden zoom-wrapper">
                    <div class="d-flex justify-center area-wrapper">
                        <img src="{{ asset($gallery->getGalleryImagePath($image['path'] ?? $image )) }}" class="d-block">
                    </div>
                </div>
            </div>
            <div class="modal-footer flex-col align-items-start">
                @if(is_array($image) && isset($image['event_name']))
                    <p>Evenement: {{$image['event_name']}}</p>
                @endif
                    @if(is_array($image) && isset($image['event_date']))
                        <p>Datum: {{$gallery->getFormattedDate($image['event_date'])}}</p>
                @endif
            </div>
        </div>
    </div>
</div>

