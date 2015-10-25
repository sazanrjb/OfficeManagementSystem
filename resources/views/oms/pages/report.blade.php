@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
    <div class="well" style="margin:0 auto;">
        <div class="row center-block" >
            @if(Auth::user()->designation == 'Administrator')
            <div class="col-md-8 col-md-offset-2 well">
                <div class="form-group">
                    @if(Session::has('notice'))
                        <p class="alert alert-info">{{Session::get('notice')}}</p>
                    @endif

                    @foreach($errors->all() as $error)
                        <p class="alert alert-info">{{$error}}</p>
                    @endforeach

                    {!!Form::open(array('url'=>'/viewreport','method'=>'post'))!!}
                    <h2 class="text-center text-muted">View Report</h2>

                    <label>Employee ID</label>
                    {!!Form::input('text','empID','',['class'=>'form-control','placeholder'=>'Employee ID'])!!}
                </div>
                <div class="form-group" id="category">
                    <label>Select Category</label>
                    {!!Form::select('listCategory',['Task'=>'Task','Attendance'=>'Attendance','Leave'=>'Leave'],'',['class'=>'form-control'])!!}

                </div>

                <hr>
                <div class="form-group" id="date-chooser">
                    Choose Date: {!!Form::input('text','year','',array('placeholder'=>'Year','class'=>'form-control'))!!}
                    {!!Form::select('month',['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec'],null,['class'=>'form-control'])!!}<br>
                </div>

                <div class="form-group">
                    {!!Form::submit('Submit',array('class'=>'btn btn-primary form-control'))!!}
                    {!!Form::close()!!}
                </div>

            </div>
            </div>
<!--            {!!Session::get('tasks')!!}-->
<!--            {!!Session::get('attendance')!!}-->
<!--            {!!Session::get('leaves')!!}-->
            @if(Session::has('tasks'))
            <div>
                <table class="table table-responsive table-striped">
                    <caption class="text-center">Task Report of <?php $tasks = Session::get('tasks'); echo $tasks[0]->users()->first()->first_name; ?></caption>
                    <tr>
                        <th>Task Name</th>
                        <th>Task Description</th>
                        <th>Assigned Date</th>
                        <th>Completion Date</th>
                    </tr>
                    <?php $tasks = Session::get('tasks'); ?>
                    @foreach($tasks as $task)
                        <tr>
                            <td><?php  echo $task->task_name; ?></td>
                            <td><?php  echo $task->task_description; ?></td>
                            <td><?php  echo $task->assigned_date ?></td>
                            <td><?php  echo $task->completion_date ?></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            @elseif(Session::has('att'))
                <table class="table table-responsive table-striped">
                    <tr>
                        <th>Attendance Date</th>
                        <th>Presence</th>
                    </tr>
                    <?php $att = Session::get('att'); ?>
                    @foreach($att as $attendance)
                        <tr>
                            <td><?php echo $attendance->attendance_date; ?></td>
                            <td><?php if($attendance->presence ==0){ echo 'Absent';}else{echo 'Present';} ?></td>
                        </tr>
                    @endforeach
                </table>
            @elseif(Session::has('leaves'))
                <table class="table table-responsive table-striped">
                    <caption class="text-center">Leave Report of <?php $startDate = Session::get('leaves'); echo $startDate[0]->user()->first()->first_name; ?></caption>
                    <tr>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reason</th>
                    </tr>
                    <?php $leaves = Session::get('leaves'); ?>
                    @if(empty($leaves))
                        hello
                    @else
                        @foreach($leaves as $leave)
                            <tr>
                                <td><?php echo $leave->start_date; ?></td>
                                <td><?php echo $leave->end_date; ?></td>
                                <td><?php echo $leave->reason; ?></td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            @endif
           @endif

    </div>
</div>
<!--Main content ends-->
<script>
    document.getElementById('title').innerHTML = "Report";
</script>
@stop

