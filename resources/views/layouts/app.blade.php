@include('layouts.head')
<body class="skin-blue layout-top-nav wysihtml5-supported" style="height: auto; min-height: 100%;">
    @include('layouts.header')

    <div class="container mt-3">
        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    @include('layouts.footer')
</body>
</html>
