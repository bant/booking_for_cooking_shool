<table>
  <thead>
  <tr>
    <th>予約番号</th>
    <th>支払い方法</th>
    <th>生徒ID</th>
    <th>生徒名</th>
    <th>コース名</th>
    <th>価格(税込み)</th>
    <th>開始時刻</th>
    <th>終了時刻</th>
  </tr>
  </thead>
  <tbody>
  @foreach ($reservations as $reservation)
    <tr>
      <td>{{ $reservation->id }}</td>
      @if ($reservation->is_pointpay == 1)
        <td>ポイント払い</td>
      @else
        <td>ポイント以外</td>
      @endif
      <td>{{ $reservation->user_id }}</td>
      <td>{{ $reservation->user_name }}</td>
      <td>{{ $reservation->course_name }}</td>
      <td>{{ $reservation->course_price * 1.1 }}</td>
      <td>{{ $reservation->start }}</td>
      <td>{{ $reservation->end }}</td>
    </tr>
  @endforeach
  </tbody>
</table>