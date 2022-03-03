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
                        <h4 class="card-title">Data Angkringan {{$code_angkringan}}</h4>
                    </div>
                    <div class="card-datatable">
                        <table class="datatables-ajax table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Kode</th>
                                    <th>Password</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($users) < 1)
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak Ada Data</td>
                                    </tr>
                                @endif
                                @foreach($users as $item)
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
    </section>
</div>
<div class="animated">
    @foreach ($users as $item)    
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

@endsection