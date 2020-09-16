@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        <a  href="{{route('staff.schedule.index')}}"> スケジュール管理</a>  >
        オンライン教室スケジュール/追加
    </div>  
<section>
    <h1> スケジュール管理</h1>
    <h2>オンライン教室スケジュール/追加</h2>
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

                    <form action="{{ route('staff.zoom_schedule.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title-field">コース</label>
                            <select type="text" class="form-control" name="course_id">                          
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="capacity-field">定員</label>
                            <input class="form-control" type="number" name="capacity" id="capacity-field"  min="1" max="10" value="{{old('capacity')}}" />
                        </div>

                        <div class="form-group">
                            <label for="start-field">開始日時</label>
                            <input type="datetime-local" name="start"  id="start-field" value="{{old('start')}}"/>
                        </div>

                        <hr />
                        <input type="hidden" name="is_zoom" value="1">
                        <div class="form-group">
                            <label for="zoom_invitation-field">【デフォルトのZOOMの招待状】変更がない場合は、そのまま登録してください</label>
                            <textarea name="zoom_invitation" id="zoom_invitation-field" class="form-control" rows="3">栗田クッキングサロン　オンラインレッスンにご予約下さりありがとうございます。
当日は下記アドレスよりお入り頂けます。
ご入金確認後、パスワードをご登録頂きましたメール宛にお送りいたしますので、ご確認の上 ご参加くださいませ。

Zoomミーティングに参加する
https://us02web.zoom.us/j/3789925374

ミーティングID: 378 992 5374                      
                            </textarea>
                        </div>
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;新規登録</button>
                            <a class="btn btn-link pull-right" href="{{ route('staff.zoom_schedule.index') }}"><i class="fas fa-backward"></i> 戻る</a>
                        </div>
                    </form>
</section>
</div>
@endsection
