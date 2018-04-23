<!DOCTYPE html>
<html>
<head>
    <title id="title"></title>
    {!!HTML::style('css/bootstrap.min.css')!!}
    {!!HTML::style('css/jquery-ui.min.css')!!}
    {!!HTML::style('css/custom.css')!!}

</head>
<body onload="startTime()">

<div class="container-fluid">
    <!--Navbar-->
    <nav class="navbar navbar-default navbar-fixed-top">
        <a href="/">{!!HTML::image('img/headerLogo.png','',array('class'=>'img-responsive center-block','width'=>'90px','style'=>'padding:1em'))!!}</a>
    </nav>


    <!--Header-->
    <header class="row">
        <div class="col-md-3 col-sm-3">
            <div class="well" id="logo-back">
                <a href="/" class="center-block">{!!HTML::image('img/oms.png','',array('class'=>'img-responsive','width'=>'200px'))!!}</a>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6">
            <!-- Featured Row starts -->
            <a href="/attendances" class="nav-top">
                <div class="col-lg-3 col-md-3 col-sm-3 well col-xs-6 nav-child">
                    {!!HTML::image('img/result.png','',array('class'=>'img-responsive center-block','width'=>'50px'))!!}
<!--                    {!!HTML::link('/attendances','Attendance')!!}-->
                    <p class="text-center"> Attendance</p>
                </div>
            </a>
            <a href="/tasks" class="nav-top">
                <div class="col-lg-3 col-md-3 col-sm-3 well col-xs-6 nav-child">
                    {!!HTML::image('img/tasks.png','',array('class'=>'img-responsive center-block','width'=>'50px'))!!}
<!--                    {!!HTML::link('/tasks','Assign Tasks')!!}-->
                    <p class="text-center">Tasks</p>
                </div>
            </a>
                @if(Auth::user()->designation == 'Administrator')
                <a href="/users" class="nav-top">
                    <div class="col-lg-3 col-md-3 col-sm-3 well col-xs-6 nav-child">
                        {!!HTML::image('img/UserGroup.png','',array('class'=>'img-responsive center-block','width'=>'50px'))!!}
                            <p class="text-center">View Users</p>
                    </div>
                </a>
                @else
                    <a href="/leave" class="nav-top">
                        <div class="col-lg-3 col-md-3 col-sm-3 well col-xs-6 nav-child">
                            {!!HTML::image('img/things-logo.jpg','',array('class'=>'img-responsive center-block','width'=>'50px'))!!}
                            <!--                    {!!HTML::link('/leave','Ask for leave')!!}-->
                            <p class="text-center">Leave</p>
                        </div>
                    </a>
                @endif
                    <a href="/complaints" class="nav-top">
                        <div class="col-lg-3 col-md-3 col-sm-3 well col-xs-6 nav-child">
                            {!!HTML::image('images/complaint.gif','',array('class'=>'img-responsive center-block','width'=>'50px'))!!}
                            <p class="text-center">Complaint</p>
                        </div>
                    </a>


            <!-- Featured Row finished-->
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="well">
                <div id="date"></div>
                <div id="clock"></div>
            </div>
        </div>



    </header>

    <!--Main body-->
    <div class="row">



        <!--Main content starts-->
            @yield('content')
        <!--Main content ends-->



        <!--Sidebar starts-->
        <aside class="col-md-3 col-sm-3 col-md-pull-9 col-sm-pull-9">
            <div class="navbar navbar-default">
                <ul class="nav nav-tabs nav-stacked">
                    <br>
                        @if(Auth::user()->profile)<a href="/{{Auth::user()->username}}">{!!HTML::image(Auth::user()->profile->profile_picture,'',array('class'=>'img-responsive img-circle center-block','width'=>'100px'))!!}</a>@endif
                        <p class="text-center"><a href="/{{Auth::user()->username}}" style="color: #000">Namaste {{Auth::user()->first_name}}!</a></p>
                    <br>
                    @if(Auth::user()->designation == 'Administrator')
                    <li><a href="/report"><span class="glyphicon glyphicon-eye-open"></span> View reports</a></li>
                    <li><a href="/broadcast"><span class="glyphicon glyphicon-book"></span> Broadcast Notice</a></li>
                    <li><a href="/noticehistory"><span class="glyphicon glyphicon-envelope"></span> Notice history</a></li>
                    @endif
                    <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>

            <!--Right sidebar starts-->
            <aside class="">
                <div class="well">

                    <div >
                        <p class="text-center text-muted"> Recent Notice from Admins </p>
                        <div style="height: 22em; overflow: auto;">
                            <div class="list-group">
                                @foreach($notice as $note)
                                <a href="/notice/{{$note->id}}" class="list-group-item">
<!--                                    <h4 class="list-group-item-heading">{{$note->users->first()->username}}</h4>-->
                                    <h4 class="list-group-item-heading">{{$note->users->first_name}} {{$note->users->middle_name}} {{$note->users->last_name}}</h4>
                                    <p class="list-group-item-text">{{$note->created_at}}</p>
                                    <p class="list-group-item-text">{{$note->notice}}</p>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <!--Right sidebar ends-->
        </aside>
        <!--Sidebar ends-->


    </div>
    <!--Main body ends-->

</div>
<!--Footer-->
<footer>
    <small>&copy; Copyright reserved 2015 | Designed and programmed by Sajan Rajbhandari</small>

</footer>
<!--Footer ends-->

</div>
</body>
{!!HTML::script('js/jquery-1.11.3.min.js')!!}
{!!HTML::script('js/jquery-ui.min.js')!!}
{!!HTML::script('js/custom.js')!!}
<style>
    .datepicker{

    }
</style>
<script>
    function startTime(){
        var date = new Date();
        var month = (date.getMonth()+1);
        var day = date.getDate();
        var year = date.getFullYear();
        var am = date.getTimezoneOffset();
//        alert(month+'/'+day+'/'+year);

        var hour = date.getHours();
        var minute = date.getMinutes();
        var second = date.getSeconds();

        minute = checkDouble(minute);
        second = checkDouble(second);

//        alert(hour+'/'+minute+'/'+second);
        document.getElementById("date").innerHTML="<small class='text-center'>Date: "+year+'/'+month+'/'+day+'</small><hr>';
        document.getElementById("clock").innerHTML="<small class='text-center'>Time: "+hour+':'+minute+':'+second+'</small>';

        setTimeout(function(){
            startTime()
        },1000);
    }



    function checkDouble(d){
        if(d < 10){
            d = '0' + d;
        }
        return d;
    }

</script>
</html>