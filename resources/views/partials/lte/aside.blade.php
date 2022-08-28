<aside class="main-sidebar sidebar-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{asset('assets/dist/img/snh_logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">St. Nicholas Hospital</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="/img/profile/{{Auth::user()->image}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="#" class="d-block">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">    
                <li class="nav-item">
                    <a href="/home" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a>
                </li>
                <li class="nav-item">
                    <a href="/profile" class="nav-link"><i class="nav-icon fas fa-user"></i><p>Profile</p></a>
                </li>
                @if(Auth::user()->hasRole('E-Services') || Auth::user()->hasRole('Super Admin'))
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-briefcase-medical"></i>
                        <p>Electronic Services <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/eservices/front_office" class="nav-link">
                            <i class="fas fa-laptop-medical nav-icon"></i>
                            <p>Front Office</p>
                            </a>
                        </li>
                        @if(Auth::user()->hasRole('Tutor') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('learn_tutor'))
                        <li class="nav-item">
                            <a href="/eservices/tutor_area" class="nav-link">
                            <i class="fas fa-user-md nav-icon"></i>
                            <p>Medical Officer</p>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasRole('Learning Admin') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('learn_admin'))
                        <li class="nav-item">
                            <a href="/eservices/admin_area" class="nav-link">
                            <i class="fa fa-x-ray nav-icon"></i>
                            <p>Radiologist</p>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasRole('Learning Admin') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('learn_admin'))
                        <li class="nav-item">
                            <a href="/eservices/admin_area" class="nav-link">
                            <i class="fa fa-user-cog nav-icon"></i>
                            <p>Administrator</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(Auth::user()->hasRole('Super Admin') || Auth::user()->can('user_management') || Auth::user()->hasRole('Human Resource'))
                <li class="nav-item">
                    <a href="/users" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Users</p></a>
                </li>
                <li class="nav-item">
                    <a href="/departments" class="nav-link"><i class="nav-icon fas fa-boxes"></i><p>Departments</p></a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="/chats" class="nav-link"><i class="nav-icon fas fa-comments"></i><p>Chats </p></a>
                </li>
                <li class="nav-item">
                    <a href="/contacts" class="nav-link"><i class="nav-icon fas fa-address-book"></i><p>Contacts</p></a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>Learning <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/learn/student_area" class="nav-link">
                            <i class="fas fa-user-graduate nav-icon"></i>
                            <p>Students</p>
                            </a>
                        </li>
                        @if(Auth::user()->hasRole('Tutor') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('learn_tutor'))
                        <li class="nav-item">
                            <a href="/learn/tutor_area" class="nav-link">
                            <i class="fas fa-chalkboard-teacher nav-icon"></i>
                            <p>Tutors</p>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasRole('Learning Admin') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('learn_admin'))
                        <li class="nav-item">
                            <a href="/learn/admin_area" class="nav-link">
                            <i class="fa fa-user-cog nav-icon"></i>
                            <p>Administrator</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/staff_month" class="nav-link"><i class="nav-icon fas fa-user-circle"></i><p>Staff of the Month</p></a>
                </li>
                <li class="nav-item">
                    <a href="/policies" class="nav-link"><i class="nav-icon fas fa-file-contract"></i><p>Policies</p></a>
                </li>
                 <li class="nav-item">
                    <a href="/notices" class="nav-link"><i class="nav-icon fas fa-clipboard"></i><p>Notices</p></a>
                </li>
                <li class="nav-item">
                    <a href="/ticketing" class="nav-link"><i class="nav-icon fas fa-tags"></i><p>Tickets</p></a>
                </li>
                @if(Auth::user()->hasRole('Information Technology') || Auth::user()->hasRole('Super Admin'))
                <li class="nav-item">
                    <a href="/internet" class="nav-link"><i class="nav-icon fas fa-network-wired"></i><p>Internet Checker</p></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Super Admin'))
                <li class="nav-item">
                    <a href="/settings" class="nav-link"><i class="nav-icon fas fa-cogs"></i><p>Settings</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="nav-icon fas fa-power-off"></i><p>Log Out </p></a>
                </li>
            </ul>
        </nav>
    </div>
</aside>