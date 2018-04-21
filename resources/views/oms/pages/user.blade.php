@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3" id="maincontent-back">
    <div class="well" style="margin:0 auto;">
        <div class="row center-block" >
            @if(Session::has('notice'))
            <p class="alert alert-success">{{Session::get('notice')}}</p>
            @endif
            <h2 class="text-center text-muted">Current Users</h2>
            <!--Table begins-->
            <table class="table table-striped table-responsive">
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Designation</th>
                    <th>Action</th>
                </tr>
                @foreach($result as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}</td>
                    <td>{{$user->address}}</td>
                    <td>{{$user->contact}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->designation}}</td>
                    <td>
                        <form method="POST" action="users/{{$user->id}}">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger">
                                <i class="glyphicon glyphicon-remove"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            <!--Table ends-->
            <button id="adduser" class="btn btn-success btn-block">Add User</button>
            <div class="col-md-8 col-md-offset-2 well" id="userform" >

                <div class="form-group" >
                    @foreach($errors->all() as $error)
                        <p class="text-center text-danger bg-danger">{{$error}}</p>
                    @endforeach
                    {!!Form::open(array('url'=>'/users','method'=>'post'))!!}
                    <h2 class="text-center text-muted">Add Users</h2>
                    <p class="text-info">Note: Username and Password will be auto generated</p>
                    <label>First name</label>
                    {!!Form::input('text','first_name','',array('class'=>'form-control','placeholder'=>'First Name'))!!}<br>
                    <label>Middle name</label>
                    {!!Form::input('text','middle_name','',array('class'=>'form-control','placeholder'=>'Middle Name'))!!}<br>
                    <label>Last name</label>
                    {!!Form::input('text','last_name','',array('class'=>'form-control','placeholder'=>'Last Name'))!!}<br>
                    <label>Joined</label>
                    {!!Form::input('text','joined_date','',array('class'=>'form-control datepicker','placeholder'=>'Joined_date'))!!}<br>
                    <label>Email</label>
                    {!!Form::input('text','email','',array('class'=>'form-control','placeholder'=>'xyz@email.com'))!!}<br>
                    <label>Designation</label>
                    {!!Form::select('designation',['Administrator'=>'Administrator','Employee'=>'Employee'],null,array('class'=>'form-control'))!!}

                </div>
                <div class="form-group">
                    {!!Form::submit('Add User',array('class'=>'btn btn-primary form-control'))!!}
                    {!!Form::close()!!}
                </div>
            </div>

        </div>
    </div>
</div>
<!--Main content ends-->
<script>
    document.getElementById('title').innerHTML = "Users";
</script>
@stop