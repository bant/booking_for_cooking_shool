@extends('layouts.user.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- left menu -->
            @include('layouts.user.menu')

            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> 教室一覧</div>

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

                    @if($staff->count())
                      <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">担当先生</th>
                          <th>教室名</th>
                          <th>住所</th>
                           <th class="text-right">オプション</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach ($staff as $teacher)
                        <tr>
                          <td>{{$teacher->name}}</td>
                          <td>{{$teacher->room->name}}</td>
                          <td>{{$teacher->room->address}}</td>
                          <td><a class="btn btn-link pull-right" href="/user/ClassroomSchedule/calendar/{{$teacher->id}}"><i class="fas fa-backward"></i> 予約カレンダへ</a></td>
                        </tr>
                        @endforeach
                       </tbody>


                      </table>
                      <a class="btn btn-primary" href=""><i class="fas fa-edit"></i> 追加</a>

                      @else
                        <h3 class="text-center alert alert-info">教室がありません。</h3>
                        <a href="/user/schedule/create"><button type="submit" class="btn btn btn-warning"><i class="fas fa-edit"></i> 登録</button></a>をクリックしてスケジュールを登録してください。
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
