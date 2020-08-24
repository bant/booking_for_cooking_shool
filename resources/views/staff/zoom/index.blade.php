@extends('layouts.staff.app')

@section('content')
<div id="content">
    <section>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> オンライン教室の詳細</div>

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


                    @if(isset($zoom))
                    <div class="form-group">
                        <label for="name-field">教室名</label>
                        <input class="form-control" type="text" name="name" id="name-field" value="{{$zoom->name}}"  readonly/>
                    </div>
                    <div class="form-group">
                        <label for="description-field">詳細</label>
                        <textarea name="description" id="description-field" class="form-control" rows="3"  readonly>{{$zoom->description}}</textarea>
                    </div>
                    <div class="well well-sm">
                            <a class="btn btn-primary" href="/staff/zoom/{{$zoom->id}}/edit"><i class="fas fa-edit"></i> 編集</a>
                        </div>
                    @else
                        <h3 class="text-center alert alert-info">オンライン教室が未登録です。</h3>
                        <a href="/staff/zoom/create"><button type="submit" class="btn btn btn-warning"><i class="fas fa-edit"></i> 登録</button></a>をクリックして教室を登録してください。
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection
