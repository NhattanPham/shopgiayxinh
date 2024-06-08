@extends('backend.master')
@section('title', 'Quản lý slider')
@section('content')
    <div class="box-container">
        <form action="{{ url('admin/sliders/updateIndex')}}" class="uk-form" name="adminList" method="POST">
            @csrf
        <header class="page-header">
            <h1 class="title-header">Danh sách slider</h1>
            <ul class="button-header">
                <li><button class="uk-button uk-button-primary">Cập nhật
                    </button></li>
                <li><a class="uk-button uk-button-success" href="{{ url('/admin/sliders/create') }}">Thêm
                        mới</a></li>
            </ul>
        </header>
        <div class="box-content">
            
                @include('backend.partials.message')
                <div class="content">
                    @foreach ($sliders as $slider)
                        <div class="item-slider" id="item-slider" data-id="{{ $slider->id }}">
                            <div class="item-slider-image">
                                <img src="{{ asset($slider->image) }}" alt="Not found">
                            </div>
                            <div class="item-slider-content">
                                <table style="width: 100%">
                                    <tr>
                                        <td><label for="title">Tiêu đề:</label></td>
                                        <td style="width: 90%"><input type="text" id="title"
                                               name="{{ 'title_'.$slider->id }}" value="{{ $slider->title }}"></td>
                                    </tr>
                                    {{-- <tr>
                                        <td><label for="description">Mô tả:</label></td>
                                        <td style="width: 90%"><input type="text" id="description_slider"
                                            name="{{ 'title_'.$slider->id }}" value="{{ $slider->description }}"></td>
                                    </tr> --}}
                                    <tr>
                                        <td><label for="url">Link:</label></td>
                                        <td style="width: 90%"><input type="text" id="url"
                                            name="{{ 'url_'.$slider->id }}" value="{{ $slider->link }}"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="ordering">Thứ tự:</label></td>
                                        <td style="width: 90%"><input type="text" id="ordering"
                                            name="{{ 'order_'.$slider->id }}" value="{{ $slider->ordering }}"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="item-slider-option">
                                <a href="{{ url('admin/sliders/edit/' . $slider->id) }}">Chỉnh sửa</a>
                                <a style="margin-left: 20px" href="{{ url('admin/sliders/delete/' . $slider->id) }}">Xóa</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            
        </div>
    </form>
    </div>
@endsection
