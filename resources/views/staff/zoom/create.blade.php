@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        <a href="{{route('staff.zoom.index')}}">オンライン教室の確認</a>  >
        オンライン教室の登録
    </div>  
    <section>
    <h1>{{ Auth::user()->name }}先生のダッシュボード</h1>
    <h2>オンライン教室の登録</h2>

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

    <form action="{{ route('staff.zoom.store') }}" method="POST">
        @csrf
        <input class="form-control" type="hidden" name="staff_id" id="staff_id-field" value="{{ Auth::user()->id }}" />
        <div class="form-group">
            <label for="name-field">オンライン教室名</label>
            <input class="form-control" type="text" name="name" id="name-field" value="{{old('name')}}" />
        </div>
        <div class="form-group">
            <label for="description-field">詳細</label>
            <input class="form-control" type="text" name="description" id="description-field" value="{{old('description')}}" />
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;オンライン教室の登録</button>
            <a class="btn btn-link pull-right" href="{{ route('staff.zoom.index') }}"><i class="fas fa-backward"></i> 戻る</a>
        </div>
    </form>
    </section>
</div>
@endsection
