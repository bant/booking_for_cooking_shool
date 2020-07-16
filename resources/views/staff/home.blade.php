@extends('layouts.staff.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <!-- left menu -->
            @include('layouts.staff.menu')

            <div class="col-md-10">

              @if ($room_count == 0 or $course_count == 0)
                <!-- 教室の予約の始まり -->
                <div class="card">
                    <div class="card-header"><i class="fas fa-id-card"></i> {{ Auth::user()->name }}初期設定のご案内</div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        @if($room_count == 0)
                           <h3 class="text-center alert alert-info">教室情報が登録されていません。</h3>
                        @endif


                        @if($course_count == 0)
                           <h3 class="text-center alert alert-info">コースが設定されてません。</h3>
                        @endif
                    </div>
                </div>



              @else
                <!-- 教室の予約の始まり -->
                <div class="card">
                    <div class="card-header"><i class="fas fa-id-card"></i> {{ Auth::user()->name }}先生の教室予約一覧</div>
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
                            <th class="text-right">オプション</th>
                          </tr>
                        </thead>

                        <tbody>
                          @foreach($class_reservations as $class_reservation)
                          <tr>
                            <td class="text-center"><strong>{{$class_reservation->id}}</strong></td>
                            <td>{{$class_reservation->course_name}}</td>
                            <td>{{$class_reservation->user_name}}</td>
                            <td>{{$class_reservation->start}}</td>
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
                    <div class="card-header"><i class="fas fa-id-card"></i> {{ Auth::user()->name }}先生のZOOM予約一覧</div>
                    <div class="card-body">
                    @if($zoom_reservations->count())
                    <h3 class="my-3 ml-3">ZOOM教室の予約一覧</h3>
                      <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>タイトル</th>
                          <th>生徒</th>
                          <th>日時</th>
                          <th class="text-right">オプション</th>
                        </tr>
                      </thead>
                      <br/>
                      <tbody>
                      @foreach($zoom_reservations as $zoom_reservation)
                        <tr>
                          <td class="text-center"><strong>{{$zoom_reservation->id}}</strong></td>
                          <td>{{$zoom_reservation->course_name}}</td>
                          <td>{{$zoom_reservation->user_name}}</td>
                          <td>{{$zoom_reservation->start}}</td>
                          <td class="text-right">メール送信

                          </td>
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
    </div>
</div>
@endsection