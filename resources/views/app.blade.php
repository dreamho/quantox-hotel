@include('partials.head')
<body>

@include('partials.nav')

<div class="container">
	
@yield('scripts')

@yield('content')

</div>

@include('partials.javascript')
</body>
</html>