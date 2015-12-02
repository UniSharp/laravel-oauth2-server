@extends('oauth2::scaffold.main')
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Create a new client</h3>
                </div>
                <div class="panel-body">
                    @include('oauth2::partial.alert')
                    <form method="POST" action="{{route('oauth2.client.store')}}" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                        <label for="name" class="col-md-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" placeholder="Application Name" name="name" type="text" value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="url" class="col-md-2 control-label">Url</label>
                            <div class="col-sm-10">
                                <input class="form-control" placeholder="Redirect Url" name="url" type="text" value="{{old('url')}}">
                            </div>
                        </div>
                        <div style="text-align:center">
                        <input class="btn btn-default btn-success" type="submit" value="Create">
                        <a href="{{route('oauth2.client.index')}}" class="btn btn-default btn-info">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection