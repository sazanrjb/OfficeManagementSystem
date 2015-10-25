@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
    <div class="well" style="margin:0 auto;">
        @foreach($errors->all() as $error)
            <p class="alert alert-info">{{$error}}</p>
        @endforeach
        @if(Session::has('notice'))
            <p class="alert alert-info">{{Session::get('notice')}}</p>
        @endif
        <div class="row center-block" >
            <div class="col-md-8 col-md-offset-2 well">
                {!!Form::open(array('url'=>'/makeleave','method'=>'post'))!!}
                    <h2 class="text-center text-muted">Take Leave</h2>
                    <label>From</label>
                    {!!Form::text('startingDate','',array('class'=>'form-control datepicker','placeholder'=>'Starting Date'))!!}
                    <label>To</label>
                    {!!Form::text('endingDate','',array('class'=>'form-control datepicker','placeholder'=>'Ending Date'))!!}<br>
                    <label>Reason</label>
                    {!!Form::textarea('reason','',array('class'=>'form-control','placeholder'=>'Reason'))!!}<br>
                    <div class="form-group">
                    {!!Form::submit('Submit',array('class'=>'btn btn-primary form-control'))!!}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
    </div>
</div>
<!--Main content ends-->
<script>
    document.getElementById('title').innerHTML = "Leave";
</script>
@stop