@extends('layouts.admin.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('admin.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        生徒のポイント管理(生徒の検索)
    </div>  

    <section>
    <h1>振込通知</h1>
    <h2>予約番号による検索</h2>
    <form action="{{ route('admin.message.user_search') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="reservation_id-field">予約番号</label>
            <input class="form-control" type="text" name="reservation_id" id="reservation_id-field" value="{{old('reservation_id')}}" />
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>検索</button>
        </div>
    </form>
    <br/>

    <h2>検索結果</h2>
    @if(!is_null($reservation))
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i>予約の詳細</div>

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

                    {{-- 予約の詳細 --}}
                    <dl class="row">
                        <dt class="col-md-4">予約番号</dt>
                        <dd class="col-md-8">{{ $reservation->id }}</dd>
                        @if (!$reservation->is_zoom)
                            <dt class="col-md-4">教室名</dt>
                            <dd class="col-md-8">{{ $reservation->room_name }}</dd>
                        @else
                            <dt class="col-md-4">教室名</dt>
                            <dd class="col-md-8">オンライン教室</dd>
                        @endif
                        <dt class="col-md-4">コース名</dt>
                        <dd class="col-md-8">{{ $reservation->course_name }}</dd>
                        <dt class="col-md-4">開催日時</dt>
                        <dd class="col-md-8">{{ $reservation->start }}</dd>
                        <dt class="col-md-4">担当先生</dt>
                        <dd class="col-md-8">{{ $reservation->staff_name }}(ID:{{ $reservation->staff_id }})</dd>
                        <dt class="col-md-4">生徒</dt>
                        <dd class="col-md-8">{{ $reservation->user_name }}(ID:{{ $reservation->user_id }})</dd>
                        <dt class="col-md-4">住所</dt>
                        <dd class="col-md-8">{{ $reservation->user_pref }}{{ $reservation->user_address }}</dd>

                     </dl>
                </div>
            </div>
        </div>
    </div>

    <br/>
    <h2>生徒さんに通知</h2>
    <form action="{{ route('admin.message.send_to_user_message') }}" method="POST">
        @csrf
        <input type="hidden" name="reservation_id" value="{{$reservation->id}}">
        <input type="hidden" name="user_id" value="{{$reservation->user_id}}">
        <input type="hidden" name="user_name" value="{{$reservation->user_name}}">
        <div class="form-group">
            <label for="message-field">メッセージ</label>
            <textarea name="message" id="message-field" class="form-control" rows="3">予約番号:{{$reservation->id}} 生徒:{{ $reservation->user_name }}(ID:{{ $reservation->user_id }}) に関するお知らせ</textarea>
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>検索</button>
        </div>
    </form>

    @else
        <div class="text-center alert alert-info">該当する予約はありません。</div>
    @endif

    <br/>
    </section>
</div>
@endsection