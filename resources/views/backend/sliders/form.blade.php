@extends('backend.master')
@section('title', isset($slider) ? 'Sửa slider' : 'Thêm slider')
@section('content')
    <div class="box-container">
        <header class="page-header">
            <h1 class="title-header">{{ isset($slider) ? 'Sửa slider' : 'Thêm slider' }}</h1>
            <ul class="button-header">
                <li><a class="uk-button uk-button-primary" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('save')">Lưu</a></li>
                <li><a class="uk-button uk-button-success" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('update')">Cập nhật</a></li>
                <li><a class="uk-button uk-button-danger" href="{{ url('/admin/sliders') }}">Trở về</a>
                </li>
            </ul>
        </header>
        <div class="box-content">
            <form class="uk-form uk-form-stacked" action="{{ url('admin/sliders') }}" name="adminForm" method="POST"
                enctype="multipart/form-data">
                @csrf
                @include('backend.partials.message')
                <div class="content">
                    <div class="uk-grid">
                        <div class="uk-width-1-3">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="title">Tiêu đề</label>
                                <div class="uk-form-controls">
                                    <input class="uk-width-1-1" type="text" id="title" name="title"
                                        value="{{ isset($slider) ? $slider->title : '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-3">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="link">Đường dẫn</label>
                                <div class="uk-form-controls">
                                    <input class="uk-width-1-1" type="text" id="link" name="link"
                                        value="{{ isset($slider) ? $slider->link : '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-3">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="target">Target</label>
                                <div class="uk-form-controls">
                                    <input class="uk-width-1-1" type="text" id="target" name="target"
                                        value="{{ isset($slider) ? $slider->target : '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="description">Mô tả</label>
                                <div class="uk-form-controls">
                                    <textarea name="description" id="description" rows="10">{{ isset($slider) ? $slider->description : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="uk-thumbnail" id="thumbnail-container">
                                @isset($slider)
                                    <img src="{{ asset($slider->image) }}" alt="Not found"><br><br>
                                @endisset
                            </div>
                        </div>
                        <div class="uk-width-1-1">
                            <label for="thumbnail" class="uk-button uk-button-primary">Chọn hình ảnh</label>
                            <input type="file" name="image" id="thumbnail">

                        </div>

                    </div>
                </div>
                <input type="hidden" name="id" value="{{ isset($slider) ? $slider->id : 0 }}">
                <input type="hidden" name="action">
            </form>
        </div>
    </div>
@endsection
