@extends('layouts.staff.app')

@section('content')
<div id="content">
    <section>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> オンライン教室の登録</div>

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

                    <form action="{{ route('staff.zoom.store') }}" method="POST">
                        @csrf
                        <input class="form-control" type="hidden" name="staff_id" id="staff_id-field" value="{{ Auth::user()->id }}" />
                        <div class="form-group">
                            <label for="name-field">オンライン教室名</label>
                            <input class="form-control" type="text" name="name" id="name-field" value="{{old('name')}}" />
                        </div>
                        <div class="form-group">
                            <label for="description-field">詳細</label>
                            <textarea name="description" id="description-field" class="form-control" rows="3">{{old('description')}}</textarea>
                        </div>
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> 新規登録</button>
                            <a class="btn btn-link pull-right" href="{{ route('staff.zoom.index') }}"><i class="fas fa-backward"></i> 戻る</a>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection
