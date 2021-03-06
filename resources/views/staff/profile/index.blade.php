@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
            教室設定の確認
    </div>  
    <section>
    <h1>{{ Auth::user()->name }}先生のダッシュボード</h1>
    <h2>教室設定の確認</h>

    </section>
</div>

<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-2">
        <!-- left menu -->
        @include('layouts.staff.menu')

        <div class="col-md-8">
            <div class="card">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> プロフィールの修正</div>

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


                    ToDo <br/>
                    鋭意作成中
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
