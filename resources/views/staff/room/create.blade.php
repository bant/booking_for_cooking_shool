@extends('layouts.staff.app')

@section('content')
<div id="content">
    <section>
    <h3>教室の作成</h3>
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

                <form action="{{ route('staff.room.store') }}" method="POST">
                    @csrf
                    <input class="form-control" type="hidden" name="staff_id" id="staff_id-field" value="{{ Auth::user()->id }}" />
                    <div class="form-group">
                        <label for="name-field">教室名</label>
                        <input class="form-control" type="text" name="name" id="name-field" value="{{old('name')}}" />
                    </div>
                    <div class="form-group">
                        <label for="address-field">住所</label>
                        <textarea name="address" id="address-field" class="form-control" rows="3">{{old('address')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="tel-field">電話番号</label>
                        <input class="form-control" type="tel" name="tel" id="tel-field" value="{{old('tel')}}" />
                    </div>
                    <div class="form-group">
                        <label for="description-field">詳細</label>
                        <textarea name="description" id="description-field" class="form-control" rows="3">{{old('description')}}</textarea>
                    </div>
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;新規登録</button>
                        <a class="btn btn-link pull-right" href="{{ route('staff.room.index') }}"><i class="fas fa-backward"></i> 戻る</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection
