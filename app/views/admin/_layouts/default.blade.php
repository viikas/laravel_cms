<!doctype html>
<html lang="en" encoding="">
    <?PHP
    header('Content-type:text/html;charset=utf-8');
    ?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>KarmaCMS :: Admin Panel</title>

	@include('admin._partials.assets')
</head>
<body>
<div class="container">
	@include('admin._partials.header')

	@yield('main')
</div>
</body>
</html>
