@props([
    'attribute' => 'gallery',
    'model' => null,
    'modelname' => '',
    'id',
    'label' => '',
    'class' => '',
    'metadatas' => [],
   ])
<div class="mb-4">
    <label class="block text-gray-700 font-bold mb-1" for="{{ $id }}">
        {{ ucfirst($label) }}
    </label>
    <h5 id="message" class="text-sm text-gray-700 font-bold mb-1">
        Sleep bestanden hierheen of klik om te uploaden
    </h5>

    <form action="{{ isset($model) ? route( 'admin.gallery.upload',  [strtolower(class_basename($model)), $model->id]) : route('admin.gallery.store', $modelname) }}" method="POST" enctype="multipart/form-data" class="dropzone border border-gray-400 bg-white rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-500 {{ $class }}" id="{{$id}}">
        @csrf
        <input type="hidden" name="attribute" value="{{ $attribute }}">
        <input type="hidden" name="metadata_names" id="hidden_metadata_names_{{ $id }}" value="{{ json_encode(array_column($metadatas, 'name')) }}">
        @foreach($metadatas as $metadata)
            <input type="hidden" name="{{ $metadata['name'] }}" id="hidden_{{ $metadata['name'] }}_{{ $id }}">
        @endforeach
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        mDropzone();
    });

    function updateMetadata(fileName, metadataValues, metadataContainer) {
        if (!fileName) {
            alert('Geen bestand geselecteerd om te updaten.');
            return;
        }

        // Prepare data object with token, filename and attribute
        var data = {
            _token: "{{ csrf_token() }}",
            file_name: fileName,
            attribute: "{{ $attribute }}"
        };

        // Add all metadata values to the data object
        for (var key in metadataValues) {
            if (metadataValues.hasOwnProperty(key)) {
                data[key] = metadataValues[key];
            }
        }

        // Send AJAX request to update metadata
        $.ajax({
            url: "{{ isset($model) ? route('admin.gallery.update-metadata', [strtolower(class_basename($model)), $model->id]) : '#' }}",
            type: "POST",
            data: data,
            success: function(response) {
                // show metadata values
                updateMetadataDisplay(metadataContainer, fileName, metadataValues);
            },
            error: function(xhr, status, error) {
                alert('Er is een fout opgetreden bij het bijwerken van de metadata: ' + error);
            }
        });
    }

    function updateMetadataDisplay(container, fileName, metadataValues) {
        container.innerHTML = '';
        var hasMetadataValues = false;

        // create metadata display fields
        @foreach($metadatas as $metadata)
            if (metadataValues['{{ $metadata['name'] }}']) {
                hasMetadataValues = true;
                var element = document.createElement('div');
                element.className = 'dz-metadata';

                var metadataType = '{{ $metadata['type'] }}';
                if (metadataType === 'date' || metadataType === 'datetime') {
                    element.innerHTML = '<span>{{ $metadata['label'] }}:</span> ' + new Date(metadataValues['{{ $metadata['name'] }}']).toLocaleDateString('nl-NL');
                } else {
                    element.innerHTML = '<span>{{ $metadata['label'] }}:</span> ' + metadataValues['{{ $metadata['name'] }}'] + (metadataValues['{{ $metadata['name'] }}'].length > 10 ? '...' : '');
                }
                container.appendChild(element);
            }
        @endforeach

        // add edit button, is reachable even if it says it isn't!
        if (@json(count($metadatas) > 0) && !container.querySelector('.dz-edit-form') && !container.querySelector('.dz-edit-button')) {
            var editButton = createEditButton(fileName, metadataValues, container);
            container.appendChild(editButton);
        }
    }

    function createEditButton(fileName, metadataValues, container) {
        var editButton = document.createElement('button');
        editButton.className = 'dz-metadata-button dz-edit-button';
        editButton.innerHTML = 'Bewerk data';
        editButton.type = 'button';
        editButton.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            showEditForm(container, fileName, metadataValues);
        };

        return editButton;
    }

    function showEditForm(container, fileName, metadataValues) {
        container.innerHTML = '';

        var form = document.createElement('div');
        form.className = 'dz-edit-form';

        // Initialize metadataValues if it's not an object
        if (typeof metadataValues !== 'object' || metadataValues === null) {
            metadataValues = {};
        }

        // Create metadata input fields
        @foreach($metadatas as $metadata)
            var {{ $metadata['name'] }}Label = document.createElement('label');
            {{ $metadata['name'] }}Label.className = 'dz-metadata-input-label';
            {{ $metadata['name'] }}Label.innerHTML = '{{ $metadata['label'] }}:';
            form.appendChild({{ $metadata['name'] }}Label);

            var {{ $metadata['name'] }}Input = document.createElement('input');
            {{ $metadata['name'] }}Input.type = '{{ $metadata['type'] }}';
            {{ $metadata['name'] }}Input.name = '{{ $metadata['name'] }}';
            {{ $metadata['name'] }}Input.className = 'dz-metadata-input';
            {{ $metadata['name'] }}Input.value = metadataValues['{{ $metadata['name'] }}'] || '';
            {{ $metadata['name'] }}Input.placeholder = 'Voer {{ strtolower($metadata['label']) }} in';

            {{ $metadata['name'] }}Input.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                }
            });

            form.appendChild({{ $metadata['name'] }}Input);
        @endforeach

        // Buttons container
        var buttonsContainer = document.createElement('div');
        buttonsContainer.className = 'btn-container';

        // Save button
        var saveButton = document.createElement('button');
        saveButton.className = 'dz-metadata-button dz-metadata-save-button';
        saveButton.innerHTML = 'Opslaan';
        saveButton.type = 'button';
        saveButton.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Collect all metadata values
            var newMetadataValues = {};
            @foreach($metadatas as $metadata)
                newMetadataValues['{{ $metadata['name'] }}'] = form.querySelector('input[name="{{ $metadata['name'] }}"]').value;
            @endforeach

            // Update metadata
            updateMetadata(fileName, newMetadataValues, container);
        };
        buttonsContainer.appendChild(saveButton);

        // Cancel button
        var cancelButton = document.createElement('button');
        cancelButton.className = 'dz-metadata-button dz-metadata-cancel-button';
        cancelButton.innerHTML = 'Annuleren';
        cancelButton.type = 'button';
        cancelButton.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            updateMetadataDisplay(container, fileName, metadataValues);
        };
        buttonsContainer.appendChild(cancelButton);

        form.appendChild(buttonsContainer);
        container.appendChild(form);
    }

    function mDropzone() {
        var maxFilesize = 5; // MB
        var maxFilesAmount = null; // unlimited

        Dropzone.options.{{$id}} = {
            paramName:"{{$attribute}}",
            maxFilesize: maxFilesize, // MB
            maxFiles: maxFilesAmount,
            resizeQuality: 1.0,
            acceptedFiles: ".jpeg,.jpg,.png,.webp,.gif,.svg",
            addRemoveLinks: {{ isset($model) }},
            timeout: 60000,
            dictDefaultMessage: "",
            dictFileTooBig: "Bestand is te groot (max. "+maxFilesize+" MB)",
            dictInvalidFileType: "Bestandstype ongeldig. Alleen JPG, JPEG, PNG, WEBP, GIF, SVG zijn toegestaan.",
            dictRemoveFile: "Verwijder bestand",
            maxfilesexceeded: function(file) {
                this.removeFile(file);
                document.getElementById("message").innerHTML = "Je kunt niet meer dan " + maxFilesAmount + " bestanden uploaden.";
            },
            sending: function(file, xhr, formData) {
                // Add all metadata values to the form data from the file's metadata form
                if (file.previewElement) {
                    var metadataContainer = file.previewElement.querySelector('.dz-metadata-container');
                    if (metadataContainer) {
                        var form = metadataContainer.querySelector('.dz-edit-form');
                        if (form) {
                            @foreach($metadatas as $metadata)
                                var {{ $metadata['name'] }}Input = form.querySelector('input[name="{{ $metadata['name'] }}"]');
                                if ({{ $metadata['name'] }}Input && {{ $metadata['name'] }}Input.value) {
                                    formData.append('{{ $metadata['name'] }}', {{ $metadata['name'] }}Input.value);
                                    document.getElementById('hidden_{{ $metadata['name'] }}_{{$id}}').value = {{ $metadata['name'] }}Input.value;
                                }
                            @endforeach
                        }
                    }
                }
            },
            removedfile: function (file) {
                @if(isset($model))
                    var fileName = file.name;
                    $.ajax({
                        url: "{{ route('admin.gallery.delete', [strtolower(class_basename($model)), $model->id]) }}",
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            file_names: [fileName],
                            attribute: "{{ $attribute }}"
                        },
                        success: function (response) {
                        },
                        error: function (xhr, status, error) {
                        }
                    });

                    var previewElement = file.previewElement;
                    if (previewElement != null) {
                        previewElement.parentNode.removeChild(previewElement);
                    }
                @endif
            },
            init: function() {
                var myDropzone = this;

                // Add event handler for addedfile to add metadata form to new uploads
                this.on("addedfile", function(file) {
                    if (!file.isLoadedFromServer && @json(count($metadatas) > 0)) {
                        var hasExistingMetadata = false;
                        @foreach($metadatas as $metadata)
                            if (file.{{ $metadata['name'] }}) {
                                hasExistingMetadata = true;
                            }
                        @endforeach

                        if (!hasExistingMetadata) {
                            // Add metadata container
                            setTimeout(function() {
                                if (file.previewElement) {
                                    var metadataContainer = document.createElement('div');
                                    metadataContainer.className = 'dz-metadata-container';

                                    updateMetadataDisplay(metadataContainer, file.name, {});
                                    file.previewElement.appendChild(metadataContainer);
                                }
                            }, 100);
                        }
                    }
                });

                @if(isset($model))
                    $.ajax({
                        url: "{{ route('admin.gallery.fetch', [strtolower(class_basename($model)), $model->id]) }}",
                        type: "GET",
                        dataType: "json",
                        success: function (response) {
                            response.forEach(function (file) {
                                // Create a mockFile with all metadata fields
                                var mockFile = {
                                    name: file.name,
                                    size: file.size,
                                    isLoadedFromServer: true
                                };

                                var metadataValues = {};
                                @foreach($metadatas as $metadata)
                                    mockFile.{{ $metadata['name'] }} = file.{{ $metadata['name'] }};
                                    metadataValues['{{ $metadata['name'] }}'] = file.{{ $metadata['name'] }};
                                @endforeach

                                myDropzone.emit("addedfile", mockFile);
                                myDropzone.emit("thumbnail", mockFile, file.path);
                                myDropzone.emit("complete", mockFile);

                                // Add metadata to the preview element
                                if (mockFile.previewElement) {
                                    var metadataContainer = document.createElement('div');
                                    metadataContainer.className = 'dz-metadata-container';

                                    updateMetadataDisplay(metadataContainer, file.name, metadataValues);
                                    mockFile.previewElement.appendChild(metadataContainer);
                                }
                            });
                            if(response.length > 0) {
                                document.getElementsByClassName("dz-message")[0].style.display = "none";
                            }
                        },
                        error: function (xhr, status, error) {
                        }
                    });
                @endif
            }
        };
    }
</script>
