@extends('layouts.user.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- left menu -->
            @include('layouts.user.menu')

            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> {{ Auth::user()->name }}さんのスケジュール</div>

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

                    @if($reservations->count())
                      <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">担当先生</th>
                          <th>タイトル</th>
                          <th>詳細</th>
                          <th>日時</th>
                           <th class="text-right">オプション</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach($reservations as $reservation)
                        <tr>
                          <td class="text-center"><strong>{{$reservation->name}}</strong></td>
                          <td>{{$reservation->title}}</td>
                          <td>{{$reservation->description}}</td>
                          <td>{{$reservation->start}}</td>
                          <td class="text-right">
                            <a class="btn btn-sm btn-warning" href="{{ route('staff.schedule.edit', $reservation->id) }}"><i class="fas fa-edit"></i> 編集</a>
                            <form action="{{ route('staff.schedule.destroy', $reservation->id) }}" method="POST" style="display: inline;"
                                onsubmit="return confirm('削除しても良いですか?');">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> 削除</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                      </table>
                      <a class="btn btn-primary" href="{{ route('staff.schedule.create') }}"><i class="fas fa-edit"></i> 追加</a>

                    @else
                        <h3 class="text-center alert alert-info">スケジュールが未登録です。</h3>
                        <a href="/staff/schedule/create"><button type="submit" class="btn btn btn-warning"><i class="fas fa-edit"></i> 登録</button></a>をクリックしてスケジュールを登録してください。
                    @endif

                    You are logged in!
                    ユーザ
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
