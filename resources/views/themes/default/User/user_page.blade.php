@extends('layouts.app')

@section('title')
    个人主页
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="col-lg-3">
            <img src="@if($UserInfo->avatar){{asset($UserInfo->avatar)}}@else{{asset('uploads/avatars/avatar_default.png')}}@endif"
                 id="avatar" class="img-responsive avatar" onclick="fileSelect();">
            <form id="avatar_upload" name="avatar_upload" method="post" enctype="multipart/form-data"
                  action="{{ URL::action('User\UserController@saveAvatar')}}">
                <input type="file" name="fileToUpload" id="fileToUpload"
                       onchange="fileSelected();" style="display:none;">
            </form>
        </div>
        <div class="col-lg-6">
            <form>
                <div class="row">
                    <div class="form-group col-md-6"><label>用户名</label>
                        <input name="username" type="text" class="form-control"
                               value="{{ $UserInfo->name }}" readonly>
                    </div>
                    <div class="form-group col-md-6"><label>电子邮箱</label>
                        <input name="email" type="email" class="form-control"
                               value="{{ $UserInfo->email }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6"><label>学号</label>
                        <input name="student_id" type="number" class="form-control" id="student_id"
                               value="@if($UserInfo->student_id){{ $UserInfo->student_id }}@endif">
                        <div class="help-block with-errors"></div>

                    </div>
                    <div class="form-group col-md-6"><label>手机</label>
                        <input name="phone_number" type="text" maxlength="11" id="phone"
                               class="form-control"
                               value="@if($UserInfo->phone_numbers){{ $UserInfo->phone_numbers }}@endif">
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12"><label>blog</label>
                        <input name="blog" type="url" class="form-control" id="blog"
                               value="@if($UserInfo->blog){{ $UserInfo->blog }}@endif">

                        <div class="help-block with-errors"></div>

                    </div>
                    <div class="form-group col-md-12">
                        <label>签名</label>
                        <textarea name="self_description" class="form-control"
                                  id="self_description">@if($UserInfo->self_description){{ $UserInfo->self_description }}@endif</textarea>
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group" style="display: none">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        function fileSelect() {
            $('#fileToUpload').click();

        }

        function fileSelected() {
            var options = {
                type: 'POST',
                success: function (data) {
//                    alert(data);
                    location.reload();
                }
            }
            $('#avatar_upload').ajaxSubmit(options);
        }
    </script>
@endsection
