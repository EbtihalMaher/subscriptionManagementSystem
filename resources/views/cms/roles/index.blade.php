@extends('layouts.mainLayout')

@section('content')
    <!-- card-header -->
    <div class="card-header">
        <h3 class="card-title">Bordered Table</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body" style="width: 90%">
        <table class="table table-bordered table-striped table-hover  " >
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 20%">Name</th>
                    <th style="width: 30%">Permissions</th>
                    <th style="width: 25%">Type</th>
                    <th style="width: 20%">Settings</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr id="role_{{$role->id}}_row">
                    <td>{{$loop->index + 1}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                        <a href="{{route('role.edit-permissions',$role->id)}}" type="button" class="btn btn-block btn-outline-primary btn-sm">({{$role->permissions_count}}) Permission/s</a>
                    </td>
                    <td>
                        <span
                            class="badge bg-success">{{$role->guard_name}}</span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('roles.edit',$role->id)}}" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="confirmDelete('{{$role->id}}')"
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
            @if ($roles->currentPage() > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $roles->previousPageUrl() }}">&laquo;</a>
                </li>
            @endif
    
            @for ($i = 1; $i <= $roles->lastPage(); $i++)
                @if ($i == $roles->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $i }}</span>
                    </li>
                @else
                    @if ($i >= $roles->currentPage() - 2 && $i <= $roles->currentPage() + 2)
                        <li class="page-item">
                            <a class="page-link" href="{{ $roles->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endif
            @endfor
    
            @if ($roles->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $roles->nextPageUrl() }}">&raquo;</a>
                </li>
            @endif
        </ul>
    </div>
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
    function performDelete(id) {
        axios.delete('/cms/{{session('guard')}}/roles/'+id)
        .then(function (response) {
            // handle success
            console.log(response);
            // toastr.success(response.data.message);
            showSwalMessage(response.data);
            document.getElementById('role_'+id+'_row').remove();
            window.location.href ='/cms/{{session('guard')}}/roles';
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
