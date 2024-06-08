@extends('backend.master')
@section('title', isset($product) ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm')
@section('content')
    <div class="box-container">
        <header class="page-header">
            <h1 class="title-header">{{ isset($product) ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm' }}</h1>
            <ul class="button-header">
                <li><a class="uk-button uk-button-primary" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('save')">Lưu</a></li>
                <li><a class="uk-button uk-button-success" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('update')">Cập nhật</a></li>
                <li><a class="uk-button uk-button-danger" href="{{ url('/admin/products') }}">Trở về</a>
                </li>
            </ul>
        </header>
        <div class="box-content">
            @include('backend.partials.message')
            <form class="uk-form uk-form-stacked" action="{{ url('admin/products') }}" method="POST" name="adminForm"
                enctype="multipart/form-data">
                @csrf
                <div class="content">
                    <div class="uk-grid">
                        <div class="uk-width-7-10">
                            <div class="uk-grid">
                                <div class="uk-width-1-2">
                                    <div class="uk-form-row">
                                        <label class="uk-form-label" for="name">Tên sản phẩm</label>
                                        <div class="uk-form-controls">
                                            <input type="text" placeholder="" name="name" id="name"
                                                class="uk-width-1-1" value="{{ isset($product) ? $product->name : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-width-1-2">
                                    <div class="uk-form-row">
                                        <label class="uk-form-label" for="slug">Slug</label>
                                        <div class="uk-form-controls">
                                            <input type="text" placeholder="" name="slug" id="slug"
                                                class="uk-width-1-1" value="{{ isset($product) ? $product->slug : '' }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <div class="uk-form-row">
                                        <label class="uk-form-label" for="description">Chi tiết sản phẩm</label>
                                        <div>
                                            <textarea id="description" name="description">{{ isset($product) ? $product->description : '' }}</textarea><br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <div class="uk-form-row">
                                        <button type="button" class="uk-button" data-uk-toggle="{target:'#text-introtext'}">Mô tả ngắn</button>
                                        <div class="uk-form-controls uk-hidden" id="text-introtext">
                                            <textarea rows="5" name="introtext" id="introtext" class="uk-width-1-1">{{ isset($product) ? $product->introtext : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-top">
                                <h3 class="uk-panel-title">Thuộc tính sản phẩm</h3>
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-4">
                                        <ul class="uk-tab uk-tab-left" data-uk-tab="{connect:'#my-id'}">
                                            <li><a href="#">Màu</a></li>
                                            <li><a href="#">Size</a></li>
                                            <li><a href="#">Tab 3</a></li>
                                            <li><a href="#">Tab 4</a></li>
                                        </ul>
                                    </div>
                                    <div class="uk-width-medium-3-4">
                                        <ul id="my-id" class="uk-switcher">
                                            <li style="padding:1em">
                                                <h4>Danh sách màu</h4>
                                                <div class="tags">
                                                    <ul class="colors-list-tag list-tag">
                                                        @isset($product)
                                                            @foreach (json_decode($product->product_colors) as $color)
                                                                <li data-value="{{ $color }}">{{ $color }} <button
                                                                        class="del-tag">X</button></li>
                                                            @endforeach
                                                        @endisset
                                                    </ul>
                                                    <input class="colors-input-tag input-tag" type="text"
                                                        placeholder="Nhập nội dung">
                                                    <input type="hidden" name="colors" value="{{ isset($product) ? implode(',', json_decode($product->product_colors)) : '' }}">
                                                </div>
                                            </li>
                                            <li style="padding:1em">
                                                <h4>Danh sách size</h4>
                                                <div class="tags">
                                                    <ul class="sizes-list-tag list-tag">
                                                        @isset($product)
                                                        @foreach (json_decode($product->product_sizes) as $size)
                                                            <li data-value="{{ $size }}">{{ $size }} <button
                                                                    class="del-tag">X</button></li>
                                                        @endforeach
                                                    @endisset
                                                    </ul>
                                                    <input class="sizes-input-tag input-tag" type="number"
                                                        placeholder="Nhập nội dung">
                                                    <input type="hidden" name="sizes" value="{{ isset($product) ? implode(',', json_decode($product->product_sizes)) : '' }}">
                                                </div>
                                            </li>
                                            <li>Hello 3 !</li>
                                            <li>Hello 4 !</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <div class="uk-form-row">
                                        <label class="uk-form-label" for="">Hình sản phẩm</label>
                                        <div class="uk-form-controls">
                                            <div class="uk-panel uk-panel-box uk-panel-box-secondary">
                                                <div class="uk-grid uk-grid-small uk-sortable " id="imageContainer"
                                                    data-uk-sortable>
                                                    @isset($product)
                                                        @foreach (json_decode($product->product_images) as $image)
                                                            <div class="uk-width-1-5 imageItem"
                                                                data-name="{{ $image }}" data-isadd="false">
                                                                <div class="thumbnail-container">
                                                                    <img class="uk-thumbnail"
                                                                        src="{{ asset('uploads/products/images/' . $image) }}""
                                                                        alt="Not found">
                                                                    <i class="uk-icon-close removeImage"></i>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endisset

                                                </div>
                                            </div>
                                        </div>
                                        <label for="addImage" class="uk-button uk-button-primary">Chọn các hình
                                            ảnh</label>
                                        <input type="file" name="" id="addImage" multiple />
                                    </div>
                                </div>
                            </div>
                            @include('backend.partials.meta', ['seo' => (isset($product) ? $product : null)])
                        </div>
                        <div class="uk-width-3-10">
                            <div class="uk-panel uk-panel-box uk-panel-box-secondary">
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="cate_id">Nhóm sản phẩm</label>
                                    <div class="uk-form-controls">
                                        {{ select_categories($categories, isset($product) ? $product->cate_id : 0) }}
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="sku">SKU</label>
                                    <div class="uk-form-controls">
                                        <input type="text" placeholder="" name="sku" id="sku"
                                            class="uk-width-1-1" value="{{ isset($product) ? $product->sku : '' }}">
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="product_price">Giá bán</label>
                                    <div class="uk-form-controls">
                                        <input type="text" placeholder="" name="product_price" id="product_price"
                                            class="uk-width-1-1"
                                            value="{{ isset($product) ? $product->product_price : '' }}">
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="sale_price">Giá giảm</label>
                                    <div class="uk-form-controls">
                                        <input type="text" placeholder="" name="sale_price" id="sale_price"
                                            class="uk-width-1-1"
                                            value="{{ isset($product) ? $product->sale_price : '' }}">
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="">Hình đại diện</label>
                                    <fieldset>
                                        <div class="uk-form-row">
                                            <div class="uk-thumbnail" id="thumbnail-container">
                                                @isset($product)
                                                    <img src="{{ asset($product->thumbnail) }}" alt="Not found" />
                                                @endisset
                                            </div>
                                        </div>
                                        <div class="uk-form-row">
                                            <div class="uk-form-controls">
                                                <div class="uk-flex uk-flex-space-between">
                                                    <label for="thumbnail" class="uk-button uk-button-primary">Chọn hình
                                                        đại
                                                        diện</label>
                                                    <input style="display:none" type="file" name="thumbnail"
                                                        onchange="displayThumbnail(event)" id="thumbnail"
                                                        {{ !isset($product) ? '' : '' }}>
                                                    <button class="uk-button">Xóa hình</button>
                                                </div>
                                                <div class="uk-form-file">

                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="">Trang chủ</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-width-1-1">
                                            <option>Không</option>
                                            <option>Có</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="special">Đặt biệt</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-width-1-1" name="special" id="special">
                                            <option value="0">Chọn --</option>
                                            <option value="1">Sản phẩm mới</option>
                                            <option value="2">Sản phẩm hot</option>
                                            <option value="3">Sản phẩm khuyến mãi</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="stated">Trạng thái</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-width-1-1" name="stated" id="stated">
                                            <option value="0">Xuất bản</option>
                                            <option value="1">Không xuất bản</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{ isset($product) ? $product->id : 0}}">
                <input type="hidden" name="action">
                <input type="hidden" name="listimage" value>
                <input style="display: none" type="file" name="images[]" id="images" multiple>
            </form>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('backend/assets/product.js') }}"></script>
    @endpush
@endsection
