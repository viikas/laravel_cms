@if (Sentry::check())
	<ul class="nav-cart">
            <li><a href="{{URL::route('admin.cms.pages.index')}}">Pages</a></li>
            <li><a href="{{URL::route('admin.cms.articles.index')}}">Articles</a></li>
            <li><a href="{{URL::route('admin.cms.category.index')}}">Categories</a></li>
            <li><a href="{{URL::route('admin.cms.gallery.index')}}">Gallery</a></li>
            <li><a href="{{URL::route('admin.cms.contacts.index')}}">Contacts/Messages</a></li>
            
	</ul>
@endif
