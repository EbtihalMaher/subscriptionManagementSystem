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
                                <a href="#" onclick="confirmDelete('{{$activationCode->id}}')" class="btn btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
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
            @if ($activationCodes->currentPage() > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $activationCodes->previousPageUrl() }}">&laquo;</a>
                </li>
            @endif
    
            @for ($i = 1; $i <= $activationCodes->lastPage(); $i++)
                @if ($i == $activationCodes->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $i }}</span>
                    </li>
                @else
                    @if ($i >= $activationCodes->currentPage() - 2 && $i <= $activationCodes->currentPage() + 2)
                        <li class="page-item">
                            <a class="page-link" href="{{ route('activation_codes.index', ['group_id' => $groupId, 'page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endif
            @endfor
    
            @if ($activationCodes->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $activationCodes->nextPageUrl() }}">&raquo;</a>
                </li>
            @endif
        </ul>
    </div>
    
    
    
@endsection

<script>
   
</script>