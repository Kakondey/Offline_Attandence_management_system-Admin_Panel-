<?php

    session_start();
    if (!isset($_SESSION['adminId'])) 
    {
        header("location: ../../../signin.php");
    }
    else
    {

        include_once('../../../dbconnect.php');

        $error = false;

        $teacherName = "0";
        $teacherphoneNo = "0";
        $subjectName = "0";
        $teacherEmail = "0";
        $teacherPassword = "0";
        $teacherStatus = "0";
       
        if (isset($_POST['submit']))
        {
            $teacherName = $_POST['teacherName'];
            $teacherName = strip_tags($teacherName);
            $teacherName = htmlspecialchars($teacherName);

            $teacherphoneNo = $_POST['teacherphoneNo'];
            $teacherphoneNo = strip_tags($teacherphoneNo);
            $teacherphoneNo = htmlspecialchars($teacherphoneNo);

            $subjectName = $_POST['subjectName'];
            $subjectList = implode(",", $subjectName);
            $subjectListExplode = explode(",", $subjectList);
            $countSubjects = count($subjectListExplode); 

            $teacherEmail = $_POST['teacherEmail'];
            $teacherEmail = strip_tags($teacherEmail);
            $teacherEmail = htmlspecialchars($teacherEmail);

            $teacherPassword = $_POST['teacherPassword'];
            $teacherPassword = strip_tags($teacherPassword);
            $teacherPassword = htmlspecialchars($teacherPassword);

            $teacherStatus = $_POST['teacherStatus'];
            $teacherStatus = strip_tags($teacherStatus);
            $teacherStatus = htmlspecialchars($teacherStatus);
        

            if (empty($teacherName)) 
            {
                $error = true;
            }
            if (empty($teacherphoneNo)) 
            {
                $error = true;
            }
            if (empty($subjectName)) 
            {
                $error = true;
            }
            if (empty($teacherEmail))
            {
                $error = true;
            }

            if (empty($teacherAddress))
            {
                $error = true;
            }

            if (empty($teacherPassword)) 
            {
                $error = true;
            }

            if (empty($teacherStatus)) 
            {
                $error = true;
            }



            if (!$error)
            {   
                $sqlu = "UPDATE `teacher` SET `teacherName`='$_POST[teacherName]',`teacherphoneNo`='$_POST[teacherphoneNo]',`teacherEmail`='$_POST[teacherEmail]',`teacherPassword`='$_POST[teacherPassword]',`teacherStatus`='$_POST[teacherStatus]' WHERE `teacherId`='$_POST[teacherId]'";

                if (mysqli_query($conn, $sqlu)) 
                {
                    /*$successmez = 'Details Updated successfully.';*/
                    header('Refresh:0; ../Tables/listTeacherDetails.php');
                }
                else
                {
                    $successmez = 'Error'.mysqli_error($conn);      
                }

            }

            if(mysqli_query($conn, $sql))
                {
                    $lastTeacherIdInserted = mysqli_insert_id($conn);

                    $subjectUpdateSQL = "UPDATE `st` SET `st`.`subjectId` = `s`.`subjectId`
                                        FROM `subject_teacher` `st`,`teacher` `t`, `subject` `s`
                                        WHERE `st`.`teacherId`=`t`.`teacherId` AND `st`.`subjectId`=`s`.`subjectId`";

                    $subjectInsertSQL = "INSERT INTO `subject_teacher`(`teacherId`, `subjectId`) VALUES";

                    for($i=0; $i<$countSubjects; $i++)
                    {
                        $subjectInsertSQL = $subjectInsertSQL."('".$lastTeacherIdInserted."','".$subjectListExplode[$i]."'),";
                    }
                    $subjectInsertSQL = substr(trim($subjectInsertSQL), 0, -1);

                    /*$successmez = 'Teacher details updated.'.'\n'.'subjects corresponding to the teacher details updated.';*/
                    
                    /*header('Refresh:0; ../Tables/listTeacherDetails.php');*/

                }
                else
                {
                    /*echo 'Error'.mysqli_error($conn);*/
                    $notice = 'Error'.mysqli_error($conn).' Enter new Details. This Id already exists';       
                }

                if (mysqli_query($conn, $subjectInsertSQL)) 
                {
                    $successofInsertSubject = 'Teacher details updated.'.'\n'.'subjects corresponding to the teacher details entered.';
                    header('Refresh:0; ../Tables/listTeacherDetails.php');
                }
                else
                {
                    /*echo "Error : ".mysqli_error($conn);*/
                    $notice = 'Error'.mysqli_error($conn).' subjects not entered';
                    header('Refresh:0; editTeacherDetails.php');
                }
        }
            
        if (isset($_GET['edit'])) 
        {
            $sql = "SELECT * FROM teacher WHERE teacherId='{$_GET['teacherId']}'";

            $query = mysqli_query($conn,$sql);
            $row = mysqli_fetch_object($query);

            $teacherId = $row->teacherId;
            $teacherName = $row->teacherName;
            $teacherphoneNo = $row->teacherphoneNo;
            $subjectName = $row->subjectName;
            $teacherEmail = $row->teacherEmail;
            $teacherPassword = $row->teacherPassword;
            $teacherStatus = $row->teacherStatus;
       
        }
                
                

        

        /*fetching subject name from subject table.*/
        /*$subjectNameSQL = "SELECT subjectName FROM subject";
        $subjectNameSQLRESULT = mysqli_query($conn, $subjectNameSQL) or die("Error!!!");

        $options = "<select tabindex='1'name='subjectName' data-placeholder='Select here..' class='span8'>";
                    while ($subjectNameROW = mysqli_fetch_assoc($subjectNameSQLRESULT))
                    {
                        $options = "<option value='{$subjectNameROW['subjectName']}'>'{$subjectNameROW['subjectName']}'</option>";
                    }
        $options = "</select>";*/
?>
<!DOCTYPE html>
<html lang="en">


<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registeration Form</title>
        <link type="text/css" href="../../../assets/DashboardAssets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="../../../assets/DashboardAssets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="../../../assets/DashboardAssets/css/theme.css" rel="stylesheet">
        <link type="text/css" href="../../../assets/DashboardAssets/css/button.css" rel="stylesheet">
        <link type="text/css" href="../../../assets/DashboardAssets/images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
        <script src="../../../assets/js/jquery.min.js"></script>
        <script src="../../../assets/DashboardAssets/scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="../../../assets/DashboardAssets/scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="../../../assets/DashboardAssets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../../../assets/DashboardAssets/scripts/flot/jquery.flot.js" type="text/javascript"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
        <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
    </head>
<body>

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">

                <a class="brand" href="index.html">
                    Student Attendence Management System
                </a>

                <div class="">

                    <form class="navbar-search pull-left input-append" action="#">
                        <input type="text" class="span3">
                        <button class="btn" type="button">
                            <i class="icon-search"></i>
                        </button>
                    </form>
                
                    <ul class="nav pull-right">
                        
                        
                        <li><a href="#">
                            <?php echo $_SESSION['adminId']; ?>
                        </a></li>
                        
                    </ul>
                </div><!-- /.nav-collapse -->
            </div>
        </div><!-- /navbar-inner -->
    </div><!-- /navbar -->



    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <div class="sidebar">

                        <ul class="widget widget-menu unstyled">
                            <li class="active">
                                <a href="../../../index.php">
                                    <i class="menu-icon icon-dashboard"></i>
                                    Dashboard
                                </a>
                            </li>
                        
                        </ul><!--/.widget-nav-->

                        <ul class="widget widget-menu unstyled">
                                <li><a href="../forms/AddnewTeacher.php"><i class="menu-icon icon-tasks"></i>Add new Teacher </a>
                                <li><a href="../forms/AddnewStudent.php"><i class="menu-icon icon-tasks"></i>Add new Student </a>
                                <li><a href="../forms/AddnewSubject.php"><i class="menu-icon icon-tasks"></i>Add new Subject </a>   
                                <li><a href="../forms/AddnewClass.php"><i class="menu-icon icon-tasks"></i>Add new Class </a> 
                                </li>
                            </ul><!--/.widget-nav-->

                        <ul class="widget widget-menu unstyled">
                            
                            
                            <li>
                                <a href="../../../logout.php">
                                    <i class="menu-icon icon-signout"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>

                    </div><!--/.sidebar-->
                </div><!--/.span3-->


                <div class="span9">
                    <div class="content">

                        <div class="module">
                            <div class="module-head">
                                <h3 style="text-align: center;">Add new Teacher</h3>
                            </div>
                            <div class="module-body">

                                    <?php
                                        if(isset($successmez))
                                        {
                                          ?>
                                          <div class="alert alert-success">
                                            <span class="glyphicon glyphicon-info-sign"><?php echo $successmez; ?></span>
                                          </div>
                                          <?php
                                        }
                                        else if (isset($notice))
                                        {
                                        ?>
                                            <div class="alert alert-success">
                                            <span class="glyphicon glyphicon-info-sign"><?php echo $notice; ?></span>
                                          </div>
                                          <?php
                                        }
                                       ?>

                                    <br />

                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-horizontal row-fluid">

                                        <!-- <div class="control-group">
                                            <div class="controls">
                                                <input type="hidden" id="token" name="token class="span8" value="<?php echo $token; ?>">
                                            </div>
                                        </div> -->

                                        <div class="control-group">
                                            <label class="control-label" for="teacherName">Name</label>
                                            <div class="controls">
                                                <input type="text" id="teacherName" name="teacherName" placeholder="name of the Teacher"
                                                value="<?php echo $teacherName; ?>" class="span8"><br><br>
                                                <span class="alert alert-error" id="checkteacherName" style="display: none;"></span>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="phone_number">Phone number</label>
                                            <div class="controls">
                                                <input type="text" id="phone_number" name="teacherphoneNo" placeholder="Phone Number"
                                                value="<?php echo $teacherphoneNo; ?>" class="span8"><br><br>
                                                <span class="alert alert-error" id="checkphone_number" style="display: none;"></span>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="basicinput">Subject</label>
                                            <div class="controls">
                                                <select tabindex="1" data-placeholder="Type here to select subject" value="<?php echo $subjectName; ?>" name="subjectName[]" multiple class="span8 chosen-select">
                                                    <?php
                                                        $subjectQuery = "SELECT * FROM subject";
                                                        $subjectResult = mysqli_query($conn, $subjectQuery);

                                                        foreach ($subjectResult as $subjects) 
                                                        {
                                                            ?>
                                                                <option  value="<?php echo $subjects['subjectId']; ?>"><?php echo $subjects['subjectName']; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                   
                                                </select>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="email">Email</label>
                                            <div class="controls">
                                                <input type="text" id="email" value="<?php echo $teacherEmail; ?>" name="teacherEmail" placeholder="kiko789@gmail.com" class="span8"><br><br>
                                                <span class="alert alert-error" id="checkemail" style="display: none;"></span>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="password">Password</label>
                                            <div class="controls">
                                                <input type="text" id="password" value="<?php echo $teacherPassword; ?>" name="teacherPassword" placeholder="click on the Generate button to generate a random password." class="span8"><br>
                                                <button class="btn btn-primary btn-small" OnClick="randomPassword()" type="button">Generate</button><br><br>
                                                <span class="alert alert-error" id="checkpassword" style="display: none;"></span>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Status</label>
                                            <div class="controls">
                                                <label class="radio inline">
                                                    <input type="radio" value="<?php echo $teacherStatus; ?>" name="teacherStatus" id="statusRadios1" value="Active" checked="">
                                                    Active
                                                </label> 
                                                <label class="radio inline">
                                                    <input type="radio" value="<?php echo $teacherStatus; ?>" name="teacherStatus" id="statusRadios2" value="InActive">
                                                    InActive
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" name="submit" class="btn btn-primary btn-xl" onclick="checkFields()">Submit</button>
                                            </div>
                                        </div>

                                    </form>
                            </div>
                        </div>

                        
                        
                    </div><!--/.content-->
                </div><!--/.span9-->
            </div>
        </div><!--/.container-->
    </div><!--/.wrapper-->
</body>

<script type="text/javascript">
    function checkFields()
    {
        /*declaring variables*/

        var teacherName = $('#teacherName').val();
        var phone_number = $('#phone_number').val();
        var email = $('#email').val();
        var address = $('#address').val();
        var password = $('#password').val();

        var filterName = /^[a-zA-Z ]*$/;
        var filterEmail  = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        var filterIds = /^[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}$/;

        var msg = "";

        if (!filterName.test(teacherName) || teacherName.length<6)
        {
           $('#checkteacherName').html("Teacher name is not valid").show().delay(1000).fadeOut('slow');
        }
        
        if (phone_number.length!=10 || isNaN(phone_number))
        {
            $('#checkphone_number').html("Phone number is not valid").show().delay(1000).fadeOut('slow');
        }
        
        if (!filterEmail.test(email))
        {
            $('#checkemail').html("email is not valid").show().delay(1000).fadeOut('slow');
        }
        
        if (address.value.length == 0)
        {
            $('#checkaddress').html("address is not valid").show().delay(1000).fadeOut('slow');
        }
        
        
    }

    $(document).ready(function()
    {
        $('.span8').keyup(function(){
        checkFields();
        });
    });

    /*choose password randomly*/
    function randomPassword()
    {
        var mypass = document.getElementById("password")
        mypass.value = Math.random().toString(36).slice(-8);
    }


    /*multiple select of subjects*/
    $(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
})
</script>

</html>

<?php
}
?>