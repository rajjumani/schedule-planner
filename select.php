<?php
include 'commonhead.php';
include 'dbcontroller.php';

	if (isset($_GET['centre']) && isset($_GET['day'])) {
		$centre_name = $_GET['centre'];
		$day = $_GET['day'];
		$row = $_GET['row'];
		$col = $_GET['col'];
		$formatted_date = $_GET['date'];
		$master = $_GET['master'];
	}

	if ($row%4 == 0 ) {
		$sewadar_type = "Ground Pathi";
	}
	elseif ($row%4 == 1) {
		$sewadar_type ="Baani";
	}
	elseif ($row%4 == 2) {
		$sewadar_type ="SK/SR";
	}
	elseif ($row%4 == 3) {
		$sewadar_type ="Pathi";
	}

	$db_handle = new DBController();
	$result = $db_handle->runQuery("SELECT * FROM `".$master."` WHERE centre_name = '".$centre_name."' AND day = '".$day."' AND col =".$col);

	foreach ($result as $r) {
		$full_date = $r['date'];
		$date = date("d.m.Y", strtotime($r['date']));
	}
?>

<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
						
		<form class="form-horizontal" role="form" name="centreform" method="post">
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Centre Name: </label>

							<div class="col-sm-9">
								<input type="text" name="centre_name" id="centre_name" class="col-ms-2" value= "<?php echo $centre_name?>" disabled/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Date: </label>

							<div class="col-sm-9">
								<input type="text" name="date" id="date" class="col-ms-2" value= "<?php echo $date?>" disabled/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php echo $sewadar_type;?>: </label>

							<div class="col-sm-9">
								<?php 
									if (strcmp($sewadar_type, "Baani") == 0) {
										$sewa_list_for_baani = $db_handle->runQuery("SELECT * FROM `".$master."` WHERE centre_name = '".$centre_name."' AND date = '".$formatted_date."'");
										$baani_sewadar = '';
										foreach ($sewa_list_for_baani as $baani_sewa_data) {
											$baani_sewadar = $baani_sewa_data["sk_sr"];
										}
										$sewadar_for_baani = trim(explode(":",$baani_sewadar)[1]);
										$baani_list = $db_handle->executeUpdate("SELECT * FROM baani WHERE sewadar_name = '".$sewadar_for_baani."'");
										$sewa_select = '<input type="text" class="col-ms-2" name="sewadar_name"  list="sewadar_name" autocomplete="off">';
										$sewa_select .= '<datalist id="sewadar_name">';	
										foreach ($baani_list as $sewadar_baani) {
											$sewa_select .= '<option value="'.$sewadar_baani["baani_name"].'"></option>';
										}
										$sewa_select .= "</datalist>";
									} else {
										$sewa_select = '<input type="text" name="sewadar_name" id="sewadar_name" class="col-ms-2" autocomplete="off" />';
									}
									echo $sewa_select;
								?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Satsang No: </label>

							<div class="col-sm-9">
								<input type="text" name="satsang_no" id="satsang_no" class="col-ms-2" autocomplete="off"/>
							</div>
						</div>

					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-3">
							<button class="btn btn-info" type="submit">
								<i class="ace-icon fa fa-check bigger-110"></i>
								Submit
							</button>

							<button class="btn btn-info" type="button" onClick="self.close();">
								<i class="ace-icon fa fa-close bigger-110"></i>
								Close
							</button>
						</div>
					</div>
				</form>
		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->
