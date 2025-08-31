<!-- Standard sidebar -->
<!-- Standard sidebar -->
<div class="adminuiux-sidebar">
    <div class="adminuiux-sidebar-inner">
        <!-- Profile -->
        <div class="px-3 not-iconic mt-3">
            <div class="row">
                <div class="col align-self-center ">
                    <h6 class="fw-medium">Main Menu</h6>
                </div>
                <div class="col-auto">
                    <a class="btn btn-link btn-square" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile" aria-expanded="false" role="button" aria-controls="usersidebarprofile">
                        <i data-feather="user"></i>
                    </a>
                </div>
            </div>
            <div class="text-center collapse " id="usersidebarprofile">
                <figure class="avatar avatar-100 rounded-circle coverimg my-3">
                    <img src="{{ secure_url('assets/img/user.png') }}" alt="{{ Auth::user()->name }}">
                </figure>
                <h5 class="mb-1 fw-medium">{{ Auth::user()->name }}</h5>
                <p class="small">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <ul class="nav flex-column menu-active-line">
            <!-- investment sidebar -->
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="menu-icon bi bi-columns-gap"></i>
                    <span class="menu-name">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('wallet') }}" class="nav-link">
                    <i class="menu-icon bi bi-wallet"></i>
                    <span class="menu-name">Wallet</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('my.earnings') }}" class="nav-link">
                    <i class="menu-icon bi bi-cash-stack"></i>
                    <span class="menu-name">My Earnings</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('my.subscriptions') }}" class="nav-link">
                    <i class="menu-icon bi bi-bank"></i>
                    <span class="menu-name">My Subscription</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('investment.index') }}" class="nav-link">
                    <i class="menu-icon bi bi-piggy-bank"></i>
                    <span class="menu-name">Investment</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('my.transactions') }}" class="nav-link">
                    <i class="menu-icon bi bi-bar-chart-line"></i>
                    <span class="menu-name">Transactions</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('withdrawal') }}">
                    <i class="menu-icon bi bi-cpu"></i>
                    <span class="menu-name">Withdrawals</span>
                </a>
            </li>

        </ul>
        <!-- User account -->
        <ul class="nav flex-column menu-active-line">
            <!-- bottom sidebar menu -->
            <li class="nav-item">
                <a href="{{ route('referrals') }}" class="nav-link">
                    <i class="menu-icon" data-feather="users"></i>
                    <span class="menu-name">Referrals</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('settings') }}" class="nav-link">
                    <i class="menu-icon" data-feather="settings"></i>
                    <span class="menu-name">Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                    <i class="menu-icon" data-feather="log-out"></i>
                    <span class="menu-name">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>