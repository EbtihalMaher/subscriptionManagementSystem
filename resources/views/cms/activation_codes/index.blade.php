@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Bordered Table</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Duration</th>   
                    <th>Duration Unit</th>
                    <th>Image</th>
                    <th>Limit</th>
                    <th>IS Unlimited</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $package)
                    <tr id="package_{{$package->id}}_row">
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$package->name}}</td>
                        <td>{{$package->description}}</td>
                        <td>{{$package->price}}</td>
                        <td>{{$package->duration}}</td>
                        <td>{{$package->duration_unit ?? 'non'}}</td>
                        <td><img src="{{asset('assets/uploads/packages/' .$package->image)}}" class="image"   alt="Image here "></td>
                        <td>{{$package->limit}}</td>
                        <td>
                            <span class="badge @if($package->is_unlimited) bg-success @else bg-danger @endif">{{$package->is_unlimited}}</span>
                        </td>
                        <td>
                            <span class="badge @if($package->active) bg-success @else bg-danger @endif">{{$package->active}}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            {{ $packages->links() }}
        </ul>
    </div>
@endsection

<script>
    
</script>