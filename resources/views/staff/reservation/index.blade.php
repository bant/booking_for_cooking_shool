@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        予約状況の確認
    </div>  

    <section>
    <h1>{{ Auth::user()->name }}先生のダッシュボード</h1>
    <h2>{{date('Y年m月', strtotime($now_first_month_day)) }}の予約状況
        <a class="float-right btn btn-sm btn-warning" href="{{ route('staff.reservation.show', $next_first_month_day) }}"> 次月>></a>
        <a class="float-right btn btn-sm btn-warning" href="{{ route('staff.reservation.show', $previous_first_month_day) }}"> <<前月</a>
    </h2>

    <h3>{{Auth::user()->room->name}}の予約一覧</h3>
  
    @if($class_reservations->count())
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>状態</th>
                <th>生徒(ID)</th>
                <th>コース名</th>
                <th>日時</th>
                <th>料金</th>
                <th>支払済ポイント</th>
                <th class="text-right">アクション</th>
            </tr>
      </thead>

      <tbody>
            @foreach($class_reservations as $class_reservation)
                <tr>
                @if ($class_reservation->is_contract)
                    <td class="text-center text-white bg-success"><strong>確</strong></td>
                @else
                    <td class="text-center text-white bg-danger"><strong>仮</strong></td>
                @endif
                @if (strtotime($class_reservation->start) > strtotime('now'))
                    <td>未</td>
                @else
                    <td>済</td>
                @endif
                <td><a href="{{ route('staff.user.info', $class_reservation->user_id) }}"> {{$class_reservation->user_name}}({{$class_reservation->user_id}})</a></td>
                <td>{{$class_reservation->course_name}}</td>
                <td>{{ date('Y年m月d日 H時i分', strtotime($class_reservation->start)) }}</td>
                <td>{{ number_format($class_reservation->course_price)}}円</td>
                <td>{{ number_format($class_reservation->point)}}pt</td>
                @if (!$class_reservation->is_contract)
                    <td>
                        <a class="float-right btn btn-sm btn-warning" href="{{ route('staff.reservation.is_contract_update', $class_reservation->id) }}"> 確定に変更</a>                              
                    </td>
                @else
                    <td>--</td>                            
                @endif
                </tr>
            @endforeach
      </tbody>
      </table>
      <a class="float-right btn btn-sm btn-warning" href="{{ route('staff.reservation.export_class', $now_first_month_day) }}"><i class="fas fa-edit"></i> execelファイルでダウンロード</a>
    @else
      <div class="text-center alert alert-info">教室の予約はありません。</div>
    @endif

    <br/>
    <h3>オンライン教室予約一覧</h3>
    @if($zoom_reservations->count())
        <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>生徒(ID)</th>
                <th>コース名</th>
                <th>料金</th>
                <th>日時</th>
                <th>状態</th>
                <th class="text-right">アクション</th>
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
                <td>{{$zoom_reservation->user_name}}({{$zoom_reservation->user_id}})</td>
                <td>{{$zoom_reservation->course_name}}</td>
                <td>{{ number_format($zoom_reservation->course_price)}}円</td>
                <td>{{ date('Y年m月d日 H時i分', strtotime($zoom_reservation->start)) }}</td>
            @if (strtotime($zoom_reservation->start) > strtotime('now'))
                <td>未</td>
            @else
                <td>済</td>
            @endif
                <td class="text-right">---</td>
            </tr>
        @endforeach
        </tbody>
        </table>
        <a class="btn btn-sm btn-warning" href="{{ route('staff.reservation.export_zoom', $now_first_month_day) }}"><i class="fas fa-edit"></i> execelファイルでダウンロード</a>
    @else
      <div class="text-center alert alert-info">オンライン教室の予約はありません。</div>
    @endif
  </section>
</div>
@endsection