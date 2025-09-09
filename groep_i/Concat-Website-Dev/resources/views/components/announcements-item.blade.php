<div class="bg-gray-100 rounded-lg shadow-md p-6 w-full">
    <div class="flex flex-col w-full">
        <div class="flex justify-between items-start gap-4 mb-2">
            <h2 class="text-xl font-semibold text-gray-800">{{ $announcement->titel }}</h2>
            <!-- Datum markup -->
        </div>
        <p class="text-gray-600 whitespace-pre-wrap">{{ $announcement->inhoud }}</p>
        <!-- Vervaldatum -->
    </div>
</div>
