@extends('layouts.user.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('user.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        <a  href="{{ route('user.zoom_reservation.calendar',$schedule->staff->zoom->id) }}">{{ $schedule->staff->zoom->name }}の予約</a>  >
        レッスンの予約
    </div>
<section>
    <h1> {{ $schedule->staff->zoom->name }}のレッスンの確認と予約</h1>
    <h2>選択したコースの確認と予約</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i>オンライン教室の詳細</div>

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

                    {{-- の情報 --}}
                    <dl class="row">
                        <dt class="col-md-2">オンライン教室名</dt>
                        <dd class="col-md-10">{{ $schedule->staff->zoom->name }}</dd>
                        <dt class="col-md-2">担当先生</dt>
                        <dd class="col-md-10">{{ $schedule->staff->name }}</dd>
                        <dt class="col-md-2">コース名</dt>
                        <dd class="col-md-10">{{ $schedule->course->name }}</dd>
                        <dt class="col-md-2">価格</dt>
                        <dd class="col-md-10">{{  number_format($schedule->course->price) }}円</dd>
                        <dt class="col-md-2">消費税</dt>
                        <dd class="col-md-10">{{  number_format($schedule->course->price*0.1) }}円</dd>
                        <dt class="col-md-2">残り席数</dt>
                        <dd class="col-md-10">{{ $schedule->capacity}}</dd>
                        <dt class="col-md-2">開始日時</dt>
                        <dd class="col-md-10">{{ date('Y年m月d日 H時i分',  strtotime($schedule->start)) }}</dd>
                        <dt class="col-md-2">終了日時</dt>
                        <dd class="col-md-10">{{ date('Y年m月d日 H時i分',  strtotime($schedule->end)) }}</dd>
                   </dl>

                   <form action="{{route('user.zoom_reservation.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="schedule_id" value="{{$schedule->id}}">
                        <input type="hidden" name="price" value="{{$schedule->course->price}}">
                        <div class="well well-sm">
                        <button type="submit" class="btn btn-primary" name="no_point" value="1"><i class="fas fa-save"></i>&ensp;仮予約</button>
                        @if (Auth::user()->point > $schedule->course->price)
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&ensp;予約</button>
                        @endif
                            <a class="btn btn-link pull-right" href="{{route('user.zoom_reservation.calendar', ['id' => $schedule->staff_id])}}"><i class="fas fa-backward"></i>{{ $schedule->staff->zoom->name }}のカレンダーに戻る</a>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    </section>
</div>
@endsection
