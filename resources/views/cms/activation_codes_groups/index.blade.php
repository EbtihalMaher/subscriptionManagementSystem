@extends('layouts.mainLayout')

@section('content')
    <div class="card-header">
        <h3 class="card-title">Activation Codes Groups</h3>
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
                    <th> Activation Codes</th>
                    <th>Settings</th>

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
                        <td>
                            <div class="btn-group">
                                <a href="{{route('activation_codes.index' , ['group_id' => $activationCodeGroup->id])}}" class="btn btn-warning">
                                    Activation Codes
                                </a>
                            </div>
                        </td>
                        <td>
                            {{-- <div class="btn-group"> --}}
                                <a href="#" onclick="confirmDelete('{{$activationCodeGroup->id}}')"
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
            @if ($activationCodeGroups->currentPage() > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $activationCodeGroups->previousPageUrl() }}">&laquo;</a>
                </li>
            @endif
    
            @for ($i = 1; $i <= $activationCodeGroups->lastPage(); $i++)
                @if ($i == $activationCodeGroups->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $i }}</span>
                    </li>
                @else
                    @if ($i >= $activationCodeGroups->currentPage() - 2 && $i <= $activationCodeGroups->currentPage() + 2)
                        <li class="page-item">
                            <a class="page-link" href="{{ $activationCodeGroups->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endif
            @endfor
    
            @if ($activationCodeGroups->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $activationCodeGroups->nextPageUrl() }}">&raquo;</a>
                </li>
            @endif
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