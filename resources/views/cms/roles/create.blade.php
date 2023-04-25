@extends('layouts.mainLayout')

@section('content')
    <!-- card-header -->
    <div class="card-header">
        <h3 class="card-title">Create Roles</h3>
    </div>
    <!-- /.card-header -->

    <!-- form start -->
    <form id="page-form">
        <div class="card-body col-md-6">
            @csrf
            <div class="form-group mt-3">
                <label for="name" class="mb-2">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter Name">
            </div>
        </div>
        <div class="card-footer">
            <button type="button" onclick="performSave()" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection


<script>
    function performSave() {
        // Make a request for a user with a given ID
        axios.post('/cms/{{session('guard')}}/roles',{
            guard_name: document.getElementById('guard_name').value,
            name: document.getElementById('name').value,
        })
        .then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
            document.getElementById('page-form').reset();
            // window.location.href ='/cms/admin/roles';
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
