@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        予約管理
    </div>  

    <section>
    <h1>予約管理</h1>
    <h2>{{date('Y年m月', strtotime($now_first_month_day)) }}の予約状況
        <a class="float-right btn btn-sm btn-warning" href="{{ route('staff.reservation.show', $next_first_month_day) }}"> 次月>></a>
        <a class="float-right btn btn-sm btn-warning" href="{{ route('staff.reservation.show', $previous_first_month_day) }}"> <<前月</a>
    </h2>

    <h3>{{Auth::user()->room->name}}の予約一覧(終了済みも表示されます)</h3>
  
    @if($class_reservations->count())
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th>予約番号</th>
                <th>確定</th>
                <th>終了</th>
                <th>生徒(ID)</th>
                <th>コース名</th>
                <th>日時</th>
                <th>料金(税込み)</th>
                <th>支払済ポイント</th>
                <th class="text-right">アクション</th>
            </tr>
      </thead>

      <tbody>
            @foreach($class_reservations as $class_reservation)
                <tr>
               <td>{{$class_reservation->id}}</td>
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

                @if (is_null($class_reservation->user_deleted_at))
                    <td><a href="{{ route('staff.user.info', $class_reservation->user_id) }}"> {{$class_reservation->user_name}}({{$class_reservation->user_id}})</a></td>
                @else
                    <td>{{$class_reservation->user_name}}(停止)</td>
                @endif
                <td>{{$class_reservation->course_name}}</td>
                <td>{{ date('Y年m月d日 H時i分', strtotime($class_reservation->start)) }}</td>
                <td>{{ number_format($class_reservation->course_price*1.1)}}円</td>
                <td>{{ number_format($class_reservation->point)}}pt</td>
                @if (!$class_reservation->is_contract)
                    <td>
                        <a class="float-right btn btn-sm btn-warning" href="{{ route('staff.reservation.is_contract_classroom_update', $class_reservation->id) }}"> 確定に変更</a>                              
                    </td>
                @else
                    <td>--</td>                            
                @endif
                </tr>
            @endforeach
      </tbody>
      </table>
      <a class="float-right btn btn-sm btn-success" href="{{ route('staff.reservation.export_class', $now_first_month_day) }}"><i class="fas fa-download"></i>&nbsp;Excelファイルでダウンロード</a>
    @else
      <div class="text-center alert alert-info">教室の予約はありません。</div>
    @endif

    <br/>
    @if (Auth::user()->is_zoom)
    <h3>{{Auth::user()->zoom->name}}の予約一覧(終了済みも表示されます)</h3>
    @if($zoom_reservations->count())
        <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th>予約番号</th>
                <th>確定</th>
                <th>終了</th>
                <th>生徒(ID)</th>
                <th>コース名</th>
                <th>日時</th>
                <th>料金(税込み)</th>
                <th>支払済ポイント</th>
                <th class="text-right">アクション</th>
            </tr>
        </thead>
        
        <tbody>
        @foreach($zoom_reservations as $zoom_reservation)
            <tr>
                <td>{{$zoom_reservation->id}}</td>
            @if ($zoom_reservation->is_contract)
                <td class="text-center text-white bg-success"><strong>確</strong></td>
            @else
                <td class="text-center text-white bg-danger"><strong>仮</strong></td>
            @endif
            @if (strtotime($zoom_reservation->start) > strtotime('now'))
                <td>未</td>
            @else
                <td>済</td>
            @endif
                <td>{{$zoom_reservation->user_name}}({{$zoom_reservation->user_id}})</td>
                <td>{{$zoom_reservation->course_name}}</td>
                <td>{{ date('Y年m月d日 H時i分', strtotime($zoom_reservation->start)) }}</td>
                <td>{{ number_format($zoom_reservation->course_price*1.1)}}円</td>
                <td>{{ number_format($zoom_reservation->point)}}pt</td>
                @if (!$zoom_reservation->is_contract)
                    <td>
                        <a class="float-right btn btn-sm btn-warning" href="{{ route('staff.reservation.is_contract_zoom_update', $zoom_reservation->id) }}"> 確定に変更</a>                              
                    </td>
                @else
                    <td>--</td>                            
                @endif
            </tr>
        @endforeach
        </tbody>
        </table>
        <a class="float-right btn btn-sm btn-success" href="{{ route('staff.reservation.export_zoom', $now_first_month_day) }}"><i class="fas fa-download"></i>&nbsp;Excelファイルでダウンロード</a>
    @else
      <div class="text-center alert alert-info">オンライン教室の予約はありません。</div>
    @endif
    @endif
    <br/>
  </section>
</div>
@endsection