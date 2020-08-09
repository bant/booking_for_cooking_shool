@extends('layouts.user.app')

@section('content')
<div id="content">
    <section>
        <h1>{{ Auth::user()->name }}さんのホーム</h1>
        <div id="main">

        <h2>教室の予約状況</h2>
        @if($classroom_reservations->count())
        <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>コース名</th>
                <th>教室</th>
                <th>先生</th>
                <th>価格</th>
                <th>開始時間</th>
                <th class="text-right">オプション</th>
            </tr>
        </thead>

        <tbody>
        @foreach($classroom_reservations as $classroom_reservation)
            <tr>
             @if ($classroom_reservation->is_contract)
                <td class="text-center text-white bg-success"><strong>確</strong></td>
            @else
                <td class="text-center text-white bg-danger"><strong>仮</strong></td>
            @endif
　              <td>{{$classroom_reservation->course_name}}</td>
                <td>{{$classroom_reservation->room_name}}</td>
                <td>{{$classroom_reservation->staff_name}}</td>
                <td>{{ number_format($classroom_reservation->course_price) }}円</td>
                <td>{{ date('Y年m月d日 H時i分', strtotime($classroom_reservation->start))}}</td>
                <td class="text-right">
                    <form action="/user/classroom_reservation/{{$classroom_reservation->id}}/destroy" method="POST" style="display: inline;"
                                 onsubmit="return confirm('予約を取り消しても良いですか?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>取り消し</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
        </table>
        @else
        <div class="text-center alert alert-info">
            教室の予約はありません。
        </div>
        @endif

        <h2>ZOOM教室の予約状況</h2>
        @if($zoom_reservations->count())
        <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>コース名</th>
                <th>教室</th>
                <th>先生</th>
                <th>価格</th>
                <th>開始時間</th>
                <th class="text-right">オプション</th>
            </tr>
        </thead>

        <tbody>
        @foreach($zoom_reservations as $zoom_reservation)
            <tr>
            @if ($zoom_reservation->is_contract)
                <td class="text-center text-white bg-success"><strong>確</strong></td>
            @else
                <td class="text-center text-white bg-danger"><strong>仮</strong></td>
            @endif
                </td>
                <td>{{$zoom_reservation->course_name}}</td>
                <td>{{$zoom_reservation->room_name}}</td>
                <td>{{$zoom_reservation->staff_name}}</td>
                <td>{{ number_format($zoom_reservation->course_price) }}円</td>
                <td>{{ date('Y年m月d日 H時i分', strtotime($zoom_reservation->start))}}</td>
                <td class="text-right">
                    <form action="/user/zoom_reservation/{{$zoom_reservation->id}}/destroy" method="POST" style="display: inline;"
                                 onsubmit="return confirm('予約を取り消しても良いですか?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>取り消し</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
        </table>
        @else
        <h3 class="text-center alert alert-info">zoom教室の予約はありません。</h3>
        @endif


        </div><!-- #main -->
        </section>
</div><!-- #content -->
@endsection