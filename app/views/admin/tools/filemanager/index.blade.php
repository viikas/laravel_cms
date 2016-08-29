@extends('admin._layouts.default')

@section('main')
@include('admin._partials.cms')
<h1>
    Manage Files and Folders
</h1>
<div id="fileTreeDemo_1" class="demoto">

</div>
<hr>

{{ Notification::showAll() }}
<link href="{{URL::asset('assets/filemanager/css/jquery-ui.css')}}" rel="stylesheet" type="text/css" media="screen" />
<script src="{{URL::asset('assets/filemanager/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/filemanager/jquery-ui-min.js')}}" type="text/javascript"></script>

<script src="{{URL::asset('assets/filemanager/gsFileManager.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/filemanager/jquery.form.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/filemanager/jquery.Jcrop.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/filemanager/jquery-ui-min.js')}}" type="text/javascript"></script>

<script src="{{URL::asset('assets/ckeditor/ckeditor.js')}}" type="text/javascript"></script>

<link href="{{URL::asset('assets/filemanager/gsFileManager.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{URL::asset('assets/filemanager/jquery.Jcrop.css')}}" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">
			
    $(document).ready( function() {
				
        jQuery('#fileTreeDemo_1').gsFileManager({ script: '{{URL::asset("assets/filemanager/connectors/GsFileManager.php")}}' });
				
    });
</script>
@stop
