<div id="nav">
    <div class="menu"><a href="#" title="基本設定">基本設定</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('staff.room.index') }}" title="教室設定">教室設定</a>
            <a class="subitem" href="{{ route('staff.zoom.index') }}" title="オンライン教室設定">オンライン教室設定</a>
            <a class="subitem" href="{{ route('staff.course.index') }}" title="コース設定">コース設定</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
    <div class="menu"><a href="#" title="予約・スケジュール管理">予約・スケジュール管理</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('staff.schedule.index') }}" title="スケジュール管理">スケジュール管理</a>
            <a class="subitem" href="{{ route('staff.reservation.index') }}" title="予約管理">予約管理</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
    <div class="menu"><a href="#" title="連絡・メッセージ">連絡・メッセージ</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('staff.message.user_edit') }}" title="教室参加生徒へメッセージ送信">教室参加生徒へメッセージ送信</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
</div><!-- #nav -->
