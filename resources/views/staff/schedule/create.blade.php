@extends('layouts.staff.app')

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
                            <label for="title-field">タイトル</label>
                            <input class="form-control" type="text" name="title" id="title-field" value="{{old('title')}}" />
                        </div>
                        <div class="form-group">
                            <label for="description-field">詳細</label>
                            <textarea name="description" id="description-field" class="form-control" rows="3">{{old('description')}}</textarea>
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

                        <input type="checkbox" name="is_zoom" {{ old('is_zoom') || !$errors->any() ? 'checked' : '' }}><label for="is_zoom"> ZOOM</label>
 

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
