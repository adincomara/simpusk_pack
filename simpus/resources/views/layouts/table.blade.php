@extends('layouts.master')
@section('konten')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>@yield('judultable')</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                Home
            </li>
            <li class="breadcrumb-item">
                @yield('menu1')
            </li>
            <li class="breadcrumb-item active">
                <strong>@yield('menu2')</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@yield('table')

</div>
</div>

@endsection

