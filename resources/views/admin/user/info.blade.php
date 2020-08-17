@extends('layouts.admin.app')

@section('content')
<div id="content">
    <section>
    <h3>生徒の詳細</h3>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> 生徒の詳細</div>
                <div class="card-body">
                    {{-- ユーザー1件の情報 --}}
                    <dl class="row">
                        <dt class="col-md-2">{{ __('ID') }}</dt>
                            <dd class="col-md-10">{{ $user->id }}</dd>
                        <dt class="col-md-2">{{ __('Name') }}</dt>
                            <dd class="col-md-10">{{ $user->name }}</dd>
                        <dt class="col-md-2">{{ __('E-Mail Address') }}</dt>
                            <dd class="col-md-10">{{ $user->email }}</dd>
                        <dt class="col-md-2">郵便番号</dt>
                            <dd class="col-md-10">{{ $user->zip_code }}</dd>
                        <dt class="col-md-2">住所</dt>
                            <dd class="col-md-10">{{ $user->pref }}{{ $user->address }}</dd>
                        <dt class="col-md-2">電話</dt>
                            <dd class="col-md-10">{{ $user->tel }}</dd>
                        <dt class="col-md-2">誕生日</dt>
                            <dd class="col-md-10">{{ $user->birthday }}</dd>
                        <dt class="col-md-2">性別</dt>
                            <dd class="col-md-10">{{ $user->gender }}</dd>
                        <dt class="col-md-2">ポイント</dt>
                            <dd class="col-md-10">{{number_format($user->point)}}pt</dd>
                    </dl>
                    <a class="float-center btn btn-sm btn-primary" href="#" onclick="javascript:window.history.back(-1);return false;">戻る</a>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection