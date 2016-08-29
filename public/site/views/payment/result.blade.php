@include('site::_partials/header')

<div class="row">
    <div class="large-12 columns">
        {{ Notification::showAll() }}
    </div>
</div>

<div class="animated fadeInUp">	
    <works>		
        <div class="row">
            <div class="large-12 columns">
               
            </div>
        </div>
    </works>
</div>
@include('site::_partials.footer')



