@extends('layouts.admin.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('admin.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        生徒の月間ポイント確認(生徒の検索)
    </div>  
    <section>
    <h1>追加ポイントの確認</h1>
    <h2>{{date('Y年m月', strtotime($now_first_month_day)) }}に生徒に追加したポイント
        <a class="float-right btn btn-sm btn-primary" href="{{ route('admin.point.check_show', ['date' => $next_first_month_day])}}"> 次月 >></a>
        <a class="float-right btn btn-sm btn-primary" href="{{ route('admin.point.check_show', ['date' => $previous_first_month_day])}}"> << 前月</a>
    </h2>

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

    @if($payments->count())
        @php
           $sum_of_point = 0;
        @endphp
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">入金日付</th>
                    <th class="text-center">生徒氏名(ID)</th>
                    <th class="text-center">住所</th>
                    <th class="text-center">ポイント</th>
                    <th class="text-center">摘要</th>
                </tr>
            </thead>

            <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td class="text-center"><strong>{{$payment->id}}</strong></td>
                    <td>{{ date('Y年m月d日 H時i分', strtotime($payment->created_at)) }}</td>
                @if (is_null($payment->user))
                    <td>停止ユーザ({{$payment->user_id}})</td>
                    <td>---</td>
                @else
                    <td>{{$payment->user->name}}({{$payment->user->id}})</td>
                    <td>{{$payment->user->pref}}{{$payment->user->address}}</td>
                @endif
                    <td class="text-right">{{number_format($payment->point)}}pt</td>
                    <td class="text-center">{{$payment->description->name}}</td>
                </tr>
                @php
                    $sum_of_point = $sum_of_point + $payment->point;
                @endphp
            @endforeach
                <tr>
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>                             
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>
                    <td class="text-right">{{number_format($sum_of_point)}}pt</td>
                    <td class="text-center">-</td>
                </tr>
            </tbody>
        </table>
        <a class="float-right btn btn-sm btn-warning" href="{{ route('admin.point.export_point', ['date' => $now_first_month_day])}}"><i class="fas fa-edit"></i> execelファイルでダウンロード</a>
    @else
         <div class="text-center alert alert-info">ポイントの追加はありません</div>
    @endif
    <br/>
</section>
</div>
@endsection