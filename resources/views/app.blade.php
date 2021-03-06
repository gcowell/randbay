<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <link rel="icon" href="{!! asset('img/favicon.ico') !!}"/>

    @include('partials.open_graph_tags')

	<title>Randbay</title>

	<link href="/css/all.css" rel="stylesheet">

</head>
<body>

    @include('partials.nav')

    @yield('content')
	<!-- Scripts -->
    <script src="/js/all.js"></script>

</body>
</html>
