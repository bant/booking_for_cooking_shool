@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        <a  href="{{route('staff.course.index')}}"> コースの確認</a>  >
            コースの作成
    </div>  
    <section>
    <h1> コース設定</h1>
    <h2>コースの作成</h2>

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

    <form action="{{ route('staff.course.store') }}" method="POST">
        @csrf
        <input class="form-control" type="hidden" name="staff_id" id="staff_id-field" value="{{ Auth::user()->id }}" />
        <div class="form-group">
            <label for="name-field">コース名</label>
            <input class="form-control" type="text" name="name" id="name-field" value="{{old('name')}}" />
        </div>
        <div class="form-group">
            <label for="price-field">単価</label>
            <input class="form-control" type="text" name="price" id="price-field" value="{{old('price')}}" />
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> コース新規登録</button>
            <a class="btn btn-link pull-right" href="{{ route('staff.course.index') }}"><i class="fas fa-backward"></i> 戻る</a>
            </div>
    </form>
    </section>
</div>
@endsection
