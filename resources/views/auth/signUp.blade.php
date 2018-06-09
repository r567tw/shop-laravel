<!-- 檔案目錄：resources/views/auth/signUp.blade.php -->

<!-- 指定繼承 layout.master 母模板 -->
@extends('layout.master')

<!-- 傳送資料到母模板，並指定變數為 title -->
@section('title', $title)

<!-- 傳送資料到母模板，並指定變數為 content -->
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>

        {{-- 錯誤訊息模板元件 --}}
        @include('components.validationErrorMessage')

        <div class="row">
            <div class="col-md-12">
                <form action="/user/auth/sign-up" method="post">
                    <div class="form-group">
                        <label for="name">名稱</label>
                        <input type="text"
                               class="form-control"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                        >
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text"
                               class="form-control"
                               id="email"
                               name="email"
                               placeholder=""
                               value="{{ old('email')}}"
                        >
                    </div>
                    <div class="form-group">
                        <label for="password">密碼</label>
                        <input type="password"
                               class="form-control"
                               id="password"
                               name="password"
                               placeholder="密碼"
                        >
                    </div>
                    <div class="form-group">
                        <label for="password">密碼確認</label>
                        <input type="password"
                               class="form-control"
                               id="password"
                               name="password_confirmation"
                               placeholder="密碼確認"
                        >
                    </div>
                    <div class="form-group">
                        <label for="type">{{ trans('shop.user.fields.type-name') }}</label>
                        <select class="form-control"
                                name="type"
                                id="type"
                        >
                            <option value="G"
                                    @if(old('type')=='G') selected @endif
                            >
                                一般
                            </option>
                            <option value="A"
                                    @if(old('type')=='A') selected @endif
                            >
                                管理者
                            </option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-default">註冊</button>

                    {{-- CSRF 欄位--}}
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@endsection