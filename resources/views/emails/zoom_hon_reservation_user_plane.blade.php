{{$data['user_name']}} 様

栗田クッキングサロン {{$data['zoom_name']}} です。
ご予約を受付ましたので、ご連絡いたします。

--- 

予約番号: {{$data['reservation_id']}}
教　　室: {{$data['zoom_name']}}
場　　所: {{$data['room_address']}}
講　　師: {{$data['staff_name']}}先生
コース名: {{$data['course_name']}}
開催日時: {{$data['start']}}
料　　金: {{$data['price']}}

---

◇参加方法
招待状に従ってZOOMにログインしてください。

---[招待状]---
{!! nl2br(e($data['zoom_invitation'])) !!}


◇ご用意いただくもの

・エプロン
・スマートフォン又はパソコン（画面が映るもの）
・レシピの材料（必要人数分ご用意ください）
・調理器具　他
・印刷したレシピ

では、{{$data['start']}} に、オンライン教室"{{$data['room_name']}}" でお待ちしております。
よろしくお願いいたしします。

----------------------------------------------
栗田クッキングサロン ホームページ管理者
URL：http://www.kuritacooking.com
e-mail：info@kuritacooking.com

〒658-0053
神戸市東灘区住吉宮町7丁目5-19-1
TEL&FAX:078-856-2583
---------------------------------------------- 