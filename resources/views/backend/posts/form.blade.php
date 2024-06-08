@extends('backend.master')
@section('title', isset($post) ? 'Sửa bài viết' : 'Thêm bài viết')
@section('content')
    <div class="box-container">
        <header class="page-header">
            <h1 class="title-header">{{ isset($post) ? 'Sửa bài viết' : 'Thêm bài viết' }}</h1>
            <ul class="button-header">
                <li><a class="uk-button uk-button-primary" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('save')">Lưu</a></li>
                <li><a class="uk-button uk-button-success" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('update')">Cập nhật</a></li>
                <li><a class="uk-button uk-button-danger" href="{{ url('/admin/posts') }}">Trở về</a>
                </li>
            </ul>
        </header>
        <div class="box-content">
            <form class="uk-form uk-form-stacked" action="{{ url('admin/posts') }}" name="adminForm" method="POST"
                enctype="multipart/form-data">
                @csrf
                @include('backend.partials.message')
                <div class="content">
                    <div class="uk-grid">
                        <div class="uk-width-3-10">
                            <div class="uk-form-row">
                                <label for="title">Tiêu đề:</label><br>
                                <input type="text" id="title" name="title"
                                    value="{{ isset($post) ? $post->title : '' }}"><br><br>
                            </div>
                        </div>
                        <div class="uk-width-3-10">
                            <div class="uk-form-row">
                                <label for="cate_id">Nhóm bài viết:</label><br>
                                <select name="cate_id" id="cate_id">
                                    <option value="">Chọn nhóm</option>
                                    @foreach ($cates as $cate)
                                        <option value="{{ $cate->id }}"
                                            {{ isset($post) ? ($post->cate_id == $cate->id ? 'selected' : '') : '' }}>
                                            {{ $cate->name }}</option>
                                    @endforeach
                                </select><br><br>
                            </div>
                        </div>
                        <div class="uk-width-3-10">
                            <div class="uk-form-row">
                                <label for="slug">Slug:</label><br>
                                <input type="text" id="slug" name="slug"
                                    value="{{ isset($post) ? $post->slug : '' }}"><br><br>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="content">Nội dung chi tiết</label>
                                <div class="uk-form-controls">
                                    <textarea class="uk-width-1-1" id="description" name="content" rows="10">{{ isset($post) ? $post->content : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="uk-form-row">
                                <button type="button" class="uk-button" data-uk-toggle="{target:'#text-introtext'}">Mô tả
                                    ngắn</button>
                                <div class="uk-form-controls uk-hidden" id="text-introtext">
                                    <textarea rows="5" name="introtext" id="introtext" class="uk-width-1-1">{{ isset($product) ? $product->introtext : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="thumbnail">Hình đại diện</label>
                                <div class="uk-form-controls">
                                    <input type="file" id="thumbnail" name="thumbnail"><br><br>
                                    <div style="width: 200px; height:200px" class="uk-thumbnail" id="thumbnail-container">
                                        @isset($post)
                                            <img src="{{ asset($post->thumbnail) }}" alt="Not found" />
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            @include('backend.partials.meta', ['seo' => isset($post) ? $post : null])
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{ isset($post) ? $post->id : 0 }}">
                <input type="hidden" name="action">
            </form>
        </div>
    </div>
@endsection
