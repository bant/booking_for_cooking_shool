@extends('layouts.staff.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- left menu -->
        @include('layouts.staff.menu')

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> {{ Auth::user()->name }}先生の教室情報</div>

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


                    <div class="form-group">
                        <label for="name-field">教室名</label>
                        <input class="form-control" type="text" name="name" id="name-field" value="{{$room->name}}"  readonly/>
                    </div>
                    <div class="form-group">
                        <label for="address-field">住所</label>
                        <textarea name="address" id="address-field" class="form-control" rows="3"  readonly>{{$room->address}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="tel-field">電話番号</label>
                        <input class="form-control" type="tel" name="tel" id="tel-field" value="{{$room->tel}}"  readonly/>
                    </div>
                    <div class="form-group">
                        <label for="description-field">詳細</label>
                        <textarea name="description" id="description-field" class="form-control" rows="3"  readonly>{{$room->description}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
