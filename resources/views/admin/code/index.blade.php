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
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Data Kode Angkringan</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createModal" style="float: right; display:block;width:200px;margin-left:10px;margin-top:10px;">Tambah</button>
                    </div>
                    <div class="card-datatable">
                        <table class="datatables-ajax table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Code</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($code) < 1)
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak Ada Data</td>
                                    </tr>
                                @endif
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($code as $item)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$item->code_angkringan}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('admin.users.codeDetailAngkringan', $item->code_angkringan)}}">
                                                        <i data-feather="eye" class="mr-50"></i>
                                                        <span>Detail</span>
                                                    </a>
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#updateModal-{{$item->id}}">
                                                        <i data-feather="edit-2" class="mr-50"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                    <a class="dropdown-item" data-toggle="modal" href="#deleteModalTransaction-{{$item->id}}">
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
    </section>
</div>
<div class="animated">
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        data-backdrop="static" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Form Tambah Data Perusahaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.users.codeStoreAngkringan')}}" method="post" id="createCode" class="form-horizontal">
                        @csrf
                        <div class="card-body">
                            @csrf
                            <label for="code_angkringan">Kode Angkringan</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="code_angkringan" placeholder="Kode Perusahaan" aria-label="code_angkringan" required/>
                            </div>

                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-md" onclick="event.preventDefault(); document.getElementById('createCode').submit();">Tambah</button>
                                <button type="submit" class="btn btn-default btn-md" data-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($code as $item)
<div class="animated">
    <div class="modal fade" id="updateModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        data-backdrop="static" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Form Tambah Data Perusahaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.users.codeUpdateAngkringan', $item->id)}}" method="post" id="updateCode" class="form-horizontal">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @csrf
                            <label for="code_angkringan">Kode Angkringan</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" value="{{$item->code_angkringan}}" name="code_angkringan" placeholder="Kode Perusahaan" aria-label="code_angkringan" required/>
                            </div>

                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-md" onclick="event.preventDefault(); document.getElementById('updateCode').submit();">Tambah</button>
                                <button type="submit" class="btn btn-default btn-md" data-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@section('scripts')

@endsection