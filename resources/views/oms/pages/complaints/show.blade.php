@extends('oms.master')
@section('content')
    <!--Main content starts-->
    <div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">
        <div class="well" style="margin:0 auto;">
            @if(Session::has('notice'))
                <div class="alert alert-info"> {{Session::get('notice')}} </div>
            @endif

            <div class="row center-block">
                <div class="col-md-8 col-md-offset-2 well">
                    @if(Auth::user()->designation == "Administrator")
                        <h2 class="text-center">Complaint by {{$complaint->user->name}}</h2>
                        <h4 class="text-center">{{$complaint->created_at}}</h4><br>
                        <h4>{{$complaint->complaint}}</h4>
                        <br>
                        <form method="POST" action="/complaints/{{$complaint->id}}">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger">
                                Delete <i class="glyphicon glyphicon-remove"></i>
                            </button>
                        </form>
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