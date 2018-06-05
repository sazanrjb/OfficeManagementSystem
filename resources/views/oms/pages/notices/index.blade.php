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
                        @foreach($notices as $notice)
                            <tr>
                                <td><a href="/notices/{{$notice->id}}">{{substr($notice->notice,0,100)}}..</a></td>
                                <td>{{$notice->created_at}}</td>
                                <td>
                                    <form method="POST" action="notices/{{$notice->id}}">
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
                </div>
            </div>

        </div>
    </div>
    <!--Main content ends-->
    <script>
        document.getElementById('title').innerHTML = "Notice";
    </script>
@stop