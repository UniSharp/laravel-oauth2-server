@extends('scaffold.main')
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Oauth2 Authorization</h3>
                </div>
                <div class="panel-body">
                    @include('partial.alert')
                    {!! Form::open(['method' => 'POST','class'=>'form-horizontal', 'style'=>'text-align:center','url'=> route('oauth.authorize.post',$params)]) !!}
                    <div class="form-group">
                        <dl class="dl-horizontal">
                            <dt>Client Name</dt>
                            <dd>{{$user->name}}</dd>
                        </dl>
                    </div>
                    {!! Form::hidden('client_id', $params['client_id']) !!}
                    {!! Form::hidden('redirect_uri', $params['redirect_uri']) !!}
                    {!! Form::hidden('response_type', $params['response_type']) !!}
                    {!! Form::hidden('state', $params['state']) !!}
                    {!! Form::submit('Approve', ['name'=>'approve', 'value'=>1, 'class'=>'btn btn-success']) !!}
                    {!! Form::submit('Deny', ['name'=>'deny', 'value'=>1, 'class'=>'btn bg-danger']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection