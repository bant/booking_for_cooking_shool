@extends('layouts.user.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <!-- left menu -->
            
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><i class="fas fa-id-card"></i> </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif


                      <h3 class="text-center alert alert-info">教室がありません。</h3>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
    </div>
</div>
@endsection