<?php
	$db_handle = new DBController();

	$cd_list = array('CD', 'CD/DVD', 'Huzur Maharaj Audio Satsang', 'Huzur Maharaj Video Satsang');

	if(isset($_POST['sewadar_name']) && !empty($_POST['sewadar_name'])){ 
		$sewadar_name = $_POST['sewadar_name'];
		$satsang_no = $_POST['satsang_no'];
		$leave_count = 0;

		$sewadar_leave_list = $db_handle->runQuery("SELECT * FROM leaves WHERE sewadar_name = '".$sewadar_name."'");
		foreach ($sewadar_leave_list as $sewadar_leave) {
			if (($full_date >= $sewadar_leave['from_date']) && ($full_date <= $sewadar_leave['to_date'])) {
				$leave_count++;
			}
		}
		
		if (strcmp($sewadar_type, "SK/SR") == 0) {
			$db = "sk_sr";
			$sewadar_list = $db_handle->runQuery("SELECT * FROM sewadars WHERE sewadar_name = '".$sewadar_name."'");
			foreach ($sewadar_list as $sewadar) {
				$db_short = $sewadar["type"].": ";
			}
			$com_name = $db_short.$sewadar_name;
			if (!in_array($sewadar_name, $cd_list)) {
				$sewa_list = $db_handle->runQuery("SELECT * FROM `".$master."` WHERE ".$db." = '".$com_name."' AND date = '".$formatted_date."'");
				$count = 0;
				foreach ($sewa_list as $alloted_sewa) {
					$alloted_centre = $alloted_sewa["centre_name"];
					$count++;
					if(strpos($centre_name, "Evening") !== false && strpos($alloted_centre, "Evening") !== false) {
						break;
					} else if(strpos($centre_name, "Evening") !== false || strpos($alloted_centre, "Evening") !== false) {
						$count--;
					} 
				} 
			} else {
				$db_short = "";
				$com_name = $sewadar_name;
			}
			if($count > 0){
				$sk_result = $db_handle->runQuery("SELECT * FROM `".$master."` WHERE centre_name = '".$centre_name."' AND date = '".$formatted_date."'");
				foreach ($sk_result as $sk_res) {
					if($sk_res["row"] < 700){
						$db_sk_name = $sk_res["sk_sr"];
					}
				}
				
				if(strcmp($com_name, $db_sk_name) == 0){
					$count = 0;
				}
			}
		}
		elseif (strcmp($sewadar_type, "Pathi") == 0) {
			$db ="pathi";
			if (strcmp(TRIM($sewadar_name), '') != 0) {
				$db_short = "PA: ";
				$sewa_list = $db_handle->runQuery("SELECT * FROM `".$master."` WHERE (`pathi` = 'PA: ".$sewadar_name."' OR `ground` = 'SS: ".$sewadar_name."') AND (date = '".$formatted_date."')");
				$count = 0;
				foreach ($sewa_list as $alloted_sewa) {
					$alloted_centre = $alloted_sewa["centre_name"];
					$count++;
					if(strpos($centre_name, "Evening") !== false && strpos($alloted_centre, "Evening") !== false) {
						break;
					} else if(strpos($centre_name, "Evening") !== false || strpos($alloted_centre, "Evening") !== false) {
						$count--;
					} 
				} 
			} else {
				$count = 0;
			}
		}
		elseif (strcmp($sewadar_type, "Ground Pathi") == 0) {
			$db ="ground";
			$db_short = "SS: ";
			$sewa_list = $db_handle->runQuery("SELECT * FROM `".$master."` WHERE (`pathi` = 'PA: ".$sewadar_name."' OR `ground` = 'SS: ".$sewadar_name."') AND (date = '".$formatted_date."')");
			$count = 0;
			foreach ($sewa_list as $alloted_sewa) {
				$alloted_centre = $alloted_sewa["centre_name"];
				$count++;
				if(strpos($centre_name, "Evening") !== false && strpos($alloted_centre, "Evening") !== false) {
					break;
				} else if(strpos($centre_name, "Evening") !== false || strpos($alloted_centre, "Evening") !== false) {
					$count--;
				} 
			} 
		}
		elseif (strcmp($sewadar_type, "Baani") == 0) {
			$db ="baani";
			$db_short = "BAANI: ";
			$count = 0;
		}

		if ($leave_count == 0) {
			if ($count == 0) {
				if (TRIM($sewadar_name) == "") {
					$db_short = "";
					$sewadar_name = "";
				}
				
				if ($satsang_no == '') {
					$result = $db_handle->executeUpdate("UPDATE `".$master."` set ". $db . " = '".$db_short.$sewadar_name."' WHERE  centre_name = '".$centre_name."' AND day = '".$day."' AND col =".$col);
				} else {
					$satsang_no = "(".$satsang_no.")";
					$result = $db_handle->executeUpdate("UPDATE `".$master."` set ". $db . " = '".$db_short.$sewadar_name."', satsang_no = '".$satsang_no."' WHERE centre_name = '".$centre_name."' AND day = '".$day."' AND col =".$col);
				}

				echo "<script>
				    window.opener.location.reload();
					window.close();
				  </script>";

			} else {
				echo "<script>
				    alert('Sewadar Already Alloted');
				  </script>";
			}
		} else {
			echo "<script>
				    alert('Sewadar on leave');
				  </script>";
		}
	}

