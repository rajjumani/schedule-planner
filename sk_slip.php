<?php
include 'session.php';
include 'commonhead.php';
//include 'dbcontroller.php';

$month_year = $_POST['NoIconDemo'];
$n = 0;
if($month_year !=''){
	$month_years = explode("/", $month_year);
	$month = $month_years[0];
	$year = $month_years[1];
}
else{
echo "<p>Insertion Failed <br/> Some Fields are Blank....!!</p>";
}

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

function get_table()
{
	$db_handle = new DBController();

	global $year, $month, $n;

	$monthObj   = DateTime::createFromFormat('!m', $month);
	$monthName = $monthObj->format('M');

	$year_short = substr($year, 2, 4);

	$master_table = "master"."-".$monthName."-".$year_short;

	$sewa_list = get_sewa();
	$sr_name = array();
	$table_str = "";

	$weekday_list = array("SUNDAY", "WEDNESDAY", "THURSDAY");
	$weekdays = array();

	foreach ($weekday_list as $w) {
		foreach (getWeekdays($year, $month, $w) as $weekday) {
			$weekdays[$weekday->format("d")] = substr($w, 0, 3);
		}
	}
	ksort($weekdays);

	$sr_names = array();

	if (!empty($sewa_list)) {
		foreach ($sewa_list as $sewa) {
			if (!in_array($sewa['sk_sr'], $sr_names)) {
				
				$sr = explode(":", $sewa['sk_sr']);

				if (strcmp($sr[0], "SK") == 0) {

					if ($n%4 == 0) {
						$div = '<div id="col0">
										<div id="rect0">';
						$div_end = '</div>';
					}
					elseif ($n%4 == 1) {
						$div = '<div id="rect2">';
						$div_end = '</div></div>';
					}

					elseif ($n%4 == 2) {
						$div = '<div id="col1">
										<div id="rect1">';
						$div_end = '</div>';
					}

					elseif ($n%4 == 3) {
						$div = '<div id="rect3">';
						$div_end = '</div></div>';
					}

					$table_str .= $div;
					array_push($sr_names, $sewa['sk_sr']);
					
					$table_str .= '<table border = 1 width= "30%" style = "margin = 0px;padding = 0px;height=100%">';

					for ($row = 1; $row <= 3; $row++) 
					{

						$table_str .= '<tr>';
						for ($col=1; $col <= 4; $col++) {
								
							if ($row == 1) 
							{
								if ($col ==1) {
									$table_str .= '<th colspan = 3 width = "60%">'."SATSANG KARTA SEWA SLIP".'</th>';
									$col++;
								}
								elseif ($col ==3) {
									$dateObj   = DateTime::createFromFormat('!m', $month);
									$monthName = $dateObj->format('M');

									$year_short = substr($year, 2, 4);
									
									$table_str .= '<th width = "40%">'.$monthName."-".$year_short.'</th>';
									$col++;
								}
								
							}

							elseif ($row == 2) 
							{
								$table_str .= '<th colspan = 4>'."Name: ".$sr[1].'</th>';
								break;
							}

							elseif ($row == 3) 
							{
								if ($col ==1) {
									$table_str .= '<th width = "10%">'."DT.".'</th>';
								}
								elseif ($col ==2) {
									$table_str .= '<th width = "20%">'."DAY".'</th>';
								}
								elseif ($col ==3) {
									$table_str .= '<th width = "35%">'."SATSANG PLACE".'</th>';
								}
								elseif ($col ==4) {
									$table_str .= '<th width = "35%">'."PATHI".'</th>';
								}
							}
						}
						
						$table_str .= '</tr>';
					}

					$sr_array = $db_handle->runQuery("SELECT * FROM `".$master_table."` WHERE sk_sr = '".$sewa['sk_sr']."'");
					foreach ($weekdays as $date => $day) {
						
						$table_str .= '<tr>';
						
						$table_str .= '<td width = "10%">'.$date.'</td>';

						$table_str .= '<td width = "20%">'.$day.'</td>';

						$centre_name = "";
						$baani = "";
						$pathi = "";
						$satsang_no = "";

						foreach ($sr_array as $sr_name) {

							$d = date('d', strtotime($sr_name['date']));

							if (strcmp($d, $date) == 0) {

								$centre_name = $sr_name['centre_name'];
								$baani = "\n".$sr_name['baani'];
								$pathi = explodeCheck($sr_name['pathi'], ":");

								if (strpos($sr_name['satsang_no'], ')') !== false) {
									$satsang_no = $sr_name['satsang_no'];
								}
							}
						}
						$date_full = $date.'.'.$month.'.'.$year;
						$sk_name = $sewa['sk_sr'];
						
						/*$table_str .= '<td width = "35%" contenteditable="true" onBlur="saveToDatabase(';
						$table_str .= "'centre_name', ";
						$table_str .= 'this, ';
						$table_str .= "'".$master_table."', ";
						$table_str .= "'".$sk_name."', ";
						$table_str .= "'".$date_full."', ";
						$table_str .= "'".$day."'";
						$table_str .= ")";
						$table_str .= '" onClick="showEdit(this)">'.$centre_name.'</td>';*/
						$table_str .= '<td width = "35%">'.$centre_name.'</td>';

						$table_str .= '<td width = "35%">'.nl2br($pathi." ".$satsang_no.$baani).'</td>';

						$table_str .= '</tr>';
					}

					$table_str .= '<tr rowspan = 4>';

					$table_str .= '<th colspan = 4 style="text-align: right; height = 70px; padding-top: 15%;">'."SECRETARY, AHMEDABAD".'</td>';

					$table_str .= '</tr>';

					$table_str .= '</table>';

					$table_str .= $div_end;

					$n++;
				}
				
			}
		}
	}
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
		function showEdit(editableValue) {
			$(editableValue).css("background","#FFF");
		} 
		
		function saveToDatabase(editableObj, editableValue, master, sk_sr, date, weekday) {
			console.log('editObj='+editableObj+'&editval='+editableValue.innerHTML+'&master='+master+'&sk_sr='+sk_sr+'&date='+date+'&day='+weekday);

			$(editableObj).css("background","#FFF url(assets/images/loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "sk_saveedit.php",
				type: "POST",
				data:'editObj='+editableObj+'&editVal='+editableValue.innerHTML+'&master='+master+'&sk_sr='+sk_sr+'&date='+date+'&day='+weekday,
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

		table {
		width: 95%;
		height: 95%;
		padding: 0px;
		margin: 0px;
		}

		tr,td, th {
			border: 1px solid black;
			text-align: center;
			font-family:arial;
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
