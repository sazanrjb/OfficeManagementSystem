@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
    <div class="well">
        <div class="row center-block" >
            <div class="col-md-8 col-md-offset-2 well">

                <h2 class="text-center text-muted">Notice by ADMINISTRATOR</h2><br>
                <div class="container" style="font-family: Helvetica; font-size: 20px;">
                    @foreach($result as $res)
                        <p>{{$res->notice}}</p>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
<!--Main content ends-->
<script>
    document.getElementById('title').innerHTML = "Notice";
</script>
@stop