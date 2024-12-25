<nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
    <div class="container-fluid navbar-inner">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto  navbar-list mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a href="#" class="search-toggle nav-link" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('images/Flag/VN.png') }}" class="img-fluid rounded-circle" alt="user"
                            style="height: 30px; min-width: 30px; width: 30px;">
                        <span class="bg-primary"></span>
                    </a>
                    <div class="sub-drop dropdown-menu dropdown-menu-end p-0" aria-labelledby="dropdownMenuButton2">
                        <div class="card shadow-none m-0 border-0">
                            <div class="p-0 ">
                                <ul class="list-group list-group-flush">
                                    <li class="iq-sub-card list-group-item"><a class="p-0" href="#"><img
                                                src="{{ asset('images/Flag/EN.jpg') }}" alt="img-flaf"
                                                class="img-fluid me-2"
                                                style="width: 15px;height: 15px;min-width: 15px;" />English</a></li>
                                    <li class="iq-sub-card list-group-item"><a class="p-0" href="#"><img
                                                src="{{ asset('images/Flag/HQ.jpg') }}" alt="img-flaf"
                                                class="img-fluid me-2"
                                                style="width: 15px;height: 15px;min-width: 15px;" />Korean</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                @if (Auth::user()->user_type == 'admin')
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" id="notification-drop" data-bs-toggle="dropdown">
                            <svg width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.7695 11.6453C19.039 10.7923 18.7071 10.0531 18.7071 8.79716V8.37013C18.7071 6.73354 18.3304 5.67907 17.5115 4.62459C16.2493 2.98699 14.1244 2 12.0442 2H11.9558C9.91935 2 7.86106 2.94167 6.577 4.5128C5.71333 5.58842 5.29293 6.68822 5.29293 8.37013V8.79716C5.29293 10.0531 4.98284 10.7923 4.23049 11.6453C3.67691 12.2738 3.5 13.0815 3.5 13.9557C3.5 14.8309 3.78723 15.6598 4.36367 16.3336C5.11602 17.1413 6.17846 17.6569 7.26375 17.7466C8.83505 17.9258 10.4063 17.9933 12.0005 17.9933C13.5937 17.9933 15.165 17.8805 16.7372 17.7466C17.8215 17.6569 18.884 17.1413 19.6363 16.3336C20.2118 15.6598 20.5 14.8309 20.5 13.9557C20.5 13.0815 20.3231 12.2738 19.7695 11.6453Z"
                                    fill="currentColor"></path>
                                <path opacity="0.4"
                                    d="M14.0088 19.2283C13.5088 19.1215 10.4627 19.1215 9.96275 19.2283C9.53539 19.327 9.07324 19.5566 9.07324 20.0602C9.09809 20.5406 9.37935 20.9646 9.76895 21.2335L9.76795 21.2345C10.2718 21.6273 10.8632 21.877 11.4824 21.9667C11.8123 22.012 12.1482 22.01 12.4901 21.9667C13.1083 21.877 13.6997 21.6273 14.2036 21.2345L14.2026 21.2335C14.5922 20.9646 14.8734 20.5406 14.8983 20.0602C14.8983 19.5566 14.4361 19.327 14.0088 19.2283Z"
                                    fill="currentColor"></path>
                            </svg>
                            <span class="bg-danger dots" style="display: none;">0</span>
                        </a>

                        <div class="sub-drop dropdown-menu dropdown-menu-end p-0" aria-labelledby="notification-drop">
                            <div class="card shadow-none m-0">
                                <div class="card-header d-flex justify-content-between bg-primary py-3">
                                    <div class="header-title">
                                        <h5 class="mb-0 text-white">All Notifications</h5>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div id="notification-list">
                                        <p class="text-center my-3">No pending notifications</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link py-0 d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">

                        @if (Auth::user()->user_type == 'admin')
                            <img src="{{ asset('images/avatars/01.png') }}" alt="User-Profile"
                                class="img-fluid avatar avatar-50 avatar-rounded">
                        @endif
                        @if (Auth::user()->user_type != 'admin')
                            <img src="{{ asset('images/avatars/avtar_5.png') }}" alt="User-Profile"
                                class="img-fluid avatar avatar-50 avatar-rounded">
                        @endif

                        <div class="caption ms-3 d-none d-md-block ">
                            <h6 class="mb-0 caption-title" style="text-transform: uppercase;">
                                {{ auth()->user()->username }}</h6>
                            <p class="mb-0 caption-sub-title text-capitalize text-center">
                                ({{ auth()->user()->user_type }})</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <form method="POST" action="{{ route('auth.logout') }}">
                                @csrf
                                <a href="javascript:void(0)" class="dropdown-item"
                                    onclick="event.preventDefault();
            this.closest('form').submit();">
                                    {{ __('Log out') }}
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
