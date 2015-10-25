@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
    <div class="well" style="margin:0 auto;">
        <div class="row center-block" >
            <div class=" well" >

                <div class="form-group" >
                    {!!Form::open(array('url'=>'broadcastprocess','method'=>'post'))!!}
                    <h2 class="text-center text-muted">Broadcast Message</h2>
                    <label>Enter Message</label>
                    {!!Form::textarea('message','',array('class'=>'form-control','placeholder'=>'Enter your message..', 'rows'=>'10px'))!!}

                </div>
                <div class="form-group">
                    {!!Form::submit('Broadcast',array('class'=>'btn btn-primary form-control'))!!}
                    {!!Form::close()!!}
                </div>
            </div>

        </div>
    </div>
</div>
<!--Main content ends-->
<script>
    document.getElementById('title').innerHTML = "Broadcaste notice";
</script>
@stop