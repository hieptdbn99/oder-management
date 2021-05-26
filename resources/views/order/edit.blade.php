@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <h3 class="col-sm-12 mb-5">Sửa thông tin đơn hàng</h3>
            <div class="form-edit col-sm-12">
                <form action="{{ route('order.update', $order->id) }}" id="form_edit_modal"
                    data-url="{{ route('order.update', $order->id) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">

                        <label for="" class="d-block mb-3">
                            <h4>Sản phẩm</h4>
                        </label>

                    </div>
                    <div class="form-group">
                        <div class="">
                            <table id="example" class="display table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá thành</th>
                                        <th>số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody class="editProduct">
                                    @if (old('productIds'))
                                        @foreach (old('productIds', ['']) as $index => $oldProduct)

                                            <tr>
                                                <td>
                                                    <select name="productIds[]" class="form-control select-pr">
                                                        <option value="">Sản phẩm</option>
                                                        @foreach ($allProduct as $product)
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
                                    @else
                                        @foreach ($orderProduct as $item)
                                            <tr class="order-edit">

                                                <td>
                                                    <select name="productIds[]" class="form-control select-pr">
                                                        @foreach ($allProduct as $product)
                                                            <option value="{{ $product->id }}" @if ($product->id == $item->product_id) selected @endif>
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="td-qty">
                                                    <input type="number" class="input-quantity" required name="quantities[]"
                                                        class="form-control" value="{{ $item->total_product }}" />
                                                </td>
                                                <td class="td-price"> <input type="text" required class="input-price"
                                                        name="prices[]" class="form-control"
                                                        value="{{ $item->price }}" />
                                                </td>
                                                <td class="td-totalEach">{{ $item->total_price }}</td>

                                                <td> <input type="button" class="del btn btn-danger" value="Delete" /></td>

                                                </td>




                                            </tr>
                                        @endforeach
                                    @endif


                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12">
                                    <button id="add_row" class="btn btn-secondary pull-left">+ Add Row</button>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <span class="d-flex">
                                    <p class="font-weight-bold d-inline mr-2">Thành tiền:
                                    </p>
                                    <p id="total-price">
                                        {{ $order->totalprice }}
                                    </p>
                                </span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">
                            <h4>Họ và tên khách hàng</h4>
                        </label>
                        <input type="text" name="name" class="form-control" id="input-name-edit"
                            value="{{ $order->namecustomer }}">
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="idHidden" id="id_order" value="{{ $order->id }}">
                    </div>
                    <div class="form-group">
                        <label for="">Ảnh đại diện</label>
                        <input type="file" name="avatar" class="form-control" id="input-arvatar-edit"
                            value="{{ $order->avatar }}">
                        <img id="img-avatar-edit" class="w-25" src="{{ asset("uploads/$order->avatar") }}" alt="">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" id="input-email-edit"
                            value="{{ $order->email }}">
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" id="input-phone-edit"
                            value="{{ $order->phone }}">
                        @error('phone')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" id="input-address-edit"
                            value="{{ $order->address }}">
                    </div>
                    @error('address')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="">Ngày đặt hàng</label>
                        <input type="date" name="date" value="{{ $order->date }}" class="form-control"
                            id="input-date">
                        @error('date')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Ghi chú</label>
                        <textarea name="note" id="text_edit_note">{{ $order->note }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal --}}
    <table class="table product-table table-light">
        <tbody class="hidden-tr d-none">
            <tr>
                <td>
                    <select name="productIds[]" class="form-control select-pr">
                        @foreach ($allProduct as $product)
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
            </tr>


        </tbody>
    </table>
    <script src="{{ asset('js/edit.js') }}"></script>
    <script>
        // "global" vars, built using blade
        var flagsUrl = '{{ URL::asset('order/updateproduct') }}';

    </script>
@endsection
