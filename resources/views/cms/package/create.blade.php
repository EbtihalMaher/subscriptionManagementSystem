@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Create User</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

    <form id="page-form">
        <div class="card-body">
            @csrf
            <div class="form-group">
                <label for="name">name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter Full name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" placeholder="Enter description">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" placeholder="Enter price">
            </div>
            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="number" class="form-control" id="duration" placeholder="Enter duration">
            </div>
            <div class="form-group">
                <label for="duration_unit">Duration unit</label>
                <select class="form-control" id="duration_unit">
                    <option value="d">Day</option>
                    <option value="m">Month</option>
                    <option value="y">Year</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image" >image</label>
                <input class="form-control" type="file"  id="image" />
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="isUnlimited" name="isUnlimited">
                    <label class="custom-control-label" for="isUnlimited">isUnlimited</label>
                </div>
            </div>
            <div class="form-group">
                <label for="limit">Limit</label>
                <input type="number" class="form-control" id="limit" placeholder="Enter Limit">
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="active" name="active">
                    <label class="custom-control-label" for="active">Active</label>
                </div>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="button" onclick="performSave()" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection

@section('scripts')

<script>
    function performSave() {
        // Make a request for a user with a given ID
        axios.post('/cms/admin/users',{
            name: document.getElementById('name').value,
            description: document.getElementById('description').value,
            price: document.getElementById('price').value,
            duration: document.getElementById('duration').value,
            duration_unit: document.getElementById('duration_unit').value,
            image: document.getElementById('image').value,
            isUnlimited: document.getElementById('isUnlimited').value,
            limit: document.getElementById('limit').value,
            active: document.getElementById('active').value,
        })
        .then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
            document.getElementById('page-form').reset();
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
@endsection