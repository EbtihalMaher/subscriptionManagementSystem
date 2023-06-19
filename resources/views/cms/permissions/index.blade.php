@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Permissions</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 40%">Name</th>
                    <th style="width: 20%">Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr id="permission_{{$permission->id}}_row">
                    <td>{{$loop->index + 1}}</td>
                    <td>{{$permission->name}}</td>
                    <td>
                        <span
                            class="badge bg-success">{{$permission->guard_name}}
                        </span>
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
