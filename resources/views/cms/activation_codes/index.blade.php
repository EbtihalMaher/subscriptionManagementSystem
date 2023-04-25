@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Activation Codes </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Group Id</th>
                    <th>Number</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($activation_codes as $activation_code )
                    <tr id="activation_codes_{{$activation_codes->id}}_row">
                        <td>{{$activation_codes->group_id}}</td>
                        <td>{{$activation_codes->number}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            {{ $activation_codes->links() }}
        </ul>
    </div>
@endsection

<script>
    
</script>