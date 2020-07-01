@extends('layouts.staff.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <!-- left -->
        <div class="col-md-2">
            <div class="card">
                <div class="card-header"><i class="fas fa-th-list"></i></i> メニュー</div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <ul class="nav nav-pills nav-stacked" style="display:block;">
                                <li><i class="fas fa-user-alt"></i> <a href="profile">プロフィール</a></li>
                                <li><i class="fas fa-user-alt"></i> <a href="room">教室情報</a></li>
                                <li><i class="fas fa-calendar"></i> <a href="schedule">スケジュール</a></li>
                                <li><i class="fas fa-calendar"></i> <a href="reservation">予約</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>



        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> {{ Auth::user()->name }}先生のスケジュール</div>

                <div class="card-body">
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

                    @if($schedules->count())
                      <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>タイトル</th>
                          <th>詳細</th>
                          <th>日時</th>
                          <th>zoom</th>
                          <th class="text-right">オプション</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach($schedules as $schedule)
                        <tr>
                          <td class="text-center"><strong>{{$schedule->id}}</strong></td>
                          <td>{{$schedule->title}}</td>
                          <td>{{$schedule->description}}</td>
                          <td>{{$schedule->start}}</td>
                               <td><input type="checkbox" disabled @if( $schedule->is_zoom ) checked @endif/></td>
                          <td class="text-right">
                            <a class="btn btn-sm btn-warning" href="{{ route('staff.schedule.edit', $schedule->id) }}"><i class="fas fa-edit"></i> 編集</a>
                            <form action="{{ route('staff.schedule.destroy', $schedule->id) }}" method="POST" style="display: inline;"
                                onsubmit="return confirm('削除しても良いですか?');">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> 削除</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                      </table>

                    @else
                      <h3 class="text-center alert alert-info">Empty!</h3>
                    @endif
            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
