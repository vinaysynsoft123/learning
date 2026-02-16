a<div class="sidebar" id="sidebar">
    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-house me-3"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('package_calculator') ? 'active' : '' }}"
                href="{{ route('admin.package.calculations') }}"><i class="bi bi-people me-3"></i> Package Calculator</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('destinations') ? 'active' : '' }}"
                href="{{ route('destinations.index') }}">
                <i class="bi bi-calendar3 me-3"></i> Destinations
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('#') ? 'active' : '' }}" href="{{ route('themes.index') }}">
                <i class="bi bi-building me-3"></i> Themes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('#') ? 'active' : '' }}"
                href="{{ route('hotel-categories.index') }}">
                <i class="bi bi-building me-3"></i> Room Management
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('hotels.index') ? 'active' : '' }}"
                href="{{ route('hotels.index') }}">
                <i class="bi bi-building me-3"></i> Hotels
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('#') ? 'active' : '' }}" href="{{ route('packages.index') }}">
                <i class="bi bi-building me-3"></i> Packages
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('packages.international') ? 'active' : '' }}"
                href="{{ route('packages.international') }}">
                <i class="bi bi-airplane me-3"></i> International Packages
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('vehicles') ? 'active' : '' }}"
                href="{{ route('vehicles.index') }}"><i class="bi bi-people me-3"></i> Vehicles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports') ? 'active' : '' }}"
                href="{{ route('reports.index') }}">
                <i class="bi bi-graph-up me-3"></i> Reports
            </a>

        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('terms-conditions.*') ? 'active' : '' }}"
                href="{{ route('terms-conditions.index') }}">
                <i class="bi bi-file-text me-3"></i> Terms & Conditions
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}" href="{{ route('settings') }}"><i
                    class="bi bi-gear me-3"></i> Settings</a>
        </li>
    </ul>
</div>
