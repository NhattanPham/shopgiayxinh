@if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="uk-alert uk-alert-danger">{{ $error }}</div>
    @endforeach
@endif
@if (session('success'))
    <div class="uk-alert uk-alert-success">
        <a href="" class="uk-alert-close uk-close"></a>
        <p>{{ session('success') }}</p>
    </div>
@endif
@if (session('warning'))
    <div class="uk-alert uk-alert-warning">
        <a href="" class="uk-alert-close uk-close"></a>
        <p>{{ session('warning') }}</p>
    </div>
@endif
@if (session('danger'))
    <div class="uk-alert uk-alert-danger">
        <a href="" class="uk-alert-close uk-close"></a>
        <p>{{ session('danger') }}</p>
    </div>
@endif