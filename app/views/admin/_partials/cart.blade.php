@if (Sentry::check())
	<ul class="nav-cart">
            <li><a href="{{URL::route('admin.cart.inventory.products.index')}}">Products</a></li>
            <li><a href="{{URL::route('admin.cart.inventory.category.index')}}">Categories</a></li>
            <li><a href="{{URL::route('admin.cart.inventory.units.index')}}">Unit</a></li>
	</ul>
@endif
