@extends('oauth2::scaffold.main')
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    @include('oauth2::partial.alert')
                    <form method="POST" action="{{route('oauth2.login.post')}}">
                        {{ csrf_field() }}
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text" value="{{old('username')}}">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password">
                            </div>
                           
                            <input name="client_id" type="hidden" value="{{$params['client_id']}}">
                            <input name="redirect_uri" type="hidden" value="{{$params['redirect_uri']}}">
                            <input name="response_type" type="hidden" value="{{$params['response_type']}}">
                            <input name="state" type="hidden" value="{{$params['state']}}">

                             <input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection