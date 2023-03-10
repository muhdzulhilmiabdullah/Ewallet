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
                <div class="panel-heading">
                <p align="left" style="font-weight:700;">Infinite Record-X</p>
                    <h4 align="right">(Balance : RM{{number_format($walletData->amount)}})</h4>
                    
                    <p style="font-weight:700;"> Send Money</p>
                    <form action="{{route('sendMoney')}}" method="post">
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                            <div class="input-group">
                                <div class="input-group-addon">RM</div>
                                <input type="number" class="form-control" name=sendAmount id="sendAmount"
                                    placeholder="Amount">
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
                <div class="panel-heading">
                    <p style="font-weight:700;"> Redeem Code</p>
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
                    <p align="left" style="font-weight:700;">Account Transactions</p>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Amount</th>
                                <!-- <th scope="col">Ref No</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($walletHistory))
                            @foreach($walletHistory as $item)
                            <tr>
                                <td>{{$item->created_at->format('d M Y H:s')}}</td>
                                @if($item->sendBy ==Auth::user()->groupInt )
                                @if($item->receiveBy == 0)
                                <td>To Admin</td>
                                @else
                                <td>To G{{$item->receiveBy}}</td>
                                @endif
                                <td style="color:red">-RM {{number_format($item->amount)}}</td>
                                @else
                                @if($item->sendBy == 0)
                                <td>From Admin</td>
                                @else
                                <td>From {{$item->sendBy}}</td>
                                @endif
                                <td style="color:green">RM {{number_format($item->amount)}}</td>
                                @endif
                                <!-- <td>{{$item->transId}}</td> -->

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
                    <p align="left" style="font-weight:700;">xE-Holder Transactions</p>
    
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Last Updated</th>
                                <th scope="col">Group</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($adminHistorys))
                            @foreach($adminHistorys as $item)
                            <tr>
                                <td>{{$item->created_at->format('d M Y H:s')}}</td>

                                @if($item->sendBy == $item->groupInt )
                                <td>@if($item->sendBy == 0) Admin @else G{{$item->sendBy}}@endif ---> @if($item->receiveBy == 0) Admin @else G{{$item->receiveBy}}@endif</td>
                                <td style="color:green">RM {{number_format($item->amount)}}</td>
                                @endif
                              
                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p align="left" style="font-weight:700;">xE-Holder Records</p>                  
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
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