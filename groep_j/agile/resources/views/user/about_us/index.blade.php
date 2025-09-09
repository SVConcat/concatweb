@extends("layouts.default")

@section("title", "Over Ons")

@section("content")
    <div class="section">
        <div class="about-us">
            <div class="container">
                <div class="info">
                    <h2>Over Ons</h2>

                    <p>
                        concat [kon-ket] (verb) “Concatenatie is een standaardoperatie in programmeertalen om twee objecten aan elkaar te verbinden.” Wanneer gebruikt na het woord studievereniging {Studievereniging Concat} worden studenten met elkaar, bedrijven en docenten verbonden.
                        Voorbeeldzinnen:
                    </p>
                    <br />
                    <ol class="about-us-list">
                        <li>"Ik ben een informaticastudent, zit op school en ben op zoek naar gezelligheid, dus dan ga ik naar studievereniging Concat."</li>
                        <li>Een bedrijf heeft een tekort aan informaticastudenten. Als oplossing benaderen ze studievereniging Concat.</li>
                        <li>SELECT CONCAT(SO, BIM) AS Gezelligheid FROM Avans;</li>
                    </ol>
                    <br />
                    <p>
                        Studievereniging Concat heeft twee hoofddoelen: studenten verbinden en een extensie zijn van de opleiding. Studenten verbinden met elkaar, docenten en het bedrijfsleven. Op deze manier willen wij studenten helpen om een gezellige studietijd te hebben en na de studietijd helemaal voorbereid te zijn voor het bedrijfsleven.
                    </p>
                </div>
            </div>

            {{-- Boards --}}
            <div class="comiboards-wrapper">
                <div class="container">

                    <div class="comiboards">
                        @foreach($boards as $member)
                            <x-comiboard :item="$member" alt="Bestuurslid" />
                        @endforeach
                    </div>
                </div>

                {{-- Commissions --}}
                @if($commissions !== null && $commissions->isNotEmpty())
                    <div class="container">
                        <div class="info">
                            @foreach($commissions as $commission)
                                <h2>{{$commission->name}}</h2>

                                <p>
                                    {{$commission->description}}
                                </p>
                                <hr>
                            @endforeach

                        </div>
                    </div>
                @endif

                <div class="container">
                    <div class="instruction-message">
                        <p>Wil je lid worden van ons bestuur of een van onze commissies? Mail dan naar <a href="mailto:info@svconcat.nl">info@svconcat.nl</a></p>
                    </div>
                </div>

                <div class="about-us-swiper">
                    <div class="container">
                        <div class="info">
                            <h2>Onze (oude) besturen</h2>
                            <x-swiper :item="$oldBoards" id="boardSwiper"/>

                        </div>



                    </div>
                </div>

            </div>

        </div>
    </div>
@stop
