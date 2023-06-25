@extends('layouts.mainLayout')

@section('content')

    <div class="card-header">
        <h3 class="card-title">Admins</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width: 20%">Settings</th>
                </tr>
            </thead>
         <tbody>
                @foreach ($admins as $admin)
                    <tr id="admin_{{$admin->id}}_row">
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$admin->name}}</td>
                        <td>{{$admin->email}}</td>
                        <td>{{$admin->roles[0]->name ?? 'Null'}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('admins.edit',$admin->id)}}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" onclick="confirmDelete('{{$admin->id}}')"
                                    class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            @if ($admins->currentPage() > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $admins->previousPageUrl() }}">&laquo;</a>
                </li>
            @endif
    
            @for ($i = 1; $i <= $admins->lastPage(); $i++)
                @if ($i == $admins->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $i }}</span>
                    </li>
                @else
                    @if ($i >= $admins->currentPage() - 2 && $i <= $admins->currentPage() + 2)
                        <li class="page-item">
                            <a class="page-link" href="{{ $admins->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endif
            @endfor
    
            @if ($admins->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $admins->nextPageUrl() }}">&raquo;</a>
                </li>
            @endif
        </ul>
    </div>

@endsection

{{-- @section('scripts') --}}
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
    function performDelete(id) {
        axios.delete('/cms/admin/admins/'+id)
        .then(function (response) {
            // handle success
            console.log(response);
            // toastr.success(response.data.message);
            showSwalMessage(response.data);
            // document.getElementById('admin_'+id+'_row').remove();
            window.location.href ='/cms/admin/admins';
        })
        .catch(function (error) {
            // handle error 4xx - 5xx
            console.log(error);
            // toastr.error(error.response.data.message);
            showSwalMessage(error.response.data);
        })
        .then(function () {
            // always executed
        });
    }

    function showSwalMessage(data) {
        Swal.fire(
            data.title,
            data.message,
            data.icon,
        )
    }
</script>
