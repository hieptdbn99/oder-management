@extends('layout.master');
@section('order-management')
    <div class="container">
        <div class="row mb-5">
            <div class="col-sm-12">
                <div class="title">
                    <h1>Thêm đơn hàng</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <form action="{{ route('order.store') }}" id="add-order-form" enctype="multipart/form-data"
                data-url="{{ route('order.store') }}" method="post">
                @csrf
                @method('post')
                <div class="row">
                    <div class="col-sm-5">
                        <div class="customer mb-3">
                            <h3>Khách hàng</h3>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="">Họ và tên khách hàng</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                    id="input-name">
                                @error('name')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Ảnh đại diện</label>
                                <input type="file" name="avatar" value="{{ old('avatar') }}" class="form-control"
                                    id="input-arvatar">
                                @error('avatar')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                id="input-email">
                            @error('email')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Số điện thoại</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                id="input-phone">
                            @error('phone')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Địa chỉ</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                                id="input-address">
                            @error('address')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <textarea name="note" id="text"></textarea>
                        @include('ckfinder::setup')
                    </div>
                    {{-- <div class="form-group">
            <label for="" class="d-block mt-2">Sản phẩm</label>
            <select class="form-select" id="select-product" aria-label="Default select example">
                @foreach ($products as $product)
                    <option value={{ $product->name }}>{{ $product->name }}</option>
                @endforeach
            </select>
            <input aria-label="quantity" id="input-qty" min="1" max="9999" type="number" value="1">
            <input id="input-price" name = "eachPrice" type="text" placeholder="Đơn giá">
            <a href="" class="addListPro"><i class="fas fa-plus-square"></i></a>
            @error('eachPrice')
                <div style="color: red">Bạn phải thêm sản phẩm để hoàn tất đơn hàng<div>
            @enderror
        </div>
        <div class="form-group">
            <table class="table">
                <thead>
                    <tr>
                       <th scope="col">Sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Thành tiền</th>
                    </tr>
                </thead>
                <tbody id="render-product">
                </tbody>
            </table>
        </div> --}}

                    <div class="col-sm-7">
                        <div class="customer mb-3">
                            <h3>Sản phẩm</h3>
                        </div>
                        <div class="card-body">
                            <table class="table" id="products_table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm </th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody class="addRow">
                                    <tr class="productRow">
                                        <td>
                                            <select name="productIds[]" class="form-control">
                                                <option value="">Sản phẩm</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->name }}

                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="quantities[]" class="form-control" />
                                        <td> <input type="text" name="prices[]" class="form-control" /></td>


                                        </td>
                                        <td> <input type="button" class="del" value="Delete" /></td>

                                        </td>
                                    </tr>
                                    @if ($errors->has('productIds') || $errors->has('quantities') || $errors->has('prices'))
                                        <tr>
                                            <div class="error"> Mời bạn nhập đúng và đủ số lượng, đơn giá cho sản phẩm</div>
                                        </tr>
                                    @endif


                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-12">
                                    <button id="add_row" class="btn btn-default pull-left">+ Add Row</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer col-sm-12">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-light">
        <tbody class="hiden-tr d-none">
            <tr>
                <td>
                    <select name="productIds[]" class="form-control">
                        <option value="">Sản phẩm</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }}

                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" required name="quantities[]" class="form-control" />
                </td>
                <td> <input type="text"  required name="prices[]" class="form-control" />
                </td>
                <td> <input type="button" class="del" value="Delete" /></td>

                </td>


            </tr>


        </tbody>
    </table>
