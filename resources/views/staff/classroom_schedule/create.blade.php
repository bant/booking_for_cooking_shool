@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        <a  href="{{route('staff.schedule.index')}}"> スケジュール管理</a>  >
        教室スケジュール/追加
    </div>  
<section>
    <h1> スケジュール管理</h1>
    <h2>教室スケジュール/追加</h2>
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

                <form action="{{ route('staff.classroom_schedule.store') }}" method="POST">
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

                    <input type="hidden" name="is_zoom" value="0">
                    <input type="hidden" name="zoom_invitation" value="　">

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;新規登録</button>
                        <a class="btn btn-link pull-right" href="{{ route('staff.classroom_schedule.index') }}"><i class="fas fa-backward"></i> 戻る</a>
                    </div>
                </form>


</section>
</div>
@endsection
