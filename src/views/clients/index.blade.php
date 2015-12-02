@extends('oauth2::scaffold.main')
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Client list</h3>
                </div>
                <div class="panel-body">
                    @include('oauth2::partial.alert')
                    <a href="{{route('oauth2.client.create')}}" class="btn btn-default btn-success">Create</a>
                    <div class="col-lg-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Client ID</th>
                                    <th>Created_time</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                <tr>
                                    <td>{{$client->name}}</td>
                                    <td>{{$client->id}}</td>
                                    <td>{{$client->created_at}}</td>
                                    <td>
                                        <a href="{{route('oauth2.client.edit', $client->id)}}" class="btn btn-primary">Edit</a>
                                        <a href="{{route('oauth2.client.delete', $client->id)}}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- pagination -->
                        <div style="text-align:center">
                            {!! $clients->render() !!}
                        <!-- /.pagination -->
                        <div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>
@endsection