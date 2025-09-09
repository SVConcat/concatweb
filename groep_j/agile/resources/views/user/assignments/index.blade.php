@extends("layouts.default")

@section("title", "Assignments")

@section("content")
    <div class="section">
        <div class="container">
            <div class="items-wrapper">
                <div class="items">
                    @foreach($assignments as $assignment)
                        <x-item :item="$assignment" route="user.assignment.show" word_count="100"/>
                    @endforeach
                </div>
                <div class="pagination">
                    {{ $assignments->links() }}
                </div>
            </div>
        </div>
    </div>
@stop
