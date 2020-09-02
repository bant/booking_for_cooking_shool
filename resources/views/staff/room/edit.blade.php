@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        <a href="{{ route('staff.room.index') }}">教室設定の確認</a> >
        教室設定の更新
    </div>  
    <section>
    <h1>{{ Auth::user()->name }}先生のダッシュボード</h1>
    <h2>教室設定の更新</h2>
 
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

    <form action="{{ route('staff.room.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input class="form-control" type="hidden" name="staff_id" id="staff_id-field" value="{{ Auth::user()->id }}" />
        <div class="form-group">
            <label for="name-field">教室名</label>
            <input class="form-control" type="text" name="name" id="name-field" value="{{$room->name}}" />
        </div>
        <div class="form-group">
            <label for="address-field">住所</label>
            <textarea name="address" id="address-field" class="form-control" rows="3">{{$room->address}}</textarea>
        </div>
        <div class="form-group">
            <label for="tel-field">電話番号</label>
            <input class="form-control" type="tel" name="tel" id="tel-field" value="{{$room->tel}}" />
        </div>
        <div class="form-group">
            <label for="description-field">詳細</label>
            <textarea name="description" id="description-field" class="form-control" rows="3">{{$room->description}}</textarea>
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> 教室情報更新</button>
            <a class="btn btn-link pull-right" href="{{ route('staff.room.index') }}"><i class="fas fa-backward"></i> 確認へ戻る</a>
        </div>
    </form>
    </section>
</div>
@endsection
