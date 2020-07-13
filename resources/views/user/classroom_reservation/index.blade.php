@extends('layouts.user.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <!-- left menu -->
            @include('layouts.user.menu')
            
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><i class="fas fa-id-card"></i> ホーム作成中</div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif


                        @if($rooms->count())
                      <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">教室名</th>
                          <th>担当先生</th>
                          <th>住所</th>
                           <th class="text-right">オプション</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach ($rooms as $room)
                        <tr>
                          <td>{{$room->name}}</td>
                          <td>{{$room->staff->name}}</td>
                          <td>{{$room->address}}</td>
                          <td><a class="btn btn-link pull-right" href="classroom_reservation/{{$room->staff->id}}/calendar"><i class="fas fa-backward"></i> 予約カレンダへ</a></td>
                        </tr>
                        @endforeach
                       </tbody>
                      </table>
                      @else
                        <h3 class="text-center alert alert-info">教室がありません。</h3>
                        <a href="/user/schedule/create"><button type="submit" class="btn btn btn-warning"><i class="fas fa-edit"></i> 登録</button></a>をクリックしてスケジュールを登録してください。
                      @endif
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
    </div>
</div>
@endsection
