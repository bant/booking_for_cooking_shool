@extends('layouts.user.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

        <h2>スターターコース</h2>



        <!-- 先生のカレンダ用スロット始まり -->
            <div class="card">
                <div class="card-header justify-content-left"><i class="fas fa-id-card"></i> ルート</div>
                <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif




                ToDo リスト<br/>
                        ・これからの予約情報の表示<br/>
                        ・etc
                </div>


            </div><!-- end card -->
        </div>
    </div>
</div>
@endsection