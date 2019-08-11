	<div class="site-menubar">
		<div class="site-menubar-body">
			<div>
				<div>
					<ul class="site-menu" data-plugin="menu">
						@if(Auth::user()->id_grade != 2 && Auth::user()->id_grade != 3 && Auth::user()->id_grade != 4)
						<li class="site-menu-category">Administrator</li>
						<li class="site-menu-item {{ request()->is('/') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('dashboard') }}">
		                        <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
		                        <span class="site-menu-title">Dashboard</span>
		                    </a>
		              	</li>
		              	<!-- <p id="menu_utama"></p> -->
		              	<?php
		              		$p = json_decode(Auth::user()->access_menu, true);
		              		if(!empty($p['master'])) {
		              	?>
		              	<li class="site-menu-item has-sub">
		              		<a href="javascript:void(0)">
		                        <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
		                        <span class="site-menu-title">Master</span>
		                        <span class="site-menu-arrow"></span>
		                    </a>
		                    <ul class="site-menu-sub">
		              	<?php
			              		foreach ($p['master'] as $key => $value) {
			              			$link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
		              	?>
		              			<li class="site-menu-item {{ request()->is('cat-item') ? 'active' : '' }}">
				                    <a class="animsition-link" href="{{ route($link->menu_value) }}">
				                      	<span class="site-menu-title">{{ $value['menu_name'] }}</span>
				                    </a>
				                </li>
		              	<?php
		              			}
		              	?>
		              		</ul>
		              	</li>
		              	<?php
		              		}
		              		if(!empty($p['account'])) {
		              	?>
		              	<li class="site-menu-item has-sub">
		              		<a href="javascript:void(0)">
		                        <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
		                        <span class="site-menu-title">Account</span>
		                        <span class="site-menu-arrow"></span>
		                    </a>
		                    <ul class="site-menu-sub">
		              	<?php
			              		foreach ($p['account'] as $key => $value) {
			              			$link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
			            ?>
		              			<li class="site-menu-item {{ request()->is('cat-item') ? 'active' : '' }}">
				                    <a class="animsition-link" href="{{ route($link->menu_value) }}">
				                      	<span class="site-menu-title">{{ $value['menu_name'] }}</span>
				                    </a>
				                </li>
		              	<?php
			              		}
			            ?>
		              		</ul>
		              	</li>
		              	<?php
		              		}
		              		if(!empty($p['request'])) {
		              	?>
		              	<li class="site-menu-item has-sub">
		              		<a href="javascript:void(0)">
		                        <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
		                        <span class="site-menu-title">Request</span>
		                        <span class="site-menu-arrow"></span>
		                    </a>
		                    <ul class="site-menu-sub">
		              	<?php
			              		foreach ($p['request'] as $key => $value) {
			              			$link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
			            ?>
		              			<li class="site-menu-item {{ request()->is('cat-item') ? 'active' : '' }}">
				                    <a class="animsition-link" href="{{ route($link->menu_value) }}">
				                      	<span class="site-menu-title">{{ $value['menu_name'] }}</span>
				                    </a>
				                </li>
		              	<?php
			              		}
			            ?>
		              		</ul>
		              	</li>
		              	<?php
		              		}if(!empty($p['system'])) {
		              	?>
		              	<li class="site-menu-item has-sub">
		              		<a href="javascript:void(0)">
		                        <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
		                        <span class="site-menu-title">System</span>
		                        <span class="site-menu-arrow"></span>
		                    </a>
		                    <ul class="site-menu-sub">
		              	<?php
			              		foreach ($p['system'] as $key => $value) {
			              			$link = DB::table('tbl_m_menu')->where('id', $value['menu_param'])->first();
			            ?>
		              			<li class="site-menu-item {{ request()->is('cat-item') ? 'active' : '' }}">
				                    <a class="animsition-link" href="{{ route($link->menu_value) }}">
				                      	<span class="site-menu-title">{{ $value['menu_name'] }}</span>
				                    </a>
				                </li>
		              	<?php
			              		}
			            ?>
		              		</ul>
		              	</li>
		              	<?php
		              		}
		              	?>
						<li class="site-menu-item {{ request()->is('notif') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('notif') }}">
		                        <i class="site-menu-icon md-notifications" aria-hidden="true"></i>
		                        <span class="site-menu-title">Notification</span>
		                    </a>
		              	</li>
		              	@endif
		              	<!-- Customer -->
		              	@if(Auth::user()->id_grade == 2)
		              	<li class="site-menu-category">Customer</li>
						<li class="site-menu-item {{ request()->is('/') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('dashboard') }}">
		                        <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
		                        <span class="site-menu-title">Dashboard</span>
		                    </a>
		              	</li>
						<li class="site-menu-item">
		                	<a class="animsition-link" href="{{ route('account-seller', ['id' => Auth::user()->id]) }}">
		                        <i class="site-menu-icon md-account" aria-hidden="true"></i>
		                        <span class="site-menu-title">Account</span>
		                    </a>
		              	</li>
						<li class="site-menu-item {{ request()->is('customer-req') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('customer-req') }}">
		                        <i class="site-menu-icon md-shopping-basket" aria-hidden="true"></i>
		                        <span class="site-menu-title">Request</span>
		                    </a>
		              	</li>
						<li class="site-menu-item {{ request()->is('customer-off') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('customer-off') }}">
		                        <i class="site-menu-icon md-mall" aria-hidden="true"></i>
		                        <span class="site-menu-title">Offer</span>
		                    </a>
		              	</li>
						<li class="site-menu-item {{ request()->is('confirm-dp') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('confirm-dp') }}">
		                        <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
		                        <span class="site-menu-title">Confirmation DP</span>
		                    </a>
		              	</li>
						<li class="site-menu-item {{ request()->is('notification-user') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('notification-user') }}">
		                        <i class="site-menu-icon md-notifications" aria-hidden="true"></i>
		                        <span class="site-menu-title">Notification </span>
		                        <span id="form_data"></span>
		                    </a>
		              	</li>
		              	@endif
		              	<!-- Admin Seller -->
		              	@if(Auth::user()->id_grade == 3)
		              	<li class="site-menu-category">Admin Seller</li>
						<li class="site-menu-item {{ request()->is('/') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('dashboard') }}">
		                        <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
		                        <span class="site-menu-title">Dashboard</span>
		                    </a>
		              	</li>
						<li class="site-menu-item {{ request()->is('setting-admin-seller') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('setting-admin-seller') }}">
		                        <i class="site-menu-icon md-settings" aria-hidden="true"></i>
		                        <span class="site-menu-title">Setting</span>
		                    </a>
		              	</li>
						<li class="site-menu-item {{ request()->is('account-detail-admin') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('account-detail-admin', ['id' => Auth::user()->id]) }}">
		                        <i class="site-menu-icon md-account" aria-hidden="true"></i>
		                        <span class="site-menu-title">Account</span>
		                    </a>
		              	</li>
						<li class="site-menu-item {{ request()->is('all-req-off') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('all-req-off') }}">
		                        <i class="site-menu-icon md-shopping-basket" aria-hidden="true"></i>
		                        <span class="site-menu-title">Request</span>
		                    </a>
		              	</li>
		              	@endif
		              	<!-- Seller -->
		              	@if(Auth::user()->id_grade == 4)
		              	<li class="site-menu-category">Seller</li>
						<li class="site-menu-item {{ request()->is('/') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('dashboard') }}">
		                        <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
		                        <span class="site-menu-title">Dashboard</span>
		                    </a>
		              	</li>
						<li class="site-menu-item">
		                	<a class="animsition-link" href="{{ route('account-seller', ['id' => Auth::user()->id]) }}">
		                        <i class="site-menu-icon md-account" aria-hidden="true"></i>
		                        <span class="site-menu-title">Account</span>
		                    </a>
		              	</li>
						<li class="site-menu-item {{ request()->is('seller-req') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('seller-req') }}">
		                        <i class="site-menu-icon md-shopping-basket" aria-hidden="true"></i>
		                        <span class="site-menu-title">Request</span>
		                    </a>
		              	</li>
						<li class="site-menu-item {{ request()->is('seller-off') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('seller-off') }}">
		                        <i class="site-menu-icon md-mall" aria-hidden="true"></i>
		                        <span class="site-menu-title">Offer</span>
		                    </a>
		              	</li>
						<li class="site-menu-item {{ request()->is('notification-user') ? 'active' : '' }}">
		                	<a class="animsition-link" href="{{ route('notification-user') }}">
		                        <i class="site-menu-icon md-notifications" aria-hidden="true"></i>
		                        <span class="site-menu-title">Notification</span>
		                    </a>
		              	</li>
		              	@endif
					</ul>
				</div>
			</div>
		</div>
	</div>