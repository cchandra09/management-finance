@extends('layouts.admin.app')
@section('title')
HIPHOP - MENUS
@endsection
@section('content')

<div class="content-body">
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Data Menu</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createModal" style="float: right; display:block;width:200px;margin-left:10px;margin-top:10px;">Tambah</button>
                    </div>
                    <div class="card-datatable">
                        <table class="datatables-ajax table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Menu</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($menus) < 1)
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak Ada Data</td>
                                    </tr>
                                @endif
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($menus as $item)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->price}}</td>
                                        <td>{{$item->stock}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#updateModal-{{$item->id}}">
                                                        <i data-feather="edit-2" class="mr-50"></i>
                                                        <span>Edit</span>
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
                    <form action="{{route('admin.menu.store')}}" method="post" id="createMenu" class="form-horizontal">
                        @csrf
                        <div class="card-body">
                            @csrf
                            <label for="name">Menu</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="name" placeholder="Nama Menu" aria-label="name" required/>
                            </div>
                            <label for="price">Price</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="price" placeholder="Harga" aria-label="price" required/>
                            </div>
                            <label for="stock">stock</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="stock" placeholder="Jumlah" aria-label="qty" required/>
                            </div>

                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-md" onclick="event.preventDefault(); document.getElementById('createMenu').submit();">Tambah</button>
                                <button type="submit" class="btn btn-default btn-md" data-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($menus as $item)
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
                    <form action="{{route('admin.menu.update', $item->id)}}" method="post" id="updateMenu-{{$item->id}}" class="form-horizontal">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @csrf
                            <label for="name">Menu</label>
                            <div class="input-group mb-2">
                                <input type="text" value="{{$item->name}}" class="form-control" name="name" placeholder="Nama Menu" aria-label="name" required/>
                            </div>
                            <label for="price">Price</label>
                            <div class="input-group mb-2">
                                <input type="text" value="{{$item->price}}" class="form-control" name="price" placeholder="Harga" aria-label="price" required/>
                            </div>
                            <label for="stock">stock</label>
                            <div class="input-group mb-2">
                                <input type="text" value="{{$item->stock}}" class="form-control" name="stock" placeholder="Jumlah" aria-label="qty" required/>
                            </div>

                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-md" onclick="event.preventDefault(); document.getElementById('updateMenu-{{$item->id}}').submit();">Edit</button>
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
    @foreach ($menus as $item)    
        <div class="modal fade" id="deleteModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
            data-backdrop="static" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticModalLabel">Hapus Data Menu</h5>
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
                        document.getElementById('deleteMenu-{{$item->id}}').submit();">Confirm</button>
                    <form action="{{route('admin.menu.delete', $item->id)}}" style="display: none" id="deleteMenu-{{$item->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endforeach
@endsection
@section('scripts')

@endsection