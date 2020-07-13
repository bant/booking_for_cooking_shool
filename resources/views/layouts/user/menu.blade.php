    <div class="card">
        <div class="card-header"><i class="fas fa-th-list"></i></i> メニュー</div>
            <div class="card-body">
                <div class="panel panel-default">
                    <ul class="nav nav-pills nav-stacked" style="display:block;">
                        <li><i class="fas fa-calendar"></i> <a href="{{ url('/user/home') }}">ホーム</a></li>
                        <li><i class="fas fa-user-alt"></i><a href="{{ url('/user/profile') }}">プロフィール</a></li>
                        <li><i class="fas fa-user-alt"></i> <a href="{{ url('/user/classroom_reservation') }}">教室スケジュール</a></li>
                        <li><i class="fas fa-user-alt"></i> <a href="{{ url('/user/zoom_reservation') }}">ZOOMスケジュール</a></li>
                        <li><i class="fas fa-calendar"></i> <a href="/user/schedule/">スケジュール管理</a></li>
                        <li><i class="fas fa-calendar"></i> <a href="/user/reservation">予約管理</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
