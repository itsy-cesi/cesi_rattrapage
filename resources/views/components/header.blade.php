<div class="position-fixed d-flex flex-column flex-shrink-0 p-3 bg-light vh-100" style="width: 280px">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none mx-auto">
        <i class="fs-2 me-2 fa-solid fa-bug"></i>
        <span class="fs-2">BugFlow</span>
    </a>
    <hr />
    <ul class="nav nav-pills flex-column mb-auto link-dark">
        <li class="nav-item d-flex justify-center align-items-center">
            <i class="fas fa-home"></i>
            <a href="#" class="nav-link" aria-current="page">Feed</a>
        </li>
        <li class="nav-item d-flex justify-center align-items-center">
            <i class="fas fa-user-friends"></i>
            <a href="#" class="nav-link" aria-current="page">Friends</a>
        </li>
        <li class="nav-item d-flex justify-center align-items-center">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <a href="#" class="nav-link" aria-current="page">Chat</a>
        </li>
        <li class="nav-item d-flex justify-center align-items-center">
            <i class="fa fa-bell" aria-hidden="true"></i>
            <a href="#" class="nav-link" aria-current="page">Notifications</a>
        </li>
        <li class="nav-item d-flex justify-center align-items-center">
            <i class="fa fa-globe" aria-hidden="true"></i>
            <a href="#" class="nav-link" aria-current="page">Explore</a>
        </li>
        <li class="nav-item d-flex justify-center align-items-center">
            <i class="fa fa-users" aria-hidden="true"></i>
            <a href="#" class="nav-link" aria-current="page">Groups</a>
        </li>
        <li class="nav-item d-flex justify-center align-items-center">
            <i class="fa fa-hashtag" aria-hidden="true"></i>
            <a href="#" class="nav-link" aria-current="page">Hashtags</a>
        </li>
    </ul>
    @if (Auth::check())
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://robohash.org/{{ Auth::user()->name }}.png?set=set5" alt="" width="32"
                    height="32" class="rounded-circle me-2" />
                <strong>{{ Auth::user()->name }}</strong>
            </a>
            <ul class="dropdown-menu text-small shadow" style="">
                <li>
                    <a class="dropdown-item" href="#">New project...</a>
                </li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
            </ul>
        </div>
    @else
        <div class="dropdown">
            <a href="{{ route('login') }}" class="d-flex align-items-center link-dark text-decoration-none">
                <img src="https://img.icons8.com/external-tanah-basah-glyph-tanah-basah/48/null/external-user-social-media-ui-tanah-basah-glyph-tanah-basah.png"
                    alt="" width="32" height="32" class="rounded-circle me-2" />
                <strong>Sign in</strong>
            </a>
        </div>
    @endif
</div>
