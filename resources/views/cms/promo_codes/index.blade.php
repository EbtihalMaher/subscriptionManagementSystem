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
                </tr>
            </thead>
            <tbody>
                @foreach ($promo_codes as $promo_code)
                    <tr id="promo_code_{{$promo_code->id}}_row">
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$promo_code->name}}</td>
                        <td>{{$promo_code->package_id}}</td>
                        <td>{{$promo_code->discount_percent}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            {{ $promo_codes->links() }}
        </ul>
    </div>
@endsection

<script>
    
</script>