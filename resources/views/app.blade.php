@include('partials.head')
<body>
@include('partials.javascript')
@include('partials.nav')

<div class="container">

@yield('content')

</div>

@yield('scripts')
@include('partials.javascript')
</body>
</html>