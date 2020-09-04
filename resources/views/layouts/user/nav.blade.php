  <div id="nav">
    <div class="menu"><a class="slite" href="#">教室の予約</a>
      <div class="submenu">
        @php ($room_nav_list = \App\Models\Room::orderBy('staff_id', 'asc')->get() )
        @foreach($room_nav_list as $room_nav)
          <a class="subitem" href="{{route('user.classroom_reservation.calendar',$room_nav->staff_id)}}" title="{{$room_nav->name}}の予約">{{$room_nav->name}}の予約</a>
        @endforeach
        </div><!-- .submenu -->
    </div>
    <div class="menu"><a class="slite" href="#">オンライン教室の予約</a>
        <div class="submenu">
        @php ($zoom_nav_list = \App\Models\Zoom::orderBy('staff_id', 'asc')->get())
        @foreach($zoom_nav_list as $zoom_nav)
          <a class="subitem" href="{{route('user.zoom_reservation.calendar',$zoom_nav->staff_id)}}" title="{{$zoom_nav->name}}の予約">{{$zoom_nav->name}}の予約</a>
        @endforeach
        </div><!-- .submenu -->
    </div> 
    <div class="menu"><a href="{{ route('user.profile.edit') }}" title="ユーザプロフィール">ユーザプロフィール</a>
    </div> 
  </div><!-- #nav -->
