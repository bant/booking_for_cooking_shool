@extends('layouts.staff.app')

@section('content')
<div id="content">
  <section>
    <h2>予約状況</h2>
    <div class="row justify-content-center">
      <div class="col-md-10">

@if ($room_count == 0 or $course_count == 0)
        <!-- 教室の予約の始まり -->
        <div class="card">
          <div class="card-header"><i class="fas fa-id-card"></i> 初期設定のご案内</div>
          <div class="card-body">
@if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
@endif

@if($room_count == 0)
            <h3 class="text-center alert alert-info">教室情報が登録されていません。</h3>
            <p><a href="{{route('staff.room.create')}}"><button type="submit" class="btn btn btn-warning"><i class="fas fa-edit"></i> 登録</button></a>をクリックして教室を登録してください。</p>
@endif

@if($course_count == 0)
            <h3 class="text-center alert alert-info">コースが設定されてません。</h3>
            <p><a href="{{route('staff.course.create')}}"><button type="submit" class="btn btn btn-warning"><i class="fas fa-edit"></i> 登録</button></a>をクリックしてコースを登録してください。</p>
@endif
          </div>
        </div>
@else
        <!-- 教室の予約の始まり -->
        <div class="card">
          <div class="card-header"><i class="fas fa-id-card"></i> 教室予約一覧</div>
          <div class="card-body">
@if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
@endif

@if($class_reservations->count())
            <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>タイトル</th>
                <th>生徒</th>
                <th>日時</th>
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
                <td>{{$class_reservation->course_name}}</td>
              @if (!is_null($class_reservation->deleted_at))
                <td><a href="{{ route('staff.user.info', ['id' => $class_reservation->user_id])}}">{{$class_reservation->user_name}}({{$class_reservation->user_id}})</a></td>
               @else
                <td>{{$class_reservation->user_name}}(停止)</td>
              @endif
                <td>{{ date('Y年m月d日 H時i分', strtotime($class_reservation->start)) }}</td>
                <td class="text-right">メール送信</td>
              </tr>
@endforeach
            </tbody>
            </table>
@else
            <h3 class="text-center alert alert-info">教室の予約はありません。</h3>
@endif
          </div>
        </div>
        <!-- 教室の予約の終わり -->
   
        <br/>
        <!-- ZOOM予約の始まり -->
        <div class="card">
          <div class="card-header"><i class="fas fa-id-card"></i> オンライン教室の予約一覧</div>
            <div class="card-body">
@if($zoom_reservations->count())
              <h3 class="my-3 ml-3">オンライン教室の予約一覧</h3>
              <table class="table table-sm table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>タイトル</th>
                  <th>生徒</th>
                  <th>日時</th>
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
                  <td>{{$zoom_reservation->course_name}}</td>
                  <td>{{$zoom_reservation->user_name}}</td>
                  <td>{{ date('Y年m月d日 H時i分', strtotime($zoom_reservation->start)) }}</td>
                  <td class="text-right">メール送信</td>
                 </tr>
@endforeach
                </tbody>
                </table>
@else
                <h3 class="text-center alert alert-info">ZOOMの予約はありません。</h3>
@endif
             </div>
            </div>
       <!-- ZOOM予約の終わり -->
    </div><!-- end card -->
@endif
  </div>

@endsection
