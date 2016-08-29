<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>District Agriculture Development Office (DADO) - Official Website</title>
    <meta name="keywords" content="dado, siraha, agriculture, government office">
    <meta name="description" content="This is official website of ">
    <link rel="stylesheet" href="{{ asset('site/assets/styles.css') }}">
</head>
<body><table style="margin:0 auto;" align="center">
        <tr>
            <td>

                <div id="content">
                    <!-- header begins -->
                    <div id="header">
                        <div id="logo">

                        </div>

                        @include('site::_partials.navigation')
                    </div>	
                    <!-- header ends -->
                    <!-- content begins -->
                    <div id="main">
                        <table width="1024px">
                            <tr>
                                <td width="229" valign="top">
                                    <div id="left_part">
                                        <div id="leftlinks" style="margin-bottom: 10px;border:none;background:none;text-a:none;">
                                            <a href="{{URL::route('site.contact')}}">
                                                {{HTML::image(URL::asset('site/assets/icons/feedback.png'))}}
                                            </a>
                                                
                                        </div>
                                        <div id="leftlinks2" style="padding:0;background:none;border:none;">
                                            {{$video->slug}}
                                        </div>
                                        <h1>DADO News</h1>
                                        <div id="leftlinks3">
                                            <ul>
                                                @foreach($news as $n)
                                                <li style="border-bottom:1px solid #eee;margin-right:20px;">
                                                    {{\Helper::ToTimeZone($n->created_at,true)}}
                                                    <h4><a href="{{URL::route('site.category.details',$n->id)}}">{{$n->title}}</a></h4>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div id="leftlinks3" style="border:none;background:none;">
                                            <div id="calendar"></div>
                                        </div>
                                    </div></td>
                                <td width="528" valign="top"><div id="right">                         
                                        <link rel="stylesheet" type="text/css" href="{{URL::asset('site/assets/css/jquery-ui.css')}}"/>
                                        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
                                        <script type="text/javascript" src="{{URL::asset('site/assets/js/jquery-ui-1.10.4.custom.min.js')}}"></script>
                                        <style>.ui-datepicker {
                                                width: 205px; /*what ever width you want*/
                                            }</style>
                                        <script type="text/javascript">
                                            $(function(){
                                                $('#calendar').datepicker({autoSize:true});
                                            });

                                        </script>




