@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Bordered Table</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Package</th>
                    <th>Group name</th>
                    <th>Count</th>
                    <th>Start date</th>   
                    <th>Expire date</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activation_codes_groups as $activation_code_group)
                    <tr id="activation_code_group{{$activation_code_group->id}}_row">
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$activation_code_group->package_id}}</td>
                        <td>{{$activation_code_group->group_name}}</td>
                        <td>{{$activation_code_group->count}}</td>
                        <td>{{$activation_code_group->start_date}}</td>
                        <td>{{$activation_code_group->expire_date}}</td>
                        <td>{{$activation_code_group->price}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            {{ $activation_codes_groups->links() }}
        </ul>
    </div>
@endsection

<script>
    
</script>