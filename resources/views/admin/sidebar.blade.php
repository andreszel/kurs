<!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home.mainPage') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Świat gier</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home.mainPage') }}">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Panel</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                <span class="text-uppercase">Użytkownicy</span>
            </div>

            <!-- Nav Items -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('get.users') }}">
                    <i class="fas fa-user"></i>
                    <span>Użytkownicy</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-plus"></i>
                    <span>Dodaj</span></a>
            </li>