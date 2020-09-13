{{$data['user_name']}} 様

栗田クッキングサロン {{$data['room_name']}} です。
仮予約を受け付けましたので、ご連絡いたします。

--- 

予約番号: {{$data['reservation_id']}}
教　　室: {{$data['room_name']}}
場　　所: {{$data['room_address']}}
講　　師: {{$data['staff_name']}}先生
コース名: {{$data['course_name']}}
開催日時: {{$data['start']}}
料　　金: {{$data['tax_price']}}円(うち消費税額{{$data['tax']}}円)
支払状況: 未払

// 振込支払済/PayPal支払済/ポイント支払済/未払

---

◇ご請求金額

レッスン料(税込み): {{$data['tax_price']}}円(うち消費税額{{$data['tax']}}円)
入　会　金(税込み): 5,500円 (2回目のみ、うち消費税額500円)

多めにお振り込みいただいた場合は、ご請求金額分を除いた残り金額を1円=1ポイントとしてチャージいたします。
後日、レッスン料金等のお支払いにお使いください。

なお、6か月コースでお支払い済みの場合は、不要です。


◇お支払い方法

銀行振込またはPayPalによるお支払いができます。

・銀行振込

三井住友銀行　御影支店　普通　4706420　栗田クッキングサロン

なお、お振り込みの際は、振込コード(振込依頼人コード)として、予約番号({{$data['reservation_id']}})をご入力ください。
振込コードを入力できない場合は、お名前の前に予約番号をお付けください。
（例：{{$data['reservation_id']}}{{$data['user_kana']}}）
恐れ入りますが、振込手数料はご負担ください。


・ペイパルによるお支払い

下記のクレジットカード、もしくは銀行口座をお持ちの方なら、手数料なしにお支払いいただけます。

クレジットカード：VISA/マスターカード/JCB/アメリカンエクスプレス/ディスカバーカード
都市銀行：みずほ銀行/三井住友銀行/三菱UFJ銀行/ゆうちょ銀行/りそな銀行/埼玉りそな銀行

ペイパルボタンをご利用ください。

オンラインレッスン：https://www.kuritacooking.com/zoom/paypal/
その他レッスン    ：https://www.kuritacooking.com/real/paypal/


◇お支払い期限とご連絡

お支払いは、遅くてもレッスン日の2日前までにお願いいたします。

◇キャンセルとキャンセル料について

レッスン日の3日以上前でしたら、同月の他のレッスンに振り替えることができます。（コースが替わっても大丈夫です）

◇ご用意いただくもの

・エプロン
・ハンドタオル
・タッパー（お料理のお持ち帰りは自己責任でお願いいたします）

では、{{$data['start']}} に、材料を用意して、{{$data['room_name']}} でお待ちしております。
よろしくお願いいたしします。

----------------------------------------------
栗田クッキングサロン ホームページ管理者
URL：http://www.kuritacooking.com
e-mail：info@kuritacooking.com

〒658-0053
神戸市東灘区住吉宮町7-5-10-19
TEL&FAX:078-856-2583
---------------------------------------------- 