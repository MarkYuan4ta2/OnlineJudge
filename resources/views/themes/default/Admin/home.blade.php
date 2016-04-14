@extends('layouts.appAdmin')

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    @include('themes.default.Admin.adminLeftBar')
    <div class="container main">
        <div class="row">
            <div class="col-md-9 col-lg-9">

            </div>
        </div>
    </div>
@endsection
