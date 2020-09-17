@extends('layouts.admin.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a href="{{route('admin.home.index')}}"><i class="fas fa-home"></i>&nbsp;トップページ</a> >
        予約番号で入金確認メッセージ送信
    </div>
    <section>
        <h1>予約番号で入金確認メッセージ送信</h1>
        <h2>振込通知</h2>
        <h3>絞り込み</h3>
        <form action="{{route('admin.message.reservation_id_search')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="reservation_id-field">予約番号</label>
                <input class="form-control" type="text" name="reservation_id" id="reservation_id-field" value="{{old('reservation_id')}}" />
            </div>
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>&ensp;絞り込み</button>
            </div>
        </form>
        <br />

        <h3>仮予約検索結果</h3>
        @if($reservations->count())
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th class="text-center">予約番号</th>
                    <th>教室名</th>
                    <th>コース名</th>
                    <th>開始時刻</th>
                    <th>担当先生</th>
                    <th>生徒名(ID)</th>
                    <th class="text-right">メッセージ送信</th>
                </tr>
            </thead>

            <tbody>
                @foreach($reservations as $reservation)
                <tr>
                    <td class="text-center"><strong>{{$reservation->id}}</strong></td>
                    @if ($reservation->schedule->is_zoom)
                    <td>{{$reservation->schedule->staff->zoom->name}}</td>
                    @else
                    <td>{{$reservation->schedule->staff->room->name}}</td>
                    @endif
                    <td>{{$reservation->schedule->course->name}}</td>
                    <td>{{date('Y年m月d日 H時i分', strtotime($reservation->schedule->start))}}</td>
                    <td>{{$reservation->schedule->staff->name}}</td>
                    @if (is_null($reservation->user))
                    <td>停止ユーザ</td>
                    @else
                    <td>{{$reservation->user->name}}({{$reservation->user->id}})</td>
                    @endif
                    <td>
                        <a class="float-right btn btn-sm btn-primary" href="{{route('admin.message.edit_to_user_message',['id'=>$reservation->id])}}"> <i class="fas fa-envelope">&ensp;生徒へ</i></a>
                        <a class="float-right btn btn-sm btn-primary" href="{{route('admin.message.edit_to_staff_message',['id'=>$reservation->id])}}"> <i class="fas fa-envelope">&ensp;先生へ</i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center alert alert-info">該当する生徒はいません。</div>
        @endif
    </section>
</div>
@endsection