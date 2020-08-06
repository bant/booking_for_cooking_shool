@extends('layouts.staff.app')

@section('content')
<div id="content">
  <section>
    <h2>コース一覧</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> {{ Auth::user()->name }}先生ののコース詳細</div>
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

                    @if($courses->count())
                      <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>名称</th>
                          <th>単価</th>
                          <th class="text-right">オプション</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach($courses as $course)
                        <tr>
                          <td class="text-center"><strong>{{$course->id}}</strong></td>
                          <td>{{$course->name}}</td>
                          <td>{{number_format($course->price)}}円</td>
                          <td class="text-right">
                            <a class="btn btn-sm btn-warning" href="{{ route('staff.course.edit', $course->id) }}"><i class="fas fa-edit"></i> 編集</a>
                            <form action="{{ route('staff.course.destroy', $course->id) }}" method="POST" style="display: inline;"
                                onsubmit="return confirm('削除しても良いですか?');">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> 削除</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                      </table>
                      <a class="btn btn-primary" href="{{ route('staff.course.create') }}"><i class="fas fa-edit"></i> 追加</a>

                    @else
                        <h3 class="text-center alert alert-info">コース情報が未登録です。</h3>
                        <a href="{{ route('staff.course.create') }}"><button type="submit" class="btn btn btn-warning"><i class="fas fa-edit"></i> 登録</button></a>をクリックしてスケジュールを登録してください。
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection
