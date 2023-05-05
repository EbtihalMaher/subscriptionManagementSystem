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
                    <th style="width: 15%">Name</th>
                    <th style="width: 20%">Description</th>
                    <th style="width: 10%">Price</th>
                    <th style="width: 10%">Duration</th>   
                    <th style="width: 10%">Duration Unit</th>
                    <th style="width: 10%">Image</th>
                    <th style="width: 10%">Limit</th>
                    <th style="width: 5%">IS Unlimited</th>
                    <th style="width: 5%">Active</th>
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
                        
                        <td><img src="{{asset('assets/uploads/products/' .$package->image)}}" style="height: 100px; width:100px" class="package-image" alt="Image here "></td>
                        {{-- <td><img src="{{Storage::url($package->image)}}"  class="image"  alt="Image here "></td> --}}

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
    {{-- <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            {{ $packages->links() }}
        </ul>
    </div> --}}
@endsection

<script>
    
</script>