  <div id="nav">
    <div class="menu"><a href="#" title="教室予約">教室予約</a>
        <div class="submenu">
        @php ($room_nav_list = \App\Models\Room::all())
        @foreach($room_nav_list as $room_nav)
          <a class="subitem" href="{{ route('user.classroom_reservation.calendar',$room_nav->id) }}" title="{{$room_nav->name}}の予約">{{$room_nav->name}}の予約</a>
        @endforeach
        </div><!-- .submenu -->
    </div>
    <div class="menu"><a href="#" title="オンライン教室予約">オンライン教室予約</a>
        <div class="submenu">
        @php ($zoom_nav_list = \App\Models\Zoom::all())
        @foreach($zoom_nav_list as $zoom_nav)
          <a class="subitem" href="{{ route('user.zoom_reservation.calendar',$zoom_nav->id) }}" title="{{$zoom_nav->name}}の予約">{{$zoom_nav->name}}の予約</a>
        @endforeach
        </div><!-- .submenu -->
    </div> 
    <div class="menu"><a href="{{ route('user.profile.edit') }}" title="ユーザプロフィール">ユーザプロフィール</a>
    </div> 
  </div><!-- #nav -->
