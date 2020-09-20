@extends('layouts.admin.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('admin.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        生徒の停止
    </div>      
    <section>
    <h1>生徒の停止</h1>
    <h2>生徒の検索</h2>
    <form action="{{ route('admin.user.search') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_id-field">生徒IDで検索</label>
            <input class="form-control" type="text" name="user_id" id="user_id-field" value="{{old('user_id')}}" />
        </div>
        <div class="form-group">
            <label for="name-field">生徒名(一部でも可)で検索</label>
            <input class="form-control" type="text" name="name" id="name-field" value="{{old('name')}}" />
        </div>
        <div class="form-group">
            <label for="address-field">住所(一部でも可)で検索</label>
            <textarea name="address" id="address-field" class="form-control" rows="3">{{old('address')}}</textarea>
        </div>

        <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;検索</button>
        </div>
    </form>

    <br/>
    <h2>検索結果</h2>
    @if(!is_null($users))
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
                <td><a href="{{route('admin.user.info',$user->id)}}">{{$user->name}}</a></td>
                <td>{{$user->email}}</td>
                <td>{{$user->prof}}{{$user->address}}</td>
                <td>{{number_format($user->point)}}pt</td>
                <td>{{number_format($user->reservations()->count())}}回</td>
                <td class="text-right">
                    @if ($user->reservations()->count()==0)
                    <form action="{{route('admin.user.force_destroy', ['id'=>$user->id])}}" method="POST" style="display: inline;"
                                 onsubmit="return confirm('{{$user->name}}さんを削除しても良いですか!?\n【注意】{{$user->name}}さんは復元できません');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-pause"></i>&ensp;生徒の削除</button>
                    </form>
                    @endif
                    <form action="{{route('admin.user.destroy', ['id'=>$user->id])}}" method="POST" style="display: inline;"
                                 onsubmit="return confirm('{{$user->name}}さんを停止しても良いですか!?\n【注意】{{$user->name}}さんは復元できます');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-pause"></i>&ensp;生徒の停止</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <div class="text-center alert alert-info">該当する生徒はいません。</div>
    @endif
</section>
</div>
@endsection