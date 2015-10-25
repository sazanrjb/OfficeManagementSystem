
@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
    <div class="well">
        <div class="row center-block" >
            @if(Session::has('notice'))
            <div class="alert alert-success">{{Session::get('notice')}}</div>
            @endif

            <h2 class="text-center text-muted">Profile</h2>
            @if($user[0]->username == Auth::user()->username)
                <a href="/editprofile/" class="btn btn-primary" style="float: right;">Edit Profile</a>
            @endif
            <div class="row center-block" >
                <div class="col-md-8 col-md-offset-2 well">
                    {!!HTML::image($profile[0]->profile_picture,'',array('class'=>'img-responsive center-block'))!!}<br>
                    <label>Name: </label>

                    <label>{{$user[0]->first_name}} {{$user[0]->middle_name}} {{$user[0]->last_name}}</label>
                    <br>
                    <label>Address: </label>
                    <label>{{$profile[0]->address}}</label>
                    <br>
                    <label>Contact: </label>
                    <label>{{$profile[0]->contact}}</label>
                    <br>
                    <label>Email: </label>
                    <label>{{$user[0]->email}}</label>
                    <br>
                    <label>Username: </label>
                    <label>{{$user[0]->username}}</label>
                    <br>
                </div>
            </div>

        </div>
    </div>
</div>
<!--Main content ends-->
<script>
    document.getElementById('title').innerHTML = "Profile";
</script>
@stop