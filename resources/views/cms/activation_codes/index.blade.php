@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Activation Codes</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Group Id</th>
                    <th>Number</th>
                    <th>Settings</th>

                    
                </tr>
            </thead>
            <tbody>
                @foreach ($activationCodes as $activationCode)
                    <tr id="activationCodes_{{$activationCode->id}}_row">
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$activationCode->group_id}}</td>
                        <td>{{$activationCode->number}}</td>
                        <td>
                            {{-- <div class="btn-group"> --}}
                                <a href="#" onclick="confirmDelete('{{$activationCode->id}}')"
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
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </div>
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
    
</script>