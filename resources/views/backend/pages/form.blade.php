@extends('backend.master')
@section('title', isset($page) ? 'Sửa trang' : 'Thêm trang')
@section('content') 
<div class="box-container">
    <header class="page-header">
        <h1 class="title-header">{{ isset($page) ? 'Sửa trang' : 'Thêm trang' }}</h1>
        <ul class="button-header">
            <li><a class="uk-button uk-button-primary" href="javascript:void(0)"
                    onclick="javascript:jQuery(this).submitForm('save')">Lưu</a></li>
            <li><a class="uk-button uk-button-success" href="javascript:void(0)"
                    onclick="javascript:jQuery(this).submitForm('update')">Cập nhật</a></li>
            <li><a class="uk-button uk-button-danger" href="{{ url('/admin/pages') }}">Trở về</a>
            </li>
        </ul>
    </header>
    <div class="box-content">
        <form class="uk-form uk-form-stacked" action="{{ url('admin/pages') }}" name="adminForm"
                method="POST" enctype="multipart/form-data">
                @csrf
                @include('backend.partials.message')
                <div class="content">
                    <div class="uk-grid">
                        <div class="uk-width-1-3">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="title">Tiêu đề</label>
                                <div class="uk-form-controls">
                                    <input class="uk-width-1-1" type="text" id="title" name="title"
                                        value="{{ isset($page) ? $page->title : '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-3">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="title">Slug</label>
                                <div class="uk-form-controls">
                                    <input class="uk-width-1-1" type="text" id="" name=""
                                        value="{{ isset($page) ? $page->slug : '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="content">Nội dung chi tiết</label>
                                <div class="uk-form-controls">
                                    <textarea class="uk-width-1-1" id="description" name="content" rows="10">{{ isset($page) ? $page->content : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{ isset($page) ? $page->id : 0 }}">
                <input type="hidden" name="action">
        </form>
    </div>
</div>
@endsection