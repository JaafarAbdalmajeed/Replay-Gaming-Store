<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach ($menu as $item)
            <li class="nav-item {{ isset($item['submenu']) ? 'menu-open' : '' }}">
                <a href="{{ $item['url'] ?? '#' }}" class="nav-link {{ $item['active'] ?? false ? 'active' : '' }}">
                    <i class="nav-icon {{ $item['icon'] }}"></i>
                    <p>
                        {{ $item['name'] }}
                        @if (isset($item['submenu']))
                            <i class="right fas fa-angle-left"></i>
                        @endif
                    </p>
                </a>
                @if (isset($item['submenu']))
                    <ul class="nav nav-treeview">
                        @foreach ($item['submenu'] as $sub)
                            <li class="nav-item">
                                <a href="{{ $sub['url'] }}" class="nav-link {{ $sub['active'] ?? false ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ $sub['name'] }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
