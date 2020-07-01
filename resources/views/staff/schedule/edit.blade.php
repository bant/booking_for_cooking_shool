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
                                <li><i class="fas fa-user-alt"></i> <a href="room">プロフィール</a></li>
                                <li><i class="fas fa-user-alt"></i> <a href="room">教室情報</a></li>
                                <li><i class="fas fa-calendar"></i> <a href="schedule">スケジュール</a></li>
                                <li><i class="fas fa-calendar"></i> <a href="schedule">予約</a></li>
                            </ul>
                            <hr>
                            <div id='calendar-container'>
                                <div id='external-events'>
                                    <div class='fc-event'>教室設定</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> スケジュール/編集</div>

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

                    <form action="{{ route('staff.schedule.update', $schedule->id) }}" method="POST">
      @method('PUT')
      @csrf

      <div class="form-group">
        <label for="title-field">タイトル</label>
        <input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $schedule->title) }}" />
      </div>
      <div class="form-group">
        <label for="description-field">詳細</label>
        <textarea name="description" id="description-field" class="form-control" rows="3">{{ old('description', $schedule->description ) }}</textarea>
      </div>

      <div class="form-group">
            <label for="start-field">日時</label>
            <input  class="form-control" type="datetime-local" name="start"  id="start-field" value="{{ str_replace(' ', 'T', old('start', $schedule->start)) }}" />
       </div>
 

        <div class="form-group">
            <label for="end-field">日時</label>
            <input class="form-control" type="datetime-local" name="end"  id="end-field"  value="{{ str_replace(' ', 'T', old('end', $schedule->end)) }}" />
        </div>


      <div class="well well-sm">
        <button type="submit" class="btn btn-primary">Save</button>
        <a class="btn btn-link pull-right" href="{{ route('staff.schedule.index') }}"><i class="fas fa-backward"></i> Back</a>
      </div>
    </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
