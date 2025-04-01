

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
