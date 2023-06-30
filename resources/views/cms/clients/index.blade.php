@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Clients</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Client ID</th>
                    <th>Profile</th>
                    <th>Subscriptions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->id }}</td>
                    <td><a href="{{ route('clients.profile', $client->id) }}">Profile</a></td>
                    <td><a href="{{ route('clients.subscriptions', $client->id) }}">Subscriptions</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
@endsection
