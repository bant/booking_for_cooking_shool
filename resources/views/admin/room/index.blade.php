@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-align-justify">
                </i>教室一覧</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($rooms->count())
                    <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>教室名</th>
                            <th>先生</th>
                            <th>場所</th>
                            <th>記述</th>
                             <th class="text-right">操作</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td class="text-center"><strong>{{$room->id}}</strong></td>
                            <td>{{$room->name}}</td>
                            <td>{{$room->owner->name}}</td>
                            <td>{{$room->location}}</td>
                            <td>{{$room->description}}</td>
   
          <td class="text-right">
            <a class="btn btn-sm btn-primary" href="">
              <i class="fas fa-eye"></i> View
            </a>
            <a class="btn btn-sm btn-warning" href="">
              <i class="fas fa-edit"></i> Edit
            </a>
            <form action="" method="POST" style="display: inline;"
              onsubmit="return confirm('Delete? Are you sure?');">
              @csrf
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i> Delete
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {!! $rooms->render() !!}
    @else
    <h3 class="text-center alert alert-info">Empty!</h3>
    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

