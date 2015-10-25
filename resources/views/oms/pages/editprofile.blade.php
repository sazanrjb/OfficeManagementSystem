@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3" id="maincontent-back">

    <div class="well" style="margin:0 auto;">
        <div class="row center-block" >
            @foreach($errors->all() as $error)
                <p class="alert alert-info">{{$error}}</p>
            @endforeach
            @if(Session::has('notice'))
                <p class="alert alert-info">{{Session::get('notice')}}</p>
            @endif
            <div class="col-md-offset-2">
                <a href="#" id="changeDetails">Change Details </a>
                <a href="#" id="changePassword">Change Password Instead?</a><br>
            </div>
            <div class="col-md-8 col-md-offset-2 well" id="changeDetailsArea">
                {!!Form::open(array('url'=>'/editprocess','method'=>'post','files'=>true))!!}
                    {!!HTML::image($profile[0]->profile_picture,'',array('class'=>'img-responsive center-block'))!!}
                    {!!Form::file('image',array('class'=>'center-block'))!!}<br>
                    <label>First Name: </label>
                    {!!Form::input('text','firstName',$user->first_name,array('class'=>'form-control'))!!}
                    <br>
                    <label>Middle Name: </label>
                    {!!Form::input('text','middleName',$user->middle_name,array('class'=>'form-control'))!!}
                    <br>
                    <label>Last Name: </label>
                    {!!Form::input('text','lastName',$user->last_name,array('class'=>'form-control'))!!}
                    <br>
                    <label>Address: </label>
                    {!!Form::input('text','address',$profile[0]->address,array('class'=>'form-control'))!!}
                    <br>
                    <label>Contact: </label>
                    {!!Form::input('text','contact',$profile[0]->contact,array('class'=>'form-control'))!!}
                    <br>
                    <label>Email: </label>
                    {!!Form::input('text','email',$user->email,array('class'=>'form-control'))!!}
                    <br>
                    <label>Gender: </label><br>
                        {!!Form::radio('gender','male',true)!!} Male
                        {!!Form::radio('gender','female')!!} Female
                    <br><br>
                    <label>Username: </label>
                    {!!Form::input('text','username',$user->username,array('class'=>'form-control','id'=>'usernameField'))!!}
                    <br>
                    {!!Form::input('hidden','userid',$user->id)!!}

                    {!!Form::submit('Submit',array('class'=>'btn btn-primary form-control'))!!}
                {!!Form::close()!!}
            </div>

            <div class="col-md-8 col-md-offset-2 well" id="changePasswordArea">
                {!!Form::open(array('url'=>'/changepassword','method'=>'post'))!!}
                <label>Old password: </label>
                {!!Form::input('password','oldPassword','',array('class'=>'form-control','placeholder'=>'Old Password'))!!}
                <br>
                <label>New Password: </label>
                {!!Form::input('password','newPassword','',array('class'=>'form-control','placeholder'=>'New Password'))!!}
                <br>
                <label>Confirm Password: </label>
                {!!Form::input('password','confirmPassword','',array('class'=>'form-control','placeholder'=>'Confirm Password'))!!}
                <br>
                {!!Form::submit('Submit',array('class'=>'btn btn-primary form-control'))!!}
                {!!Form::close()!!}
            </div>

        </div>
    </div>
</div>
<!--Main content ends-->

<script>
    document.getElementById('usernameField').disabled = true;
    document.getElementById('title').innerHTML = "Attendance";

</script>
@stop