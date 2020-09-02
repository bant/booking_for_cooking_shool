@extends('layouts.admin.app')

@section('content')
<div id="content"> 
    <div id="breadcrumbs">
        <i class="fas fa-home"></i> トップページ
    </div>  
    <section>
    <h1>管理者のダッシュボード</h1>

    <h2>先生からのメッセージ</h2>
            @if($staff_messages->count())
            <table class="table table-sm table-striped">
            <thead>
            <tr>
                <th width="120">先生</th>
                <th >メッセージ</th>
                <th width="250">表示期限</th>
                <th width="180">アクション</th>
            </tr>
        </thead>

        <tbody>
        @foreach($staff_messages as $staff_message)
            <tr>
                <td>{{$staff_message->staff->name}}</td>
                <td>{{$staff_message->message}}</td>
                <td>{{ date('Y年m月d日 H時i分', strtotime($staff_message->expired_at))}}</td>
                <td><a class="float-right btn btn-sm btn-warning" href=""> 返信</a> 
                    <a class="float-right btn btn-sm btn-danger" href="{{route('admin.message.delete_staff_message',$staff_message->id)}}"> <i class="fas fa-trash">メッセージの削除</a></td>                             
            </tr>
        @endforeach
        </tbody>
        </table>
        @else
        <div class="text-center alert alert-info">
            先生からのメッセージはありません。
        </div>
        @endif

    </section>
</div>
@endsection
