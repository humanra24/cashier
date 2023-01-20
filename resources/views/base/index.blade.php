<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ $data['title'] . ' - ' . auth()->user()->store->name }}</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <script src="{{ asset('js/fontawesome-6.1.0.js') }}"></script>
    @stack('css')
</head>

<body class="sb-nav-fixed">
    @include('partials.header')
    <div id="layoutSidenav">
        @include('partials.side')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="row align-items-center">
                        <div
                            class="@isset($data['btn']) col-md-6 @else @isset($data['id']) col-md-6 @else col-12 @endisset @endisset">
                            <h1 class="mt-4">{{ $data['title'] }}</h1>
                            @isset($data['breadcrumb'])
                                <ol class="breadcrumb mb-4">
                                    @foreach ($data['breadcrumb'] as $item)
                                        @if ($loop->last)
                                            <li class="breadcrumb-item active">{{ $item['label'] }}</li>
                                        @else
                                            <li class="breadcrumb-item">
                                                <a href="{{ $item['target'] }}">{{ $item['label'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ol>
                            @endisset
                        </div>
                        @isset($data['btn'])
                            <div class="col-md-6 text-md-end mb-3">
                                <a href="{{ $data['btn']['target'] }}"
                                    class="btn btn-primary">{{ $data['btn']['label'] }}</a>
                            </div>
                        @endisset
                        @isset($data['id'])
                            <div class="col-md-6 text-md-end mt-md-4 mb-3">
                                <span class="badge fs-6 bg-primary">{{ $data['id'] }}</span>
                            </div>
                        @endisset
                    </div>

                    @yield('content')
                </div>
            </main>
            @include('partials.footer')
        </div>
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/sweetalert2-11.7.0.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/datatable/datatable-bootstrap5.js') }}"></script>
    <script src="{{ asset('js/custom/logout.js') }}"></script>
    @stack('js')
</body>

</html>
