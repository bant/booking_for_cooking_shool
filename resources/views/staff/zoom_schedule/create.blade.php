@extends('layouts.staff.app')

@section('content')
<div id="content">
<section>
    <h2>オンライン教室スケジュール/追加</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> 教室スケジュール/追加</div>

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

                    <form action="{{ route('staff.zoom_schedule.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title-field">コース</label>
                            <select type="text" class="form-control" name="course_id">                          
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="capacity-field">定員</label>
                            <input class="form-control" type="number" name="capacity" id="capacity-field"  min="1" max="10" value="{{old('capacity')}}" />
                        </div>

                        <div class="form-group">
                            <label for="start-field">開始日時</label>
                            <input type="datetime-local" name="start"  id="start-field" value="{{old('start')}}"/>
                        </div>

                        <hr />
                        <input type="hidden" name="is_zoom" value="1">
                        <div class="form-group">
                            <label for="zoom_invitation-field">【ZOOMの招待状】を貼り付けてください</label>
                            <textarea name="zoom_invitation" id="zoom_invitation-field" class="form-control" rows="3">{{old('zoom_invitation')}}</textarea>
                        </div>
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> 新規登録</button>
                            <a class="btn btn-link pull-right" href="{{ route('staff.zoom_schedule.index') }}"><i class="fas fa-backward"></i> 戻る</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
