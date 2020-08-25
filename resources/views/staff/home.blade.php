@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
            予約確認
    </div>  
    <section>
    <h1>{{$staff->name}}先生のダッシュボード</h1>
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
                    @if (is_null($class_reservation->deleted_at))
                        <td><a href="{{ route('staff.user.info', ['id' => $class_reservation->user_id])}}">{{$class_reservation->user_name}}({{$class_reservation->user_id}})</a></td>
                    @else
                        <td>{{$class_reservation->user_name}}(停止)</td>
                    @endif
                        <td>{{ date('Y年m月d日 H時i分', strtotime($class_reservation->start)) }}</td>
                        <td class="text-right">
                        @if (!$class_reservation->is_contract)
                            <td><strong>確定にする</strong></td>
                        @endif
                        
                        
                        
                        メール送信</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center alert alert-info">教室の予約はありません。</div>
        @endif
        <!-- 教室の予約の終わり -->
   

        <h2>オンライン教室の予約状況</h2>

        <!-- オンライン教室の予約状況の始まり -->
        @if($zoom_reservations->count())
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
            <div class="text-center alert alert-info">オンライン教室の予約はありません。</div>
        @endif
    @endif

    </section>
</div>
@endsection
