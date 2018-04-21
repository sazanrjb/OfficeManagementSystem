@extends('oms.master')
@section('content')
    <!--Main content starts-->
    <div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
        <div class="well">
            <div class="row center-block">
                @if(Session::has('notice'))
                    <div class="alert alert-success">{{Session::get('notice')}}</div>
                @endif

                <h2 class="text-center text-muted">Profile</h2>
                @if($user->username == Auth::user()->username)
                    <a href="/editprofile/" class="btn btn-primary" style="float: right;">Edit Profile</a>
                @endif
                <div class="row center-block">
                    <div class="col-md-8 col-md-offset-2 well">
                        @if($user->profile)
                            {!!HTML::image($user->profile->profile_picture,'',array('class'=>'img-responsive center-block'))!!}
                        @else
                            <img src="/img/user.bmp">
                        @endif
                        <br>
                        <label>Name: </label>

                        <label>{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}</label>
                        <br>
                        <label>Address: </label>
                        <label>{{optional($user->profile)->address}}</label>
                        <br>
                        <label>Contact: </label>
                        <label>{{optional($user->profile)->contact}}</label>
                        <br>
                        <label>Email: </label>
                        <label>{{$user->email}}</label>
                        <br>
                        <label>Username: </label>
                        <label>{{$user->username}}</label>
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