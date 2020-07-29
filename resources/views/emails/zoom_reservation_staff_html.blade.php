{{$data['user_name']}} 様からZOOM教室のご予約がありました。<br/>
<br/>
{{$data['action']}}<br/>
<br/>
予約番号: {{$data['reservation_id']}}<br/>
回　　数: {{$data['times']}}<br/>
コース名: {{$data['course_name']}}<br/>
生徒氏名: {{$data['user_name']}}({{$data['user_email']}})<br/>
開催日時: {{$data['start']}}<br/>
費　　用: {{$data['price']}}<br/>
<br/>
------------------------------------------------------------------<br/>
{!! nl2br(e($data['zoom_invitation'])) !!}