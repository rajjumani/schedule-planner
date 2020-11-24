<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Schedule Planner</title>

		<meta name="description" content="top menu &amp; navigation" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse          ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<ul class="nav nav-list">
					<li class="hover">
						<a href="index.php">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Home </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="hover">
						<a href="master_month_selector.php">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text"> Master </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="hover">
						<a href="pathi_balsatsang_month_selector.php">
							<i class="menu-icon fa fa-group"></i>
							<span class="menu-text"> Bal Satsang </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="hover">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-book"></i>
							<span class="menu-text"> Slip </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="hover">
								<a href="sk_month_selector.php">
									<span class="menu-text"> SK Slip </span>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="hover">
								<a href="sr_month_selector.php">
									<span class="menu-text"> SR Slip </span>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="hover">
								<a href="pathi_month_selector.php">
									<span class="menu-text"> Pathi Slip </span>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="hover">
								<a href="extra_slip_month_selector.php">
									<span class="menu-text"> Extra Slips </span>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="hover">
								<a href="blank_slip_month_selector.php">
									<span class="menu-text"> Blank Slips </span>
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					

					<li class="hover">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-building"></i>
							<span class="menu-text"> Monthly Sewa List </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="hover" align="center">
								<a href="sk_list_month_selector.php">
									<span class="menu-text"> SK </span>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="hover" align="center">
								<a href="sr_list_month_selector.php">
									<span class="menu-text"> SR </span>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="hover" align="center">
								<a href="pathi_list_month_selector.php">
									<span class="menu-text"> Pathi </span>
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li class="hover">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-calendar-o"></i>
							<span class="menu-text"> Yearly Sewa List </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="hover" align="center">
								<a href="sk_month.php">
									<span class="menu-text"> SK </span>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="hover" align="center">
								<a href="sr_month.php">
									<span class="menu-text"> SR </span>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="hover" align="center">
								<a href="pathi_month.php">
									<span class="menu-text"> Pathi </span>
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li class="hover">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-caret-square-o-left"></i>
							<span class="menu-text"> Last Sewa </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="hover" align="center">
								<a href="sk_last_sewa.php">
									<span class="menu-text"> SK </span>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="hover" align="center">
								<a href="sr_last_sewa.php">
									<span class="menu-text"> SR </span>
								</a>

								<b class="arrow"></b>
							</li>

							<li class="hover" align="center">
								<a href="pathi_last_sewa.php">
									<span class="menu-text"> Pathi </span>
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li class="hover">
						<a href="leave_month_selector.php">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text"> Leaves </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="hover" style="position:fixed; right:5px;">
						<a href="logout.php">
							<i class="menu-icon fa fa-sign-out"></i>
							<span class="menu-text"> Log Out </span>
						</a>

						<b class="arrow"></b>
					</li>

				</ul><!-- /.nav-list -->
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">