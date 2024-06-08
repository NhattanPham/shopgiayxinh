@extends('backend.master')
@section('title', 'Cấu hình')
@section('content')
    <div class="box-container">
        <form class="uk-form" action="{{ url('admin/config/updates') }}" method="POST">
            @csrf
            <header class="page-header">
                <h1 class="title-header">Cấu hình</h1>
                <ul class="button-header">
                    <li><button class="uk-button uk-button-primary">Lưu</button></li>
                </ul>
            </header>
            <div class="box-content">
                @include('backend.partials.message')
                <div class="uk-tab-center">
                    <ul class="uk-tab" data-uk-tab="{connect:'#my-id'}">
                        <li class="uk-active"><a href="">Thông tin chung</a></li>
                        <li><a href="">Hình ảnh</a></li>
                        <li><a href="">Google</a></li>
                        <li><a href="">Facebook</a></li>
                        <li><a href="">Zalo</a></li>
                    </ul>
                </div>
                <ul id="my-id" class="uk-switcher uk-margin">
                    <li class="uk-flex uk-flex-center">
                        <table>
                            <tr>
                                <td>
                                    <label for="nameCompany">Tên công ty</label>
                                </td>
                                <td><input type="text" name="nameCompany" id="nameCompany"
                                        value="{{ isset($nameCompany) ? $nameCompany->option_value : '' }}"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="phone">Số điện thoại</label>
                                </td>
                                <td><input type="number" name="phone" id="phone"
                                        value="{{ isset($phone) ? $phone->option_value : '' }}"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="address">Địa chỉ</label>
                                </td>
                                <td><input type="text" name="address" id="address"
                                        value="{{ isset($address) ? $address->option_value : '' }}"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="email">Email</label>
                                </td>
                                <td><input type="email" name="email" id="email"
                                        value="{{ isset($email) ? $email->option_value : '' }}"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="website">Website</label>
                                </td>
                                <td><input type="text" name="website" id="website"
                                        value="{{ isset($website) ? $website->option_value : '' }}"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="hotline">Hotline</label>
                                </td>
                                <td><input type="text" name="hotline" id="hotline"
                                        value="{{ isset($hotline) ? $hotline->option_value : '' }}"></td>
                            </tr>
                        </table>

                    </li >
                    <li class="uk-flex uk-flex-center">Hình ảnh
                    </li>
                    <li class="uk-flex uk-flex-center">Google
                    </li>
                    <li class="uk-flex uk-flex-center">Facebook
                    </li>
                    <li class="uk-flex uk-flex-center">Zalo
                    </li>
                </ul>

            </div>
        </form>
    </div>
@endsection
