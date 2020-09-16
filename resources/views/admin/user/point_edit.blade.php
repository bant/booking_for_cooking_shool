@extends('layouts.admin.app')

@section('content')
<div id="content">
    <section>
    <h3>生徒のポイントの追加</h3>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> 生徒の詳細</div>
                <div class="card-body">
                    {{-- ユーザー1件の情報 --}}
                    <dl class="row">
                        <dt class="col-md-2">{{ __('ID') }}</dt>
                            <dd class="col-md-10">{{ $user->id }}</dd>
                        <dt class="col-md-2">{{ __('Name') }}</dt>
                            <dd class="col-md-10">{{ $user->name }}</dd>
                        <dt class="col-md-2">{{ __('E-Mail Address') }}</dt>
                            <dd class="col-md-10">{{ $user->email }}</dd>
                        <dt class="col-md-2">住所</dt>
                            <dd class="col-md-10">{{ $user->address }}</dd>
                        <dt class="col-md-2">ポイント</dt>
                            <dd class="col-md-10">{{number_format($user->point)}}pt</dd>
                    </dl>
                </div>
                
                </div>
                <br/>
                <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> ポイント追加/編集履歴(過去20件)</div>
                <div class="card-body">
                    <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>日付</th>
                          <th>生徒名</th>
                          <th>住所</th>
                          <th>ポイント</th>
                          <th>摘要</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach($payments as $payment)
                        <tr>
                          <td class="text-center"><strong>{{$payment->id}}</strong></td>
                          <td>{{$payment->created_at}}</td>                             
                          <td>{{$payment->user->name}}</td>
                          <td>{{$payment->user->address}}</td>
                           <td>{{number_format($payment->point)}}pt</td>
                           <td>{{$payment->description->name}}</td>

                        </tr>
                      @endforeach
                      </tbody>
                      </table>
                    </div>
                </div>

                <br/>
                <div class="card">
                    <div class="card-header"><i class="fas fa-align-justify"></i> ポイント追加/修正</div>
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
                        <form action="{{ route('admin.user.point_update', $user->id) }}" method="POST">
                        @csrf
                            <div class="form-group">
                                <label for="name-field">追加ポイント(訂正の場合はマイナス値を入力)</label>
                                <input class="form-control" type="number" name="point" id="point-field" value="" />
                            </div>
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
                            <div class="well well-sm">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;ポイント追加/削除</button>
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