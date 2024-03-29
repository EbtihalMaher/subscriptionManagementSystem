@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Create Package</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

    <form id="page-form" enctype="multipart/form-data">
        <div class="card-body ">
            @csrf
            <div class="form-group">
                <label for="name">name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter Full name">
            </div>
            <div class="form-group mt-3">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" placeholder="Enter description">
            </div>
            <div class="form-group mt-3">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" placeholder="Enter price">
            </div>
            <div class="form-group mt-3">
                <label for="duration">Duration</label>
                <input type="number" class="form-control" id="duration" placeholder="Enter duration">
            </div>
            <div class="form-group mt-3">
                <label for="duration_unit">Duration unit</label>
                <select class="form-control" id="duration_unit">
                    <option value="d">Day</option>
                    <option value="m">Month</option>
                    <option value="y">Year</option>
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="image" >image</label>
                <input class="form-control" type="file"   name="image" id="image" />
            </div>
            <div class="form-group mt-3">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_unlimited" name="is_unlimited" >
                    <label class="custom-control-label" for="is_unlimited">isUnlimited</label>
                </div>
            </div>
            <div class="form-group mt-3" id="limit-div">
                <label for="limit">Limit</label>
                <input type="number" class="form-control" id="limit" placeholder="Enter Limit">
            </div>
            <div class="form-group mt-3">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="active" name="active">
                    <label class="custom-control-label" for="active">Active</label>
                </div>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer mt-3">
            <button type="button" onclick="performSave()" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection

@section('scripts')

<script>


    const isUnlimitedCheckbox = document.getElementById('is_unlimited');
    const limitInput = document.getElementById('limit');


    isUnlimitedCheckbox.addEventListener('change', function() {
    document.getElementById('limit-div').style.display = this.checked ? 'none' : 'block';
    });

        function performSave() {
        let formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('description', document.getElementById('description').value);
        formData.append('price', document.getElementById('price').value);
        formData.append('duration', document.getElementById('duration').value);
        formData.append('duration_unit', document.getElementById('duration_unit').value);
        formData.append('image', document.getElementById('image').files[0]);
        formData.append('is_unlimited', (isUnlimitedCheckbox.checked ? 1 : 0));
        formData.append('limit', limitInput.value);
        formData.append('active', (document.getElementById('active').checked ? 1: 0));

        axios.post('/cms/user/packages', formData, {
            headers: {
            'Content-Type': 'multipart/form-data'
            }
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
