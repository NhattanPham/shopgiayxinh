@extends('backend.master')
@section('title', isset($category) ? 'Sửa danh mục' : 'Thêm danh mục')
@section('content')
    <div class="box-container">
        <header class="page-header">
            <h1 class="title-header">{{ isset($user) ? 'Sửa danh mục' : 'Thêm danh mục' }}</h1>
            <ul class="button-header">
                <li><a class="uk-button uk-button-primary" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('save')">Lưu</a></li>
                <li><a class="uk-button uk-button-success" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('update')">Cập nhật</a></li>
                <li><a class="uk-button uk-button-danger" href="{{ url('/admin/categories/' . $extension) }}">Trở về</a>
                </li>
            </ul>
        </header>
        <div class="box-content">
            <form class="uk-form uk-form-stacked" action="{{ url('admin/categories/' . $extension) }}" name="adminForm"
                method="POST" enctype="multipart/form-data">
                @include('backend.partials.message')
                <div class="content">
                    <div class="uk-grid">
                        <div class="uk-width-3-4">
                            <div class="uk-grid">
                                <div class="uk-width-1-2">
                                    <div class="uk-form-row">
                                        <label class="uk-form-label" for="name">Tên danh mục</label>
                                        <div class="uk-form-controls">
                                            <input class="uk-width-1-1" type="text" id="name" name="name"
                                                value="{{ isset($category) ? $category->name : '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-width-1-2">
                                    <div class="uk-form-row">
                                        <label class="uk-form-label" for="slug">Slug</label>
                                        <div class="uk-form-controls">
                                            <input class="uk-width-1-1" type="text" id="slug" name="slug"
                                                value="{{ isset($category) ? $category->slug : '' }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-form-row uk-margin-top">
                                <label class="uk-form-label" for="introtext">Mô tả ngắn</label>
                                <div class="uk-form-controls">
                                    <textarea class="uk-width-1-1" id="introtext" name="introtext" rows="5">{{ isset($category) ? $category->introtext : '' }}</textarea>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="description">Nội dung chi tiết</label>
                                <div class="uk-form-controls">
                                    <textarea class="uk-width-1-1" id="description" name="description" rows="10">{{ isset($category) ? $category->description : '' }}</textarea>
                                </div>
                            </div>
                            @include('backend.partials.meta', ['seo' => (isset($category) ? $category : null)])
                        </div>
                        <div class="uk-width-1-4">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="parent_id">Nhóm cha</label>
                                <div class="uk-form-controls">
                                    {{ select_categories($categories, isset($category)? $category->parent_id :0) }}
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-thumbnail" id="thumbnail-container">
                                    @isset($category)
                                        <img src="{{ asset($category->thumbnail) }}" alt="Not found" />
                                    @endisset
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label>Chọn hình đại diện</label>
                                <input type="file" name="thumbnail" id="thumbnail">
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="parent_id">Trạng thái</label>
                                <div class="uk-form-controls">
                                    <select class="uk-width-1-1" name="stated" id="stated">
                                        <option value="1">Xuất bản</option>
                                        <option value="0" {{ isset($category) ? ($category->state == 0 ? 'selected' :'' ):' '}}>Không xuất bản</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @csrf
                <input type="hidden" name="id" value="{{ isset($category) ? $category->id : 0 }}">
                <input type="hidden" name="action">
            </form>
        </div>
    </div>
@endsection
