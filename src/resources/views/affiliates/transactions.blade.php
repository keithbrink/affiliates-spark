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
                            <li>
                                <a href="{{url('/affiliates')}}">
                                    <i class="fa fa-fw fa-btn fa-dashboard"></i>Affiliate Dashboard
                                </a>
                            </li>
                            <li class="active">
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
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Transactions</div>

                        <div class="panel-body">
                            <table class="table table-borderless m-b-none">
                                <thead>
                                    <th>Transaction Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                </thead>

                                <tbody>
                                    @foreach($transactions as $transaction)
                                    <tr class="{{$transaction->amount < 0 ? 'danger' : 'success'}}">
                                        <td>
                                            <div class="btn-table-align">
                                                {{ \Carbon\Carbon::parse($transaction->transaction_date)->toDateString() }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-table-align">
                                                {{ $transaction->type }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-table-align">
                                                {{ $transaction->amount }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
