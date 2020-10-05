@extends('layouts.staff.app')

@section('content')
<div id="content">
    <section>
    <h3>生徒の検索</h3>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> 生徒の検索</div>
                <div class="card-body">
                    <form action="{{ route('staff.message.user_search') }}" method="POST">
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
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>&nbsp;検索</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr/>

            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> 検索結果</div>
                <div class="card-body">
                    @if(!is_null($users))
                      <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>生徒名</th>
                          <th>メール</th>
                          <th>住所</th>
                          <th class="text-right">アクション</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach($users as $user)
                        <tr>
                          <td class="text-center"><strong>{{$user->id}}</strong></td>
                          <td>{{$user->name}}</td>
                          <td>{{$user->email}}</td>
                          <td>{{$user->address}}</td>
                          <td class="text-right">
                            <a class="btn btn-sm btn-warning" href="{{route('staff.message.user_send', $user->id)}}"><i class="fas  fa-envelope"></i>&nbsp;メッセージ送信</a>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                      </table>
                    @else
                        <h3 class="text-center alert alert-info">該当する生徒はいません。</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection