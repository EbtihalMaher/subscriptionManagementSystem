@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Subscriptions {{ $client->name }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 20%">Start Date</th>
                    <th style="width: 20%">End Date</th>
                    <th style="width: 15%">Limit</th>
                    <th style="width: 20%">Payment Method</th>
                    {{-- <th style="width: 20%">Paid Amount</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $subscription)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subscription->start_date }}</td>
                        <td>{{ $subscription->end_date }}</td>
                        <td>{{ $subscription->limit }}</td>
                        <td>{{ $subscription->subscription_method }}</td>
                        {{-- <td>{{ $subscription->paid_amount }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
@endsection
