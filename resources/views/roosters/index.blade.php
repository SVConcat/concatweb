<x-layout>
@php
    $klasColors = [
        1 => '#08e8de',
        2 => '#e39ff6',
        3 => '#fe4040',
        4 => '#3129ff',
    ];
@endphp

<div class="bg-white min-h-screen py-6 px-4 sm:px-6 lg:px-8 rounded-2xl" data-dusk="rooster-page">
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-6">

        {{-- Linkerkolom: Kalender + Roostervorm --}}
        <div class="w-full lg:w-1/3 space-y-6">

            {{-- Kalender --}}
            <div class="p-4 border rounded shadow-sm" role="region" aria-label="Kalender">
                <h2 class="text-xl font-semibold mb-3">Kalender</h2>
                <div id="inlineCalendar" class="select-none" data-dusk="calendar" aria-label="Interactieve kalender"></div>
            </div>

            {{-- Rooster toevoegen --}}
            <div class="p-4 border rounded shadow-sm" role="region" aria-label="Rooster toevoegen">
                <h2 class="text-xl font-semibold mb-3">Rooster toevoegen</h2>
                <form action="/roosters" method="POST" class="mb-4" data-dusk="rooster-form" aria-label="Formulier om rooster toe te voegen">
                    @csrf
                    <label for="ical_url" class="sr-only">iCal URL</label>
                    <input type="url" id="ical_url" name="ical_url" required placeholder="https://rooster.avans.nl/gcal/..."
                        class="w-full p-2 border rounded mb-2" data-dusk="input-ical-url" aria-label="Voer de iCal URL in">

                    <label for="klas" class="sr-only">Selecteer klas</label>
                    <select id="klas" name="klas" required class="w-full p-2 border rounded mb-2" data-dusk="select-klas" aria-label="Selecteer een klas">
                        <option value="">Selecteer een klas</option>
                        <option value="1">Klas 1</option>
                        <option value="2">Klas 2</option>
                        <option value="3">Klas 3</option>
                        <option value="4">Klas 4</option>
                    </select>

                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded w-full" data-dusk="btn-add-rooster" aria-label="Rooster toevoegen">
                        Toevoegen
                    </button>
                </form>

                @if(session('success'))
                    <p class="text-green-600 mb-4" data-dusk="form-success" role="status">{{ session('success') }}</p>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4" role="alert" aria-label="Foutenlijst">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Kalender selecties --}}
           <div class="p-4 border rounded shadow-sm" role="region" aria-label="Kalenders selecteren">
            <h2 class="text-xl font-semibold mb-3">Kalenders selecteren</h2>
            @if($roosters->count() > 0)
                <div class="max-h-48 overflow-y-auto">
                    @foreach($roosters as $rooster)
                        @php
    $urlParts = parse_url($rooster->ical_url);
    parse_str($urlParts['query'] ?? '', $queryParams);
    $shortName = $queryParams['value'] ?? 'onbekend';                            $color = $klasColors[$rooster->klas] ?? '#999999';
                        @endphp
                        <div class="flex items-center justify-between mb-2 border rounded p-2" data-dusk="calendar-item-{{ $shortName }}">
                            <label class="inline-flex items-center cursor-pointer" aria-label="Rooster {{ $shortName }} selectievakje">
                                <input type="checkbox" name="selected_calendars[]" value="{{ $shortName }}" checked
                                    class="toggle-calendar"
                                    data-color="{{ $color }}"
                                    data-dusk="checkbox-{{ $shortName }}"
                                    aria-label="Selecteer rooster {{ $shortName }}">
                                <span class="ml-2" style="color: {{ $color }};">{{ $shortName }}</span>
                            </label>

                            <form action="{{ route('roosters.destroy', $rooster->id) }}" method="POST"
                                onsubmit="return confirm('Weet je zeker dat je deze kalender wilt verwijderen?');"
                                data-dusk="delete-form-{{ $shortName }}" aria-label="Verwijder rooster {{ $shortName }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 px-2"
                                    title="Verwijder rooster" data-dusk="btn-delete-{{ $shortName }}"
                                    aria-label="Verwijder rooster {{ $shortName }}">
                                    &times;
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p data-dusk="no-calendars" aria-label="Geen kalenders toegevoegd">Geen kalenders toegevoegd.</p>
            @endif
        </div>

        </div>

        {{-- Rechterkolom: Grafiek --}}
        <div class="w-full lg:w-2/3 p-4 border rounded shadow-sm" role="region" aria-label="Drukte per uur grafiek">
            <h2 class="text-xl font-semibold mb-3">Drukte</h2>

            @if(empty($events))
                <div class="text-red-600 font-medium" data-dusk="no-data-message" role="alert" aria-label="Geen data beschikbaar">
                    Geen data en/of webcal link is down.
                </div>
            @else
                <canvas id="hourlyChart" height="250" role="img" aria-label="Grafiek van drukte per uur per klas" data-dusk="hourly-chart"></canvas>

                {{-- Legenda onder de chart --}}
                <div id="legend" class="flex flex-wrap gap-4 mt-4 justify-center" data-dusk="chart-legend" role="group" aria-label="Legenda met kleuren per klas">
                    @foreach($klasColors as $klasNum => $color)
                        <div class="flex items-center space-x-2" aria-label="Klas {{ $klasNum }} kleur {{ $color }}">
                            <div style="width: 20px; height: 20px; background-color: {{ $color }}; border-radius: 4px;"></div>
                            <span class="font-medium">Klas {{ $klasNum }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="block sm:hidden text-gray-500 mt-2 text-sm italic" aria-hidden="true">
                * Roosternamen zijn verborgen op mobiel
            </div>
        </div>
    </div>
</div>


{{-- Verborgen lessenlijst --}}
<ul id="lessonsList" class="hidden">
    @foreach($events as $event)
        @php
            $eventColor = '#999999'; 
            foreach($roosters as $r) {
$urlParts = parse_url($r->ical_url);
parse_str($urlParts['query'] ?? '', $queryParams);
$shortName = $queryParams['value'] ?? 'onbekend';
                if($shortName === $event['calendar_name']) {
                    $eventColor = $klasColors[$r->klas] ?? '#999999';
                    break;
                }
            }
        @endphp
        <li class="lesson-item"
            data-calendar="{{ $event['calendar_name'] }}"
            data-start="{{ \Carbon\Carbon::createFromFormat('d-m-Y H:i', $event['start'])->format('Y-m-d') }}"
            data-start-time="{{ \Carbon\Carbon::createFromFormat('d-m-Y H:i', $event['start'])->format('H:i') }}"
            style="border-left: 5px solid {{ $eventColor }};"
            data-dusk="lesson-{{ $loop->index }}">
            <strong>{{ $event['title'] }}</strong><br>
            Start: {{ $event['start'] }}<br>
            Eind: {{ $event['end'] }}
        </li>
    @endforeach
</ul>

{{-- Chart.js & Kalender scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const startHour = 8;
    const endHour = 22;
    const hourLabels = [];
    for (let h = startHour; h <= endHour; h++) {
        hourLabels.push(`${h.toString().padStart(2, '0')}:00`);
    }

    const ctx = document.getElementById('hourlyChart')?.getContext('2d');
    let hourlyChart = null;
    if(ctx) {
        hourlyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: hourLabels,
                datasets: []
            },
           options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    stacked: true, // toevoegen
                    ticks: {
                        callback: function (value) {
                            if (Number.isInteger(value)) return value;
                        },
                        stepSize: 1,
                        min: 0
                    },
                    title: { display: true, text: 'Aantal lessen' }
                },
                x: {
                    stacked: true,
                    title: { display: true, text: 'Uur van de dag' }
                }
            },
            plugins: {
                tooltip: { mode: 'index', intersect: false },
                legend: { display: false }
            }
        }
 
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const calendarCheckboxes = document.querySelectorAll('.toggle-calendar');
        const lessonItems = document.querySelectorAll('.lesson-item');
        let selectedDate = null;

        const lessonDatesSet = new Set();
        lessonItems.forEach(ev => lessonDatesSet.add(ev.getAttribute('data-start')));
        const lessonDates = Array.from(lessonDatesSet);

        const calendarEl = document.getElementById('inlineCalendar');

        function createCalendar(year, month) {
            calendarEl.innerHTML = '';
            const monthNames = ['Jan', 'Feb', 'Mrt', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'];
            const daysOfWeek = ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'];

            const header = document.createElement('div');
            header.classList.add('flex', 'justify-between', 'items-center', 'mb-2');

            const prevBtn = document.createElement('button');
            prevBtn.textContent = '<';
            prevBtn.classList.add('px-2', 'py-1', 'bg-gray-200', 'rounded');
            prevBtn.onclick = () => createCalendar(month === 0 ? year - 1 : year, (month + 11) % 12);

            const nextBtn = document.createElement('button');
            nextBtn.textContent = '>';
            nextBtn.classList.add('px-2', 'py-1', 'bg-gray-200', 'rounded');
            nextBtn.onclick = () => createCalendar(month === 11 ? year + 1 : year, (month + 1) % 12);

            const title = document.createElement('div');
            title.textContent = `${monthNames[month]} ${year}`;
            title.classList.add('font-semibold');

            header.appendChild(prevBtn);
            header.appendChild(title);
            header.appendChild(nextBtn);
            calendarEl.appendChild(header);

            const daysHeader = document.createElement('div');
            daysHeader.classList.add('grid', 'grid-cols-7', 'gap-1', 'text-center', 'mb-1');
            daysOfWeek.forEach(day => {
                const d = document.createElement('div');
                d.textContent = day;
                d.classList.add('font-medium');
                daysHeader.appendChild(d);
            });
            calendarEl.appendChild(daysHeader);

            const firstDayOfMonth = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            const grid = document.createElement('div');
            grid.classList.add('grid', 'grid-cols-7', 'gap-1');

            for(let i = 0; i < firstDayOfMonth; i++) {
                const emptyCell = document.createElement('div');
                grid.appendChild(emptyCell);
            }

            for(let day = 1; day <= daysInMonth; day++) {
                const dateStr = `${year}-${(month + 1).toString().padStart(2,'0')}-${day.toString().padStart(2,'0')}`;
                const cell = document.createElement('button');
                cell.textContent = day;
                cell.classList.add('p-1', 'rounded', 'w-full', 'hover:bg-blue-100');
                cell.type = 'button';

                if(lessonDates.includes(dateStr)) {
                    cell.classList.add('font-bold', 'text-blue-700');
                }

                if(selectedDate === dateStr) {
                    cell.classList.add('bg-blue-400', 'text-white');
                }

                cell.onclick = () => {
                    selectedDate = dateStr;
                    createCalendar(year, month);
                    updateChartForDate(dateStr);
                };

                grid.appendChild(cell);
            }

            calendarEl.appendChild(grid);
        }

        function updateChartForDate(dateStr) {
            if(!hourlyChart) return;

            const checkedCalendars = Array.from(calendarCheckboxes)
                .filter(chk => chk.checked)
                .map(chk => ({
                    name: chk.value,
                    color: chk.dataset.color
                }));

            if(checkedCalendars.length === 0) {
                hourlyChart.data.datasets = [];
                hourlyChart.update();
                return;
            }

            const datasets = checkedCalendars.map(cal => {
                const counts = new Array(hourLabels.length).fill(0);

                lessonItems.forEach(item => {
                    if(item.getAttribute('data-calendar') === cal.name && item.getAttribute('data-start') === dateStr) {
                        const startTime = item.getAttribute('data-start-time');
                        const hour = parseInt(startTime.split(':')[0]);
                        if(hour >= startHour && hour <= endHour) {
                            counts[hour - startHour]++;
                        }
                    }
                });

                return {
                    label: cal.name,
                    data: counts,
                    backgroundColor: cal.color,
                    borderWidth: 1
                };
            });

            hourlyChart.data.datasets = datasets;
            hourlyChart.update();
        }

        calendarCheckboxes.forEach(chk => {
            chk.addEventListener('change', () => {
                if(selectedDate) {
                    updateChartForDate(selectedDate);
                }
            });
        });

        // Start calendar op vandaag en update chart meteen
        const today = new Date();
        const y = today.getFullYear();
        const m = today.getMonth();
        const d = today.toISOString().slice(0,10);
        selectedDate = d;
        createCalendar(y, m);
        updateChartForDate(selectedDate);
    });
</script>

<style>
    /* Optioneel: legenda layout */
    #legend div {
        cursor: default;
    }
</style>
</x-layout>
