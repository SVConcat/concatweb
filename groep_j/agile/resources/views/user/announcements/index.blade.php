@extends("layouts.default")

@section("title", "Aankondigingen")

@section("content")
    <div class="section">
        <div class="container">
            <div class="items-wrapper">
                <div class="items">
                    @foreach($announcements as $announcement)
                        <x-item
                                :item="$announcement"
                                :alt="($announcement->banner ? 'Afbeelding voor ' . $announcement->title : '')" route="user.announcement.show"
                        />
                    @endforeach
                </div>
                    <div class="pagination">
                        {{ $announcements->withQueryString()->links() }}
                    </div>
            </div>
        </div>
    </div>

@endsection
