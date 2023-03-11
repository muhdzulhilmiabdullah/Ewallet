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
                    <p style="font-weight:700;"> Create Promo</p>
                    <form action="{{route('addPromoCode')}}" method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Code</div>
                                <input type="text" class="form-control" name=promoCodeNm id="promoCodeNm"
                                    placeholder="Add promo code">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Num.</div>
                                <input type="text" class="form-control" name=promoRedeem id="promoRedeem"
                                    placeholder="No. of redeem">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">RM</div>
                                <input type="text" class="form-control" name=promoValue id="promoValue"
                                    placeholder="Promo Value in RM">
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
                    <p align="left" style="font-weight:700;">Promo Acccount-X</p>
                </div>
                <!-- <div class="panel-body">
                    Welcome <b>{{ Auth::user()->name }}</b> from <b>Group {{ Auth::user()->groupInt }}! </b>

                </div> -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Created</th>
                                <th scope="col">Code</th>
                                <th scope="col">Redeem</th>
                                <th scope="col">Value</th>


                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($promoCodes))
                            @foreach($promoCodes as $item)
                            <tr>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->promoCodeNm}}</td>
                                @if($item->promoRedeem == 0)
                                <td style="color:red">{{$item->promoRedeem}}</td>
                                @else
                                <td style="color:green">{{$item->promoRedeem}}</td>
                                @endif
                                <td>RM {{$item->promoValue}}</td>
                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>











    @stop