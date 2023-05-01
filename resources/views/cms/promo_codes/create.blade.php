@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Create Promo Code</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

    <form id="page-form">
        <div class="card-body">
            @csrf
            <div class="form-group">
                <label for="name">Promo Code Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter the name">
            </div>
            <div class="form-group mt-3">
                <label>Package</label>
                <select class="form-control" id="package_id">
                    @foreach ($packages as $package)
                    <option value="{{$package->id}}">{{$package->name}}</option>
                    @endforeach
                </select>
            </div>  
            <div class="form-group mt-3">
                <label for="discount_percent">Discount</label>
                <input type="number" class="form-control" id="discount_percent" placeholder="Enter the discount percent">
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
        axios.post('/cms/user/promo_codes',{
            name: document.getElementById('name').value,
            package_id: document.getElementById('package_id').value,
            discount_percent: document.getElementById('discount_percent').value,
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