
@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
    <div class="well">
        <div class="row center-block" >
                @if(Session::has('notice'))
                <div class="alert alert-success">{{Session::get('notice')}}</div>
                @endif
                <h2 class="text-center text-muted">Dashboard</h2>
                {!! HTML::image('images/office.png','',array('class'=>'img img-responsive','width'=>'100%')) !!}
        </div>
    </div>
</div>
<!--Main content ends-->
<script>
    document.getElementById('title').innerHTML = "Dashboard";
</script>
@stop