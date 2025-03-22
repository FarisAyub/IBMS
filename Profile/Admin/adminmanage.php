<?php
require('../../connect.php');
$ROOT = '../../'; 
include $ROOT.'nav.php';
$username = $_SESSION['username'];
$result1 = mysqli_query($connect, "SELECT * FROM `FYP-Homeins`") or die(mysqli_error($connect));
$result2 = mysqli_query($connect, "SELECT * FROM `FYP-Healthins`") or die(mysqli_error($connect));
$result3 = mysqli_query($connect, "SELECT * FROM `FYP-Vehicleins`") or die(mysqli_error($connect));
$result4 = mysqli_query($connect, "SELECT * FROM `FYP-Accounts`") or die(mysqli_error($connect));
$result5 = mysqli_query($connect, "SELECT * FROM `FYP-Policies`") or die(mysqli_error($connect));

if ($_SESSION['level'] == "2") {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    
      <title>Insurance Brokerage</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      
    </head>
    
    <body>
    <div class="container">
    <br>
    <div class="card card-dark">
            <div class="card-header">
            <!--- Tab definition --->
            <ul class="nav nav-tabs bg-dark navbar-dark" id="policyTab" role="tablist" style="border-bottom: none;">
              <li class="nav-item">
              	<a class="nav-link" href='<?=$ROOT?>Profile/profile.php'><i class="fas fa-chevron-left"></i>&nbsp;Back&nbsp;&nbsp;</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home Insurance</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="health-tab" data-toggle="tab" href="#health" role="tab" aria-controls="health" aria-selected="false">Health Insurance</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="vehicle-tab" data-toggle="tab" href="#vehicle" role="tab" aria-controls="vehicle" aria-selected="false">Vehicle Insurance</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="false">Accounts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="policies-tab" data-toggle="tab" href="#policies" role="tab" aria-controls="policies" aria-selected="false">Policies</a>
              </li>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" id="appointments-tab" data-toggle="tab" href="#appointments" role="tab" aria-controls="appointments" aria-selected="false">Appointments</a>
              </li>
            </ul>
            </div>
            <div class="card-body">
            <!--- Search bar --->
            <div>
                <input class="form-control" id="filterTable" type="text" placeholder="Filter table">
            </div>
            <script>
                $(document).ready(function() {
                    $("#filterTable").on("keyup", function() {
                        var value = $(this).val().toLowerCase();
                        $("#filterable tr").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
            </script>
            <!--- Tab contents start --->
            <div class="tab-content" id="policyTabContent">
            	<!--- Home panel --->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <p class="card-text text-center">
                        <?php
                        if (isset($_GET['updated'])) {
                            $done = $_GET['updated'];
                            if ($done == "true") {
                                echo '<div class="alert alert-success alert-dismissible">';
                                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                echo '<Strong>Success!</Strong> Details updated!';
                                echo '</div>';
                            }
                        }
                        ?>
                        <table class='table table-bordered' style='font-size: 12px;'>
                            <tr>
                            <td width="3%"><b>ID</b></td>
                            <td><b>Username</b></td>
                            <td><b>Status</b></td>
                            <td><b>Property</b></td>
                            <td><b>Year built</b></td>
                            <td><b>Bedroom #</b></td>
                            <td><b>Sq footage</b></td>
                            <td><b>Purchase price</b></td>
                            <td width="5%"><b>Stories</b></td>
                            <td><b>Purchase date</b></td>
                            <td><b>Policy start</b></td>
                            <td width="3%"><b>Edit</b></td>
                            <td width="3%"><b>Delete</b></td>
                            </tr>
                        <?php
                            while ($row1 = mysqli_fetch_array($result1)) {
                        ?>
                        	<tbody id="filterable">
                            <tr>
                            <td><?=$row1['homeins_id']?></td>
                            <td><?=$row1['Username']?></td>
							<?php
                            switch ($row1['Status']) { // Check status and change colour
                              case "Declined":
                                echo "<td><b><p class='text-danger'>".$row1['Status']."</p></b></td>";
                                break;
                              case "Pending":
                                echo "<td><b><p class='text-warning'>".$row1['Status']."</p></b></td>";
                                break;
                              case "Successful":
                                echo "<td><b><p class='text-success'>".$row1['Status']."</p></b></td>";
                                break;
                              default: 
                                echo "<td><b><p class='text-danger'>".$row1['Status']."</p></b></td>";
                            }
                            ?>
                            <td><?=$row1['Property']?></td>
                            <td><?=$row1['Year_built']?></td>
                            <td><?=$row1['Bedroom_count']?></td>
                            <td><?=$row1['Square_footage']?></td>
                            <td><?=$row1['Purchase_price']?></td>
                            <td><?=$row1['Stories']?></td>
                            <td><?=$row1['Purchase_date']?></td>
                            <td><?=$row1['Policy_start_date']?></td>
                            <td><a href="edit.php?id=<?=$row1['homeins_id']?>&frm=a" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a></td>
                            <td><a href="delete.php?id=<?=$row1['homeins_id']?>&frm=a" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                            </tbody>
                        <?php } ?>
                      </table>
                  </p>
                </div>
                <!--- Health panel --->
                <div class="tab-pane fade" id="health" role="tabpanel" aria-labelledby="health-tab">
                    <p class="card-text text-center">
                        <?php
                        if (isset($_GET['updated'])) {
                            $done = $_GET['updated'];
                            if ($done == "true") {
                                echo '<div class="alert alert-success alert-dismissible">';
                                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                echo '<Strong>Success!</Strong> Details updated!';
                                echo '</div>';
                            }
                        }
                        ?>
                        <table class='table table-bordered' style='font-size: 12px;'>
                            <tr>
                            <td width="3%"><b>ID</b></td>
                            <td><b>Username</b></td>
                            <td><b>Status</b></td>
                            <td><b>SSN</b></td>
                            <td><b>Job</b></td>
                            <td><b>Employer</b></td>
                            <td><b>Hire date</b></td>
                            <td><b>Policy start</b></td>
                            <td width="3%"><b>Edit</b></td>
                            <td width="3%"><b>Delete</b></td>
                            </tr>
                        <?php
                            while ($row2 = mysqli_fetch_array($result2)) {
                        ?>
                        	<tbody id="filterable">
                            <tr>
                            <td><?=$row2['healthins_id']?></td>
                            <td><?=$row2['Username']?></td>
                            <?php
                            switch ($row2['Status']) { // Check status and change colour
                              case "Declined":
                                echo "<td><b><p class='text-danger'>".$row2['Status']."</p></b></td>";
                                break;
                              case "Pending":
                                echo "<td><b><p class='text-warning'>".$row2['Status']."</p></b></td>";
                                break;
                              case "Successful":
                                echo "<td><b><p class='text-success'>".$row2['Status']."</p></b></td>";
                                break;
                              default: 
                                echo "<td><b><p class='text-danger'>".$row2['Status']."</p></b></td>";
                            }
                            ?>
                            <td><?=$row2['SSN']?></td>
                            <td><?=$row2['Job']?></td>
                            <td><?=$row2['Employer']?></td>
                            <td><?=$row2['Hire_date']?></td>
                            <td><?=$row2['Policy_start_date']?></td>
                            <td><a href="edit.php?id=<?=$row2['healthins_id']?>&frm=b" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a></td>
                            <td><a href="delete.php?id=<?=$row2['healthins_id']?>&frm=b" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                            </tbody>
                        <?php } ?>
                      </table>
                  </p>
                </div>
                <!--- Vehicle panel --->
                <div class="tab-pane fade" id="vehicle" role="tabpanel" aria-labelledby="vehicle-tab">
                    <p class="card-text text-center">
                        <?php
                        if (isset($_GET['updated'])) {
                            $done = $_GET['updated'];
                            if ($done == "true") {
                                echo '<div class="alert alert-success alert-dismissible">';
                                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                echo '<Strong>Success!</Strong> Details updated!';
                                echo '</div>';
                            }
                        }
                        ?>
                        <table class='table table-bordered' style='font-size: 12px;'>
                            <tr>
                            <td width="3%"><b>ID</b></td>
                            <td><b>Username</b></td>
                            <td><b>Status</b></td>
                            <td><b>Make</b></td>
                            <td><b>Model</b></td>
                            <td><b>Year</b></td>
                            <td><b>Registration date</b></td>
                            <td><b>Policy start</b></td>
                            <td width="3%"><b>Edit</b></td>
                            <td width="3%"><b>Delete</b></td>
                            </tr>
                        <?php
                            while ($row3 = mysqli_fetch_array($result3)) {
                        ?>
                        	<tbody id="filterable">
                            <tr>
                            <td><?=$row3['vehins_id']?></td>
                            <td><?=$row3['Username']?></td>
                            <?php
                            switch ($row3['Status']) { // Check status and change colour
                              case "Declined":
                                echo "<td><b><p class='text-danger'>".$row3['Status']."</p></b></td>";
                                break;
                              case "Pending":
                                echo "<td><b><p class='text-warning'>".$row3['Status']."</p></b></td>";
                                break;
                              case "Successful":
                                echo "<td><b><p class='text-success'>".$row3['Status']."</p></b></td>";
                                break;
                              default: 
                                echo "<td><b><p class='text-danger'>".$row3['Status']."</p></b></td>";
                            }
                            ?>
                            <td><?=$row3['Make']?></td>
                            <td><?=$row3['Model']?></td>
                            <td><?=$row3['Manufacture_year']?></td>
                            <td><?=$row3['Reg_Date']?></td>
                            <td><?=$row3['Policy_Start']?></td>
                            <td><a href="edit.php?id=<?=$row3['vehins_id']?>&frm=c" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a></td>
                            <td><a href="delete.php?id=<?=$row3['vehins_id']?>&frm=c" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                            </tbody>
                        <?php } ?>
                      </table>
                  </p>
                </div>
                <!--- Account panel --->
                <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <p class="card-text text-center">
                        <?php
                        if (isset($_GET['updated'])) {
                            $done = $_GET['updated'];
                            if ($done == "true") {
                                echo '<div class="alert alert-success alert-dismissible">';
                                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                echo '<Strong>Success!</Strong> Details updated!';
                                echo '</div>';
                            }
                        }
                        ?>
                        <table class='table table-bordered' style='font-size: 12px;'>
                            <tr>
                            <td><b>Username</b></td>
                            <td><b>Password</b></td>
                            <td><b>Email</b></td>
                            <td><b>Name</b></td>
                            <td><b>Gender</b></td>
                            <td><b>Age</b></td>
                            <td><b>Phone</b></td>
                            <td><b>Street</b></td>
                            <td><b>Country</b></td>
                            <td><b>Created</b></td>
                            <td><b>Power</b></td>
                            <td><b>Edit</b></td>
                            <td><b>Delete</b></td>
                            </tr>
                        <?php
                            while ($row4 = mysqli_fetch_array($result4)) {
                        ?>
                        	<tbody id="filterable">
                            <tr>
                            <td><?=$row4['Username']?></td>
                            <td><?=$row4['Password']?></td>
                            <td><?=$row4['Email']?></td>
                            <td><?=$row4['Name']?></td>
                            <td><?=$row4['Gender']?></td>
                            <td><?=$row4['Age']?></td> 
                            <td><?=$row4['Phone']?></td>    
                            <td><?=$row4['Street']?></td>         
                            <td><?=$row4['Country']?></td>      
                            <td nowrap><?=$row4['Created']?></td>
                            <td><?=$row4['Access']?></td>
                            <td><a href="edit.php?id=<?=$row4['Username']?>&frm=d" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a></td>
                            <td><a href="delete.php?id=<?=$row4['Username']?>&frm=d" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                            </tbody>
                         <?php } ?>
                      </table>
                  </p>
                </div>
                <!--- Policies panel --->
                <div class="tab-pane" id="policies" role="tabpanel" aria-labelledby="policies-tab">
                    <p class="card-text text-center">
                        <?php
                        if (isset($_GET['updated'])) {
                            $done = $_GET['updated'];
                            if ($done == "true") {
                                echo '<div class="alert alert-success alert-dismissible">';
                                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                echo '<Strong>Success!</Strong> Details updated!';
                                echo '</div>';
                            }
                        }
                        ?>
                        <table class='table table-bordered' style='font-size: 12px;'>
                            <tr>
                            <td width="3%"><b>ID</b></td>
                            <td width="10%"><b>Title</b></td>
                            <td><b>Description</b></td>
                            <td width="3%"><b>Edit</b></td>
                            <td width="3%"><b>Delete</b></td>
                            </tr>
                        <?php
                            while ($row5 = mysqli_fetch_array($result5)) {
                        ?>
                        	<tbody id="filterable">
                            <tr>
                            <td><?=$row5['Policy_id']?></td>
                            <td><?=$row5['Title']?></td>
                            <td><?=$row5['Description']?></td>
                            <td><a href="edit.php?id=<?=$row5['Policy_id']?>&frm=e" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a></td>
                            <td><a href="delete.php?id=<?=$row5['Policy_id']?>&frm=e" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                            </tbody>
                        <?php } ?>
                      </table>
                  </p>
                </div>
            </div>
		  <!--- Tab contents end --->
          </div>
        </div>
      </div>
      <!--- Remembers last selected tab (for when deleting and returning to page -->
      <script>
		  $(function() {
				$('a[data-toggle="tab"]').on('click', function(e) {
					window.localStorage.setItem('activeTab', $(e.target).attr('href'));
				});
				var activeTab = window.localStorage.getItem('activeTab');
				if (activeTab) {
					$('#policyTab a[href="' + activeTab + '"]').tab('show');
				}
			});
	  </script>
    </body>
    
</html>
<?php
} else {
	header("Location: ".$ROOT."index.php");
}