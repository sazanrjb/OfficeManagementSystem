@extends('oms.master')
@section('content')
<!--Main content starts-->
<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
    <div class="well" style="margin:0 auto;">
        @if(Session::has('notice'))
        <div class="alert alert-info"> {{Session::get('notice')}} </div>
        @endif

        <div class="row center-block" >
            <div class="col-md-8 col-md-offset-2 well">
                @if(Auth::user()->designation == "Administrator")
                        @foreach($complaint as $comp)
                            <h2 class="text-center">Complaint by <?php $user = $comp->getEmpName($comp->user_id);  echo $user->first_name . " " . $user->middle_name . " " . $user->last_name; ?></h2>
                            <h4 class="text-center">{{$comp->created_at}}</h4><br>
                            <h4>{{$comp->complaint}}</h4>
                            <br>
                            <a href="/deletecomplaint/{{$comp->id}}"  class="text-center"><h5 class="text-danger">Delete this complaint</h5></a>
                        @endforeach
                @endif
            </div>
        </div>

    </div>
</div>
<!--Main content ends-->
<script>
    document.getElementById('title').innerHTML = "Complaints";
</script>
@stop