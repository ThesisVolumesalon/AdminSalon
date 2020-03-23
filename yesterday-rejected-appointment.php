<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{ ?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Rejected Appointment</title>
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<link href="css/font-awesome.css" rel="stylesheet"> 
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/modernizr.custom.js"></script>
		<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
		<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
		<script src="js/wow.min.js"></script>
		<script>
		 	new WOW().init();
		</script>
		<script src="js/metisMenu.min.js"></script>
		<script src="js/custom.js"></script>
		<link href="css/custom.css" rel="stylesheet">

</head> 

<body class="cbp-spmenu-push">
	<div class="main-content">

		 <?php include_once('includes/sidebar.php');?>
		 <?php include_once('includes/header.php');?>

		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<div class="table-responsive bs-example widget-shadow">
			<h3 class="title1">REJECTED APPOINTMENT YESTERDAY</h3>
            <button class="btn  bckclrgreen" align="Left" ><a href="yesterday-accepted-appointment.php"> ACCEPT RESERVATION YESTERDAY</a></button>
            <button class="btn  bckclrred" align="Left" ><a href="yesterday-rejected-appointment.php"> REJECT RESERVATION YESTERDAY</a></button>
						<table class="table table-bordered"> 
							<thead> 
								<tr> 
									<th>#</th> 
									<th> Appointment Number</th> 
									<th>Name</th><th>Mobile Number</th> 
									<th>Appointment Date</th>
									<th>Appointment Time</th>
									<th>Action</th> 
								</tr> 
							</thead> 
							<tbody>
<?php $sql = "SELECT
            user_id,
            useremail,
            userphonenumber ,
            CONCAT(userfirstname ,' ',
                 usermidlename, ' ',
                 userlastname) AS FULLNAME, 
            AptTime,
            AptNumber,
            AptDate  , 
            Services_id, 
            ApplyDate ,
            Remark,
            RemarkDate , 
            Status 
            from  tblusers U, 
            	  tblappointment ap 
          	where 
            U.user_id =  ap.userid 
            and date(AptDate)=CURDATE()-1 
            and Status = 2 
            order by AptDate, AptTime DESC";

        $retValue= mysqli_query($con,$sql);
		$cnt=1;
		while ($row=mysqli_fetch_array($retValue)) { ?>
						 <tr> 
						 	<th scope="row"><?php echo $cnt;?></th> 
						 	<td><?php  echo $row['AptNumber'];?></td> 
						 	<td><?php  echo $row['FULLNAME'];?></td>
						 	<td><?php  echo $row['userphonenumber'];?></td>
						 	<td><?php  echo $row['AptDate'];?></td>
						 	<td><?php  echo $row['AptTime'];?></td> 
						 	<td><a href="view-appointment.php?viewid=<?php echo $row['user_id'];?>">View</a></td> 
						 </tr> <?php $cnt=$cnt+1; } ?> 
						</tbody> 
					</table> 
					</div>
				</div>
			</div>
		</div>
		
		 <?php include_once('includes/footer.php');?>
        
	</div>

		<script src="js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			
			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>

	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/bootstrap.js"> </script>
</body>
</html>
<?php }  ?>