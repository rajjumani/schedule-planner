<?php
include 'session.php';
include 'commonhead.php';
//include 'dbcontroller.php';

function get_sewa()
{
	$db_handle = new DBController();
	global $year, $month;

	$monthObj   = DateTime::createFromFormat('!m', $month);
	$monthName = $monthObj->format('M');

	$year_short = substr($year, 2, 4);

	$master_table = "master"."-".$monthName."-".$year_short;

	$sewa = $db_handle->runQuery("SELECT * FROM `".$master_table."` WHERE TRIM(sk_sr)<>''");
	
	return $sewa;
}

function get_centres()
{
	require 'conn.php';
	$runz = mysqli_query($con,"SELECT * FROM `centres`");

	$centre_list = array();
	$centres = array();
	while($object = mysqli_fetch_array($runz))
	{
		$centre_list[] = $object;
	}

	foreach ($centre_list as $centre) {
		array_push($centres, $centre['name']);
	}
	mysqli_close($con);
	return $centres;
}

function get_table()
{
	$db_handle = new DBController();
	$centres = get_centres();
	$temp_month = date('d-M-y',strtotime('first day of -1 year', strtotime(date('M-y'))));

	$masterList = array();
	for ($i=0; $i < 12; $i++) {
		$temp_month = date('d-M-y',strtotime('first day of +1 month', strtotime($temp_month)));
		$masterData = explode("-", $temp_month);
		$masterName = "master-".$masterData[1]."-".$masterData[2];
		array_push($masterList, $masterName);
	}

	$sk_names = $db_handle->runQuery("SELECT sewadar_name FROM sewadars WHERE type = 'SK'");
	
	$sr_name = array();
	$table_str = "";
	$skArray = array();

	if (!empty($sk_names)) {
		foreach ($sk_names as $sewa) {
			array_push($skArray, "SK: ".$sewa['sewadar_name']);
		}
	}
	sort($skArray);
	$sewaList = array();

	foreach ($skArray as $sk_name) {
		$sewa_lo = array();
		foreach ($masterList as $master_table) {
			$sewa_center = array();
			$sk_array = $db_handle->runQuery("SELECT centre_name FROM `".$master_table."` WHERE sk_sr = '".$sk_name."'");
			$key = "";
			if(!empty($sk_array)){
				foreach ($sk_array as $kl) {
					foreach ($kl as $kmg) {
						$key = $sk_name."-".$kmg;
						if(array_key_exists($key, $sewaList)){
							if(!in_array($key."-".$master_table, $sewa_center)){
								$sewaList[$key] = $sewaList[$key].",".$master_table;
								array_push($sewa_center, $key."-".$master_table);
							}
						}
						else{
							$sewaList[$key] = $master_table;
							array_push($sewa_center, $key."-".$master_table);
						}
					}
				}
			}
		}
	}
	$row_count = sizeof($skArray);
	$col_count = sizeof($centres);
	$col_width = (100/($col_count+3)).'%';

	$table_str .= '<table border = 1 width= "100%" style = "margin = 0px;padding = 0px;height=100%">';

	for ($row = 1; $row <= $row_count + 1; $row++) 
	{		
		$skName = "";
		$table_str .= '<tr align="center">';
		if ($row != 1) {
			$skName = $skArray[$row - 2];
		}

		for ($col=1; $col <= $col_count + 2; $col++) {
				
			if ($row == 1) 
			{
				if ($col == 1) {
					$table_str .= '<th>Sr No.</th>';
				}
				else if ($col == 2) {
					$table_str .= '<th width =12%>SK</th>';
				}
				else {
					$table_str .= '<th width = '.$col_width.'>'.$centres[$col - 3].'</th>';
				}	
			}
			else {

				$sewa_month = '';

				if ($col == 1) {
					$table_str .= '<th width = '.$col_width.'>'.($row-1).'</th>';
				}
				else if ($col == 2) {
					$table_str .= '<td width =10% style="text-align: left;">'.explodeCheck($skName, ":").'</td>';
				}
				else {
					if(array_key_exists($skName."-".$centres[$col - 3], $sewaList)){

						$centre_name = $sewaList[$skName."-".$centres[$col - 3]];
						$masterMonthList = explode(",", $centre_name);
						foreach ($masterMonthList as $masterData) {
							$temp = explode("-", $masterData);
							$sewa_month = $sewa_month.$temp[1]."-".$temp[2]."\t";
						}
						
					}

					$table_str .= '<td width = '.$col_width.'>'.$sewa_month.'</td>';
				}
			}
		}
		$table_str .= '</tr>';
	}

	$table_str .= '</table>';

	return $table_str;
}

function getWeekdays($y, $m, $w)
{
    return new DatePeriod(
        new DateTime("first ".$w." of $y-$m"),
        DateInterval::createFromDateString('next '.$w),
        new DateTime("next month $y-$m-01")
    );
}
function explodeCheck($str, $del)
{	
	if (strpos($str, $del) != false) {
		return TRIM(explode($del, $str)[1]);
	} else {
		return "";
	}
}
?>

<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
						
		<?php echo get_table();		
				
		?>
		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->
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
		<script>
		function showEdit(editableObj) {
			$(editableObj).css("background","#FFF");
		} 
		
		function saveToDatabase(editableObj, row, col, master, weekday) {
			console.log('row='+row+'&editval='+editableObj.innerHTML+'&col='+col+'&master='+master+'&weekday='+weekday);

			$(editableObj).css("background","#FFF url(assets/images/loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "saveedit.php",
				type: "POST",
				data:'row='+row+'&editval='+editableObj.innerHTML+'&col='+col+'&master='+master+'&weekday='+weekday,
				success: function(data){
					$(editableObj).css("background","#FDFDFD");
				}        
		   });
		}
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

		tr, td, th {
		    text-align: center;
			font-family:arial;
		}
	</style>
</html>
