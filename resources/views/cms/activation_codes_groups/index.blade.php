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
                @foreach ($activationCodeGroups as $activationCodeGroup)
                    <tr id="activationCodeGroups{{$activationCodeGroup->id}}_row">
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$activationCodeGroup->package_id}}</td>
                        <td>{{$activationCodeGroup->group_name}}</td>
                        <td>{{$activationCodeGroup->count}}</td>
                        <td>{{$activationCodeGroup->start_date}}</td>
                        <td>{{$activationCodeGroup->expire_date}}</td>
                        <td>{{$activationCodeGroup->price}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    {{-- <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            {{ $activationCodeGroups->links() }}
        </ul>
    </div> --}}
@endsection

<script>
    
</script>