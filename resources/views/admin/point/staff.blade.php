@extends('layouts.admin.app')

@section('content')
<div id="content">
    <div id="breadcrumbs">
        <a  href="{{route('admin.home.index')}}"><i class="fas fa-home"></i> トップページ</a>  >
        先生の月間獲得ポイント確認(先生の一覧)
    </div>  
    <section>
    <h1>先生の月間獲得ポイント確認</h1>
    <h2>先生の一覧</h2>
  @if(!is_null($staff))
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>先生名</th>
                <th>教室名</th>
                <th class="text-right">アクション</th>
            </tr>
        </thead>

        <tbody>
        @foreach($staff as $teacher)
          <tr>
            <td class="text-center"><strong>{{$teacher->id}}</strong></td>
            <td>{{$teacher->name}}</td>
            <td>{{$teacher->room->name}}</td>
            <td class="text-right">
              <a class="btn btn-sm btn-warning" href="{{route('admin.point.staff_check', $teacher->id)}}"><i class="fas fa-edit"></i> 獲得ポイントの確認</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <div class="text-center alert alert-info">該当する先生はいません</div>
  @endif
</section>
</div>
@endsection