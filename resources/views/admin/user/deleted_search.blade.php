@extends('layouts.admin.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('admin.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        生徒の復元
    </div>     
    <section>
    <h1>生徒の復元</h1>
    <h2>停止中の生徒一覧</h2>
    @if($users->count())
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>生徒名</th>
                    <th>Email</th>
                    <th>住所</th>
                    <th>現ポイント</th>
                    <th>参加回数</th>
                    <th class="text-right">アクション</th>
                </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="text-center"><strong>{{$user->id}}</strong></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->prof}}{{$user->address}}</td>
                    <td>{{number_format($user->point)}}pt</td>
                    <td>{{number_format($user->reservations()->count())}}回</td>
                    <td class="text-right">
                        <a class="btn btn-sm btn-warning" href="{{route('admin.user.restore', $user->id)}}"><i class="fas fa-window-restore"></i> 生徒の復元</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center alert alert-info">停止中の生徒はいません</div>
    @endif

</section>
</div>
@endsection