@extends('spark::layouts.app')

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endsection

@section('content')
<div class="spark-screen container">
    <div class="row">
        <!-- Tabs -->
        @include('affiliates-spark::affiliates.layouts.nav')
        <div class="col-md-9">
            @yield('sub-content')
        </div>
    </div>
</div>
@endsection
        