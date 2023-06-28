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
                    <h4 align="right">(Balance : MNC {{number_format($walletData->amount)}})</h4>
                    
                    <p style="font-weight:700;"> Send MNC</p>
                    <form action="{{route('sendMoney')}}" method="post">
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                            <div class="input-group">
                                <div class="input-group-addon">MNC</div>
                                <input type="number" class="form-control" name=sendAmount id="sendAmount"
                                    placeholder="Amount">
                            </div><br>
                            <div class="form-group">
                                <select class="form-control" name="receiverId" id="receiverId">
                                    <option>-- Select Group --</option>
                                    @foreach($groups as $group)
                                    @if($group->groupInt == 0)
                                    <option  value="{{$group->groupInt}}">Admin</option>
                                    @else
                                    <option value="{{$group->groupInt}}">Group {{$group->groupInt}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            <button type="submit" class="btn btn-default">Send</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->role == 1)
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                <p align="left" style="font-weight:700;">Ahlong Deduct Record-X</p>
                    <!-- <h4 align="right">(Balance : RM{{number_format($walletData->amount)}})</h4> -->
                    
                    <p style="font-weight:700;"> Deduct MNC</p>
                    <form action="{{route('deductMoney')}}" method="post">
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                            <div class="input-group">
                                <div class="input-group-addon">MNC</div>
                                <input type="number" class="form-control" name=deductAmount id="deductAmount"
                                    placeholder="Deduction Amount">
                            </div><br>
                            <div class="form-group">
                                <select class="form-control" name="deductGroup" id="deductGroup">
                                    <option>-- Select Group --</option>
                                    @foreach($groups as $group)
                                    @if($group->groupInt == 0)
                                    <option  value="{{$group->groupInt}}">Admin</option>
                                    @else
                                    <option value="{{$group->groupInt}}">Group {{$group->groupInt}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            <button type="submit" class="btn btn-danger">Deduct</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif


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
                                <td style="color:red">-MNC {{number_format($item->amount)}}</td>
                                @else
                                @if($item->sendBy == 0)
                                <td>From Admin</td>
                                @else
                                <td>From {{$item->sendBy}}</td>
                                @endif
                                <td style="color:green">MNC {{number_format($item->amount)}}</td>
                                @endif
                                <!-- <td>{{$item->transId}}</td> -->

                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="row footer_height">
      <div class="col-md-4 col-md-offset-4">
        {!! $walletHistory->render() !!}
      </div>
    </div>
            </div>
        </div>
    </div>
    @else
    
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p align="left" style="font-weight:700;">xE-Holder Records</p>       
                    <h4 align="right">(Balance : MNC {{number_format($walletData->amount)}})</h4>           
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Last Updated</th>
                                <th scope="col">Group</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($datas))
                            @foreach($datas as $item)
                            <tr>
                                <td>{{$item->updated_at->format('d M Y H:s')}}</td>
                                <td>Group {{$item->groupInt}} </td>
                                <td>MNC {{number_format($item->amount)}}</td>
                                <td>
                                <a class="btn btn-primary" href="{{route('viewUserTrans', ['group' => $item->groupInt])}}">View</a>
                                </td>
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
                    <p align="left" style="font-weight:700;">xE-Holder Transactions</p>
    
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Last Updated</th>
                                <th scope="col">Group</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ref No</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($adminHistorys))
                            @foreach($adminHistorys as $item)
                            <tr>
                                <td>{{$item->created_at->format('d M Y H:s')}}</td>
                                @if($item->sendBy == $item->groupInt )
                                <td>@if($item->sendBy == 0) Admin 
                                    @else G{{$item->sendBy}}@endif to @if($item->receiveBy == 0) Admin @else G{{$item->receiveBy}}@endif</td>
                                <td style="color:green">MNC {{number_format($item->amount)}}</td>
                                <td>{{$item->remarks}}</td>
                                <td>{{$item->transId}}</td>
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

    @endif
</div>
@stop