@php
  $notifCount = $notifCount ?? 0;
  $notifItems = $notifItems ?? [];
  $user = session('user');
@endphp

<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="navbar-header">
      <a href="/" class="navbar-brand"><b>PADUKASIH</b></a>
    </div>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning">{{ $notifCount }}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header"><b>Notifikasi</b></li>
            <li>
              <ul class="menu">
                @foreach($notifItems as $nt)
                  <li>
                    <a href="/order/{{ $nt->id_orders }}">
                      <i class="fa fa-users text-aqua"></i> Pesanan baru no order {{ $nt->id_orders }} <small class="label pull-right bg-yellow">{{ $nt->jlmitem }}</small>
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
            <li class="footer"><a href="/media?module=order">View all</a></li>
          </ul>
        </li>

        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="/img/suster.png" class="user-image" alt="User Image">
            <span class="hidden-xs">{{ $user->namauser ?? ($user->username ?? 'User') }}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="/img/suster.png" class="img-circle" alt="User Image">
              <p>{{ $user->namauser ?? ($user->username ?? 'User') }}</p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="/media.php?module=password" class="btn btn-default btn-flat"><i class="fa fa-cog fa-spin"></i> Seting</a>
              </div>
              <div class="pull-right">
                <a href="{{ route('logout') }}" class="btn btn-default btn-flat"><i class="fa fa-refresh fa-spin"></i> LogOut</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
