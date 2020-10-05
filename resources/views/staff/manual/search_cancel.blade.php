@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
    <a  href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        予約キャンセル
    </div>      
    <section>
    <h1>予約のキャンセル</h1>
    <h2>予約番号の入力</h2>

    <form action="{{ route('staff.manual.check_cancel') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="reservation_id-field">予約番号を入力</label>
            <input class="form-control" type="text" name="reservation_id" id="reservation_id-field" value="{{old('reservation_id')}}" />
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>&nbsp;検索</button>
        </div>
    </form>
    <h2>検索結果&amp;キャンセル</h2>
    @if(!is_null($reservation))
    <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><i class="fas fa-align-justify"></i> 予約の詳細</div>
                    <div class="card-body">
                        {{-- ユーザー1件の情報 --}}
                        <dl class="row">
                            <dt class="col-md-2">予約番号</dt>
                            <dd class="col-md-10">{{ $reservation->id }}</dd>
      
                            <dt class="col-md-2">コース名</dt>
                            <dd class="col-md-10">{{ $reservation->schedule->course->name }}</dd>
                            <dt class="col-md-2">担当先生</dt>
                            <dd class="col-md-10">{{ $reservation->schedule->staff->name }}</dd>
                            <dt class="col-md-2">開催日時</dt>
                            <dd class="col-md-10">{{ date('Y年m月d日 H時i分', strtotime($reservation->schedule->start))}}</dd>
  
                            <dt class="col-md-2">場所</dt>
                            @if ($reservation->schedule->course->is_zoom)
                                <dd class="col-md-10">オンライン教室</dd>
                            @else 
                                <dd class="col-md-10">リアル教室</dd>                      
                            @endif
                            
                            <dt class="col-md-2">生徒(ID)</dt>
                            <dd class="col-md-10">{{ $reservation->user->name }}({{ $reservation->user->id }})</dd>
                        </dl>

                        <form action="{{route('staff.cancel.do_reservation',['message_id'=>0,'id'=>$reservation->id])}}" method="POST" style="display: inline;" onsubmit="return confirm('キャンセルしますか?\n【注意】キャンセルすると元に戻せません。');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>&nbsp;予約のキャンセル</button>
                        </form>
                      </div>
                </div>
            </div>
        </div>
    @else
        {{--成功時のメッセージ--}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @else
            <div class="text-center alert alert-info">該当する予約はありません。</div>
        @endif
    @endif
</section>
</div>
@endsection