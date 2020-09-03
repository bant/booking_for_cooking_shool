@extends('layouts.admin.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('admin.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        生徒のポイントの追加/修正
    </div>  

    <section>
    <h1>生徒のポイントの追加/修正</h1>
    <h2>生徒の検索</h2>
    <form action="{{ route('admin.point.user') }}" method="POST">
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
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>検索</button>
        </div>
    </form>
    <br/>

    <h2>予約番号による検索</h2>
    <form action="{{ route('admin.point.reservation_search') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="reservation_id-field">予約番号</label>
            <input class="form-control" type="text" name="reservation_id" id="reservation_id-field" value="{{old('reservation_id')}}" />
        </div>
        <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>検索</button>
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
                    <th class="text-right">アクション</th>
                </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="text-center"><strong>{{$user->id}}</strong></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->pref}}{{$user->address}}</td>
                    <td>{{number_format($user->point)}}pt</td>
                    <td class="text-right">
                        <a class="btn btn-sm btn-warning" href="{{route('admin.point.user_edit', $user->id)}}"><i class="fas fa-edit"></i> ポイントの追加</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center alert alert-info">該当する生徒はいません。</div>
    @endif
    <br/>
    </section>
</div>
@endsection