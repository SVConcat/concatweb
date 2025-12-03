<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5">
        <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1"
            alt="Formulier voor het toevoegen van een foto">
            Foto toevoegen
        </h1>

        <form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4" id="galleryForm">
            @csrf

            <div>
                <label for="title" class="block text-l font-bold">Titel*</label>
                <input type="text" name="title" id="title" placeholder="Titel van de foto"
                    value="{{ old('title', $photo->title ?? '') }}"
                    class="w-full p-2 {{ $errors->has('title') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('title')
                    <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="type" class="block text-l font-bold">Categorie*</label>
                <select name="type" id="type"
                    class="w-full p-2 {{ $errors->has('type') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                    <option value="">-- Selecteer een categorie --</option>
                    <option value="blokborrel" {{ old('type', $photo->type ?? '') == 'blokborrel' ? 'selected' : '' }}>
                        Blokborrel</option>
                    <option value="education" {{ old('type', $photo->type ?? '') == 'education' ? 'selected' : '' }}>
                        Education</option>
                </select>
                @error('type')
                    <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="date" class="block text-l font-bold">Datum*</label>
                <input type="date" name="date" id="date"
                    value="{{ old('date', isset($photo) ? $photo->date->format('Y-m-d') : '') }}"
                    class="w-full p-2 {{ $errors->has('date') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('date')
                    <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="evenementen" class="block text-l font-bold">Koppel aan evenement(en)</label>
                <select name="evenementen[]" id="evenementen" multiple
                    class="w-full p-2 bg-purple-100 text-purple-700 rounded-lg outline-none border border-purple-300 focus:ring-2 focus:ring-purple-500">
                    @foreach($evenementen as $evenement)
                        <option value="{{ $evenement->id }}" {{ collect(old('evenementen'))->contains($evenement->id) ? 'selected' : '' }}>
                            {{ $evenement->titel }}
                        </option>
                    @endforeach
                </select>
                @error('evenementen')
                    <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-l font-bold">Afbeelding*</label>
                <input type="file" name="images[]" id="image" multiple accept="image/*"
                    class="w-full p-2 bg-purple-100 text-purple-700 rounded-lg outline-none border border-purple-300 focus:ring-2 focus:ring-purple-500">

                @error('image')
                    <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <!-- File size validation message - altijd zichtbaar zodra bestanden geselecteerd zijn -->
            <div id="fileValidation" class="hidden">
                <!-- Success message -->
                <div id="fileSuccess" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg hidden">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="font-bold">Bestanden gevalideerd!</p>
                            <p id="successDetails"></p>
                        </div>
                    </div>
                </div>

                <!-- Error message -->
                <div id="fileError" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg hidden">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="font-bold">Upload limiet overschreden!</p>
                            <p id="errorDetails"></p>
                            <p class="text-sm mt-1">Maximum: 20MB totaal, 5MB per bestand</p>
                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" value="Opslaan" id="submitBtn"
                class="w-full bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition font-semibold cursor-pointer">
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('image');
            const fileValidation = document.getElementById('fileValidation');
            const fileSuccess = document.getElementById('fileSuccess');
            const fileError = document.getElementById('fileError');
            const successDetails = document.getElementById('successDetails');
            const errorDetails = document.getElementById('errorDetails');
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('galleryForm');

            // Verhoog de limieten om overeen te komen met je controller
            const MAX_TOTAL_SIZE = 50 * 1024 * 1024; // 50MB totaal
            const MAX_FILE_SIZE = 5 * 1024 * 1024;   // 5MB per bestand (match met controller)

            fileInput.addEventListener('change', function() {
                const files = this.files;

                // Verstop alle meldingen eerst
                fileValidation.classList.add('hidden');
                fileSuccess.classList.add('hidden');
                fileError.classList.add('hidden');

                if (files.length === 0) {
                    enableSubmit();
                    return;
                }

                // Toon validatie sectie
                fileValidation.classList.remove('hidden');

                let totalSizeBytes = 0;
                let hasError = false;
                let errorMessage = '';

                // Controleer elk bestand
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    totalSizeBytes += file.size;

                    // Controleer individuele bestandsgrootte
                    if (file.size > MAX_FILE_SIZE) {
                        hasError = true;
                        errorMessage = `"${file.name}" is ${formatBytes(file.size)} (te groot voor individueel bestand)`;
                        break;
                    }
                }

                // Controleer totale grootte
                if (!hasError && totalSizeBytes > MAX_TOTAL_SIZE) {
                    hasError = true;
                    errorMessage = `Totale grootte is ${formatBytes(totalSizeBytes)} (limiet overschreden)`;
                }

                if (hasError) {
                    // Toon foutmelding
                    errorDetails.textContent = errorMessage;
                    fileError.classList.remove('hidden');
                    disableSubmit();
                } else {
                    // Toon success melding
                    successDetails.textContent = `${files.length} bestand(en) geselecteerd (${formatBytes(totalSizeBytes)})`;
                    fileSuccess.classList.remove('hidden');
                    enableSubmit();
                }
            });

            // Voorkom form submit als er een fout is
            form.addEventListener('submit', function(e) {
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return false;
                }
            });

            function formatBytes(bytes) {
                if (bytes === 0) return '0 MB';
                const mb = bytes / (1024 * 1024);
                return mb.toFixed(2) + ' MB';
            }

            function disableSubmit() {
                submitBtn.disabled = true;
                submitBtn.classList.remove('bg-red-500', 'hover:bg-red-600', 'cursor-pointer');
                submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                submitBtn.value = 'Kan niet opslaan - bestanden te groot';
            }

            function enableSubmit() {
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                submitBtn.classList.add('bg-red-500', 'hover:bg-red-600', 'cursor-pointer');
                submitBtn.value = 'Opslaan';
            }
        });
    </script>
</x-layout>
