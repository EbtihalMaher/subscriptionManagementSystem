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
            <div class="form-group mt-3">
                <label>Package</label>
                <select class="form-control" id="package_id">
                    @foreach ($packages as $package)
                    <option value="{{$package->id}}">{{$package->name}}</option>
                    @endforeach
                </select>
            </div>  
            <div class="form-group mt-3">
                <label for="group_name">Group Name</label>
                <input type="text" class="form-control" id="group_name" placeholder="Enter Group Name">
            </div>
            <div class="form-group mt-3">
                <label for="count">Count</label>
                <input type="number" class="form-control" id="count" placeholder="Enter count">
            </div>

            <div class="form-group mt-3">
                <label for="start_date">Start Date</label>
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" id="start_date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <label for="expire_date">Expire Date</label>
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" id="expire_date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>
           
            

            <div class="form-group mt-3">
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
        axios.post('/cms/user/activation_codes_groups',{
            package_id: document.getElementById('package_id').value,
            group_name: document.getElementById('group_name').value,
            count: document.getElementById('count').value,
            start_date: document.getElementById('start_date').value,
            expire_date: document.getElementById('expire_date').value,
            price: document.getElementById('price').value,
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
    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true,
            todayHighlight: true
        });
    });
        

</script>


@endsection