<header class="header py-3 bg-white shadow-sm">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">

              <img src="#" alt="Logo" height="50">

            <!-- NAV -->
            <ul class="nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="/package-calculator">Package Calculator</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="/international-calculator">International Calculator</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
               
              
                @auth
                   @if (in_array(auth()->user()->role, ['Agent', 'Staff', 'Freelancer']))

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
                                    <a class="dropdown-item" href="{{ route('agent.profile') }}">
                                        Profile 
                                    </a>
                                </li>
                                 <li>
                                    <a class="dropdown-item" href="{{ route('calculation.report') }}">
                                        Reports 
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
                   
                @endauth
            </ul>

        </div>
    </div>
</header>