function explodeCheck($str, $del)
{	
	if (strpos($str, $del) != false) {
		return TRIM(explode($del, $str));
	} else {
		return "";
	}
}
?>
			</div><!-- /.page-content -->


			
		</div>
	</div><!-- /.main-content -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
 	 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

 	 	<script>
		$(document).ready(function(){
		 
		 $('#sewadar_name').typeahead({
		  source: function(query, result)
		  {
		   $.ajax({
		    url:"fetch.php",
		    method:"POST",
		    data:{query:query},
		    dataType:"json",
		    success:function(data)
		    {
		     result($.map(data, function(item){
		      return item;
		     }));
		    }
		   })
		  }
		 });
		 
		});
		</script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 var $sidebar = $('.sidebar').eq(0);
			 if( !$sidebar.hasClass('h-sidebar') ) return;
			
			 $(document).on('settings.ace.top_menu' , function(ev, event_name, fixed) {
				if( event_name !== 'sidebar_fixed' ) return;
			
				var sidebar = $sidebar.get(0);
				var $window = $(window);
			
				//return if sidebar is not fixed or in mobile view mode
				var sidebar_vars = $sidebar.ace_sidebar('vars');
				if( !fixed || ( sidebar_vars['mobile_view'] || sidebar_vars['collapsible'] ) ) {
					$sidebar.removeClass('lower-highlight');
					//restore original, default marginTop
					sidebar.style.marginTop = '';
			
					$window.off('scroll.ace.top_menu')
					return;
				}
			
			
				 var done = false;
				 $window.on('scroll.ace.top_menu', function(e) {
			
					var scroll = $window.scrollTop();
					scroll = parseInt(scroll / 4);//move the menu up 1px for every 4px of document scrolling
					if (scroll > 17) scroll = 17;
			
			
					if (scroll > 16) {			
						if(!done) {
							$sidebar.addClass('lower-highlight');
							done = true;
						}
					}
					else {
						if(done) {
							$sidebar.removeClass('lower-highlight');
							done = false;
						}
					}
			
					sidebar.style['marginTop'] = (17-scroll)+'px';
				 }).triggerHandler('scroll.ace.top_menu');
			
			 }).triggerHandler('settings.ace.top_menu', ['sidebar_fixed' , $sidebar.hasClass('sidebar-fixed')]);
			
			 $(window).on('resize.ace.top_menu', function() {
				$(document).triggerHandler('settings.ace.top_menu', ['sidebar_fixed' , $sidebar.hasClass('sidebar-fixed')]);
			 });
			
			
			});
		</script>
	</body>
	<style type="text/css">
		body {
		width: 100%;
		height: 100%;
		padding: 0px;
		margin: 0px;
		}

		html {
		width: 100%;
		height: 100%;
		padding: 0px;
		margin: 0px;
		}

		table {
		width: 95%;
		height: 95%;
		padding: 0px;
		margin: 0px;
		}

		tr,td {
			border: 1px solid black;
		}

		#col0 {
		float: left;
		width: 50%;
		height: 100%;
		padding: 0px;
		margin: 0px;
		}

		#col1 {
		float: right;
		width: 50%;
		height: 100%;
		padding: 0px;
		margin: 0px;
		}

		#rect0 {
		width: 100%;
		height: 50vh;
		padding: 0px;
		margin: 0px;
		}

		#rect1 {
		width: 100%;
		height: 50vh;
		padding: 0px;
		margin: 0px;
		}

		#rect2 {
		width: 100%;
		height: 50vh;
		padding: 0px;
		margin: 0px;
		}

		#rect3 {
		width: 100%;
		height: 50vh;
		padding: 0px;
		margin: 0px;
		}
	</style>
</html>