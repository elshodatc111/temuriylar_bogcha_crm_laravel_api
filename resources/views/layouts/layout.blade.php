<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center text-center justify-content-between">
      <a href="{{ route('home') }}" class="logo d-flex align-items-center" >
        <span class="d-block d-lg-none">CRM</span>
        <span class="d-none d-lg-block">CRM Center</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown">
          <a class="nav-link nav-icon" href="#">
            <i class="bi bi-cash-stack text-danger"></i>
            <span class="badge bg-success badge-number">5</span>
          </a>
        </li>
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle" style="font-size: 25px;"></i>
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ auth()->user()->position->name ?? '-' }}</h6>
              <span>{{ auth()->user()->phone }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-person"></i>
                <span>Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Chiqish</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>

    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home') ? '' : 'collapsed' }}" href="{{ route('home') }}">
                    <i class="bi bi-grid"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('tashriflar') ? '' : 'collapsed' }}" href="#">
                    <i class="bi bi-people"></i>
                    <span>Tashriflar</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('positions','rooms') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Sozlamalar</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse {{ request()->routeIs('positions','rooms') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('positions') }}" class="{{ request()->routeIs('positions') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Lavozimlar</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('rooms') }}" class="{{ request()->is('rooms') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Xonalar</span>
                        </a>
                    </li>
                </ul>
            </li>



        </ul>
    </aside>

    <main id="main" class="main">

    @yield('content')

</main>

  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
    <strong><span>CodeStart</span></strong> Dev Center
    </div>
  </footer>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
