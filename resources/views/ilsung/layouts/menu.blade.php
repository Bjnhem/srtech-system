<ul class="navbar-nav iq-main-menu" id="sidebar">
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Home</span>
            <span class="mini-icon">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('Home.checklist')) }}" aria-current="page" href="{{ route('Home.checklist') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/business.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Overview</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('Check.checklist')) }}" aria-current="page"
            href="{{ route('Check.checklist') }}">
            {{-- <i class=" icon"></i> --}}
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/checklist.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Check list</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('Plan.checklist')) }}" aria-current="page"
            href="{{ route('Plan.checklist') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/planner.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Plan</span>
        </a>
    </li>
    <li>
        <hr class="hr-horizontal">
    </li>

    {{-- Master data --}}
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Master data</span>
            <span class="mini-icon">-</span>
        </a>
    </li>

    {{-- database --}}

    <li class="nav-item">
        <a class="nav-link  {{ Request::is('Checklist/Master*') ? 'active' : '' }}" aria-current="page"
            href="{{ route('update.master') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/database-storage.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Database</span>
        </a>

        {{-- <a class="nav-link  {{ Request::is('Update-master*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#sidebar-special-pages" role="button" aria-expanded="false"
            aria-controls="sidebar-special-pages">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/database-storage.png') }}" alt="Camera"
                width="20" height="20">

            <span class="item-name">Database</span> --}}
        {{-- <i class="right-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </i> --}}
        {{-- </a> --}}
        {{-- <ul class="sub-nav collapse" id="sidebar-special-pages" data-bs-parent="#sidebar">
            <li class=" nav-item ">
                <a class="nav-link {{ activeRoute(route('update.data.model')) }}" href="{{ route('update.data.model') }}">
                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/next.png') }}" alt="Camera"
                        width="20" height="20">
                    <span class="item-name">Model</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ activeRoute(route('update.data.line')) }}"
                    href="{{ route('update.data.line') }}">
                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/next.png') }}" alt="Camera"
                        width="20" height="20">
                    <span class="item-name">line</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ activeRoute(route('special-pages.kanban')) }}"
                    href="{{ route('special-pages.kanban') }}">
                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/next.png') }}" alt="Camera"
                        width="20" height="20">
                    <span class="item-name">Machine</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ activeRoute(route('special-pages.pricing')) }}"
                    href="{{ route('special-pages.pricing') }}">
                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/next.png') }}" alt="Camera"
                        width="20" height="20">
                    <span class="item-name">Checklist item</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ activeRoute(route('special-pages.rtlsupport')) }}"
                    href="{{ route('special-pages.rtlsupport') }}">
                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/next.png') }}" alt="Camera"
                        width="20" height="20">
                    <span class="item-name">Checklist detail</span>
                </a>
            </li>
          
        </ul> --}}
    </li>


    {{-- user --}}


    {{-- <li class="nav-item">
        <a class="nav-link  {{ Request::is('users*') ? 'active' : '' }}" aria-current="page"
            href="{{ route('users.index') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/group.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Users</span>
        </a>
    </li> --}}

    {{-- <li class="nav-item">
        <a class="nav-link " data-bs-toggle="collapse" href="#sidebar-user" role="button" aria-expanded="false"
            aria-controls="sidebar-user">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/group.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Users</span>
            <i class="right-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </i>
        </a>
        <ul class="sub-nav collapse" id="sidebar-user" data-bs-parent="#sidebar">
            <li class="nav-item">
                <a class="nav-link {{ activeRoute(route('users.index')) }}" href="{{ route('users.index') }}">
                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/next.png') }}" alt="Camera"
                        width="20" height="20">
                    <span class="item-name">User List</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ activeRoute(route('users.show', 1)) }}" href="{{ route('users.show', 1) }}">
                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/next.png') }}" alt="Camera"
                        width="20" height="20">
                    <span class="item-name">User Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ activeRoute(route('users.create')) }}" href="{{ route('users.create') }}">
                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/next.png') }}" alt="Camera"
                        width="20" height="20">
                    <span class="item-name">Edit User</span>
                </a>
            </li>

        </ul>
    </li> --}}

    {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-auth" role="button" aria-expanded="false"
            aria-controls="sidebar-user">
            <i class="icon">
                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.4"
                        d="M12.0865 22C11.9627 22 11.8388 21.9716 11.7271 21.9137L8.12599 20.0496C7.10415 19.5201 6.30481 18.9259 5.68063 18.2336C4.31449 16.7195 3.5544 14.776 3.54232 12.7599L3.50004 6.12426C3.495 5.35842 3.98931 4.67103 4.72826 4.41215L11.3405 2.10679C11.7331 1.96656 12.1711 1.9646 12.5707 2.09992L19.2081 4.32684C19.9511 4.57493 20.4535 5.25742 20.4575 6.02228L20.4998 12.6628C20.5129 14.676 19.779 16.6274 18.434 18.1581C17.8168 18.8602 17.0245 19.4632 16.0128 20.0025L12.4439 21.9088C12.3331 21.9686 12.2103 21.999 12.0865 22Z"
                        fill="currentColor"></path>
                    <path
                        d="M11.3194 14.3209C11.1261 14.3219 10.9328 14.2523 10.7838 14.1091L8.86695 12.2656C8.57097 11.9793 8.56795 11.5145 8.86091 11.2262C9.15387 10.9369 9.63207 10.934 9.92906 11.2193L11.3083 12.5451L14.6758 9.22479C14.9698 8.93552 15.448 8.93258 15.744 9.21793C16.041 9.50426 16.044 9.97004 15.751 10.2574L11.8519 14.1022C11.7049 14.2474 11.5127 14.3199 11.3194 14.3209Z"
                        fill="currentColor"></path>
                </svg>
            </i>
            <span class="item-name">Authentication</span>
            <i class="right-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </i>
        </a>
        <ul class="sub-nav collapse" id="sidebar-auth" data-bs-parent="#sidebar">
            <li class="nav-item">
                <a class="nav-link {{ activeRoute(route('auth.signin')) }}" href="{{ route('auth.signin') }}">
                    <i class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                            fill="currentColor">
                            <g>
                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                            </g>
                        </svg>
                    </i>
                    <i class="sidenav-mini-icon"> L </i>
                    <span class="item-name">Login</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ activeRoute(route('auth.signup')) }}" href="{{ route('auth.signup') }}">
                    <i class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                            fill="currentColor">
                            <g>
                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                            </g>
                        </svg>
                    </i>
                    <i class="sidenav-mini-icon"> R </i>
                    <span class="item-name">Register</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ activeRoute(route('auth.confirmmail')) }}"
                    href="{{ route('auth.confirmmail') }}">
                    <i class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                            fill="currentColor">
                            <g>
                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                            </g>
                        </svg>
                    </i>
                    <i class="sidenav-mini-icon"> C </i>
                    <span class="item-name">Confirm Mail</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ activeRoute(route('auth.lockscreen')) }}"
                    href="{{ route('auth.lockscreen') }}">
                    <i class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                            fill="currentColor">
                            <g>
                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                            </g>
                        </svg>
                    </i>
                    <i class="sidenav-mini-icon"> L </i>
                    <span class="item-name">Lock Screen</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ activeRoute(route('auth.recoverpw')) }}" href="{{ route('auth.recoverpw') }}">
                    <i class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                            fill="currentColor">
                            <g>
                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                            </g>
                        </svg>
                    </i>
                    <i class="sidenav-mini-icon"> R </i>
                    <span class="item-name">Recover password</span>
                </a>
            </li>
        </ul>
    </li> --}}

    {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#utilities-error" role="button" aria-expanded="false"
            aria-controls="utilities-error">
            <i class="icon">
                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.4"
                        d="M11.9912 18.6215L5.49945 21.864C5.00921 22.1302 4.39768 21.9525 4.12348 21.4643C4.0434 21.3108 4.00106 21.1402 4 20.9668V13.7087C4 14.4283 4.40573 14.8725 5.47299 15.37L11.9912 18.6215Z"
                        fill="currentColor"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.89526 2H15.0695C17.7773 2 19.9735 3.06605 20 5.79337V20.9668C19.9989 21.1374 19.9565 21.3051 19.8765 21.4554C19.7479 21.7007 19.5259 21.8827 19.2615 21.9598C18.997 22.0368 18.7128 22.0023 18.4741 21.8641L11.9912 18.6215L5.47299 15.3701C4.40573 14.8726 4 14.4284 4 13.7088V5.79337C4 3.06605 6.19625 2 8.89526 2ZM8.22492 9.62227H15.7486C16.1822 9.62227 16.5336 9.26828 16.5336 8.83162C16.5336 8.39495 16.1822 8.04096 15.7486 8.04096H8.22492C7.79137 8.04096 7.43991 8.39495 7.43991 8.83162C7.43991 9.26828 7.79137 9.62227 8.22492 9.62227Z"
                        fill="currentColor"></path>
                </svg>
            </i>
            <span class="item-name">Utilities</span>
            <i class="right-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </i>
        </a>
        <ul class="sub-nav collapse" id="utilities-error" data-bs-parent="#sidebar">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('errors.error404') }}">
                    <i class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                            fill="currentColor">
                            <g>
                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                            </g>
                        </svg>
                    </i>
                    <span class="item-name">Error 404</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('errors.error500') }}">
                    <i class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                            fill="currentColor">
                            <g>
                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                            </g>
                        </svg>
                    </i>
                    <span class="item-name">Error 500</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('errors.maintenance') }}">
                    <i class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24"
                            fill="currentColor">
                            <g>
                                <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                            </g>
                        </svg>
                    </i>
                    <span class="item-name">Maintence</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('role.permission.list')) }}"
            href="{{ route('role.permission.list') }}" target="_blank">
            <i class="icon">
                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.7688 8.71387H16.2312C18.5886 8.71387 20.5 10.5831 20.5 12.8885V17.8254C20.5 20.1308 18.5886 22 16.2312 22H7.7688C5.41136 22 3.5 20.1308 3.5 17.8254V12.8885C3.5 10.5831 5.41136 8.71387 7.7688 8.71387ZM11.9949 17.3295C12.4928 17.3295 12.8891 16.9419 12.8891 16.455V14.2489C12.8891 13.772 12.4928 13.3844 11.9949 13.3844C11.5072 13.3844 11.1109 13.772 11.1109 14.2489V16.455C11.1109 16.9419 11.5072 17.3295 11.9949 17.3295Z"
                        fill="currentColor"></path>
                    <path opacity="0.4"
                        d="M17.523 7.39595V8.86667C17.1673 8.7673 16.7913 8.71761 16.4052 8.71761H15.7447V7.39595C15.7447 5.37868 14.0681 3.73903 12.0053 3.73903C9.94257 3.73903 8.26594 5.36874 8.25578 7.37608V8.71761H7.60545C7.20916 8.71761 6.83319 8.7673 6.47754 8.87661V7.39595C6.4877 4.41476 8.95692 2 11.985 2C15.0537 2 17.523 4.41476 17.523 7.39595Z"
                        fill="currentColor"></path>
                </svg>
            </i>
            <span class="item-name">Admin</span>
        </a>
    </li> --}}

</ul>
