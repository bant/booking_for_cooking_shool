{{$data['staff_name']}} 先生

{{$data['user_name']}} 様から {{$data['course_name']}} ({{$data['start']}})の予約があり、確定しました。

--- 

予約番号: {{$data['reservation_id']}}
教　　室: {{$data['room_name']}}
コース名: {{$data['course_name']}}
開催日時: {{$data['start']}}
料　　金: {{$data['tax_price']}}(うち消費税額{{$data['tax']}})
支払状況: 支払済
生徒ＩＤ: {{$data['user_id']}}
生徒氏名: {{$data['user_name']}}({{$data['user_email']}})
生徒住所: {{$data['user_address']}}
生徒電話: {{$data['user_tel']}}
受講回数: {{$data['times']}}