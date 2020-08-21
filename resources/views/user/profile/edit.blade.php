@extends('layouts.user.app')

@section('content')
<div id="content">
  <section>
    <h2>プロフィール</h2>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> プロフィール編集</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{--成功時のメッセージ--}}
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    {{-- エラーメッセージ --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </div>
                    @endif


                    <form action="{{ route('user.profile.update', Auth::user()->id) }}" method="POST">
                        @csrf
                        <div class="h-adr">
                         <div class="form-group">
                            <label for="name-field">お名前</label>
                            <input class="form-control" type="text" name="name" id="name-field"  value="{{$user->name}}" />
                        </div>
                        <div class="form-group">
                            <label for="name-field">読み方</label>
                            <input class="form-control" type="text" name="kana" id="kana-field"  value="{{$user->kana}}" />
                        </div>

                        <span class="p-country-name" style="display:none;">Japan</span>
                        <div class="form-group">
                            <label for="postal_code-field">郵便番号(入力すると都道府県と住所が補完されます)(例:123-4560)</label><br/>
                            <input type="text" name="zip_code" class="p-postal-code" size="8" maxlength="8" value="{{$user->zip_code}}"/>
                        </div>
                        <div class="form-group">
                            <label for="perf-field">都道府県</label><br/>
                            <input type="text" name="pref" class="p-region" value="{{$user->pref}}"/>
                        </div>
                        <div class="form-group">
                            <label for="address-field">住所(残りを入力してください)</label><br/>
                            <input type="text" name="address" class="form-control p-locality p-street-address p-extended-address"　size="35" maxlength="128"  value="{{$user->address}}"/>
                        </div>
                        
                        <div class="form-group">
                            <label for="tel-field">昼間に連絡の取れる電話番号(携帯可)(例:078-123-4567)</label><br/>
                            <input class="form-control" type="tel" name="tel" id="tel-field" value="{{$user->tel}}" />
                        </div>

                        <div class="form-group">
                            <label for="birthday-field">誕生日</label><br/>
                        
                            <select id="year" name="year">
                                <option value="">---</option>
                                <?php $years = array_reverse(range(today()->year - 60, today()->year)); ?>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ $birthday_year == $year ? 'selected' : '' }} >{{ $year }}</option>
                            @endforeach
                            </select>
                            <label for="year">年</label>

                            <select id="month" name="month">
                                <option value="">---</option>
                            @foreach(range(1, 12) as $month)
                                <option value="{{ $month }}" {{ $birthday_month == $month ? 'selected' : '' }} >{{ $month }}</option>
                            @endforeach
                            </select>
                            <label for="month">月</label>

                            <select id="day" name="day" data-old-value="{{ $birthday_day }}" ></select>
                            <label for="day">日</label>
                        </div>

                        <div class="form-group">
                            <label for="gender-field">性別</label>
                            @if ($user->gender =='male')
                                <input type="radio" name="gender" value="male" checked="checked">男
                                <input type="radio" name="gender" value="female">女
                            @else
                                <input type="radio" name="gender" value="male">男
                                <input type="radio" name="gender" value="female" checked="checked">女
                            @endif
                        </div>
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>データ更新</button>
                        </div>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<script src="/js/birthday.js"></script>
@endsection