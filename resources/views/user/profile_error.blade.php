@extends('layouts.user.app')

@section('content')
<div id="content">
    <section>
        <h1>{{ Auth::user()->name }}さんのホーム</h1>
        <h2>プロファイルの登録のご案内</h2>
        <div class="text-center alert alert-info">
            お手数をお掛けしますが、プロフィールを登録してください。<br/>
            プロファイルは、<a href="{{ route('user.profile.edit') }}" title="ユーザプロフィール">こちら</a>から登録できます。
        </div>
    </section>
</div><!-- #content -->
@endsection