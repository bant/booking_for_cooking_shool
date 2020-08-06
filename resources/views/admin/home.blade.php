@extends('layouts.admin.app')

@section('content')
<div id="content">
    <section>
        <h2>管理者トップ</h2>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        You are logged in!
                        管理者
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
