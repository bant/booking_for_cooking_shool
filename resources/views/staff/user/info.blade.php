@extends('layouts.staff.app')

@section('content')
<div id="content">
    <section>
        <h3>生徒の詳細</h3>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><i class="fas fa-align-justify"></i>{{$user->name}}さんの詳細</div>

                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        {{--成功時のメッセージ--}}
                        @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        {{-- エラーメッセージ --}}
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        {{-- 生徒の情報 --}}
                        <dl class="row">
                            <dt class="col-md-4">お名前</dt>
                            <dd class="col-md-8">{{ $user->name }}</dd>
                            <dt class="col-md-4">読みがな</dt>
                            <dd class="col-md-8">{{ $user->kana }}</dd>
                            <dt class="col-md-4">生徒ID</dt>
                            <dd class="col-md-8">{{ $user->id }}</dd>
                            <dt class="col-md-4">メールアドレス</dt>
                            <dd class="col-md-8">{{ $user->email }}</dd>
                            <dt class="col-md-4">郵便番号</dt>
                            <dd class="col-md-8">{{ $user->zip_code }}</dd>
                            <dt class="col-md-4">住所</dt>
                            <dd class="col-md-8">{{ $user->pref }}{{ $user->address }}</dd>
                            <dt class="col-md-4">電話番号</dt>
                            <dd class="col-md-8">{{ $user->tel }}</dd>
                            <dt class="col-md-4">誕生日</dt>
                            <dd class="col-md-8">{{ $user->birthday }}</dd>
                            <dt class="col-md-4">性別</dt>
                            @if ($user->gender=='male')
                            <dd class="col-md-8">男性</dd>
                            @else
                            <dd class="col-md-8">女性</dd>
                            @endif
                            <dt class="col-md-4">教室参加回数</dt>
                            <dd class="col-md-8">{{ $class_reservation_times }}回</dd>
                            <dt class="col-md-4">オンライン教室参加回数</dt>
                            <dd class="col-md-8">{{ $zoom_reservation_times }}回</dd>
                        </dl>
                    </div>
                    <a class="btn btn-link pull-right" href="javascript:history.back();"><i class="fas fa-backward"></i> 戻る</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection