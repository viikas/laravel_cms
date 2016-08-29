@include('site::_partials/headerSimple')
<style>
    .error-paragraph{font-size: 16px;margin:10px 0;}
    a:hover{color:#006b4d;}
</style>
<div style="margin:50px;color:#333;">
	<h2 style="padding-bottom:10px;border-bottom:3px solid #bbb;color:#006b4d;">Page not found</h2>
	<p class="error-paragraph">The page you requested either does not exists or has been removed.</p>
        <p class="error-paragraph"><b>What can I do?</b></p>
        <p class="error-paragraph">
        <ul style="margin-left: 30px;">
            <li>Go back to <a style="color:green;" href="{{URL::route('site.index')}}">home page</a></li>
            <li>Go to <a style="color:green;" href="{{URL::route('site.contact')}}">contact page</a> and tell us about it</li>
        </ul>
        </p>
        <p class="error-paragraph">We are sorry for the inconvenience occurred.</p>

</div>

@include('site::_partials/footerSimple')
