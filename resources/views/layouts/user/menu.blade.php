    <div class="card">
        <div class="card-header"><i class="fas fa-th-list"></i></i> メニュー</div>
            <div class="card-body">
                <div class="panel panel-default">
                    <ul class="nav nav-pills nav-stacked" style="display:block;">
                        <li><i class="fas fa-home"></i> <a href="{{ route('user.home.index') }}">ホーム</a></li>
                        <li><i class="fas fa-calendar"></i> <a href="{{ route('user.classroom_reservation.index') }}">教室予約</a></li>
                        <li><i class="fas fa-calendar"></i> <a href="{{ route('user.zoom_reservation.index') }}">ZOOM予約</a></li>
                        <li><i class="fas fa-calendar"></i> <a href="/user/reservation">予約履歴</a></li>
                        <li><i class="fas fa-user-alt"></i><a href="{{ url('/user/profile') }}">プロフィール</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
