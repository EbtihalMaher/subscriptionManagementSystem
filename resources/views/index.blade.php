@extends('layouts.mainLayout')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 pt-2">
            <div class="card">
                {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}


                @can('Home')
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h2>
                            {{ __('Welcome Admin') }}

                        </h2>
                            {{-- @if(\Illuminate\Support\Facades\Auth::user()->enterprise_id != null)
                                <small>Name: {{$enterprise->name}}</small>
                                <small style="margin-left: 150px;">Email: {{$enterprise->email}}</small>
                                <small style="margin-left: 150px;">API Key: {{$enterprise->api_key}}</small>
                                <small style="margin-left: 150px;">Contact: {{$enterprise->contact}}</small>
                            @endif --}}
                    </div>
                @endcan

            </div>
        </div>
    </div>
@endsection
