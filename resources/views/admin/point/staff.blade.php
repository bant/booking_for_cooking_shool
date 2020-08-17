@extends('layouts.admin.app')

@section('content')
<div id="content">
    <section>
    <h3>生徒の検索</h3>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify"></i> 先生一覧</div>
                <div class="card-body">
                    @if(!is_null($staff))
                      <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>先生名</th>
                          <th>教室名</th>
                          <th class="text-right">オプション</th>
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
                        <h3 class="text-center alert alert-info">該当する先生はいません</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection