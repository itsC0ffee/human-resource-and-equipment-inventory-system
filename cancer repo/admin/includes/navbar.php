<?php include('../includes/session.php')?>
<div class="header">
		<div class="header-left">
	
			  <!--digital clock start-->
			  <div class="datetime">
		<div class="date">
		  <span id="dayname">Day</span>,
		  <span id="month">Month</span>
		  <span id="daynum">00</span>,
		  <span id="year">Year</span>
		</div>
		<div class="time">
		  <span id="hour">00</span>:
		  <span id="minutes">00</span>:
		  <span id="seconds">00</span>
		  <span id="period">AM</span>
		</div>
	  </div>
	  <!--digital clock end-->
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
			
		</div>
		<div class="header-right">
			<div class="dashboard-setting user-notification">
				<div class="dropdown">
					
				</div>
			</div>
			
			<div class="user-info-dropdown">
				<div class="dropdown">
					<?php $query= mysqli_query($conn,"select * from hr_employees where emp_id = '$session_id'") or die(mysqli_error());
								$row = mysqli_fetch_array($query);
						?>

					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="<?php echo (!empty($row['location'])) ? '../uploads/'.$row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" alt="">
						</span>
						<span class="user-name"><?php echo $row['first_name']. " " .$row['last_name']; ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item" href="my_profile.php"><i class="dw dw-user1"></i> Profile</a>
						<a class="dropdown-item" href="change_password.php"><i class="dw dw-help"></i> Reset Password</a>
						<a class="dropdown-item" href="../logout.php"><i class="dw dw-logout"></i> Log Out</a>
					</div>
				</div>
			</div>
			
		</div>
	</div>

	<script type="text/javascript"> 
	function updateClock(){
	var now = new Date();
	var dname = now.getDay(),
		mo = now.getMonth(),
		dnum = now.getDate(),
		yr = now.getFullYear(),
		hou = now.getHours(),
		min = now.getMinutes(),
		sec = now.getSeconds(),
		pe = "AM";

		if(hou >= 12){
		  pe = "PM";
		}
		if(hou == 0){
		  hou = 12;
		}
		if(hou > 12){
		  hou = hou - 12;
		}

		Number.prototype.pad = function(digits){
		  for(var n = this.toString(); n.length < digits; n = 0 + n);
		  return n;
		}

		var months = ["January", "February", "March", "April", "May", "June", "July", "Augest", "September", "October", "November", "December"];
		var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
		var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
		var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
		for(var i = 0; i < ids.length; i++)
		document.getElementById(ids[i]).firstChild.nodeValue = values[i];
  }

  function initClock(){
	updateClock();
	window.setInterval("updateClock()", 1);
  }

  window.onload = initClock();
	</script> 
