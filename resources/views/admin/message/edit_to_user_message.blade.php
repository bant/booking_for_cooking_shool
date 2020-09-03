@extends('layouts.admin.app')

@section('content')
<div id="content">
<div id="breadcrumbs">
        <a  href="{{route('admin.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        生徒に入金確認メッセージの送付
    </div>  

    <section>
    <h1>生徒に入金確認メッセージの送付</h1>

    <h2>予約情報</h2>
    @if(!is_null($reservation))
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i>予約の詳細</div>

                <div class="card-body">
                    {{-- 予約の詳細 --}}
                    <dl class="row">
                        <dt class="col-md-4">予約番号</dt>
                        <dd class="col-md-8">{{ $reservation->id }}</dd>
                        @if (!$reservation->is_zoom)
                            <dt class="col-md-4">教室名</dt>
                            <dd class="col-md-8">{{ $reservation->schedule->staff->room->name }}</dd>
                        @else
                            <dt class="col-md-4">オンライン教室名</dt>
                            <dd class="col-md-8">{{ $reservation->schedule->staff->zoom->name }}</dd>
                        @endif
                        <dt class="col-md-4">コース名</dt>
                        <dd class="col-md-8">{{$reservation->schedule->course->name}}</dd>
                        <dt class="col-md-4">開催日時</dt>
                        <dd class="col-md-8">{{date('Y年m月d日 H時i分', strtotime($reservation->schedule->start))}}</dd>
                        <dt class="col-md-4">担当先生</dt>
                        <dd class="col-md-8">{{ $reservation->schedule->staff->name }}</dd>
                        <dt class="col-md-4">生徒</dt>
                        <dd class="col-md-8">{{$reservation->user->name}}({{$reservation->user->id}})</dd>
                        <dt class="col-md-4">住所</dt>
                        <dd class="col-md-8">{{ $reservation->user->pref }}{{ $reservation->user->address }}</dd>
                     </dl>
                </div>
            </div>
        </div>
    </div>

    <br/>
    <h2>{{$reservation->user->name}}さんにメッセージ送信</h2>
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

    <form action="{{ route('admin.message.send_to_user_message') }}" method="POST">
        @csrf
        <input type="hidden" name="reservation_id" value="{{$reservation->id}}">
        <input type="hidden" name="user_id" value="{{$reservation->user->id}}">
        <input type="hidden" name="user_name" value="{{$reservation->user->name}}">
        <div class="form-group">
            <label for="message-field">メッセージ</label>
            <textarea name="message" id="message-field" class="form-control" rows="3">予約番号:{{$reservation->id}} に関するお知らせ</textarea>
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>　メッセージ送信</button>
        </div>
    </form>

    @else
        <div class="text-center alert alert-info">該当する予約はありません。</div>
    @endif

    <br/>
    </section>
</div>
@endsection