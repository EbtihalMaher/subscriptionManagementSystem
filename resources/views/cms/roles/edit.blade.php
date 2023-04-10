@extends('layouts.mainLayout')


@section('content')
    <!-- card-header -->
    <div class="card-header">
        <h3 class="card-title">Edit Role</h3>
    </div>
    <!-- /.card-header -->

    <!-- form start -->

    <form id="page-form">
        <div class="card-body col-md-6">
            @csrf
            <div class="form-group mt-3">
                <label for="name" class="mt-2">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter Name"
                    value="{{$role->name}}">
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="button" onclick="performUpdate()" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection

<script>
    function performUpdate() {
        // Make a request for a user with a given ID
        axios.put('/cms/admin/roles/{{$role->id}}',{
            guard_name: document.getElementById('guard_name').value,
            name: document.getElementById('name').value,

        })
        .then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
            window.location.href = '/cms/{{session('guard')}}/roles';
        })
        .catch(function (error) {
            // handle error 4xx - 5xx
            console.log(error);
            toastr.error(error.response.data.message);
        })
        .then(function () {
            // always executed
        });
    }
</script>
