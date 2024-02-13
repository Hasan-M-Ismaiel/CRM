<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <!-- brand name and logo-->
    <div class="sidebar-brand d-none d-md-flex">
        {{ config('app.name') }}    
        <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
        <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div>

    <!-- nav bar items-->
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                </svg> 
                Dashboard
            </a>
        </li>
        @if(Auth::user()->hasRole('admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user-follow') }}"></use>
                </svg> 
                Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.clients.index') }}">
                <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-money') }}"></use>
                </svg> 
                Clients
            </a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.projects.index') }}">
                <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-settings') }}"></use>
                </svg> 
                Projects
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.tasks.index') }}">
                <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list-high-priority') }}"></use>
                </svg> 
                Tasks
            </a>
        </li>
        <li class="nav-item">
            <a href="#submenu2" data-bs-toggle="collapse" class="nav-link dropdown-toggle">
                <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-chat-bubble') }}"></use>
                </svg> 
                Chats
                <span class="ms-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8"/>
                    </svg>
                </span>
            </a>
            <ul class="collapse nav flex-column ms-3 " id="submenu2" data-bs-parent="#menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.tasks.index') }}">
                        <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-chat-bubble') }}"></use>
                        </svg> 
                        Chats
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.tasks.index') }}">
                        <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-chat-bubble') }}"></use>
                        </svg> 
                        Chats
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
                </svg> 
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
