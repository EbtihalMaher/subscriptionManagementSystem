@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Profile {{ $client->name }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 20%">Start Date</th>
                    <th style="width: 20%">End Date</th>
                    <th style="width: 15%">Package ID</th>
                    <th style="width: 20%">Limit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $profile->start_date }}</td>
                    <td>{{ $profile->end_date }}</td>
                    <td>{{ $profile->package_id }}</td>
                    <td>{{ $profile->limit }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
@endsection
