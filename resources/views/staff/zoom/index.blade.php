@extends('layouts.staff.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('staff.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
            オンライン教室設定
    </div>  

    <section>
    <h1>オンライン教室の設定</h1>
    <h2>オンライン教室の確認</h2>
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

    @if(isset($zoom))
        <div class="form-group">
            <label for="name-field">教室名</label>
            <input class="form-control" type="text" name="name" id="name-field" value="{{$zoom->name}}"  readonly/>
        </div>
        <div class="form-group">
            <label for="description-field">サロン名</label>
            <input class="form-control" type="text" name="description" id="description-field" value="{{$room->description}}" readonly/>
        </div>
        <div class="well well-sm">
            <a class="btn btn-primary" href="{{route('staff.zoom.edit',$zoom->id)}}"><i class="fas fa-edit"></i> 編集</a>
            <form action="{{ route('staff.zoom.destroy', $zoom->id) }}" method="POST" style="display: inline;"
                        onsubmit="return confirm('削除するとオンライン教室は閉鎖になります。');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> 削除</button>
            </form>
        </div>
        オンライン教室を閉鎖する場合は、削除をクリックしてください。
    @else
        <div class="text-center alert alert-info">オンライン教室が未登録です。</div>
        オンライン教室を開催する場合は、     
        <a href="{{route('staff.zoom.create')}}"><button type="submit" class="btn btn btn-warning"><i class="fas fa-edit"></i> 登録</button></a>をクリックしてください。<br/>
        開催しない場合は、未登録の状態にしてください。
    @endif

    </section>
</div>
@endsection
