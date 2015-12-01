@extends('oauth2::scaffold.main')
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Oauth2 Authorization</h3>
                </div>
                <div class="panel-body">
                    @include('oauth2::partial.alert')
                    <form method="POST" action="{{route('oauth2.authorize.post', $params)}}" class="form-horizontal" style="text-align:center">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <dl class="dl-horizontal">
                            <dt>Client Name</dt>
                            <dd>{{$user->name}}</dd>
                        </dl>
                    </div>
                    <input name="client_id" type="hidden" value="{{$params['client_id']}}">
                    <input name="redirect_uri" type="hidden" value="{{$params['redirect_uri']}}">
                    <input name="response_type" type="hidden" value="{{$params['response_type']}}">
                    <input name="state" type="hidden" value="{{$params['state']}}">
                    <input name="approve" type="submit" value="Approve" class="btn btn-success">
                    <input name="deny" type="submit" value="Deny" class="btn bg-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection