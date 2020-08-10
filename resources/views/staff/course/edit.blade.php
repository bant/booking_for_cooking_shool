@extends('layouts.staff.app')

@section('content')
<div id="content">
  <section>
    <h2>コース一覧</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> コース編集</div>

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

                    <form action="{{ route('staff.course.update', $course->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input class="form-control" type="hidden" name="staff_id" id="staff_id-field" value="{{ Auth::user()->id }}" />
                        <div class="form-group">
                            <label for="name-field">コース名</label>
                            <input class="form-control" type="text" name="name" id="name-field" value="{{$course->name}}" />
                        </div>
                        <div class="form-group">
                            <label for="price-field">価格</label>
                            <input class="form-control" type="price" name="price" id="price-field" value="{{$course->price}}" />
                        </div>
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>データ更新</button>
                            <a class="btn btn-link pull-right" href="{{ route('staff.course.index') }}"><i class="fas fa-backward"></i> 戻る</a>
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
