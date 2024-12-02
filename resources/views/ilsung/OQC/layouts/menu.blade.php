<ul class="navbar-nav iq-main-menu" id="sidebar">
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Home</span>
            <span class="mini-icon">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('Home.OQC')) }}" aria-current="page"
            href="{{ route('Home.OQC') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/business.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Overview</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('OQC.plan')) }}" aria-current="page" href="{{ route('OQC.plan') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/business.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Plan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('OQC.loss')) }}" aria-current="page"
            href="{{ route('OQC.loss') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/planner.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Nhập lỗi</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('OQC.feedback')) }}" aria-current="page"
            href="{{ route('OQC.feedback') }}">
                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/checklist.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Feedback</span>
        </a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('warehouse.stock')) }}" aria-current="page"
            href="{{ route('warehouse.stock') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/checklist.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Tồn Kho</span>
        </a>
    </li> --}}

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
        <a class="nav-link  {{ Request::is('OQC/Master*') ? 'active' : '' }}" aria-current="page"
            href="{{ route('OQC.update.master') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/database-storage.png') }}" alt="Camera"
                width="20" height="20">
            <span class="item-name">Database</span>
        </a>


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



</ul>
