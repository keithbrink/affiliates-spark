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
                            <li>
                                <a href="{{url('/affiliates/transactions')}}">
                                    <i class="fa fa-fw fa-btn fa-money"></i>Transactions
                                </a>
                            </li>
                            <li class="active">
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
                        <div class="panel-heading">Withdraw Funds</div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading text-center">Current Balance</div>
                                    <div class="panel-body text-center">
                                        <div style="font-size: 24px;">
                                            ${{$balance}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @isset($errors)
                            @if ($errors->all())
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                    <br>
                                @endforeach
                                </div>
                            </div>
                            @endif
                            @endisset                            
                            @if (session()->has('withdrawal_message'))
                            <div class="col-md-12">
                                <div class="alert alert-success">                                
                                    {{ session('withdrawal_message') }}
                                </div>
                            </div>
                            @endif
                            <p>All withdrawal requests will be processed within 2 business days. Thank you for your partnership!</p>
                            <form method="POST">
                                <div class="form-group" style="width:30%">
                                    <label for="withdrawalAmount">Withdrawal Amount</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <input type="number" name="amount" class="form-control" id="withdrawalAmount" placeholder="Amount">
                                        <div class="input-group-addon">.00</div>
                                    </div>  
                                    <p class="help-block">The minimum withdrawal amount is $10.</p>
                                </div>
                                
                                <div class="form-group" style="width:50%">
                                    <label for="paypalEmail">Paypal Email</label>
                                    <input type="email" class="form-control" id="paypalEmail" name="paypalEmail" placeholder="Email">
                                    <p class="help-block">The email address you would like to withdraw to.</p>
                                </div>
                                <button type="submit" class="btn btn-default">Withdraw</button>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
