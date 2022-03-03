@extends('layouts.employee.app')
@section('title')
HIPHOP - TAMBAH TRANSAKSI
@endsection
@section('content')

<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-primary btn-sm" data-toggle="modal" href="#cartModal">Tambah Cart</a>
                        <div class="card-datatable">
                            <table class="datatables-ajax table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Menu</th>
                                        <th>Price</th>
                                        <th>qty</th>
                                        <th>Total</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($carts) < 1)
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak Ada Data</td>
                                        </tr>
                                    @endif
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach($carts as $item)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>{{$item->total}}</td>
                                            <td>
                                                <button class="dropdown-item" onclick="event.preventDefault();
                                                document.getElementById('deleteMenu-{{$item->id}}').submit();">
                                                    <i data-feather="trash" class="mr-50"></i>
                                                    <span>Delete</span>
                                                </button>
                                                <form action="{{route('employee.cart.delete', $item->id)}}" style="display: none" id="deleteMenu-{{$item->id}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <form class="form" action="{{route('employee.transaction.store')}}" method="POST">
                            <div class="row">
                                @csrf
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Tanggal Transaksi</label>
                                        <input type="text" id="fp-default" name="date_transaction" required class="form-control flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="amount">Nominal</label>
                                        <input type="text" id="amount" value="{{$subTotal->total}}" name="amount" class="form-control" placeholder="Nominal" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="last-name-column">Status</label>
                                            <select class="form-control" name="status" id="basicSelect" required>
                                                <option>-- Pilih Status --</option>
                                                <option value="1">Masuk</option>
                                                <option value="0">Keluar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Deskripsi</label>
                                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="Textarea" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="animated">   
    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
        data-backdrop="static" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticModalLabel">Hapus Data Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('employee.cart.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="last-name-column">Menu</label>
                            <select class="form-control" name="docNo" id="docNo">
                                <option value="">-- Pilih Menu --</option>
                                @foreach($menus as $item)
                                <option name="id" value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="hidden" name="name" id="name" class="form-control" placeholder="nama" readonly/>
                            <input type="text" name="price" id="harga" class="form-control" placeholder="harga" readonly />
                        </div>
                    
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="text" name="stock" id="stock" class="form-control" placeholder="Stock" readonly/>
                        </div>
                        <div class="form-group">
                            <label for="stock">Jumlah</label>
                            <input type="number" name="qty" class="form-control" placeholder="jumlah"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')
      <script>
        $('#docNo').change(function() {
            var id = $(this).val();
            var url = '{{ route("employee.menu.detail", ":id") }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response != null) {
                        $('#name').val(response.name);
                        $('#harga').val(response.price);
                        $('#stock').val(response.stock);
                        console.log(response);
                    }
                }
            });
        });
      </script>
@endsection