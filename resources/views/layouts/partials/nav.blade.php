  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->

    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      @auth
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
          <form action="{{route('logout')}}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary">LOGOUT</button>
          </form>
        </div>
      </div>
      @endauth

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      {{-- <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                @yield('title')
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New ---</span>
              </p>
            </a>
          </li>
        </ul>
      </nav> --}}
      <x-nav :menu="[
        [
            'name' => 'Category',
            'url' => '/dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'active' => true,
            'submenu' => [
                ['name' => 'active', 'url' => '/dashboard/categories/active', 'active' => true],
                ['name' => 'archived', 'url' => '/dashboard/categories/archived'],
            ]
        ],
        [
            'name' => 'Products',
            'url' => '/',
            'icon' => 'fas fa-th',
            'badge' => 'جديد',
            'badge_class' => 'badge-danger',
    ],
    [
            'name' => 'Orders',
            'url' => '/simple-link',
            'icon' => 'fas fa-th',
            'badge' => 'جديد',
            'badge_class' => 'badge-danger',
        ]

    ]" />

      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
