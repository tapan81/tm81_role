<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            

<!--***********************************************Dashboard************************************************-->
            <li style="margin-top:82px">
                <a href="{{ route('admin.index')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>

<!--***********************************************Role************************************************-->

 			<li>
                <a  href="{{ route('roles.index')}}"><i class="fa fa-lock fa-fw"></i> Role</a>
                <!-- /.nav-second-level -->
            </li>  
<!--***********************************************users************************************************-->

 			<li>
                <a  href="{{ route('users.index')}}"><i class="fa fa-lock fa-fw"></i> Users</a>
                <!-- /.nav-second-level -->
            </li>  

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
    <!-- /.navbar-static-side -->
