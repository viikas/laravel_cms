@include('site::_partials/headersimple')
<article>
    <div id="content-simple">
        {{ Notification::showAll() }}
    </div>
</article>
@include('site::_partials/footer')