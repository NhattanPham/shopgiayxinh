@extends('backend.master')
@section('title', isset($menu) ? 'Sửa menu' : 'Thêm menu')
@section('content')
    <div class="box-container">
        <header class="page-header">
            <h1 class="title-header">{{ isset($menu) ? 'Sửa menu' : 'Thêm menu' }}</h1>
            <ul class="button-header">
                <li><a class="uk-button uk-button-primary" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('save')">Lưu</a></li>
                <li><a class="uk-button uk-button-success" href="javascript:void(0)"
                        onclick="javascript:jQuery(this).submitForm('update')">Cập nhật</a></li>
                <li><a class="uk-button uk-button-danger" href="{{ url('/admin/menu') }}">Trở về</a>
                </li>
            </ul>
        </header>
        <div class="box-content">
            <form class="uk-form uk-form-stacked" action="{{ url('admin/menu') }}" name="adminForm" method="POST">
                @include('backend.partials.message')
                <div class="content">
                    <div class="uk-grid">
                        <div class="uk-width-1-2">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="nameM">Tên Menu</label>
                                <div class="uk-form-controls">
                                    <input class="uk-width-1-1" type="text" id="name" name="nameM"
                                        value="{{ isset($menu) ? $menu->name : '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-2">
                            <div class="uk-form-row">
                                <label class="uk-form-label" for="name">Slug</label>
                                <div class="uk-form-controls">
                                    <input class="uk-width-1-1" type="text" id="name" name="name"
                                        value="{{ isset($menu) ? $menu->slug : '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-4">
                            <div class="uk-accordion" data-uk-accordion>
                                <div class="options">
                                <h3 class="uk-accordion-title">Liên kết tùy chọn</h3>
                                <div class="uk-accordion-content">
                                    <div class="uk-form-row">
                                        <label class="uk-form-label" for="menu-name">Tiêu đề</label>
                                        <div class="uk-form-controls">
                                            <input class="uk-width-1-1" type="text" id="menu-name" name="menu_name">
                                        </div>
                                    </div>
                                    <div class="uk-form-row">
                                        <label class="uk-form-label" for="menu-url">URL</label>
                                        <div class="uk-form-controls">
                                            <input class="uk-width-1-1" type="text" id="menu-url" name="menu_url">
                                        </div>
                                    </div>
                                    <div class="uk-form-row">
                                        <button class="uk-button uk-button-primary uk-float-right" type="button"
                                            onclick="javascript:jQuery(this).addMenuItem('options')">
                                            Thêm vào menu
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="cate_products">
                                <h3 class="uk-accordion-title">Nhóm sản phẩm</h3>
                                <div class="uk-accordion-content">
                                    <div class="uk-scrollable-box">
                                        {{ menu_categories('product') }}
                                    </div>
                                    <div class="uk-flex uk-flex-middle uk-flex-space-between uk-margin-top">
                                        <div class="uk-form-controls">
                                            <label>
                                                <input type="checkbox" class="select-menu-all"
                                                    data-menu_type="cate_products"> Chọn tất cả
                                            </label>
                                        </div>
                                        <button class="uk-button uk-button-primary" type="button"
                                            onclick="javascript:jQuery(this).addMenuItem('cate_products')">
                                            Thêm vào menu
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="cate_posts">
                                <h3 class="uk-accordion-title">Nhóm bài viết</h3>
                                <div class="uk-accordion-content">
                                    <div class="uk-scrollable-box">
                                        {{ menu_categories('post') }}
                                    </div>
                                    <div class="uk-flex uk-flex-middle uk-flex-space-between uk-margin-top">
                                        <div class="uk-form-controls">
                                            <label>
                                                <input type="checkbox" class="select-menu-all" data-menu_type="cate_posts">
                                                Chọn tất cả
                                            </label>
                                        </div>
                                        <button class="uk-button uk-button-primary" type="button"
                                            onclick="javascript:jQuery(this).addMenuItem('cate_posts')">
                                            Thêm vào menu
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="uk-width-3-4">
                            <div id="list-menu" class="uk-panel uk-panel-box uk-panel-box-secondary">
                                <ul class="uk-nestable uk-accordion" id="nestableList"
                                    data-uk-nestable="{handleClass:'uk-nestable-handle'}"
                                    data-uk-accordion="{toggle:'.uk-accordion-toggle' ,showfirst:false}">
                                    {{ isset($menuItems) ? menu_items($menuItems) : '' }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @csrf
                <input type="hidden" name="id" value="{{ isset($menu) ? $menu->id : 0 }}">
                <input type="hidden" name="action">
                <input type="hidden" name="list_data" id="">
            </form>
        </div>
    </div>
@endsection
