@extends('layouts.app')

@section('content')


<div class="container">
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {!! session('error') !!}
    </div>
    @endif
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><p style="font-weight:700;"> Send Money</p>
                    <form action="{{route('sendMoney')}}" method="post">
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                            <div class="input-group">
                                <div class="input-group-addon">RM</div>
                                <input type="text" class="form-control" name=sendAmount id="sendAmount"
                                    placeholder="Amount">
                                <div class="input-group-addon">.00</div>
                            </div><br>
                            <div class="form-group">
                                <select class="form-control" name="receiverId" id="receiverId">
                                    <option>-- Select Group --</option>
                                    @foreach($groups as $group)
                                    <option value="{{$group->groupInt}}">{{$group->groupInt}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            <button type="submit" class="btn btn-default">Submit</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

@if(Auth::user()->role != 1)
<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><p style="font-weight:700;"> Redeem Code</p>
                    <form action="{{route('redeemCode')}}" method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Code</div>
                                <input type="text" class="form-control" name=redeemCode id="redeemCode"
                                    placeholder="Insert Promo Code here">
                            </div><br>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            <button type="submit" class="btn btn-default">Submit</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p align="left" style="font-weight:700;">Savings Acccount-X</p>
                    <h4 align="right">(Balance : RM{{number_format($walletData->amount)}})</h4>
                </div>
                <div class="panel-body">
                    Welcome <b>{{ Auth::user()->name }}</b> from <b>Group {{ Auth::user()->groupInt }}! </b>

                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Ref No</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($walletHistory))
                            @foreach($walletHistory as $item)
                            <tr>
                                <td>{{$item->created_at}}</td>
                                @if($item->sendBy ==Auth::user()->id )
                                <td>G{{$item->receiveBy}}</td>
                                <td style="color:red">{{number_format($item->amount)}}</td>
                                @else
                                <td>G{{$item->sendBy}}</td>
                                <td style="color:green">{{number_format($item->amount)}}</td>
                                @endif
                                <td>{{$item->transId}}</td>

                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@else
<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p align="left" style="font-weight:700;">Infinite Record-X</p>
                    <h4 align="right">(Balance : RM{{number_format($walletData->amount)}})</h4>
                </div>
                <div class="panel-body">
                    Welcome <b> King {{ Auth::user()->name }}!</b><br>Showing latest balance from all user.

                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Last Updated</th>
                                <th scope="col">Group</th>
                                <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($datas))
                            @foreach($datas as $item)
                            <tr>
                                <td>{{$item->updated_at}}</td>
                                <td>Group {{$item->groupInt}} </td>
                                <td>RM {{number_format($item->amount)}}</td>
                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endif
</div>
@stop