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
    <ul id="parent" class="sidebar-nav" data-coreui="navigation" data-simplebar="" class="nav flex-column" id="nav_accordion">
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
            <a class="nav-link" href="{{ route('admin.skills.index') }}">
                <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-settings') }}"></use>
                </svg> 
                Skills
            </a>
        </li>

        <!-- <li class="nav-item">
            <a class="nav-link" href="#"> 
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-chat-bubble') }}"></use>
                </svg>
                Teams  
                <span class="ms-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8"/>
                    </svg>
                </span>
            </a>
            <ul id="teams" class="submenu collapse">
                
            </ul>
        </li> -->

        <li class="nav-item">
            <a class="nav-link" href="#"> 
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-chat-bubble') }}"></use>
                </svg>
                Tasks  
                <span class="ms-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8"/>
                    </svg>
                </span>
            </a>
            <ul id="tasks" class="submenu collapse">
                
            </ul>
        </li>
        
        <li class="nav-item" id="logout">
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

<script>
    document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
        
        element.addEventListener('click', function (e) {

        let nextEl = element.nextElementSibling;
        let parentEl  = element.parentElement;	

            if(nextEl) {
                e.preventDefault();	
                let mycollapse = new bootstrap.Collapse(nextEl);
                
                if(nextEl.classList.contains('show')){
                mycollapse.hide();
                } else {
                    mycollapse.show();
                    // find other submenus with class=show
                    var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                    // if it exists, then close all of them
                    if(opened_submenu){
                    new bootstrap.Collapse(opened_submenu);
                    }
                }
            }
        }); // addEventListener
    }) // forEach
    }); 
// DOMContentLoaded  end
</script>
<script>
    function loadteams(){
            $.ajax({
                url: "{{ route('admin.teams.index') }}",
                method: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(output){
                    var result = $.parseJSON(output);
                    console.log(result[0]);
                    $("#logout").before(result[0]);
                    // $('#teams').append(result[0]);
                }
            });
        }
</script>