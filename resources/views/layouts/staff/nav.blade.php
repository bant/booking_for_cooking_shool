<div id="nav">
    <div class="menu"><a class="slite" href="#">基本設定</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('staff.room.index') }}" title="教室設定">教室設定</a>
            <a class="subitem" href="{{ route('staff.zoom.index') }}" title="オンライン教室設定">オンライン教室設定</a>
            <a class="subitem" href="{{ route('staff.course.index') }}" title="コース設定">コース設定</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
    <div class="menu"><a class="slite" href="#">予約・スケジュール管理</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('staff.schedule.index') }}" title="スケジュール管理">スケジュール管理</a>
            <a class="subitem" href="{{ route('staff.reservation.index') }}" title="予約管理">予約管理</a>
            <a class="subitem" href="{{ route('staff.manual.search_cancel') }}" title="予約キャンセル">予約キャンセル</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
    <div class="menu"><a class="slite" href="#">連絡・メッセージ</a>
        <div class="submenu">
            <a class="subitem" href="{{route('staff.message.admin_edit')}}" title="管理者へメッセージ送信">管理者へメッセージ送信</a>
            <a class="subitem" href="{{route('staff.message.class_user_edit')}}" title="教室参加生徒へ一括メッセージ送信">教室参加生徒へ一括メッセージ送信</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
</div><!-- #nav -->
