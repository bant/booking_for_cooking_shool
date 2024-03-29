<div id="nav">
    <div class="menu"><a class="slite" href="#">ポイント管理</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('admin.point.user') }}" title="生徒のポイント追加/修正">生徒のポイントの追加/修正</a>
            <a class="subitem" href="{{ route('admin.point.check') }}" title="生徒の月間ポイント確認">生徒の月間ポイント確認</a>
            <a class="subitem" href="{{ route('admin.point.staff') }}" title="先生の月間獲得ポイント確認">先生の月間獲得ポイント確認</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
    <div class="menu"><a class="slite" href="#">入金確認通知</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('admin.message.reservation_id_list') }}" title="予約番号でメッセージ送信">予約番号でメッセージ送信</a>
            <a class="subitem" href="{{ route('admin.message.reservation_user_list') }}" title="生徒情報でメッセージ送信">生徒情報でメッセージ送信</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
    <div class="menu"><a class="slite" href="#">生徒の管理</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('admin.user.check') }}" title="生徒の確認">生徒の確認</a>
            <a class="subitem" href="{{ route('admin.user.search') }}" title="生徒の停止">生徒の停止</a>
            <a class="subitem" href="{{ route('admin.user.deleted_search') }}" title="生徒の復元">生徒の復元</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
</div><!-- #nav -->
