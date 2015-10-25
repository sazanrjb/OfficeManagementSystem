@extends('oms.master')
@section('content')
        <!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
    <div class="well">
        <div class="row center-block" >
            <div class="col-md-8 col-md-offset-2 well">
                @if(Session::has('note'))
                    <p class="alert alert-info"> {{Session::get('note')}} </p>
                @endif
                <table class="table table-striped table-responsive">
                    <tr>
                        <th>Notice</th>
                        <th>Posted on</th>
                        <th>Action</th>
                    </tr>
                    @foreach($result as $res)
                    <tr>
                        <td><a href="/notice/{{$res->id}}">{{substr($res->notice,0,30)}}..</a></td>
                        <td>{{$res->created_at}}</td>
                        <td><a href="deletenotice/{{$res->id}}"><i class="glyphicon glyphicon-remove-circle" style="color:red;">Delete</i> </a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </div>
</div>
<!--Main content ends-->
<script>
    document.getElementById('title').innerHTML = "Notice";
</script>
@stop