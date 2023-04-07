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
                    <th>Full name</th>
                    <th>Email</th>
                    <th>Permissions</th>
                    <th style="width: 20%">Settings</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr id="admin_{{$user->id}}_row">
                    <td>{{$loop->index + 1}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <a href="{{route('user.edit-permissions',$user->id)}}" type="button" class="btn btn-block btn-outline-primary btn-sm">({{$user->permissions_count}}) Permission/s</a>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('users.edit',$user->id)}}" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="confirmDelete('{{$user->id}}')"
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
            {{ $users->links() }}
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
        axios.delete('/cms/admin/users/'+id)
        .then(function (response) {
            // handle success
            console.log(response);
            // toastr.success(response.data.message);
            toastr.success(response.data.message);
            // document.getElementById('admin_'+id+'_row').remove();
        })
        .catch(function (error) {
            // handle error 4xx - 5xx
            console.log(error);
            // toastr.error(error.response.data.message);
            toastr.error(error.response.data.message);
        })
        .then(function () {
            // always executed
        });
    }
</script>