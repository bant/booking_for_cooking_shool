@extends('layouts.staff.app')

@section('content')
<div id="content">
    <section>
    <h3>{{Auth::user()->room->name}}の生徒さんへメッセージ送信</h3>

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

    <form action="{{route('staff.message.class_user_send')}}" method="POST">
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
