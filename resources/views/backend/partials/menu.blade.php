    <ul class="menu-sidebar">
        @foreach (Config::get('menuadmin') as $keyItem => $valueItem)
            <li {{ request()->is('*/' . $keyItem . '*') ? ' class="active"' : '' }}>
                <a href="{{ url('admin/' . $keyItem) }}">
                    <i class="{{ $valueItem['icon'] }}"></i>
                    <span class="link-name">{{ $valueItem['name'] }}</span>
                </a>
                @isset($valueItem['sub-menu'])
                    <ul class="sub-menu">
                        @foreach ($valueItem['sub-menu'] as $key => $value)
                                <li><a href="{{ url('admin/'.$key) }}">{{ $value }}</a></li>
                        @endforeach
                    </ul>
                @endisset
            </li>
        @endforeach
    </ul>
