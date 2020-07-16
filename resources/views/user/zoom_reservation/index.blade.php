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


                      @if($staff->count())
                      <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th>担当先生</th>
                           <th class="text-right">オプション</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach ($staff as $teacher)
                        <tr>
                          <td>{{$teacher->name}}</td>
                          <td><a class="btn btn-link pull-right" href="zoom_reservation/{{$teacher->id}}/calendar"><i class="fas fa-backward"></i> 予約カレンダへ</a></td>
                        </tr>
                        @endforeach
                       </tbody>
                      </table>
                      @else
                        <h3 class="text-center alert alert-info">ZOOM教室がありません。</h3>
                      @endif
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
    </div>
</div>
@endsection
