@extends('layouts.staff.app')

@section('content')
<div id="content">
  <section>
    <h3>メール</h3>
    @if($messages->count())
      <table class="table table-sm table-striped">
      <thead>
        <tr>
          <th class="text-center">#</th>
          <th>生徒</th>
          <th>先生</th>
          <th>管理者</th>
          <th class="text-right">オプション</th>
        </tr>
      </thead>
      <tbody>
      @foreach($messages as $message)
        <tr>
          <td>{{$message->message}}</td>
          <td class="text-right">---</td>
        </tr>
      @endforeach
      </tbody>
      </table>
      <a class="btn btn-sm btn-warning" href="{{ route('staff.reservation.export_zoom', $now_first_month_day) }}"><i class="fas fa-edit"></i> execelファイルでダウンロード</a>
    @else
      <div class="text-center alert alert-info">オンライン教室の予約はありません。</div>
    @endif

</section>
</div>
@endsection
