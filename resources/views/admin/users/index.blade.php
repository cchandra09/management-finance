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
                                <a class="nav-link active" id="home-tab-fill" data-toggle="tab" href="#home-fill" role="tab" aria-controls="home-fill" aria-selected="true">Area Manager</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab-fill" data-toggle="tab" href="#profile-fill" role="tab" aria-controls="profile-fill" aria-selected="false">Front Office</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content pt-1">
                            <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title">Data Area Manager</h4>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" href="#createModal">Tambah Area Manager</button>
                                            </div>
                                            <div class="card-datatable" style="padding: 15px; box-sizing: border-box">
                                                <table class="datatables-ajax table" id="all-management">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Kecamatan</th>
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
                                                                <td>{{$item->district}}</td>
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
                            <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title">Data Front Office</h4>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" href="#createFrontOfficeModal">Tambah Front Office</button>
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
                    <h5 class="modal-title" id="staticModalLabel">Tambah Data Area Manager</h5>
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
                            <label for="district">Kecamatan</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="district" placeholder="district" aria-label="district" required/>
                            </div>
                            <div class="col-sm-9 mt-2">
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
    <div class="modal fade" id="createFrontOfficeModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
        data-backdrop="static" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticModalLabel">Tambah Data Front Office</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.users.frontOffice.store')}}" method="post" id="createFrontOffice" class="form-horizontal">
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
                            <label for="password">Code Angkringan</label>
                            <select class="livesearch select2 form-control form-control-lg" name="code_angkringan"></select>

                            <div class="col-sm-9 mt-2">
                                <button type="submit" class="btn btn-primary btn-md" onclick="event.preventDefault(); document.getElementById('createFrontOffice').submit();">Tambah</button>
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
                        document.getElementById('deleteUser2-{{$item->id}}').submit();">Confirm</button>
                        <form action="{{route('admin.users.delete', $item->id)}}" style="display: none" id="deleteUser2-{{$item->id}}" method="POST">
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
<script type="text/javascript">
    $('.livesearch').select2({
        placeholder: 'Select Kode Angkringan',
        ajax: {
            url: '/admin/search-code',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.code_angkringan,
                            id: item.code_angkringan
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
@endsection