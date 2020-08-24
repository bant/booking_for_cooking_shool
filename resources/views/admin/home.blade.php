@extends('layouts.admin.app')

@section('content')
<div id="content"> 
    <div id="breadcrumbs">
        <a  href="{{route('admin.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        生徒の確認
    </div>  
    <section>
    <h1>管理者のダッシュボード</h1>

    <h2>生徒の確認</h2>
        <h3>生徒の状況(過去1年)</h3>
        <table class="table table-sm table-striped">
            <thead>
            <tr>
                <th>年月</th>            
                <th>新規生徒数</th>
                <th>停止生徒数</th>
                <th>総生徒数</th>
            </tr>
        </thead>

        <tbody>
        @foreach($count_datas as $count_data)
            <tr>
                <td>{{ date('Y年m月', strtotime($count_data['first_month_day'])) }}</td>
                <td>{{ $count_data['add_count']}}</td>
                <td>{{ $count_data['stop_count']}}</td>
                <td>{{ $count_data['all_count']}}</td>
            </tr>
        @endforeach
        </tbody>
        </table>

        <h3>生徒の一覧出力</h3>
            <a class="btn btn-sm btn-danger" href="{{route('admin.user.export_users')}}"><i class="fas fa-edit"></i> 生徒一覧ダウンロード</a>
    </section>
</div>
@endsection
