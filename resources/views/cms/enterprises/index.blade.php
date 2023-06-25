@extends('layouts.mainLayout')

@section('content')

    <div class="card-header">
        <h3 class="card-title">Enterprises</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th style="width: 20%">Settings</th>
                </tr>
            </thead>
         <tbody>
                @foreach ($enterprises as $enterprise)
                    <tr id="enterprise_{{$enterprise->id}}_row">
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$enterprise->name}}</td>
                        <td>{{$enterprise->email}}</td>
                        <td>{{$enterprise->contact}}</td>
                        {{-- <td>{{$enterprise->api_key}}</td> --}}
                        <td>
                            <div class="btn-group">
                                <a href="{{route('enterprises.edit',$enterprise->id)}}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" onclick="confirmDelete('{{$enterprise->id}}')"
                                    class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            @if ($enterprises->currentPage() > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $enterprises->previousPageUrl() }}">&laquo;</a>
                </li>
            @endif
    
            @for ($i = 1; $i <= $enterprises->lastPage(); $i++)
                @if ($i == $enterprises->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $i }}</span>
                    </li>
                @else
                    @if ($i >= $enterprises->currentPage() - 2 && $i <= $enterprises->currentPage() + 2)
                        <li class="page-item">
                            <a class="page-link" href="{{ $enterprises->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endif
            @endfor
    
            @if ($enterprises->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $enterprises->nextPageUrl() }}">&raquo;</a>
                </li>
            @endif
        </ul>
    </div>

@endsection

{{-- @section('scripts') --}}
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
        axios.delete('/cms/admin/enterprises/'+id)
        .then(function (response) {
            // handle success
            console.log(response);
            // toastr.success(response.data.message);
            showSwalMessage(response.data);
            // document.getElementById('enterprise_'+id+'_row').remove();
            window.location.href ='/cms/admin/enterprises';
        })
        .catch(function (error) {
            // handle error 4xx - 5xx
            console.log(error);
            // toastr.error(error.response.data.message);
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
