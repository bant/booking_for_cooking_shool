@extends('layouts.staff.app')

@section('style')
<style>
    input[type=radio] {
       display: none; /* ラジオボタンを非表示にする */
  }
</style>
@section('style')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-2">
        <!-- left menu -->
        @include('layouts.staff.menu')

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> スケジュール/追加</div>

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

                    <form action="{{ route('staff.schedule.store') }}" method="POST">
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
                        <div class="form-group">
                            <label for="end-field">終了日時</label>
                            <input type="datetime-local" name="end"  id="end-field"  value="{{old('end')}}"/>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label class="form-label" for="form-field">教室/ZOOM</label>
                            </div>
                            <div class="col-sm-10 btn-group" data-toggle="buttons">
        
                                <label class="btn btn-outline-secondary active" style="width:50%">
                                    <input type="radio" name="is_zoom" value="0" checked="checked"> 教室
                                </label>
                                <label class="btn btn-outline-secondary" style="width:50%">
                                     <input type="radio" name="is_zoom" value="1"> ZOOM
                                </label>
                                   
                            </div>
                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> 新規登録</button>
                            <a class="btn btn-link pull-right" href="{{ route('staff.schedule.index') }}"><i class="fas fa-backward"></i> 戻る</a>
                        </div>
                    </form>
                 


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
