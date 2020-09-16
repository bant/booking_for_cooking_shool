@extends('layouts.admin.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('admin.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        <a  href="{{route('admin.point.user')}}">生徒のポイントの追加/修正</a> >
        生徒のポイントの追加
    </div>  
    <section>
    <h1>生徒のポイントの追加</h1>
    <h2>生徒の詳細</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> {{ $user->name  }}さんの詳細</div>
                <div class="card-body">
                    {{-- ユーザー1件の情報 --}}

                    <dl class="row">
                        <dt class="col-md-2">{{ __('ID') }}</dt>
                            <dd class="col-md-10">{{ $user->id }}</dd>
                        <dt class="col-md-2">{{ __('Name') }}</dt>
                            <dd class="col-md-10">{{ $user->name }}</dd>
                        <dt class="col-md-2">{{ __('E-Mail Address') }}</dt>
                            <dd class="col-md-10">{{ $user->email }}</dd>
                        <dt class="col-md-2">郵便番号</dt>
                            <dd class="col-md-10">{{ $user->zip_code }}</dd>
                        <dt class="col-md-2">住所</dt>
                            <dd class="col-md-10">{{ $user->pref }}{{ $user->address }}</dd>
                        <dt class="col-md-2">電話</dt>
                            <dd class="col-md-10">{{ $user->tel }}</dd>
                        <dt class="col-md-2">誕生日</dt>
                            <dd class="col-md-10">{{ $user->birthday }}</dd>
                        <dt class="col-md-2">性別</dt>
                        @if ($user->gender=='male')
                            <dd class="col-md-10">男</dd>
                        @else
                            <dd class="col-md-10">女</dd>
                        @endif
                        <dt class="col-md-2">ポイント</dt>
                            <dd class="col-md-10">{{number_format($user->point)}}pt</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <br/>
    <h2>ポイント追加/編集履歴(過去20件)</h2>
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>ポイント</th>
                <th>生徒名</th>
                <th>住所</th>
                <th>入金等日付</th>
                <th>摘要</th>
            </tr>
        </thead>

        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td class="text-center"><strong>{{$payment->id}}</strong></td>
                <td>{{number_format($payment->point)}}pt</td>
                <td>{{$payment->user->name}}</td>
                <td>{{$payment->user->pref}}{{$payment->user->address}}</td>
                <td>{{ date('Y年m月d日 H時i分', strtotime($payment->created_at)) }}</td>
                <td>{{$payment->description->name}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <br/>
    <h2>ポイント追加/修正</h2>

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
    
    <form action="{{ route('admin.point.user_update', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name-field">追加ポイント(訂正の場合はマイナス値を入力)</label>
            <input class="form-control" type="number" name="point" id="point-field" value="" />
        </div>
        <div class="form-group">
            <label for="title-field">摘要(訂正の場合は訂正を選択)</label>
            <select type="text" class="form-control" name="description_id">                          
                @foreach($payment_descriptions as $description)
                <option value="{{ $description->id }}" 
                    @if ( $description->id ===  1) 
                        selected
                    @endif                          
                    >{{ $description->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;ポイント追加/削除</button>
        </div>
    </form>
    </section>
</div>
@endsection