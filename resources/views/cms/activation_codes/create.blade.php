@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Creat Activation Code</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

    <form id="page-form">
        <div class="card-body">
            @csrf

            <div class="form-group mt-3">
                <label>Group ID</label>
                <select class="form-control" id="group_id">
                    @foreach ($activationCodeGroups as $activationCodeGroup)
                    <option value="{{$activationCodeGroup->id}}">{{$activationCodeGroup->group_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="number">Number</label>
                <input type="text" class="form-control" id="number" placeholder="Enter number">
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
        axios.post('/cms/user/activation_codes',{
            group_id: document.getElementById('group_id').value,
            number: document.getElementById('number').value,
           
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