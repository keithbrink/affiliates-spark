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
                    Affiliates
                </div>

                <div class="panel-body">
                    <div class="spark-settings-tabs">
                        <ul class="nav spark-settings-stacked-tabs" role="tablist">
                            <li class="active">
                                <a href="{{url('/affiliates')}}">
                                    <i class="fa fa-fw fa-btn fa-dashboard"></i>Affiliate Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/affiliates/transactions')}}">
                                    <i class="fa fa-fw fa-btn fa-money"></i>Transactions
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/affiliates/withdraw')}}">
                                    <i class="fa fa-fw fa-btn fa-bank"></i>Withdraw Funds
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <!-- Monthly Recurring Revenue -->
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading text-center">Your Affiliate Link</div>

                        <div class="panel-body text-center">
                            <div style="font-size: 24px; margin-bottom: 10px;">
                                <a href="https://azlabels.com/?ref={{$affiliate_token}}">https://azlabels.com/?ref={{$affiliate_token}}</a>
                            </div>
                            <div>
                                <p style="margin-bottom: 0;">You can also add "?ref={{$affiliate_token}}" to the end of any of our <a href="https://azlabels.com/blog">blog pages</a>, such as:</p>
                                <a class="mt-0" href="https://azlabels.com/blog/printing-fba-labels-guide?ref={{$affiliate_token}}">https://azlabels.com/blog/printing-fba-labels-guide<b>?ref={{$affiliate_token}}</b></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Monthly Recurring Revenue -->
                <div class="col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading text-center">Monthly Recurring Revenue</div>

                        <div class="panel-body text-center">
                            <div style="font-size: 24px;">
                                ${{$monthly_recurring}}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Yearly Recurring Revenue -->
                <div class="col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading text-center">Yearly Recurring Revenue</div>

                        <div class="panel-body text-center">
                            <div style="font-size: 24px;">
                                ${{$yearly_recurring}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Total Volume -->
                <div class="col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading text-center">Total Referrals</div>

                        <div class="panel-body text-center">
                            <span style="font-size: 24px;">
                                {{$referral_count}}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Total Trial Users -->
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading text-center">Free Plan Users</div>

                        <div class="panel-body text-center">
                            <span style="font-size: 24px;">
                                {{$free_users}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscribers Per Plan -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Subscribers</div>

                        <div class="panel-body">
                            <table class="table table-borderless m-b-none">
                                <thead>
                                    <th>Name</th>
                                    <th>Subscribers</th>
                                </thead>

                                <tbody>
                                    @foreach($plans as $plan => $count)
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
        </div>
    </div>
</div>
@endsection
