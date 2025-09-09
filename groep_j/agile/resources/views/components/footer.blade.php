<footer>
    <div class="container" id="footer-container">
        <div class="footerNav">
            <p>
                <a href="mailto:info@svconcat.nl">info@svconcat.nl</a>
                <a href="tel:+31644848495">(0)6 44848495</a>
                <br>
            </p>
            <ul>
                <li><a href="https://www.instagram.com/svconcat/" target="_blank">Instagram</a></li>
                <li><a href="https://www.linkedin.com/company/sv-concat" target="_blank">LinkedIn</a></li>
                <li><a href="#" target="_blank">Discord</a></li> <!-- De link van de Discord Server moet ingevoerd worden -->
            </ul>
        </div>
        <div class="footerNav">
            <p>
                <a href="{{ asset('assets/files/privacyverklaring_concat.pdf') }}" target="_blank">Privacyverklaring</a>
                @isset($statue)
                <a href="{{$statue->filepath_url ?? '#'}}" target="_blank">Statuten</a>
                @endisset
            </p>
            <br>
            <p class="end">&copy; {{date("Y")}} Studievereniging Concat</p>
        </div>
    </div>
</footer>
