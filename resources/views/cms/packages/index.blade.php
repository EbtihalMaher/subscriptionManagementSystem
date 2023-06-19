@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Packages Table</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th >#</th>
                        <th >Name</th>
                        <th >Description</th>
                        <th >Price</th>
                        <th >Duration</th>   
                        <th >Duration Unit</th>
                        <th >Image</th>
                        <th >Limit</th>
                        <th >IS Unlimited</th>
                        <th >Active</th>
                        <th >Settings</th>
    
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
    
                            <td>
                                <div class="btn-group" >
                                    <a href="#" onclick="confirmDelete('{{$package->id}}')" class="btn btn-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
    <!-- /.card-body -->
    {{-- <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            {{ $packages->links() }}
        </ul>
    </div> --}}
@endsection

<script>
  
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    performDelete(id);
                }
        })
    }
     
</script>