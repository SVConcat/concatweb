@component('mail::message')
    Hallo!
    <br>
    Blijf up to date met concat en lees onze nieuwsbrief in de bijlagen.



    @component('mail::button', ['url' => config('app.url')])
        ga naar onze site
    @endcomponent

    Met vriendelijke groeten,<br>
    Concat
@endcomponent
