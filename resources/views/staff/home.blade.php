@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <i class="fas fa-home"></i> トップページ
    </div>  
    <section>
    <h1>お知らせ</h1>
    @if ($room_count == 0 or $course_count == 0)
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
    @else


        <h2>管理者からのお知らせ</h2>
            @if($admin_messages->count())
            <table class="table table-sm table-striped">
            <thead>
            <tr>
                <th>予約番号</th>
                <th>メッセージ</th>
                <th>表示期限</th>
                <th>アクション</th>
            </tr>
        </thead>

        <tbody>
        @foreach($admin_messages as $admin_message)
            <tr>
                <td>{{$admin_message->reservation_id}}</td>
                <td>{{$admin_message->message}}</td>
                <td>{{ date('Y年m月d日 H時i分', strtotime($admin_message->expired_at))}}</td>
                <td><a class="float-right btn btn-sm btn-warning" href="{{ route('staff.message.admin_delete', $admin_message->id) }}"> メッセージ削除</a> </td>                             
            </tr>
        @endforeach
        </tbody>
        </table>
        @else
        <div class="text-center alert alert-info">
            管理者からメッセージはありません。
        </div>
        @endif

        <h2>{{$staff->room->name}}の予約状況</h2>

        <!-- 教室の予約の始まり -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
        @endif

        @if($class_reservations->count())
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                    <th>予約番号</th>
                    <th>確定</th>
                    <th>生徒(ID)</th>
                    <th>コース名</th>
                    <th>日時</th>
                    <th>料金</th>
                    <th>支払済ポイント</th>
                    <th>アクション</th>
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
        @else
            <div class="text-center alert alert-info">教室の予約はありません。</div>
        @endif
        <!-- 教室の予約の終わり -->
   
        @if ($staff->is_zoom)
        <h2>{{$staff->zoom->name}}の予約状況</h2>

        <!-- オンライン教室の予約状況の始まり -->
        @if($zoom_reservations->count())
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                    <th>予約番号</th>
                    <th>確定</th>
                    <th>生徒(ID)</th>
                    <th>コース名</th>
                    <th>日時</th>
                    <th>料金</th>
                    <th>支払済ポイント</th>
                    <th>アクション</th>
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
                    <td><a href="{{ route('staff.user.info', $zoom_reservation->user_id) }}"> {{$zoom_reservation->user_name}}({{$zoom_reservation->user_id}})</a></td>
                    <td>{{$class_reservation->course_name}}</td>
                    <td>{{ date('Y年m月d日 H時i分', strtotime($zoom_reservation->start)) }}</td>
                    <td>{{ number_format($zoom_reservation->course_price)}}円</td>
                    <td>{{ number_format($zoom_reservation->point)}}pt</td>
                    <td>--</td>                            
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center alert alert-info">オンライン教室の予約はありません。</div>
        @endif
        @endif
    @endif

    </section>
</div>
@endsection
