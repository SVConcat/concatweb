<nav class="navbar navbar-expand-xl navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse" id="navbarNav">
        <ul class="navbar-nav flex-wrap">
            <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}"><span class="home"></span></a>
            </li>
            <li class="nav-item {{ Request::is('event*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.events.index') }}">Evenementen</a>
            </li>
            <li class="nav-item {{ Request::is('announcement*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('public.announcements.index') }}">Mededelingen</a>
            </li>
            <li class="nav-item {{ Request::is('gallery') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.galleries.index') }}">Galerij</a>
            </li>
            <li class="nav-item {{Request::is('assignment*') ? 'active' : ''}}">
                <a class="nav-link" href="{{ route('user.assignments.index') }}">Prikbord</a>
            </li>
            <li class="nav-item {{ Request::is('sponsors') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.sponsors.index') }}">Sponsoren</a>
            </li>
            <li class="nav-item {{ Request::is('about-us') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.about-us.index') }}">Over ons</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://sv-concat.myspreadshop.nl" target="_blank" rel="noopener noreferrer">Webshop</a>
            </li>

            <li class="nav-item has-children">
                <span class="nav-link">
                    <span class="profile"></span>
                </span>
                <ul class="submenu">
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.index') }}">Admin</a>
                            </li>
                        @endif

                        <li class="nav-item {{ Request::is('profile') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.profile.index') }}">Profiel</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Uitloggen
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item {{ Request::is('register') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('register') }}">Inschrijven</a>
                        </li>
                        <li class="nav-item {{ Request::is('login') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('login') }}">Inloggen</a>
                        </li>
                    @endauth
                </ul>
            </li>
        </ul>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        const navbarToggler = document.querySelector(".navbar-toggler");
        const navbarCollapse = document.querySelector("#navbarNav");

        navbarToggler.addEventListener("click", function(event){
            navbarCollapse.classList.toggle("show");
            event.stopPropagation();
        });

        document.addEventListener("click", function(event) {
            if(!navbarCollapse.contains(event.target) && !navbarToggler.contains(event.target)){
                navbarCollapse.classList.remove("show");
            }
        });

        document.querySelectorAll(".navbar-nav .nav-link").forEach(item => {
            item.addEventListener("click", function (){
                navbarCollapse.classList.remove("show");
            });
        });
    });
</script>
