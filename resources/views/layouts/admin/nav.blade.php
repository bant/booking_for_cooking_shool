<div id="nav">
    <div class="menu"><a href="#" title="ポイント管理">ポイント管理</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('admin.point.search') }}" title="生徒のポイント追加/修正">生徒のポイントの追加/修正</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
    <div class="menu"><a href="https://cooking.sumomo.ne.jp/real/tomo/" title="ともクッキングサロン">須磨区教室</a>
        <div class="submenu">
            <a class="subitem" href="https://cooking.sumomo.ne.jp/real/tomo/tomo-lessons/" title="須磨区教室：今月のレッスン">今月のレッスン</a>
            <a class="subitem" href="https://booking.wheatbobcat7.sakura.ne.jp/tomo/" title="須磨区教室：予約カレンダー">予約カレンダー</a>
            <a class="subitem" href="https://www.facebook.com/tomocookingsalon/" title="Facebook：ともクッキングサロン" target="_blank">Facebook</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
    <div class="menu"><a href="https://cooking.sumomo.ne.jp/real/kei/" title="Keiクッキングサロン">北区教室</a>
        <div class="submenu">
            <a class="subitem" href="https://cooking.sumomo.ne.jp/real/kei/kei-lessons/" title="北区教室：今月のレッスン">今月のレッスン</a>
            <a class="subitem" href="https://booking.wheatbobcat7.sakura.ne.jp/kei/" title="北区教室：予約カレンダー">予約カレンダー</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->
    <div class="menu"><a href="https://cooking.sumomo.ne.jp/real/hama/" title="クッキングルームHAMA">西明石教室</a>
        <div class="submenu">
            <a class="subitem" href="https://cooking.sumomo.ne.jp/real/hama/hama-lessons/" title="西明石教室：今月のレッスン">今月のレッスン</a>
            <a class="subitem" href="https://booking.wheatbobcat7.sakura.ne.jp/hama/" title="西明石教室：予約カレンダー">予約カレンダー</a>
        </div><!-- .submenu -->
    </div><!-- .menu -->

    <div class="menu"><a href="{{ route('staff.home.index') }}" title="ダッシュボード">ダッシュボード</a>
        <div class="submenu">
            <a class="subitem" href="{{ route('admin.point.index') }}" title="ポイント管理">ポイント管理</a>
            <a class="subitem" href="{{ route('admin.user.index') }}" title="ユーザ管理">ユーザ管理</a>
            <a class="subitem" href="{{ route('staff.reservation.index') }}"  title="予約管理">予約管理</a>
            <a class="subitem" href="{{ url('/staff/course') }}"  title="コース情報">コース情報</a>
            <a class="subitem" href="{{ url('/staff/room') }}"  title="教室情報">教室情報</a>
            <a class="subitem" href="{{ url('/staff/zoom') }}"  title="ZOOM情報">ZOOM情報</a>
            <a class="subitem" href="{{ url('/staff/profile') }}"  title="プロフィール">プロフィール</a>
        </div><!-- .submenu -->
    </div>  
</div><!-- #nav -->
