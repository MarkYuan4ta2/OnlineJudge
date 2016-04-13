@extends('layouts.app')

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/default/css/collection.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="banner">
        <div class="collection-head">
            <div class="container">
                <div class="collection-title">
                    <h1 class="collection-header">欢迎来到Online Judge</h1>
                    <div class="collection-info" style="font-size: 20px;">
                    <span class="meta-info">
                        Talk is cheap, show me the code!
                        <br>
                        废话少说，放码过来！
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
