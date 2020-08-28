<div id="nav">
    <div class="menu"><a href="#" title="ポイント管理">ポイント管理</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('admin.point.user') }}" title="生徒のポイント追加/修正">生徒のポイントの追加/修正</a>
            <a class="subitem" href="{{ route('admin.point.check') }}" title="生徒の月間ポイント確認">生徒の月間ポイント確認</a>
            <a class="subitem" href="{{ route('admin.point.staff') }}" title="先生の月間獲得ポイント確認">先生の月間獲得ポイント確認</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
    <div class="menu"><a href="#" title="連絡・メッセージ">連絡・メッセージ送信</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('admin.message.staff_search') }}" title="先生へ入金確認通知">先生へ入金確認通知</a>
            <a class="subitem" href="{{ route('admin.message.user_search') }}" title="生徒さんへ入金確認通知">生徒さんへ入金確認通知</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
    <div class="menu"><a href="#" title="生徒の管理">生徒の管理</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('admin.user.check') }}" title="生徒の確認">生徒の確認</a>
            <a class="subitem" href="{{ route('admin.user.search') }}" title="生徒の停止">生徒の停止</a>
            <a class="subitem" href="{{ route('admin.user.deleted_search') }}" title="生徒の復元">生徒の復元</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
</div><!-- #nav -->
