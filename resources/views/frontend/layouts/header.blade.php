<header class="header py-3 bg-white shadow-sm">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">

            <!-- LOGO -->
            <img src="{{ asset('logo.png') }}" alt="Logo" height="50">

            <!-- NAV -->
            <ul class="nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="/package-calculator">Calculator</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
               
              
                @auth
                    @if (auth()->user()->role === 'Agent')
                        <li class="nav-item dropdown ms-3">
                            <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('agent.dashboard') }}">
                                        Dashboard
                                    </a>
                                </li>
                                 <li>
                                    <a class="dropdown-item" href="{{ route('agent.dashboard') }}">
                                        Profile 
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('agent.logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item text-danger">
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                @else
                    <li class="nav-item ms-3">
                        <a href="{{ route('register') }}" class="btn btn-outline-primary">
                            Agent Login
                        </a>
                    </li>
                @endauth
            </ul>

        </div>
    </div>
</header>
