<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
    if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {
      $cid = $_GET['viewid'];
      $idup = $_POST['idUpdate'];
      $remark=$_POST['remark'];
      $status=$_POST['status'];
      $beautician = $_POST['beautician'];
     
   $query=mysqli_query($con, "update tblappointment set  
                              beautician_id = '$beautician', 
                              Remark = '$remark',
                              Status = '$status' 

                              where userid = '$cid' and ID = '$idup'");
    if ($query) {
    $msg="All remark has been updated.";
    header("location: ");
  }
  else
    {
      $msg="Something Went Wrong. Please try again";
    }

}
  

  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>View Appointment</title>

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
          <?php

  $cid=$_GET['viewid'];
  $sql = "SELECT  user_id,
              CONCAT(userfirstname ,' ',
                           usermidlename, ' ',
                           userlastname) AS FULLNAME, 
                           useremail,
                           userphonenumber ,
              CONCAT(houseNumber,' ',
                           streetName,' ',
                           barangay,' ',
                           city,' ' ,
                           province,' ',
                           country,' ',
                           zipCode) as ADDRESS,
                           ServiceName,
              ID,           
              AptTime,
              AptNumber,
              AptDate  , 
              Services_id, 
              ApplyDate ,
              Remark,
              RemarkDate , 
              Status,

          CONCAT(employeeFirstName,' ',
                          employeeMidleName, ' ',
                           employeeLastName) AS BeauticianName   
              from tblusers U, 
                  tblappointment ap, 
                  tbluseraddress AD,
                  tblServices ser,
                  tblemployee employ
              where 
              U.user_id =  $cid and 
              AD.userid = $cid and 
              ap.userid = $cid and 
              ap.Services_id = ser.Service_id and
              ap.beautician_id =  employ.employeeId and ap.Status = ''";

        $ret = mysqli_query($con,$sql);
$cnt=1;
while ($row=mysqli_fetch_array($ret)) { ?>
					<h3 class="title1">APPOINTMENT DETAILS of: <label><?php echo $row['FULLNAME'];?></label></h3> 

					<div class="table-responsive bs-example widget-shadow">
						<p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;  }  ?> </p>

            <button class="btn" style="font-size:16px; color:red" align="Left" ><a href="all-appointment.php"> ALL APPOINTMENT</a></button>
						<table class="table table-bordered">
	<tr>
    <th>Appointment Number</th>
    <td><?php  echo $row['AptNumber'];?></td>
  </tr>

  <tr>
      <th>Name</th>
      <td><?php  echo $row['FULLNAME'];?></td>
  </tr>

    <tr>
       <th>ADDRESS</th>
        <td>
        <?php echo $row['ADDRESS'];?>
        </td>
    </tr>

  <tr>
    <th>Email</th>
    <td><?php  echo $row['useremail'];?></td>
  </tr>

   <tr>
    <th>Mobile Number</th>
    <td><?php  echo $row['userphonenumber'];?></td>
  </tr>
   <tr>
    <th>Appointment Date</th>
    <td><?php  echo $row['AptDate'];?></td>
  </tr>
 
<tr>
    <th>Appointment Time</th>
    <td><?php  echo $row['AptTime'];?></td>
</tr>
  
<tr>
    <th>Services</th>
    <td><?php  echo $row['ServiceName'];?></td>
</tr>

<tr>
    <th>Apply Date</th>
    <td><?php  echo $row['ApplyDate'];?></td>
</tr>

<tr>
    <th>Beautician Name</th>
    <td><?php  echo $row['BeauticianName'];?></td>
</tr>

  
  
  

<tr>
    <th>Status</th>
    <td> <?php  
if($row['Status']=="1")
{
  echo "Accept";
}

if($row['Status']=="2")
{
  echo "Rejected";
}

     ;?></td>
  </tr>

</table>
  <table class="table table-bordered">
							<?php if($row['Remark']==""){ ?>
    <form name="submit" method="post" enctype="multipart/form-data"> 
      <tr>
        <th>Remark:</th>
        <td>
          <textarea name="remark" placeholder="" rows="12" cols="14" class="form-control wd-450" required="true"></textarea></td>
      </tr>

<tr>
    <th>Status:</th>
    <td>
      <input type="hidden" name="idUpdate"  value="<?php echo $row['ID']; ?>">
        <select name="status" class="form-control wd-450" required="true" >
          <option value="1" selected="true">Accept</option>
          <option value="2">Rejected</option>
        </select>
      </td>
  </tr>


  <tr>
    <th>Choice Beutycian :</th>
    <td>
      <select name="beautician"  class="form-control wd-450" >
      <?php $sql1 = "SELECT employeeId, Concat(employeeFirstName, ' ',
                                          employeeMidleName, ' ',
                                          employeeLastName ) as EmployeeName from tblemployee";
      $ret1 = mysqli_query($con,$sql1); 
      while ( $row1=mysqli_fetch_array($ret1)) { ?>
        <option value="<?php echo $row1['employeeId']; ?>"><?php echo $row1['EmployeeName']; ?></option>
          <?php } ?>
      </select>
    </td>
  </tr>

  


  <tr align="center">
    <td colspan="2"><button type="submit" name="submit" class="btn btn-az-primary pd-x-20">Submit</button></td>
  </tr>



  </form>
<?php } else { ?>
						</table>
						<table class="table table-bordered">
							<tr>
    <th>Remark</th>
    <td><?php echo $row['Remark']; ?></td>
  </tr>


<tr>
<th>Remark date</th>
<td><?php echo $row['RemarkDate']; ?>  </td></tr>


						</table>
						<?php } ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>


		<!--footer-->
		
        <!--//footer-->
	</div>
	<!-- Classie -->
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
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js"> </script>
</body>
</html>
<?php }  ?>