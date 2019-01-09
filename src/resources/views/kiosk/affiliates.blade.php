@extends('spark::layouts.app')

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Tabs -->
        <div class="col-md-4">
            <div class="panel panel-default panel-flush">
                <div class="panel-heading">
                    Kiosk
                </div>

                <div class="panel-body">
                    <div class="spark-settings-tabs">
                        <ul class="nav spark-settings-stacked-tabs" role="tablist">
                            <li class="active">
                                <a href="{{url('/spark/kiosk')}}">
                                    <i class="fa fa-fw fa-btn fa-dashboard"></i>Back to Kiosk
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default panel-flush">
                <div class="panel-heading">
                    Affiliates
                </div>

                <div class="panel-body">
                    <div class="col-md-8">
                        @foreach($affiliates as $affiliate)
                        <div class="row">
                            <div class="col-md-12">
                                <h3>{{$affiliate['name']}}</h3>
                                <div class="panel panel-default">
                                    <div class="panel-heading">Subscribers</div>

                                    <div class="panel-body">
                                        <table class="table table-borderless m-b-none">
                                            <thead>
                                                <th>Name</th>
                                                <th>Subscribers</th>
                                            </thead>

                                            <tbody>
                                                @foreach($affiliate['plans'] as $plan => $count)
                                                <tr>
                                                    <!-- Plan Name -->
                                                    <td>
                                                        <div class="btn-table-align">
                                                            {{ $plan }}
                                                        </div>
                                                    </td>

                                                    <!-- Subscriber Count -->
                                                    <td>
                                                        <div class="btn-table-align">
                                                            {{ $count }}
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
