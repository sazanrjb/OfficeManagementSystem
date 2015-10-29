@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
    <div class="well" style="margin:0 auto;">

        <div class="row center-block" >
            @if(Auth::user()->designation == 'Administrator')
            <div class="col-md-8 col-md-offset-2 well">
                {!!Form::open(array('url'=>'assigntask','method'=>'post'))!!}
                <div class="form-group">
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                        @if(!empty(array($result)))
                    <h2 class="text-center text-muted">Assign Task</h2>

                    <label>Task Name</label>
                    {!!Form::input('text','taskName','',array('class'=>'form-control','placeholder'=>'Task Name'))!!}

                </div>
                <div class="form-group">
                    <label>Task Description</label>
                    {!!Form::textarea('taskDescription','',array('class'=>'form-control','placeholder'=>'Task Description'))!!}

                </div>
                <div class="form-group">
                    <label>Starting Date</label>
                    {!!Form::text('startingDate','',array('class'=>'form-control datepicker','placeholder'=>'Starting Date'))!!}
                </div>
                <div class="form-group">
                    <label>Ending Date</label>
                    {!!Form::text('endingDate','',array('class'=>'form-control datepicker','placeholder'=>'Ending Date'))!!}

                </div>
                <div class="form-group">
                    <label>Slug</label>
                    {!!Form::text('slug','',array('class'=>'form-control','placeholder'=>'Slug'))!!}
                </div>
                <div class="form-group">
                    <label>Employees</label>
                    <a id="checkAll" class="text-success" href="javascript:void(0);">check all</a>&nbsp;&nbsp;
                    <a id="uncheckAll" class="text-danger" href="javascript:void(0);">uncheck all</a>
                    <div>
                        @foreach($result as $res)
                        <!--                        {!!Form::checkbox('empName[]','{{$res->id}}')!!}-->
                        <input name="empName[]" type="checkbox" value="{{$res->id}}">
                        <label>{{$res->first_name}} {{$res->middle_name}} {{$res->last_name}} [{{$res->id}}]</label><br>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::submit('Submit',array('class'=>'btn btn-primary form-control'))!!}
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
                        <h4>Task Summary</h4>
                    </div>
                    {!!Form::open(array('url'=>'/viewtask','method'=>'post'))!!}
                    <div class="center-block text-center">

                        {{--Search task: {!!Form::input('text','date','')!!}--}}
                        {{--{!!Form::submit('Search',array('class'=>'btn btn-primary'))!!}--}}
                        @if(Session::has('notice'))
                        <div class="alert alert-info"> {{Session::get('notice')}} </div>
                        @endif
                    </div>
                    </form><br>
                    <tr>
                        <th>Task ID</th>
                        <th>Task Name</th>
                        <th>Task Description</th>
                        <th>Starting Date</th>
                        <th>Completion Date</th>
                        <th>Employee Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach($task as $t)
                    <tr>
                        <td>{{$t->id}}</td>
                        <td>{{$t->task_name}}</td>
                        <td>{{$t->task_description}}</td>
                        <td>{{date('Y-m-d',strtotime($t->assigned_date))}}</td>
                        <td>{{date('Y-m-d',strtotime($t->completion_date))}}</td>
                        <td>@foreach($t->users as $user)
                                <a href="/{{$user->username}}">{{$user->first_name}}</a>
                            @endforeach</td>
                        <td>&nbsp;&nbsp;&nbsp;<a href="/deletetask/{{$t->id}}" class="text-danger"><i class="glyphicon glyphicon-remove"></i></a></td>
                    </tr>
                    @endforeach
                </table>
                @else
                    <p class="text-center text-danger">{{'You must add atleast an employee to assign task'}}</p>
                @endif
            </div>


            @else
        </div>

        <!--Table starts-->
        <div class="row center-block">
            <div class="form-group">
                <table class="table table-striped table-responsive ">
                    <div class="text-center text-muted">
                        <h4>Task Summary</h4>
                    </div>
                    {!!Form::open(array('url'=>'/viewtask','method'=>'post'))!!}
                    <div class="center-block text-center">

                        {{--Search task: {!!Form::input('text','date','')!!}--}}
                        {{--{!!Form::submit('Search',array('class'=>'btn btn-primary'))!!}--}}
                        @if(Session::has('notice'))
                        <div class="alert alert-info"> {{Session::get('notice')}} </div>
                        @endif
                    </div>
                    </form><br>
                    <tr>
                        <th>Task ID</th>
                        <th>Task Name</th>
                        <th>Task Description</th>
                        <th>Starting Date</th>
                        <th>Completion Date</th>
                        <th>Employee Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach($empTask as $t)
                    <tr>
                        <td>{{$t->id}}</td>
                        <td>{{$t->task_name}}</td>
                        <td>{{$t->task_description}}</td>
                        <!--                        <td>{{$t->assigned_date}}</td>-->
                        <td>{{date('Y-m-d',strtotime($t->assigned_date))}}</td>
                        <td>{{date('Y-m-d',strtotime($t->completion_date))}}</td>
                        <!--                        <td>{{$t->users()->first()->id}}</td>-->
                        <td>@foreach($t->users as $user)
                            <a href="/{{$user->username}}">{{$user->first_name}}</a>
                            @endforeach</td>
                        <td>&nbsp;&nbsp;&nbsp;<a href="/deletetask/{{$t->id}}" class="text-danger"><i class="glyphicon glyphicon-remove"></i></a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif

        </div>
        <!--Table ends-->

    </div>
</div>
<!--Main content ends-->
<script>
    document.getElementById('title').innerHTML = "Tasks";
</script>
@stop