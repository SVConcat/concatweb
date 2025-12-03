@props(['groupedAnnouncements', 'containerClass' => ''])

<div class="{{ $containerClass }}">
    <div id="announcements-container" class="w-full">
        @foreach($groupedAnnouncements as $group => $announcements)
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="mx-4 text-gray-500 font-medium">{{ $group }}</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <div class="space-y-4 w-full">
                    @foreach($announcements as $announcement)
                        <!-- Je bestaande announcement item markup -->
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
