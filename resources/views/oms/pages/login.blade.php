<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    {!!HTML::style('css/bootstrap.min.css')!!}
    {!!HTML::style('css/jquery-ui.min.css')!!}
    {!!HTML::style('css/custom.css')!!}
</head>
<body id="loginBG">
<div class="container col-lg-12">
    <div class="col-sm-4 col-md-4"></div>
    <div class="well col-sm-4 col-md-4 center-block">

        <div>
            {!!HTML::image('img/oms.png','',array('class'=>'img-responsive'))!!}
        </div>
        <div id="loginWrapper">
                @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{$error}}</p>
                @endforeach

                @if(Session::has('error'))
                    <div class="bg-warning text-center text-danger">{{Session::get('error')}}</div>
                @endif
                {!!Form::open(array('action'=>'MainController@loginprocess','method'=>'post','class'=>'form-signin'))!!}

                <div class="text-primary text-center">
                    <h4 class="well-sm bg-success" >Members Login</h4>
                </div>
                <div class="form-group">
                    <label>
                        Designation
                    </label>
                    {!!Form::select('designation',['Administrator'=>'Administrator','Employee'=>'Employee'],null,['class'=>'form-control'])!!}
                </div>
                <div class="form-group">
                    <label>
                        Username
                    </label>
                    {!!Form::input('text','username','',array('class'=>'form-control','placeholder'=>'Username'))!!}
                </div>
                <div class="form-group">
                    <label>
                        Password
                    </label>
                    {!!Form::input('password','password','',array('class'=>'form-control','placeholder'=>'Password'))!!}
                </div>
                <div class="form-group">
                    {!!Form::checkbox('remember')!!}
                    <label><small>Keep me logged in</small></label>
                    {{--<label style="margin-left: 6em">--}}
                        {{--<small>{!!HTML::link('#','Forget Password')!!}</small>--}}
                    {{--</label>--}}
                    {!!Form::submit('Login',array('class'=>'btn-success form-control'))!!}
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>