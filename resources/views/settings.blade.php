@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p align="left" style="font-weight:700;">Xe-Wallet Users</p>
                    <h4 align="right">(Total Money : RM)</h4>
                </div>
                <div class="panel-body">
                    Welcome <b> King {{ Auth::user()->name }}!</b><br>Showing all user.

                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Group</th>
                                <th scope="col">Role</th>
                                <!-- <th scope="col">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users))
                            @foreach($users as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}} </td>
                                <td>{{$item->email}} </td>
                                <td>{{$item->groupInt}}</td>
                                <td>{{$item->role}}</td>
                                <!-- <td><button type="button" 
                                class="btn btn-info" 
                                data-toggle="modal" 
                                id="editUser" 
                                data-target="#myModal" 
                                data-url="{{ route('getUserAjax', $item->id) }}"
                                value="{{$item->id}}">
                                Edit</button></td> -->
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit User</h4>
      </div>
      <div class="modal-body">
        <p class="">Name: <span id="name"></span></p>
        <p class="">Email: <span id="email"></span></p>
        <p class="">Group: <span id="group"></span></p>
        <p class="">Role: <span id="role"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
var ajaxtoken           = '{{ Session::token() }}';
</script>
@stop
