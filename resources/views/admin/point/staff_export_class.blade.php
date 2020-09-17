<table>
  <thead>
  <tr>
    <th>予約番号</th>
    <th>先生氏名</th>
    <th>コース名</th>
    <th>価格(税込み)</th>
    <th>開始日時</th>
    <th>生徒ID</th>
    <th>生徒氏名</th>
    <th>生徒住所</th>
    <th>生徒Email</th>
    <th>生徒性別</th>
    <th>契約</th>
    <th>終了</th>
    <th>支払い方法</th>
    <th>支払ったポイント</th>
  </tr>
  </thead>
  <tbody>

  @if (is_null($reservation->user_deleted_at))
                <td><a href="{{ route('admin.user.info', ['id' => $zoom_reservation->user_id])}}">{{$zoom_reservation->user_name}}({{$zoom_reservation->user_id}})</a></td>
                @else
                <td>{{$zoom_reservation->user_name}}(停止)</td>
                @endif

  @foreach ($reservations as $reservation)
    <tr>
      <td>{{ $reservation->id }}</td>
      <td>{{ $staff->name }}</td>
      <td>{{ $reservation->course_name }}</td>
      <td>{{ $reservation->course_price * 1.1 }}</td>
      <td>{{ $reservation->start }}</td>
@if (is_null($reservation->user_deleted_at))
      <td>{{ $reservation->user_id }}</td>
      <td>{{ $reservation->user_name }}</td>
      <td>{{ $reservation->user_pref }}{{ $reservation->user_address }}</td>
      <td>{{ $reservation->user_email }}</td>
@else
      <td>--</td>
      <td>{{ $reservation->user_name }}(停止ユーザ)</td>
      <td>{{ $reservation->user_pref }}{{ $reservation->user_address }}</td>
      <td>{{ $reservation->user_email }}</td>
@endif
      @if ($reservation->user_gender=='male')
      <td>男性</td>
    @else
      <td>女性</td>
    @endif
    @if ($reservation->is_contract)
      <td>確</td>
    @else
      <td>仮</td>
    @endif
    @if (strtotime($reservation->start) > strtotime('now'))
      <td>未</td>
    @else
      <td>済</td>
    @endif
    @if ($reservation->is_pointpay)
      <td>ポイント払い</td>
    @else
      <td>ポイント以外</td>
    @endif
    <td>{{ $reservation->spent_point}}</td>
    </tr>
  @endforeach
  </tbody>
</table>