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
                    <p align="left" style="font-weight:700;">Account Transactions</p>
                </div>
                <div class="table-responsive">
                    <table class="table">
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
                            @if(isset($walletHistory))
                            @foreach($walletHistory as $item)
                            <tr>
                                <td>{{$item->created_at->format('d M Y H:s')}}</td>
                                @if($item->sendBy == $item->groupInt )
                                <td>@if($item->sendBy == 0) Admin 
                                    @else G{{$item->sendBy}}@endif to @if($item->receiveBy == 0) Admin @else G{{$item->receiveBy}}@endif</td>
                                    @if($item->groupInt == $item->sendBy && $item->receiveBy == 0) 
                                <td style="color:red">MNC {{number_format($item->amount)}}</td>
                                @else <td style="color:green">MNC {{number_format($item->amount)}}</td> @endif
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









            @stop