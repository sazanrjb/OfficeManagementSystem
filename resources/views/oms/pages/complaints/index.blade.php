@extends('oms.master')
@section('content')
    <!--Main content starts-->
    <div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
        <div class="well" style="margin:0 auto;">

            <!--Table starts-->
            <div class="row center-block">
                <div class="form-group">
                    @if(Session::has('notice'))
                        <div class="alert alert-info"> {{Session::get('notice')}} </div>
                    @endif
                    @if(Auth::user()->designation == "Administrator")

                        @if($complaints->count() === 0)
                            {!!Form::open(array('url'=>'/adminprocesscomplaint','method'=>'post'))!!}
                            <h5 class="text-success text-center">No complaints to display</h5>
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
                                @foreach($complaints as $complaint)
                                    <tr>
                                        <td>{{$complaint->user->id}}</td>
                                        <td>{{$complaint->user->name}}</td>
                                        <td>
                                            <a href="/complaints/{{$complaint->id}}">{{substr($complaint->complaint,0,30)}}
                                                ..</a></td>
                                        <td>{{$complaint->created_at}}</td>
                                        <td>&nbsp;&nbsp;&nbsp;
                                        <td>&nbsp;&nbsp;&nbsp;
                                            <form method="POST" action="complaints/{{$complaint->id}}">
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

                            {!!Form::close()!!}<br>
                        @endif

                    @else

                        <div class="text-center text-muted">
                            <h2>Report Complaint</h2>
                        </div>
                        {!!Form::open(array('url'=>'/complaints','method'=>'post'))!!}
                        <div class="center-block text-center">
                            <label>Enter Complaint</label>
                            {!!Form::textarea('complaint','',array('class'=>'form-control','placeholder'=>'Enter your complaint..', 'rows'=>'10px'))!!}

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