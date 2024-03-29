@extends('layouts.staff.app')

@section('content')
<div id="content">
  <section>
    <h2>スケジュール</h2>
    <div class="row justify-content-center">
      <div class="col-md-10">
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
                          <th class="text-right">アクション</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach($schedules as $schedule)
                        <tr>
                          <td class="text-center"><strong>{{$schedule->id}}</strong></td>
                          <td>{{ $schedule->course->name }}</td>
                          <td>{{ $schedule->course->price }}</td>
                          <td>{{$schedule->start}}</td>
                               <td><input type="checkbox" disabled @if( $schedule->is_zoom ) checked @endif/></td>
                          <td class="text-right">
                            <a class="btn btn-sm btn-warning" href="{{ route('staff.schedule.edit', $schedule->id) }}"><i class="fas fa-edit"></i> 編集</a>
                            <form action="{{ route('staff.schedule.destroy', $schedule->id) }}" method="POST" style="display: inline;"
                                onsubmit="return confirm('削除しても良いですか?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> 削除</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                      </table>
                      <a class="btn btn-primary" href="{{ route('staff.schedule.create') }}"><i class="fas fa-edit"></i> 追加</a>
                      <a class="btn btn-link pull-right" href="/staff/home"><i class="fas fa-backward"></i> カレンダーに戻る</a>
                    @else
                        <h3 class="text-center alert alert-info">スケジュールが未登録です。</h3>
                        <a href="/staff/schedule/create"><button type="submit" class="btn btn btn-warning"><i class="fas fa-edit"></i> 登録</button></a>をクリックしてスケジュールを登録してください。
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection
