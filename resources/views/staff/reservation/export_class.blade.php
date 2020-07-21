<table>
  <thead>
  <tr>
    <th>{{ __('id') }}</th>
    <th>{{ __('is_pointpay') }}</th>
    <th>{{ __('user_id') }}</th>
    <th>{{ __('user_name') }}</th>
    <th>{{ __('course_name') }}</th>
    <th>{{ __('course_price') }}</th>
    <th>{{ __('start') }}</th>
  </tr>
  </thead>
  <tbody>
  @foreach ($reservations as $reservation)
    <tr>
      <td>{{ $reservation->id }}</td>
      <td>{{ $reservation->is_pointpay }}</td>
      <td>{{ $reservation->user_id }}</td>
      <td>{{ $reservation->user_name }}</td>
      <td>{{ $reservation->course_name }}</td>
      <td>{{ $reservation->course_price }}</td>
      <td>{{ $reservation->start }}</td>
    </tr>
  @endforeach
  </tbody>
</table>