<table>
    <thead>
        <tr>
            <th>#</th>
            <th>氏名</th>
            <th>読みかな</th>
            <th>Email</th>
            <th>郵便番号</th>
            <th>住所</th>
            <th>電話</th>
            <th>誕生日</th>
            <th>性別</th>
            <th>現ポイント</th>
            <th>教室参加回数(オンラインも含む)</th>
            <th>参加日時</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->kana}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->zip_code}}</td>
            <td>{{$user->address}}</td>
            <td>{{$user->tel}}</td>
            <td>{{$user->birthday}}</td>
            @if ($user->gender=='male')
                <td>男性</td>
            @else
                <td>女性</td>
            @endif
            <td>{{$user->point}}</td>
            <td>{{$user->reservations()->count()}}</td>
            <td>{{$user->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>