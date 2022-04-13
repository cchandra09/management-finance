@extends('layouts.management.app')
@section('title')
HIPHOP - USERS
@endsection
@section('content')

<div class="content-body">
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0" id="all-management">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Kode Angkringan</th>
                                        <th>Kecamatan</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($user) < 1)
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak Ada Data</td>
                                        </tr>
                                    @endif
                                    @foreach($user as $item)
                                        <tr>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->code_angkringan}}</td>
                                            <td>{{$item->district}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{route('management.users.detail', $item->id)}}">
                                                            <i data-feather="eye" class="mr-50"></i>
                                                            <span>Detail</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#all-users').DataTable();
        $('#all-management').DataTable();
        $('#dataClosedDocument').DataTable();
    });
    $(document).ready(function () {
    $('#dtDynamicVerticalScrollExample').DataTable({
    "scrollY": "50vh",
    "scrollCollapse": true,
    });
    $('.dataTables_length').addClass('bs-select');
    });
</script>
@endsection