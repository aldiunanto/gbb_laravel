<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GBB - {{ $title }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">
  
        <link rel="shortcut icon" href="http://aldiunanto/jaly_images/favicon.ico">
        <link rel="stylesheet" href="{{ $asset::css('normalize') }}">
        <link rel="stylesheet" href="{{ $asset::css('main') }}">
    		<link rel="stylesheet" href="{{ $asset::css('font-awesome.min') }}">

        @if(! empty($css))
          @foreach($css as $file)
            <link rel="stylesheet" href="{{ $asset::css($file) }}">
          @endforeach
        @endif

    		<link rel="stylesheet/less" type="text/css" href="{{ $asset::less('global') }}">
    		<link rel="stylesheet/less" type="text/css" href="{{ $asset::less(current_route('class')) }}">

    		<script src="{{ $asset::js('vendor/less-1.3.3.min') }}"></script>
        <script src="{{ $asset::js('vendor/modernizr-2.6.2.min') }}"></script>
    </head>
    <body data-controller="{{ current_route('class') }}" data-method="{{ current_route('method') }}">
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

		<div id="sidebar">
			<div class="logo">
				<h1><img src="{{ images_url('logo_kent.gif') }}" alt="Logo" />gbb</h1>
			</div>
			<nav>
				<ul>
          <li><a href="{{ url('home') }}" <?php echo is_active('home') . is_active('admin') ?>><i class="fa fa-home left"></i>beranda</a></li>
          <?php $role = Auth::user()->hak_akses ?>
					<li><a href="{{ url('supplier') }}" <?php echo is_active('supplier') ?>><i class="fa fa-users left"></i>supplier</a></li>
          <li class="sidebar-dropdown-toggle  {{ (! empty($opened) && $opened == 'material' ? 'opened' : '') }}"><a href="" <?php echo is_active('material') ?>><i class="fa fa-dropbox left"></i>material<i class="fa fa-angle-left right"></i></a>
            <ul>
              <li><a href="{{ url('material') }}"><i class="fa fa-list"></i>data list</a></li>
              @if($role != 7)
              <li><a href="{{ url('material/request') }}"><i class="fa fa-shopping-cart"></i>permintaan<?php $count = count_request(); echo ($count == 0 ? '' : '<span class="notif-count">'.$count.'</span>') ?></a></li>
              @endif

              @if($role != 6 && $role != 7 && $role != 4)
              <li><a href="{{ url('material/acceptance') }}"><i class="fa fa-sign-in"></i>penerimaan</a></li>
              @endif

              @if($role == 1 || $role == 3)
              <li><a href="{{ url('material/expenditure') }}"><i class="fa fa-sign-out"></i>pengeluaran</a></li>
              @endif
              <li><a href="{{ url('material/acceptance/retur') }}"><i class="fa fa-rotate-left"></i>returan</a></li>

              @if($role == 1 || $role == 3)
              <li><a href="{{ url('material/closingStock') }}"><i class="fa fa-retweet"></i>closing stok</a></li>
              @endif
            </ul>
          </li>

          @if(in_array($role, [1,2,5]))
          <li><a href="{{ url('po') }}" <?php echo is_active('po') ?>><i class="fa fa-file-powerpoint-o left"></i>purchasing order</a></li>
          @endif

          @if(in_array($role, [1,2,3,5,7]))
          <li class="sidebar-dropdown-toggle {{ (! empty($opened) && $opened == 'report' ? 'opened' : '') }}"><a href="" <?php echo is_active('report') ?>><i class="fa fa-area-chart left"></i>laporan<i class="fa fa-angle-left right"></i></a>
            <ul>
              @if($role == 1 || $role == 2 || $role == 5)
              <li><a href="{{ url('report/purchasing/qualityplan') }}"><i class="fa fa-bar-chart"></i>Rencana Mutu</a></li>
              <li><a href="{{ url('report/purchasing/purchasemonthly') }}"><i class="fa fa-line-chart"></i>Pembelian Bulanan</a></li>
              @endif
              @if($role == 1 || $role == 3 || $role == 5 || $role == 7)
              <li><a href="{{ url('report/rawmat/materialTransaction') }}"><i class="fa fa-bar-chart"></i>Transaksi Material</a></li>
              <li><a href="{{ url('report/rawmat/expenditure') }}"><i class="fa fa-line-chart"></i>Pengeluaran</a></li>
              @endif
            </ul>
          </li>
          @endif
				</ul>
			</nav>
		</div>
		<header>
			<nav>
				<ul>
          <!-- <li><a href="{{ url('notification') }}" class="notif-top" title="Notifikasi"><i class="fa fa-bell fa-2x"></i><?php $notif = count_notif(); echo ($notif == 0 ? '' : '<span>' . $notif . '</span>') ?></a></li> -->
          <li><a href="{{ url('checklist') }}" class="notif-top" title="Checklist Penerimaan dan Pengeluaran Material"><i class="fa fa-check fa-2x"></i></a></li>
          <li><a href="{{ url('material/acceptance/retur') }}" class="notif-top" title="Retur Penerimaan Material"><i class="fa fa-rotate-left fa-2x"></i><?php $countAppr = count_returApprovement(); echo ($countAppr == 0 ? '' : '<span>' . $countAppr . '</span>') ?></a></li>
          @if($role != 7)
          <li><a href="{{ url('material/request') }}" class="notif-top" title="Permintaan Material"><i class="fa fa-shopping-cart fa-2x"></i><?php echo ($count == 0 ? '' : '<span>' . $count . '</span>') ?></a></li>
          @endif
					<li><a href=""><img src="{{ images_url('foto/' . session('kar_foto')) }}" alt="User" class="user-logged-in" />{{ session('kar_nama') }} <i class="fa fa-angle-down"></i></a>
						<ul class="dropdown-menu">
							<li><a href="" id="get-profile"><i class="fa fa-user"></i> Profil Saya</a></li>
              <li><a href="{{ url('admin/changePassword') }}"><i class="fa fa-shield"></i> Ubah Password</a></li>
							<li><a href="{{ url('auth/logout') }}" id="logout"><i class="fa fa-key"></i> Sign out</a></li>
						</ul>
					</li>
				</ul>
			</nav>
      <ul class="position">
        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i>Beranda</a></li>
        @foreach($position as $uri => $text)
        <li class="delimiter"><span>&rsaquo;</span></li>
        <li><a href="{{ url($uri) }}">{{ $text }}</a></li>
        @endforeach
      </ul>

			<div class="clearfix"></div>
		</header>
       	<div id="content">
       		@yield('content')
       	</div>
       	<div class="clearfix"></div>

       	<div id="confirmation">
       		<div class="container">
       			<div class="text">Anda yakin ingin menghapus data ini?</div>
       			<div class="actions">
       				<button class="btn default negative">cancel</button>
       				<button class="btn primary positive">ok</button>
       			</div>
       		</div>
       	</div>

        <div id="popup">
          <div class="header">
            <a class="close-button" href="javascript:;"><i class="fa fa-close"></i></a>
            <div class="caption"><i class="fa fa-info"></i><span></span></div>

            <div class="clearfix"></div>
          </div>
          <div class="content"></div>
          <div class="footer">
            <button class="btn primary positive"></button>
            <button class="btn default negative">cancel</button>

            <div class="clearfix"></div>
          </div>
        </div>

        <script>
          var options = { 'baseUrl' : '{{ url('/') }}/' }
        </script>
        <script src="{{ $asset::js('vendor/jquery-1.10.2.min') }}"></script>
        <script src="{{ $asset::js('plugins') }}"></script>

        @if(! empty($js))
          @foreach($js as $file)
            <script src="{{ $asset::js($file) }}"></script>
          @endforeach
        @endif

        <script src="{{ $asset::js('libs') }}"></script>
        <script src="{{ $asset::js('main') }}"></script>
        <script src="{{ $asset::js(current_route('class')) }}"></script>
        <script src="{{ $asset::js('exec') }}"></script>
    </body>
</html>
