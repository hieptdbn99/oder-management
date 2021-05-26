@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row pt-2 pb-2">
            <div class="col-sm-12 mt-1">
                <div class="title">
                    <h1>THÊM ĐƠN HÀNG</h1>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <form id="add-order-form" enctype="multipart/form-data"
                data-url="{{ route('order.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
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


                            <div class="form-group col-sm-6">
                                <label for="">Email</label>
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                    id="input-email">
                                @error('email')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Số điện thoại</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                    id="input-phone">
                                @error('phone')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="">Địa chỉ</label>
                                <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                                    id="input-address">
                                @error('address')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Ngày đặt hàng</label>
                                <input type="date" name="date" value="{{ old('date') }}" class="form-control"
                                    id="input-date">
                                @error('date')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12">
                                <label for="">Ghi chú</label>
                                <textarea name="note" id="text"></textarea>
                                @include('ckfinder::setup')
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="product mt-2 mb-2">
                                <h3>Sản phẩm</h3>
                            </div>
                            <div class="card-body">
                                <table class="table product-table" id="products-table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm </th>
                                            <th>Số lượng</th>
                                            <th>Đơn giá</th>
                                            <th>Thành tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="addRow">
                                        @foreach (old('productIds', ['']) as $index => $oldProduct)

                                            <tr>
                                                <td>
                                                    <select name="productIds[]" class="form-control select-pr">
                                                        <option value="">Sản phẩm</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                {{ $oldProduct == $product->id ? ' selected' : '' }}>
                                                                {{ $product->name }}

                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="td-qty">
                                                    <input type="number" class="input-quantity" required name="quantities[]"
                                                        class="form-control"
                                                        value="{{ old('quantities.' . $index) ?? '' }}" />
                                                </td>
                                                <td class="td-price"> <input type="text" required class="input-price"
                                                        value="{{ old('prices.' . $index) ?? '' }}" name="prices[]"
                                                        class="form-control" />
                                                </td>
                                                <td class="td-totalEach">
                                                    {{ old('quantities.' . $index) * old('prices.' . $index) }}</td>
                                                <td> <input type="button" class="del btn btn-danger" value="Delete" /></td>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($errors->has('productIds') || $errors->has('quantities') || $errors->has('prices'))
                                            <tr>
                                                <div class="error"> Mời bạn nhập đúng và đủ số lượng, đơn giá cho sản phẩm
                                                </div>
                                            </tr>
                                        @endif


                                    </tbody>
                                </table>
                                <div class="row">
                                    <span class="d-flex">
                                        <p class="font-weight-bold d-inline mr-2">Thành tiền:
                                        <p>
                                        <p id="total-price">
                                        <p>
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button id="add_row" class="btn btn-default pull-left">+ Thêm hàng</button>
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

    <table class="table product-table table-light">
        <tbody class="hiden-tr d-none">
            <tr>
                <td>
                    <select name="productIds[]" class="form-control select-pr">
                        <option value="">Sản phẩm</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }}

                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="td-qty">
                    <input type="number" class="input-quantity" required name="quantities[]" class="form-control" />
                </td>
                <td class="td-price"> <input type="text" required class="input-price" name="prices[]"
                        class="form-control" />
                </td>
                <td class="td-totalEach"></td>
                <td> <input type="button" class="del btn btn-danger" value="Delete" /></td>
                </td>
            </tr>


        </tbody>
    </table>
    <script src="{{ asset('js/create.js') }}"></script>

@endsection
