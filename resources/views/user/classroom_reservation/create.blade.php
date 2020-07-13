@extends('layouts.staff.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-2">
        <!-- left menu -->
        @include('layouts.staff.menu')

        <div class="col-md-8">
            <div class="card">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i>レッスンの詳細</div>

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
                        <dt class="col-md-2">教室名</dt>
                        <dd class="col-md-10">{{ $schedule->staff->room->name }}</dd>
                        <dt class="col-md-2">住所</dt>
                        <dd class="col-md-10">{{ $schedule->staff->room->address }}</dd>
                        <dt class="col-md-2">担当先生</dt>
                        <dd class="col-md-10">{{ $schedule->staff->name }}</dd>
                        <dt class="col-md-2">コース名</dt>
                        <dd class="col-md-10">{{ $schedule->course->name }}</dd>
                        <dt class="col-md-2">価格</dt>
                        <dd class="col-md-10">{{  number_format($schedule->course->price) }}円</dd>
                        <dt class="col-md-2">開始日時</dt>
                        <dd class="col-md-10">{{ date('Y年m月d日 H時i分',  strtotime($schedule->start)) }}</dd>
                        <dt class="col-md-2">終了日時</dt>
                        <dd class="col-md-10">{{ date('Y年m月d日 H時i分',  strtotime($schedule->end)) }}</dd>
                   </dl>

                   <form action="/user/classroom_reservation/store" method="POST">
                        @csrf
                        <input type="hidden" name="schedule_id" value="{{$schedule->id}}">
                        <input type="hidden" name="price" value="{{$schedule->course->price}}">
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> 予約</button>
                            <a class="btn btn-link pull-right" href="/user/classroom_reservation/{{$schedule->staff_id}}/calendar"><i class="fas fa-backward"></i>{{ $schedule->staff->room->name }}のカレンダーに戻る</a>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
