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



                        ToDo リスト<br/>
                        ・これからの予約情報の表示<br/>
                        ・etc

                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
    </div>
</div>
@endsection
