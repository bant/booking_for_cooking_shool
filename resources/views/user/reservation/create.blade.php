@extends('layouts.user.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-2">
        <!-- left menu -->
        @include('layouts.user.menu')

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> 予約を追加</div>

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

                    <form action="{{ route('user.reservation.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="capacity-field"></label>
                            スケジュールID:{{$schedule->id}}<br/>
                            先生:{{$schedule->course->staff->name}}<br/>
                            場所:{{$schedule->course->staff->room->name}}<br/>
                            コース名:{{$schedule->course->name }}<br/>
                            開始日時:{{$schedule->start}}<br/>
                           終了日時:{{$schedule->end}}
                           
                        </div>
 
                        <input type="hidden" name="schedule_id" value="{{$schedule->id}}">
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> 新規登録</button>
                            <a class="btn btn-link pull-right" href="/user/ClassroomSchedule/calendar/{{$schedule->staff_id}}"><i class="fas fa-backward"></i> カレンダーに戻る</a>
                        </div>
                    </form>
                 


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
