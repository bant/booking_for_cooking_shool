@extends('layouts.admin.app')

@section('content')
<div id="content">
    <section>
    <h3>生徒の検索</h3>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> 生徒の検索</div>
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

                    <form action="{{ route('admin.user.search') }}" method="POST">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                            <label for="user_id-field">生徒ID</label>
                            <input class="form-control" type="text" name="user_id" id="user_id-field" value="" />
                        </div>
                        <div class="form-group">
                            <label for="name-field">生徒名(一部でも可)</label>
                            <input class="form-control" type="text" name="name" id="name-field" value="" />
                        </div>
                        <div class="form-group">
                            <label for="address-field">住所(一部でも可)</label>
                            <textarea name="address" id="address-field" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>検索</button>
                            <a class="btn btn-link pull-right" href="{{ route('staff.zoom.index') }}"><i class="fas fa-backward"></i> 詳細へ戻る</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection