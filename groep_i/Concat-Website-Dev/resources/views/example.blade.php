<x-layout>
    <div class="mt-12 max-w-2xl mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Laatste aankondigingen</h2>
        <x-announcements-list
            :groupedAnnouncements="$groupedAnnouncements"
            containerClass="space-y-6"
        />
    </div>
</x-layout>
