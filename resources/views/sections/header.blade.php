<nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background-color: rgb(0, 162, 255)">
    <div class="container">
        <a class="navbar-brand guide-1" href="/" >
            <svg xmlns="http://www.w3.org/2000/svg"
                width="26"
                height="26"
                fill="currentColor"
                class="d-inline-block align-text-top"
                viewBox="0 0 16 16">
                <path d="M6 1v3H1V1h5zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12v3h-5v-3h5zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8v7H1V8h5zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6v7h-5V1h5zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z"/>
              </svg>
            Pulic Table
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="ms-auto navbar-nav">
                @auth
                <guide-component></guide-component>
                <li class="nav-item dropdown guide-6">
                    <notifications-component></notifications-component>
                </li>
                <li class="nav-item dropdown guide-5">
                    <a class="nav-link active dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="rounded" src="{{ Auth::user()->avatar }}" width="22" height="22">
                        {{ strtok(Auth::user()->name, ' ') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                      <li><a class="dropdown-item" href="{{Auth::user()->getUrl()}}">{{__('My profile')}}</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="{{ route('social.auth.logout') }}">{{__('Logout')}}</a>
                      </li>
                    </ul>
                  </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('social.auth') }}">
                            {{__('Login')}}
                        </a>
                    </li>
                @endauth
                <li class="nav-item dropdown guide-2">
                    <a class="nav-link active dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ app()->getLocale() == 'en' ? 'English' : 'Español' }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                        <li><a class="dropdown-item" href="{{route('locale', 'en')}}">{{__('English')}}</a></li>
                        <li><a class="dropdown-item" href="{{route('locale', 'es')}}">{{__('Spanish')}}</a></li>
                      </li>
                    </ul>
                  </li>
            </ul>
        </div>
    </div>
</nav>
