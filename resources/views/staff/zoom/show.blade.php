@extends('layouts.staff.app')

@section('content')
<div id="content">
    <section>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> オンライン教室情報</div>

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

                    <div class="form-group">
                        <label for="name-field">教室名</label>
                        <input class="form-control" type="text" name="name" id="name-field" value="{{$zoom->name}}"  readonly/>
                    </div>
                    <div class="form-group">
                        <label for="description-field">詳細</label>
                        <input class="form-control" type="text" name="description" id="description-field" value="{{$zoom->description}}" readonly/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection
