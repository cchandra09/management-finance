@extends('layouts.admin.app')
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
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab-fill" data-toggle="tab" href="#home-fill" role="tab" aria-controls="home-fill" aria-selected="true">Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab-fill" data-toggle="tab" href="#profile-fill" role="tab" aria-controls="profile-fill" aria-selected="false">Karyawan</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content pt-1">
                            <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title">Data Management</h4>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" href="#createModal">Tambah Managament</button>
                                            </div>
                                            <div class="card-datatable" style="padding: 15px; box-sizing: border-box">
                                                <table class="datatables-ajax table" id="all-management">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Kode Angkringan</th>
                                                            <th>Password</th>
                                                            <th>Option</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($management) < 1)
                                                            <tr>
                                                                <td colspan="6" class="text-center">Tidak Ada Data</td>
                                                            </tr>
                                                        @endif
                                                        @foreach($management as $item)
                                                            <tr>
                                                                <td>{{$item->name}}</td>
                                                                <td>{{$item->email}}</td>
                                                                <td>{{$item->code_angkringan}}</td>
                                                                <td>{{$item->user_password}}</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                                            <i data-feather="more-vertical"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            {{-- <a class="dropdown-item" href="{{route('admin.users.detail', $item->id)}}">
                                                                                <i data-feather="eye" class="mr-50"></i>
                                                                                <span>Detail</span>
                                                                            </a> --}}
                                                                            <a class="dropdown-item" data-toggle="modal" href="#deleteManagementModal-{{$item->id}}">
                                                                                <i data-feather="trash" class="mr-50"></i>
                                                                                <span>Delete</span>
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
                            <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title">Data Karyawan</h4>
                                            </div>
                                            <div class="card-datatable" style="padding: 15px; box-sizing: border-box">
                                                <table class="datatables-ajax table" id="all-users">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Kode Angkringan</th>
                                                            <th>Password</th>
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
                                                                <td>{{$item->user_password}}</td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                                            <i data-feather="more-vertical"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="{{route('admin.users.detail', $item->id)}}">
                                                                                <i data-feather="eye" class="mr-50"></i>
                                                                                <span>Detail</span>
                                                                            </a>
                                                                            <a class="dropdown-item" data-toggle="modal" href="#deleteModal-{{$item->id}}">
                                                                                <i data-feather="trash" class="mr-50"></i>
                                                                                <span>Delete</span>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="animated">
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
        data-backdrop="static" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticModalLabel">Hapus Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.users.store')}}" method="post" id="createUserManagement" class="form-horizontal">
                        @csrf
                        <div class="card-body">
                            @csrf
                            <label for="name-user">Nama</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="name" placeholder="Nama User" aria-label="name-user" required/>
                            </div>
                            <label for="email-user">Email</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="email" placeholder="Email User" aria-label="email-user" required/>
                            </div>
                            <label for="password">Password</label>
                            <div class="input-group mb-2">
                                <input type="password" class="form-control" name="password" placeholder="Password" aria-label="password" required/>
                            </div>

                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-md" onclick="event.preventDefault(); document.getElementById('createUserManagement').submit();">Tambah</button>
                                <button type="submit" class="btn btn-default btn-md" data-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="animated">
    @foreach ($management as $item)    
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
            data-backdrop="static" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticModalLabel">Hapus Data User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Apakah Anda yakin ingin menghapus data ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="event.preventDefault();
                        document.getElementById('deleteUser').submit();">Confirm</button>
                    <form action="{{route('admin.users.delete', $item->id)}}" style="display: none" id="deleteUser" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="animated">
    @foreach ($user as $item)    
        <div class="modal fade" id="deleteModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
            data-backdrop="static" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticModalLabel">Hapus Data User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Apakah Anda yakin ingin menghapus data ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="event.preventDefault();
                        document.getElementById('deleteUser-{{$item->id}}').submit();">Confirm</button>
                    <form action="{{route('admin.users.delete', $item->id)}}" style="display: none" id="deleteUser-{{$item->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
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