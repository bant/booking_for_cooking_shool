@extends('layouts.staff.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- left menu -->
        @include('layouts.staff.menu')

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus"></i> スケジュール/追加</div>

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

                    <form action="{{ route('staff.schedule.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title-field">タイトル</label>
                            <input class="form-control" type="text" name="title" id="title-field" value="" />
                        </div>
                        <div class="form-group">
                            <label for="description-field">詳細</label>
                            <textarea name="description" id="description-field" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="start-field">日時</label>
                                         <input type="datetime-local" name="start"  id="start-field"/>
                        </div>

                        <div class="form-group">
                            <label for="end-field">日時</label>
                                  <input type="datetime-local" name="end"  id="end-field"/>
                        </div>



                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a class="btn btn-link pull-right" href="{{ route('staff.schedule.index') }}"><i class="fas fa-backward"></i>戻る</a>
                        </div>
                    </form>
                 


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        $('#start_date').datetimepicker({
            dayViewHeaderFormat: 'YYYY年 M月',
            tooltips: {
                close: '閉じる',
                selectMonth: '月を選択',
                prevMonth: '前月',
                nextMonth: '次月',
                selectYear: '年を選択',
                prevYear: '前年',
                nextYear: '次年',
                selectTime: '時間を選択',
                selectDate: '日付を選択',
                prevDecade: '前期間',
                nextDecade: '次期間',
                selectDecade: '期間を選択',
                prevCentury: '前世紀',
                nextCentury: '次世紀'
            },
            format: 'YYYY年MM月DD日',
            locale: moment.locale('ja', {
                week: { dow: 0 }
            }),
            viewMode: 'days',
            buttons: {
                showClose: true
            },
            daysOfWeekDisabled: [0, 6],
            disabledDates: [
                    "2019/1/1","2019/1/14","2019/2/11","2019/3/21","2019/4/29","2019/4/30", "2019/5/1", "2019/5/2", "2019/5/3", "2019/5/4", "2019/5/5", "2019/5/6", "2019/7/15", "2019/8/11", "2019/8/12", "2019/9/16", "2019/9/23", "2019/10/14", "2019/10/22" , "2019/11/3", "2019/11/4", "2019/11/23", "2020/1/1", "2020/1/13", "2020/2/11", "2020/3/20", "2020/4/29", "2020/5/3", "2020/5/4", "2020/5/5", "2020/7/20", "2020/8/11", "2020/9/21", "2020/9/22", "2020/10/12", "2020/11/3", "2020/11/23","2020/12/23"
           ],
           minDate: moment().format('L'),
           maxDate: moment().add(30, 'days').calendar()
        });
        $('#datetimepicker2').datetimepicker({
            tooltips: {
                close: '閉じる',
                pickHour: '時間を取得',
                incrementHour: '時間を増加',
                decrementHour: '時間を減少',
                pickMinute: '分を取得',
                incrementMinute: '分を増加',
                decrementMinute: '分を減少',
                pickSecond: '秒を取得',
                incrementSecond: '秒を増加',
                decrementSecond: '秒を減少',
                togglePeriod: '午前/午後切替',
                selectTime: '時間を選択'
            },
            format: 'HH:mm',
            locale: 'ja',
            buttons: {
                showClose: true
            },
            // disabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 19, 20, 21, 22, 23],
            enabledHours: [ 9,10, 11, 12, 13, 14, 15, 16, 17,18]

        });
    });
</script>
@endsection
