@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Create Activation Codes Group</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

    <form id="page-form">
        <div class="card-body">
            @csrf
            <div class="form-group">
                <label for="package_id">Package</label>
                <input type="number" class="form-control" id="package_id">
            </div>
            <div class="form-group">
                <label for="group_name">Group Name</label>
                <input type="text" class="form-control" id="group_name" placeholder="Enter Group Name">
            </div>
            <div class="form-group">
                <label for="count">Count</label>
                <input type="number" class="form-control" id="count" placeholder="Enter count">
            </div>

            <div class="container mt-5" style="max-width: 450px">
                <h2 class="mb-4">Start Date</h2>
                <div class="form-group">
                    <div class='input-group date' id='start_date'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
           </div>

           <div class="container mt-5" style="max-width: 450px">
            <h2 class="mb-4">Expire_date</h2>
            <div class="form-group">
                <div class='input-group date' id='expire_date'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>
            </div>
       </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" placeholder="Enter price">
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
        axios.post('/cms/admin/packages',{
            name: document.getElementById('package_id').value,
            description: document.getElementById('group_name').value,
            price: document.getElementById('count').value,
            duration: document.getElementById('start_date').value,
            duration_unit: document.getElementById('expire_date').value,
            image: document.getElementById('price').value,
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