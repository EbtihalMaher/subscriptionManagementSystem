@extends('layouts.mainLayout')


@section('content')
    <div class="card-header">
        <h3 class="card-title">Create Enterprise</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

    <form id="page-form">
        <div class="card-body">
            @csrf                          
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label for="name">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <label for="name">Contact</label>
                    <input type="text" class="form-control" id="contact" placeholder="Enter Contact">
                </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="button" onclick="performSave()" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection


<script>
    function performSave() {
        // Make a request for a user with a given ID
        axios.post('/cms/admin/enterprises',{
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            contact: document.getElementById('contact').value
        })
        .then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
            // document.getElementById('page-form').reset();
            window.location.href = '/cms/admin/enterprises';
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
