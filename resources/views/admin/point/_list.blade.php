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

    </div>
</section>
</div>
@endsection