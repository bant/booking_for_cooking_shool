@extends('layouts.admin.app')

@section('content')
<div id="content">
  <section>
    <h3>{{$staff->name}}先生のポイント</h3>
    <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- 先生の教室の予約の始まり -->
                <div class="card">
                    <div class="card-header"><i class="fas fa-id-card"></i> {{date('Y年m月', strtotime($now_first_month_day)) }}のポイントあり</div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        @if($pointpay_class_reservations->count())
                        <table class="table table-sm table-striped">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>生徒(ID)</th>
                            <th>コース名</th>
                            <th>料金</th>
                            <th>日時</th>
                            <th>状態</th>
                            <th class="text-right">オプション</th>
                          </tr>
                        </thead>

                        <tbody>
                          @foreach($pointpay_reservations as $class_reservation)
                          <tr>
                            @if ($class_reservation->is_contract)
                              <td class="text-center text-white bg-success"><strong>確</strong></td>
                            @else
                              <td class="text-center text-white bg-danger"><strong>仮</strong></td>
                            @endif
                            <td>{{$class_reservation->user_name}}({{$class_reservation->user_id}})</td>
                            <td>{{$class_reservation->course_name}}</td>
                            <td>{{ number_format($class_reservation->course_price)}}円</td>
                            <td>{{ date('Y年m月d日 H時i分', strtotime($class_reservation->start)) }}</td>
                            @if (strtotime($class_reservation->start) > strtotime('now'))
                              <td>未</td>
                            @else
                              <td>済</td>
                            @endif
                            <td class="text-right">メール送信</td>
                          </tr>
                          @endforeach
                        </tbody>
                        </table>
                        <a class="float-left btn btn-sm btn-warning" href="{{ route('staff.reservation.export_class', $now_first_month_day) }}"><i class="fas fa-edit"></i> execelファイルでダウンロード</a>
                        @else
                          <h3 class="text-center alert alert-info">教室の予約はありません。</h3>
                        @endif
                        <a class="float-right btn btn-sm btn-primary" href="{{ route('staff.reservation.show', $next_first_month_day) }}"> 次月 >></a>
                        <a class="float-right btn btn-sm btn-primary" href="{{ route('staff.reservation.show', $previous_first_month_day) }}"> << 前月</a>
                    </div>
                </div>
                <!-- 先生の教室の予約の終わり -->

   
                <br/>
                <!-- 先生の教室の予約の始まり -->
                <div class="card">
                    <div class="card-header"><i class="fas fa-id-card"></i> {{date('Y年m月', strtotime($now_first_month_day)) }}のポイントなし</div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        @if($no_pointpay_class_reservations->count())
                        <table class="table table-sm table-striped">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>生徒(ID)</th>
                            <th>コース名</th>
                            <th>料金</th>
                            <th>日時</th>
                            <th>状態</th>
                            <th class="text-right">オプション</th>
                          </tr>
                        </thead>

                        <tbody>
                          @foreach($no_pointpay_class_reservations as $class_reservation)
                          <tr>
                            @if ($class_reservation->is_contract)
                              <td class="text-center text-white bg-success"><strong>確</strong></td>
                            @else
                              <td class="text-center text-white bg-danger"><strong>仮</strong></td>
                            @endif
                            <td>{{$class_reservation->user_name}}({{$class_reservation->user_id}})</td>
                            <td>{{$class_reservation->course_name}}</td>
                            <td>{{ number_format($class_reservation->course_price)}}円</td>
                            <td>{{ date('Y年m月d日 H時i分', strtotime($class_reservation->start)) }}</td>
                            @if (strtotime($class_reservation->start) > strtotime('now'))
                              <td>未</td>
                            @else
                              <td>済</td>
                            @endif
                            <td class="text-right">メール送信</td>
                          </tr>
                          @endforeach
                        </tbody>
                        </table>
                        <a class="float-left btn btn-sm btn-warning" href="{{ route('staff.reservation.export_class', $now_first_month_day) }}"><i class="fas fa-edit"></i> execelファイルでダウンロード</a>
                        @else
                          <h3 class="text-center alert alert-info">教室の予約はありません。</h3>
                        @endif
                        <a class="float-right btn btn-sm btn-primary" href="{{ route('staff.reservation.show', $next_first_month_day) }}"> 次月 >></a>
                        <a class="float-right btn btn-sm btn-primary" href="{{ route('staff.reservation.show', $previous_first_month_day) }}"> << 前月</a>
                    </div>
                </div>
                <!-- 先生の教室の予約の終わり -->
   
                <br/>
                <!-- 生徒さん様の予約リスト用スロット始まり -->
                <div class="card">
                    <div class="card-header"><i class="fas fa-id-card"></i> {{date('Y年m月', strtotime($now_first_month_day)) }}のZOOM教室予約一覧</div>
                    <div class="card-body">
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
                          <th class="text-right">オプション</th>
                        </tr>
                      </thead>
                      <br/>
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
                          <td class="text-right">メール送信
                          </td>
                         </tr>
                      @endforeach
                      </tbody>
                      </table>
                      <a class="btn btn-sm btn-warning" href="{{ route('staff.reservation.export_zoom', $now_first_month_day) }}"><i class="fas fa-edit"></i> execelファイルでダウンロード</a>
                    @else
                        <h3 class="text-center alert alert-info">ZOOMの予約はありません。</h3>
                    @endif
                    <a class="float-right btn btn-sm btn-warning" href="{{ route('staff.reservation.show', $next_first_month_day) }}"> 次月>></a>
                    <a class="float-right btn btn-sm btn-warning" href="{{ route('staff.reservation.show', $previous_first_month_day) }}"> <<前月</a>
 
                  </div>
                </div>
                 <!-- 生徒さん様の予約リスト用スロット終わり -->
            </div><!-- end card -->
       
        </div>
    </div>
  </section>
</div>
@endsection