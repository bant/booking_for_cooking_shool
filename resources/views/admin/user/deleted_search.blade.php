@extends('layouts.admin.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('admin.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        生徒の復元
    </div>     
    <section>
    <h2>生徒の復元</h2>
    <h3>停止中の生徒一覧</h3>
    @if($users->count())
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>生徒名</th>
                    <th>住所</th>
                    <th>現ポイント</th>
                    <th class="text-right">オプション</th>
                </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="text-center"><strong>{{$user->id}}</strong></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->pref}}{{$user->address}}</td>
                    <td>{{number_format($user->point)}}pt</td>
                    <td class="text-right">
                        <a class="btn btn-sm btn-warning" href="{{route('admin.user.restore', $user->id)}}"><i class="fas fa-edit"></i> 生徒の復元</a>
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