@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        管理者さんへメッセージの送信
    </div>  
    <section>
    <h1>管理者さんへメッセージ送信</h1>
    <h2>メッセージ作成</h2>

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

    <form action="{{route('staff.message.admin_send')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="message-field">メッセージ</label>
            <textarea name="message" id="message-field" class="form-control" rows="3"></textarea>
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="fas fa-envelope"></i> 送信</button>
        </div>
    </form>
</section>
</div>
@endsection
