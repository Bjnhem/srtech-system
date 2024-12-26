<ul class="navbar-nav iq-main-menu" id="sidebar">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs(['WareHouse.chuyen.kho', 'Home.index']) ? 'active' : '' }}"
            aria-current="page" href="{{ route('WareHouse.chuyen.kho') }}">
            <img class=" icon" src="{{ asset('SR-TECH/icon/transfer.png') }}" alt="Camera" width="20" height="20">
            <span class="item-name">Nhập xuất</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('WareHouse.history')) }}" aria-current="page"
            href="{{ route('WareHouse.history') }}">
            <img class=" icon" src="{{ asset('SR-TECH/icon/checklist.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Lịch sử NX</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('warehouse.stock')) }}" aria-current="page"
            href="{{ route('warehouse.stock') }}">
            <img class=" icon" src="{{ asset('SR-TECH/icon/stock.png') }}" alt="Camera" width="20"
                height="20">
            <span class="item-name">Tồn Kho</span>
        </a>
    </li>

    <li>
        <hr class="hr-horizontal">
    </li>

    {{-- Master data --}}
    @if (Auth::user()->user_type == 'admin' || auth::user()->user_type == 'leader')
        <li class="nav-item static-item">
            <a class="nav-link static-item disabled" href="#" tabindex="-1">
                <span class="default-icon">Master data</span>
                <span class="mini-icon">-</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link  {{ Request::is('Master*') ? 'active' : '' }}" aria-current="page"
                href="{{ route('WareHouse.update.master') }}">
                <img class=" icon" src="{{ asset('SR-TECH/icon/database-storage.png') }}" alt="Camera"
                    width="20" height="20">
                <span class="item-name">Database</span>
            </a>
        </li>
        {{-- @endif --}}

        {{-- @if (Auth::user()->user_type == 'admin') --}}
        <li class="nav-item">
            <a class="nav-link  {{ Request::is('User*') ? 'active' : '' }}" aria-current="page"
                href="{{ route('user.index') }}">
                <img class=" icon" src="{{ asset('SR-TECH/icon/group.png') }}" alt="Camera" width="20"
                    height="20">
                <span class="item-name">Users</span>
            </a>
        </li>
    @endif


</ul>
