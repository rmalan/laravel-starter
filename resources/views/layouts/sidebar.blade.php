                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ url('/') }}">Laravel Starter</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{ url('/') }}">LS</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        <li><a class="nav-link" href="{{ url('/') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
                        @role('administrator')
                            <li class="menu-header"><i>Auth</i></li>
                            <li><a class="nav-link" href="{{ url('/permissions') }}"><i class="fas fa-key"></i> <span>Permissions</span></a></li>
                            <li><a class="nav-link" href="{{ url('/roles') }}"><i class="fas fa-user-tag"></i> <span>Roles</span></a></li>
                            <li><a class="nav-link" href="{{ url('/users') }}"><i class="fas fa-users-cog"></i> <span>Users</span></a></li>
                        @endrole
                    </ul>
                </aside>