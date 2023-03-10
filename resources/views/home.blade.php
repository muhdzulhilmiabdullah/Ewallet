@extends('layouts.app')

@section('content')

<div class="container">
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
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
                                    <option value="{{$group->id}}">{{$group->id}}</option>
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


    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p align="left">Savings Acccount-X</p>
                    <h4 align="right">(Balance : RM{{$walletData->amount}})</h4>
                </div>
                <div class="panel-body">
                    Welcome <b>{{ Auth::user()->name }}</b> from <b>Group {{ Auth::user()->groupInt }}! </b>

                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Status</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($walletHistory))
                            @foreach($walletHistory as $item)
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                @if($item->sendBy ==Auth::user()->id )
                                <td>Group {{$item->receiveBy}}</td>
                                <td style="color:red">{{$item->amount}}</td>
                                @else
                                <td>Group {{$item->sendBy}}</td>
                                <td style="color:green">{{$item->amount}}</td>
                                @endif

                                <td>{{date('d-m-Y / H:m', strtotime($item->created_at))}}</td>
                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





</div>
@endsection