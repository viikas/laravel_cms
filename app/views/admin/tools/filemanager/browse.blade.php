@extends('admin._layouts.empty')

@section('main')
<h1>
    Browse and Select File <input type="button" value="Cancel and Close" onclick="window.close();"/>
</h1>
<div id="container_id">

</div>
<hr>

<script src="{{URL::asset('assets/filemanager/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/filetree/jqueryFileTree.js')}}" type="text/javascript"></script>
<link href="{{URL::asset('assets/filetree/jqueryFileTree.css')}}" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">
    $(document).ready( function() {
        $('#container_id').fileTree({
            root: '/',
            script: '{{URL::asset("assets/filetree/connectors/jqueryFileTree.php")}}',
            expandSpeed: 1000,
            collapseSpeed: 1000,
            multiFolder: false
        }, function(file) {
            if(confirm('Following file will be selected:\n '+file+''))
            insertFile(file);
        });
        
    });
    function insertFile(fileName)
    {
        fileName=getAbsoluteUrlFromRelativeUrl(fileName);
        var func=getParameterByName('CKEditorFuncNum');
        window.parent.top.opener.CKEDITOR.tools.callFunction(func,fileName);
        window.parent.top.close(); 
        window.parent.top.opener.focus();
       
    }
    function getAbsoluteUrlFromRelativeUrl(url)
    {
        var host=location.host;
        if(host=='localhost')
            host+='/karma_cms';
        host+='/public/uploads';
        //alert(host);
        return decodeURI(location.protocol + "//" + host + url);        
    }
    
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
</script>
@stop
