@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Promo Codes</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Name</th>
                    <th>Package Id</th>
                    <th>Discount Percent</th>
                    <th>Settings</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($promo_codes as $promo_code)
                    <tr id="promo_codes_{{$promo_code->id}}_row">
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$promo_code->name}}</td>
                        <td>{{$promo_code->package_id}}</td>
                        <td>{{$promo_code->discount_percent}}</td>
                        <td>
                            {{-- <div class="btn-group"> --}}
                                <a href="#" onclick="confirmDelete('{{$promo_code->id}}')"
                                    class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            {{-- </div> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    {{-- <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            {{ $promo_codes->links() }}
        </ul>
    </div> --}}
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
        axios.delete('/cms/user/promo_codes/'+id)
        .then(function (response) {
            console.log(response);
            showSwalMessage(response.data);
            window.location.href ='/cms/user/promo_codes';
        })
        .catch(function (error) {
            console.log(error);
            showSwalMessage(error.response.data);
        })
        .then(function () {
            // always executed
        });
    }

    function showSwalMessage(data) {
        Swal.fire(
            data.title,
            data.message,
            data.icon,
        )
    }
    
</script>