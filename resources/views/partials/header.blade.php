<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
            </svg>
        </button><a class="header-brand d-md-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
                <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
            </svg></a>
        <ul class="header-nav d-none d-md-flex">
            @can('user_access')<li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Users</a></li>@endcan
            @can('user_access')<li class="nav-item"><a class="nav-link" href="{{ route('admin.clients.index') }}">Clients</a></li>@endcan
            @can('user_access')<li class="nav-item"><a class="nav-link" href="{{ route('admin.projects.index') }}">Projects</a></li>@endcan
            @can('user_access')<li class="nav-item"><a class="nav-link" href="{{ route('admin.tasks.index') }}">Tasks</a></li>@endcan
            @can('user_access')<li class="nav-item"><a class="nav-link" href="{{ route('admin.skills.index') }}">Skills</a></li>@endcan
        </ul>
        <ul class="header-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link iconClass" href="{{ route('admin.notifications.index') }}">
                    @if(auth()->user()->unreadNotifications->count()==0)
                        <!--dont show-->
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                        </svg>
                        <em id = "num_of_notification" class="badge bg-danger text-white px-2 rounded-4"></em>
                    @else 
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                        </svg>
                        <em id = "num_of_notification" class="badge bg-danger text-white px-2 rounded-4">{{ auth()->user()->unreadNotifications->count() }}</em>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                <svg class="icon icon-lg">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list-rich') }}"></use>
                </svg></a></li>
            <li class="nav-item">
                <a class="nav-link chatParentClass" href="#">
                    <svg width="25" height="25">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-chat-bubble') }}"></use>
                    </svg>
                    <em id = "num_of_messages" class="badge bg-danger text-white px-2 rounded-4">1</em>
                </a>
            </li>
        </ul>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link py-0 imageParentClass" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    @if(Auth::user()->profile && Auth::user()->profile->getFirstMediaUrl("profiles"))
                        <div class="avatar avatar-md">
                            <img class="avatar-img" src='{{ Auth::user()->profile->getFirstMediaUrl("profiles") }}' alt="user@email.com" />
                        </div>
                        <span class="ms-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8"/>
                            </svg>
                        </span>
                    @elseif(Auth::user()->getFirstMediaUrl("users"))
                        <div class="avatar avatar-md"><img class="avatar-img" src='{{ Auth::user()->getMedia("users")[0]->getUrl("thumb") }}' alt="user@email.com" /></div>
                        <span class="ms-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8"/>
                            </svg>
                        </span>
                    @else 
                        <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('images/avatar.png') }}" alt="user@email.com"></div>
                        <span class="ms-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8"/>
                            </svg>
                        </span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Account</div>
                    </div>
                    <!-- remove the text-muted class & the style to activate the linke-->
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-bell') }}"></use>
                        </svg> Updates<span class="badge badge-sm bg-info ms-2">42</span>
                    </a>
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-envelope-open') }}"></use>
                        </svg> Messages<span class="badge badge-sm bg-success ms-2">42</span>
                    </a>
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-task') }}"></use>
                        </svg> Tasks<span class="badge badge-sm bg-danger ms-2">42</span>
                    </a>
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-comment-square') }}"></use>
                        </svg> Comments<span class="badge badge-sm bg-warning ms-2">42</span>
                    </a>
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Settings</div>
                    </div>
                    <a class="dropdown-item" href="{{ route('admin.users.show', Auth::user()) }}">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                        </svg> Account</a>
                    <a class="dropdown-item" href="{{ route('admin.profiles.show', Auth::user()) }}">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                        </svg> Profile</a>
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-settings') }}"></use>
                        </svg> Settings</a>
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-credit-card') }}"></use>
                        </svg> Payments<span class="badge badge-sm bg-secondary ms-2">42</span>
                    </a>
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-file') }}"></use>
                        </svg> Projects<span class="badge badge-sm bg-primary ms-2">42</span>
                    </a>
                    <div class="dropdown-divider text-muted" style="pointer-events: none; cursor: default;"></div>
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                        </svg> Lock Account
                    </a>
                    <a class="dropdown-item text-muted" style="pointer-events: none; cursor: default;" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
                        </svg> Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
    <div class="header-divider"></div>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                <li class="breadcrumb-item">
                    <!-- if breadcrumb is single--><span>Hello</span>
                </li>
                <li class="breadcrumb-item active">
                    <span> You could add notification flash here</span>
                </li>
            </ol>
        </nav>
    </div>
</header>