<?php
	Helper::init_abs_path(FCPATH);
	$user = Auth::user();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- favicon -->
  <link rel="icon" href="<?= base_url('assets/images/icons/fav.ico'); ?>" />

	<title><?= Helper::$APP_NAME; ?> | <?= $title; ?></title>

	<!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/css/adminlte/adminlte.min.css'); ?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/toastr/toastr.min.css'); ?>">
  <!-- Ladda -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/ladda/css/ladda-themeless.min.css'); ?>">

	<?php
		// Additional Css
		if(! empty($assets['css']) && is_array($assets['css'])) {
			foreach ($assets['css'] as $cssAsset) {
				echo '<link rel="stylesheet" type="text/css" href="'.base_url( Helper::file_version('assets/'.$cssAsset) ).'">';
			}
		}
	?>
	<!-- Admin Css -->
	<link rel="stylesheet" type="text/css" href="<?= base_url( Helper::file_version('assets/css/admin.css') ); ?>">

	<!-- jQuery -->
	<script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
	  <!-- Navbar -->
	  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
	    <!-- Left navbar links -->
	    <ul class="navbar-nav">
	      <li class="nav-item">
	        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
	      </li>
	    </ul>
	    <!-- Right navbar links -->
	    <ul class="navbar-nav ml-auto text-sm">
	    	<li class="nav-item">
	    		<p class="nav-link user-fullname user-nav text-dark pr-0 mb-0">
	    			<?= $user->get('full_name'); ?>
	    		</p>
	    	</li>
	    	<li class="nav-item">
	        <a href="<?= site_url('authentication/logout'); ?>" class="nav-link user-nav">
	        	<i class="nav-icon fa fa-sign-out-alt"></i> Keluar
	        </a>
	      </li>
	    </ul>
	  </nav>
	  <!-- /.navbar -->

	  <!-- Main Sidebar Container -->
	  <aside class="main-sidebar sidebar-dark-primary elevation-4">
	    <!-- Brand Logo -->
	    <a href="<?= base_url('dashboard'); ?>" class="brand-link">
	    	<i class="fa fa-star"></i>
	      <span class="brand-text font-weight-light"><?= Helper::$APP_NAME; ?></span>
	    </a>

	    <!-- Sidebar -->
	    <div class="sidebar">
	      <!-- Sidebar Menu -->
	      <nav class="mt-2">
	        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
	          <?php
	          	$userMenu = array(
	          		array(
		          		'menu_uri' => 'dashboard',
		          		'menu_name' => 'Dashboard',
		          		'menu_icon' => 'fas fa-tachometer-alt',
	          		),
	          		array(
		          		'menu_uri' => '',
		          		'menu_name' => 'Data Master',
		          		'menu_icon' => 'fa fa-list',
		          		'child_menus' => array(
		          			array(
			          			'menu_uri' => 'satuan',
				          		'menu_name' => 'Satuan',
				          		'menu_icon' => '',
				          	),
				          	array(
			          			'menu_uri' => 'supplier',
				          		'menu_name' => 'Supplier',
				          		'menu_icon' => '',
				          	),
		          			array(
			          			'menu_uri' => 'barang',
				          		'menu_name' => 'Barang',
				          		'menu_icon' => '',
				          	),
		          		),
	          		),
	          		array(
		          		'menu_uri' => 'transaksi',
		          		'menu_name' => 'Transaksi',
		          		'menu_icon' => 'fa fa-shopping-cart',
	          		),
	          	);

	          	$resultMenu = array();
	          	$current_route = $this->router->directory . $this->router->class;

	          	foreach($userMenu as $uMenuLvl1) {
	          		$hasChild = array_key_exists('child_menus', $uMenuLvl1);

	          		// Is Menu Level 1 Active
					      $uMenuLvl1['menu_active'] = $current_route == $uMenuLvl1['menu_uri'] ? 'active': '';
					      $uMenuLvl1['menu_open']   = '';

					      // Menu Level 2
					      if($hasChild) {
					        $level2Menus = array();

					        foreach ($uMenuLvl1['child_menus'] as $menuLevel2) {
					          $hasChild = array_key_exists('child_menus', $menuLevel2);

					          // Is Menu Level 2 Active
					          $menuLevel2['menu_active'] = '';
					          $menuLevel2['menu_open']   = '';
					          
					          if($current_route == $menuLevel2['menu_uri']){
					            $menuLevel2['menu_active'] = 'active';

					            $uMenuLvl1['menu_active'] = 'active';
					            $uMenuLvl1['menu_open']   = 'menu-open';
					          }

					          // Menu Level 3
					          if($hasChild) :
					            $level3Menus = array();

					            foreach ($menuLevel2['child_menus'] as $menuLevel3) {
					              // Is Menu Level 3 Active
					              $menuLevel3['menu_active'] = '';
					              
					              if($current_route == $menuLevel3['menu_uri']){
					                $menuLevel3['menu_active'] = 'active';

					                $menuLevel2['menu_active'] = 'active';
					                $menuLevel2['menu_open']   = 'menu-open';

					                $uMenuLvl1['menu_active'] = 'active';
					                $uMenuLvl1['menu_open']   = 'menu-open';
					              }

					              // Assign Menu Level 3
					              $level3Menus[] = $menuLevel3;
					            }

					            if(empty($level3Menus)) continue;

					            // Override Menu Level 2 Child
					            $menuLevel2['child_menus'] = $level3Menus;
					          endif;

					          // Assign Menu Level 2
					          $level2Menus[] = $menuLevel2;
					        }

					        if(empty($level2Menus)) continue;

					        // Override Menu Level 1 Child
					        $uMenuLvl1['child_menus'] = $level2Menus;
					      }

					      // Assign Menu Level 1
					      $resultMenu[] = $uMenuLvl1;
	          	}

							foreach($resultMenu as $menuLevel1) :
								$hasDropdown = array_key_exists('child_menus', $menuLevel1);
								$menuUri = $hasDropdown ? 'javascript:void(0);' : $menuLevel1['menu_uri'];
						?>
							<li class="nav-item <?php if($hasDropdown) echo 'has-treeview'; ?> <?= $menuLevel1['menu_open']; ?>">
		            <a href="<?= $menuUri; ?>" class="nav-link <?= $menuLevel1['menu_active']; ?>">
		              <i class="nav-icon <?= $menuLevel1['menu_icon']; ?>"></i>
		              <p>
		                <?= $menuLevel1['menu_name']; ?>
		                <?php if($hasDropdown): ?>
		                	<i class="fas fa-angle-left right"></i>
		                <?php endif; ?>
		              </p>
		            </a>

		            <?php if($hasDropdown): ?>
			            <ul class="nav nav-treeview">
		            		<?php foreach($menuLevel1['child_menus'] as $menuLevel2) : ?>
		            			<?php
		            				$hasDropdown = array_key_exists('child_menus', $menuLevel2);
												$menuUri = $hasDropdown ? 'javascript:void(0);' : $menuLevel2['menu_uri'];
		            			?>
				              <li class="nav-item <?php if($hasDropdown) echo 'has-treeview'; ?> <?= $menuLevel2['menu_open']; ?>">
				                <a href="<?= $menuUri; ?>" class="nav-link <?= $menuLevel2['menu_active']; ?>">
				                  <i class="far fa-circle nav-icon"></i>
				                  <p>
				                  	<?= $menuLevel2['menu_name']; ?>
				                  	<?php if($hasDropdown): ?>
						                	<i class="fas fa-angle-left right"></i>
						                <?php endif; ?>
				                  </p>
				                </a>
				                
				                <?php if($hasDropdown): ?>
			            				<ul class="nav nav-treeview">
			            					<?php foreach($menuLevel2['child_menus'] as $menuLevel3) : ?>
			            						<li class="nav-item">
								                <a href="<?= $menuLevel3['menu_uri']; ?>" class="nav-link <?= $menuLevel3['menu_active']; ?>">
								                  <i class="far fa-dot-circle nav-icon"></i>
								                  <p><?= $menuLevel3['menu_name']; ?></p>
								                </a>
								              </li>
			            					<?php endforeach; ?>
			            				</ul>
			            			<?php endif; ?>
				              </li>
			          		<?php endforeach; ?>
			            </ul>
			          <?php endif; ?>
		          </li>
						<?php endforeach; ?>
	        </ul>
	      </nav>
	      <!-- /.sidebar-menu -->
	    </div>
	    <!-- /.sidebar -->
	  </aside>

	  <!-- Content Wrapper. Contains page content -->
	  <div class="content-wrapper">
	    <!-- Content Header (Page header) -->
	    <div class="content-header">
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-sm-6">
	            <h1 class="m-0 text-dark" style="font-size: 1.25em;"><?= $title; ?></h1>
	          </div><!-- /.col -->
	          <div class="col-sm-6">
	          	<?php if(isset($breadcrumbs)) : ?>
		            <ol class="breadcrumb float-sm-right text-sm">
		              <?php 
										$breadcrumbs_length = count($breadcrumbs) - 1;
										for ($i = 0; $i <= $breadcrumbs_length; $i++) :
										  if ( $i === $breadcrumbs_length ) :
										?>
											<li class="breadcrumb-item active">
												<span class="text-muted"><?php echo $breadcrumbs[$i]['title'] ?></span>
											</li>
										<?php
											break;
											endif;
										?>
										<li class="breadcrumb-item">
											<a style="color: #007bff;" href="<?php echo $breadcrumbs[$i]['link'] ?>">
												<?php echo $breadcrumbs[$i]['title'] ?>
											</a>
										</li>
									<?php
										endfor;
									?>
		            </ol>
		          <?php endif; ?>
	          </div><!-- /.col -->
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>
	    <!-- /.content-header -->

	    <!-- Main content -->
	    <section class="content">
	      <div class="container-fluid">
	      	<?php
						if(! empty($content)) {
							$this->load->view($content);
						}
					?>
	      </div><!-- /.container-fluid -->
	    </section>
	    <!-- /.content -->
	  </div>
	  <!-- /.content-wrapper -->
	  <footer class="main-footer text-sm">
	    <strong>Copyright &copy; 2023</strong>
	    All rights reserved.
	    <div class="float-right d-none d-sm-inline-block">
	      <b>Version</b> 1.0.0
	    </div>
	  </footer>
	</div>

	<!-- Popper -->
	<script src="<?= base_url('assets/plugins/popper/popper.min.js'); ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<!-- overlayScrollbars -->
	<script src="<?= base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url('assets/js/adminlte/adminlte.min.js'); ?>"></script>
	<!-- Toastr -->
	<script src="<?= base_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>
	<!-- Ladda -->
	<script src="<?= base_url('assets/plugins/ladda/js/spin.min.js'); ?>"></script>
	<script src="<?= base_url('assets/plugins/ladda/js/ladda.min.js'); ?>"></script>
	<script src="<?= base_url('assets/plugins/ladda/js/ladda.jquery.min.js'); ?>"></script>
	<!-- Admin Js -->
	<script src="<?= base_url( Helper::file_version('assets/js/admin.js') ); ?>"></script>

	<?php
		// Additional Js
		if(! empty($assets['js']) && is_array($assets['js'])) {
			foreach ($assets['js'] as $jsAsset) {
				echo '<script type="text/javascript" src="'.base_url( Helper::file_version('assets/'.$jsAsset) ).'"></script>';
			}
		}
	?>
</body>
</html>
