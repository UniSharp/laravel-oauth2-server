@extends('oauth2::scaffold.main')
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit client information</h3>
                </div>
                <div class="panel-body">
                    @include('oauth2::partial.alert')
                    <form method="POST" action="{{route('oauth2.client.update', $client->id)}}" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-md-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="name" type="text" value="{{$client->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="col-md-2 control-label">Url</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="url" type="text" value="{{$end_point->redirect_uri}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="client_id" class="col-md-2 control-label">Key</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="client_id" type="text" value="{{$client->id}}" disabled="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="secret" class="col-md-2 control-label">Secret</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="secret" type="text" value="{{$client->secret}}" disabled="">
                            </div>
                        </div>
                        <div style="text-align:center">
                            <input class="btn btn-default btn-success" type="submit" value="Update">
                            <a href="{{route('oauth2.client.index')}}" class="btn btn-default btn-info">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection