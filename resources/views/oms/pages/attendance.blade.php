@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
    <div class="well" style="max-height: 56em; overflow: auto;">
        <div class="row center-block" >
            @if(Auth::user()->designation == 'Administrator')

            <div class="col-md-8 col-md-offset-2 well" style="max-height: 25em; overflow: auto;" >
                    @foreach($errors->all()  as $error)
                        {{$error}}
                    @endforeach

                    @if(Session::has('notice'))
                        {{Session::get('notice')}}
                    @endif

                    @if(Session::has('attendance'))
                        <div class="alert alert-info"> {{Session::get('attendance')}} </div>
                    @endif
                    @if(!empty($result))
                    <h2 class="text-center text-muted">Make Attendance</h2>
                    {!!Form::open(array('url'=>'/makeattendance','method'=>'post'))!!}
                <div class="form-group">
                    <p>Date: <input type="text" class="datepick" name="date" id="date1" value="{{date('Y/m/d')}}"><br></p>
                    <a id="checkAll" class="text-success" href="javascript:void(0);">check all</a>&nbsp;&nbsp;
                    <a id="uncheckAll" class="text-danger" href="javascript:void(0);">uncheck all</a>
                    <div id="checkbox">
                        @foreach($result as $res)
                            <input name="empName[]" type="checkbox" value="{{$res->id}}">
                            <label>{{$res->first_name}} {{$res->middle_name}} {{$res->last_name}} [User ID: {{$res->id}}]</label><br>
                        @endforeach
                    </div>

                </div>
                <div class="form-group">
                    {!!Form::submit('Make Attendance',array('class'=>'btn btn-primary form-control'))!!}
                    {!!Form::close()!!}
                </div>

            </div>
        </div>
            <hr>


            <!--Table starts-->
            <div class="row center-block">
                <div class="form-group">
                    <table class="table table-striped table-responsive ">
                        <div class="text-center text-muted">
                            <h4>View Attendance record</h4>
                        </div>
                        {!!Form::open(array('url'=>'/viewattendance','method'=>'post'))!!}
                        <div class="center-block text-center">

                                Choose Date: {!!Form::input('text','date','',array('class'=>'datepicker','placeholder'=>'Choose date'))!!}
<!--                                            <a href="/viewattendance" class="btn btn-primary"><i class=" glyphicon glyphicon-eye-open"></i> View attendance</a>-->
<!--                                            <a href="/view" class="btn btn-danger"><i class=" glyphicon glyphicon-remove"></i> Delete attendance of this day</a>-->
                                            {!!Form::submit('View Attendance',array('class'=>'btn btn-primary'))!!}
<!--                                            {!!Form::submit('Delete Attendance of this day',array('class'=>'btn btn-danger'))!!}-->
                            {!!Form::close()!!}
                            @if(Session::has('attendance'))
                                <div class="alert alert-info"> {{Session::get('attendance')}} </div>
                            @endif
                        </div>
                        </form>
                        <br>
                        @if(isset($att[0]))
                        <tr>
                            <th>Date</th>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Attendance</th>
                        </tr>

                            @foreach($att as $atts)
                                <tr>
                                    <td>{{date('Y-m-d',strtotime($atts->attendance_date))}}</td>
                                    <td>{{$atts->user_id}}</td>
                                    <td>{{$atts->first_name}}</td>
                                    <td>@if($atts->presence == true)
                                            Present
                                        @else
                                            Absent
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif<br>
                    </table>
                    @else
                        <p class="text-center text-danger">{{'You must add atleast an employee to mark attendance'}}</p>
                    @endif
                </div>

                @else

                <h2 class="text-center text-muted">View Attendance</h2>

            </div>
        <hr>

        <!--Table starts-->
        <div class="row center-block">

            <div class="form-group">
                <table class="table table-striped table-responsive ">
                    <div class="text-center text-muted">
                    </div>
                    {!!Form::open(array('url'=>'/viewempattendance','method'=>'post'))!!}
                    <div class="center-block text-center">
                        <div class="col-md-8 col-md-offset-2 well" style="max-height: 25em; overflow: auto;" >
                        Choose Date: {!!Form::input('text','year','',array('placeholder'=>'Year','class'=>'form-control'))!!}
                        {!!Form::select('month',['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec'],null,['class'=>'form-control'])!!}<br>
                        {!!Form::submit('View Attendance',array('class'=>'btn btn-primary'))!!}
                    </div>
                    </div>
                    </form>
                    <br>
                    @if(!empty($empattendance))
                        <tr>
                            <th>Date</th>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Attendance</th>
                        </tr>

                        @foreach($empattendance as $atts)
                        <tr>
                            <td>{{date('Y-m-d',strtotime($atts->attendance_date))}}</td>
                            <td>{{$atts->user_id}}</td>
                            <td>{{$atts->first_name}}</td>
                            <td>@if($atts->presence == true)
                                Present
                                @else
                                Absent
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif<br>
                </table>
            </div>

                @endif
            </div>
            <!--Table ends-->


    </div>
</div>
<script>
    document.getElementById('title').innerHTML = "Attendance";
</script>

<!--Main content ends-->

@stop