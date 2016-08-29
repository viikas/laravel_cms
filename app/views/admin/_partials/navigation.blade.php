@if (Sentry::check())
	<ul class="nav">
            <li class="{{ Request::is('admin/cms*') ? 'active' : null }}"><a href="{{ URL::route('admin.cms.pages.index') }}"><i class="icon-book"></i> CMS</a></li>	
            <li class="{{ Request::is('admin/files-manager*') ? 'active' : null }}"><a href="{{ URL::route('admin.tools.filesmanager') }}"><i class="icon-book"></i> Files</a></li>	
	<!--<li class="{{ Request::is('admin/cart/orders*') ? 'active' : null }}"><a href="{{ URL::route('admin.cart.orders.index') }}"><i class="icon-book"></i> Orders</a></li>	
        <li class="{{ Request::is('admin/cart/inventory*') ? 'active' : null }}"><a href="{{ URL::route('admin.cart.inventory.products.index') }}"><i class="icon-asterisk"></i> Products</a></li>	-->
           <li class="{{ Request::is('admin/users*') ? 'active' : null }}"><a href="{{ URL::route('admin.users.index') }}"><i class="icon-user"></i> Users</a></li>
                <li class="{{ Request::is('admin/users/password') ? 'active' : null }}"><a href="{{ URL::route('admin.users.password') }}"><i class="icon-asterisk"></i> Change Password</a></li>
                <!--<li class="{{ Request::is('admin/permissions*') ? 'active' : null }}"><a href="{{ URL::route('admin.permissions.index') }}"><i class="icon-permission"></i> Permissions</a></li>-->
		<li><a href="{{ URL::route('admin.logout') }}"><i class="icon-lock"></i> Logout</a></li>
	</ul>
@endif
