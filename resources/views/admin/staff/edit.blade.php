@extends('layouts.admin.app')

@section('content')
<div id="content">
    <section>
    <h3>教室の詳細</h3>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> {{ Auth::user()->name }}先生の教室の詳細</div>
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
                    <form action="{{ route('admin.staff.store') }}" method="POST">
                    @csrf
                        <div class="form-group">
                            <label for="name-field">先生名</label>
                            <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name') }}" />
                        </div>
                        <div class="form-group">
                            <label for="email-field">Eメール</label>
                            <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email') }}" />
                        </div>
                        <div class="form-group">
                            <label for="password-field">パスワード</label>
                            <input class="form-control" type="text" name="password" id="password-field" value="{{ old('password') }}" />
                        </div>

                        <div class="form-group">
                            <label for="is_zoom-field">オンライン教室</label>
                                <input type="radio" name="is_zoom" value="0">開催する
                                <input type="radio" name="is_zoom" value="1">開催しない
                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>先生登録</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
