{{$data['user_name']}} 様 ZOOM教室のご予約ありがとうございます。<br/>
<br/>
{{$data['action']}}<br/>
<br/>
予約番号: {{$data['reservation_id']}}<br/>
回　　数: {{$data['times']}}<br/>
コース名: {{$data['course_name']}}<br/>
担当先生: {{$data['staff_name']}}<br/>
開催日時: {{$data['start']}}<br/>
費　　用: {{$data['price']}}<br/>

------------------------------------------------------------------<br/>
{!! nl2br(e($data['zoom_invitation'])) !!}