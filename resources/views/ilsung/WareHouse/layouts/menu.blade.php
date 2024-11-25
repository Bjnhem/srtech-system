<ul class="navbar-nav iq-main-menu" id="sidebar">
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Home</span>
            <span class="mini-icon">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('Home.WareHouse')) }}" aria-current="page"
            href="{{ route('Home.WareHouse') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/business.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Overview</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('WareHouse.nhap.kho')) }}" aria-current="page" href="{{ route('WareHouse.nhap.kho') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/business.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Nhập Kho</span>
        </a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('WareHouse.chuyen.kho')) }}" aria-current="page"
            href="{{ route('WareHouse.chuyen.kho') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/planner.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Nhập xuất</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('WareHouse.xuat.kho')) }}" aria-current="page"
            href="{{ route('WareHouse.xuat.kho') }}">
                    <img class=" icon" src="{{ asset('checklist-ilsung/icon/checklist.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Xuất Kho</span>
        </a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('warehouse.stock')) }}" aria-current="page"
            href="{{ route('warehouse.stock') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/checklist.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Tồn Kho</span>
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
        <a class="nav-link  {{ Request::is('WareHouse/Master*') ? 'active' : '' }}" aria-current="page"
            href="{{ route('WareHouse.update.master') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/database-storage.png') }}" alt="Camera"
                width="20" height="20">
            <span class="item-name">Database</span>
        </a>


    </li>


    {{-- user --}}


    <li class="nav-item">
        <a class="nav-link  {{ Request::is('users*') ? 'active' : '' }}" aria-current="page"
            href="{{ route('users.index') }}">
            <img class=" icon" src="{{ asset('checklist-ilsung/icon/group.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Users</span>
        </a>
    </li>



</ul>
