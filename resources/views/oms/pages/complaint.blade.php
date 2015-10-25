@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
    <div class="well" style="margin:0 auto;">

        <!--Table starts-->
        <div class="row center-block">
            <div class="form-group">

                @if(Auth::user()->designation == "Administrator")

                    @if($complaint->count()<1)
                        {!!Form::open(array('url'=>'/adminprocesscomplaint','method'=>'post'))!!}
                            <h5 class="text-success text-center">{{'No complaints to display'}}</h5>
                    @else
                            <div class="text-center text-muted">
                                <h2>Complaints</h2>
                            </div>
                            <table class="table table-striped table-responsive">
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Complaint</th>
                                    <th>Employee Date</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($complaint as $comp)
                                    <tr>
                                        <td>{{$comp->user_id}}</td>
                                        <td><?php $user = $comp->getEmpName($comp->user_id); echo $user->first_name . " " . $user->middle_name . " " . $user->last_name; ?></td>
                                        <td><a href="/viewcomplaint/{{$comp->id}}">{{substr($comp->complaint,0,30)}}..</a></td>
                                        <td>{{$comp->created_at}}</td>
                                        <td>&nbsp;&nbsp;&nbsp;<a href="/deletecomplaint/{{$comp->id}}" class="text-danger"><i class="glyphicon glyphicon-remove"></i></a></td>
                                    </tr>
                                @endforeach
                            </table>

                        {!!Form::close()!!}<br>
                    @endif

                @else

                    <div class="text-center text-muted">
                        <h2>Report Complaint</h2>
                    </div>
                    {!!Form::open(array('url'=>'/processcomplaint','method'=>'post'))!!}
                    <div class="center-block text-center">
                        <label>Enter Message</label>
                        {!!Form::textarea('message','',array('class'=>'form-control','placeholder'=>'Enter your message..', 'rows'=>'10px'))!!}

                    </div><br>
                    <div class="form-group">
                        {!!Form::submit('Send',array('class'=>'btn btn-primary form-control'))!!}
                    </div>
                    {!!Form::close()!!}<br>

                @endif
            </div>
        </div>
        <!--Table ends-->

    </div>
</div>
<!--Main content ends-->
<script>
    document.getElementById('title').innerHTML = "Complaint";
</script>
@stop