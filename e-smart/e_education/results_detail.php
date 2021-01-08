

<?php include "templates/header.php" ;?>
<?php include "templates/navber.php" ;?>
<?php include "alert/alert_admin.php" ;?>

<style>

</style>

<?php
    if(isset($_GET["FormCode"]) != "") {

        $FormCode = $_GET["FormCode"];
        $ListUserSQL = "SELECT surveytypeId,surveytypeKey,surveytypeMain,surveySecondary,surveyDateFrom,surveyDateTo,Status
        FROM surveytype WHERE surveytypeId = '$FormCode' ";
        $ListUserQuery = mysqli_query($connBoardcast, $ListUserSQL);
        $iNum = 1;
        if(mysqli_num_rows($ListUserQuery) > 0) {
        $ListUserResult = mysqli_fetch_array($ListUserQuery, MYSQLI_ASSOC);

        }else {
        echo "<script>window.close();</script>";
        exit();
        }

    }else {
    echo "<script>window.close();</script>";
    exit();
    }
?>

<div class="container">

<form action="save/save_result_edit.php" autocomplete="off" method="POST" target="iframe_edit_form">

<div class="card my-4">
  <div class="card-header">
    <h5>Detail no. <?php echo $ListUserResult["surveytypeKey"] ;?></h5>
  </div>
  <div class="card-body">

<div class="form-row">
<div class="form-group col-md-6">
  <label for="inputID">Form ID:</label>
  <input type="text" class="form-control " id="inputID" name="inputID" value="<?php echo $ListUserResult["surveytypeKey"] ;?>" required placeholder="" >
</div>
<div class="form-group col-md-12">
  <label for="inputName">Form name:</label>
  <input type="text" class="form-control " id="inputName" name="inputName" value="<?php echo $ListUserResult["surveytypeMain"] ;?>" required placeholder="" >
</div>

<div class="form-group col-md-6">
  <label for="inputDateFrom">Date from:</label>
  <input type="date" class="form-control " id="inputDateFrom" name="inputDateFrom" value="<?php echo date("Y-m-d", strtotime($ListUserResult["surveyDateFrom"])) ;?>" required placeholder="" >
</div>
<div class="form-group col-md-6">
  <label for="inputTimeFrom">Time from:</label>
  <input type="time" class="form-control " id="inputTimeFrom" name="inputTimeFrom" value="<?php echo date("H:i", strtotime($ListUserResult["surveyDateFrom"])) ;?>" required placeholder="" >
</div>

<div class="form-group col-md-6">
  <label for="inputDateTo">Date to:</label>
  <input type="date" class="form-control " id="inputDateTo" name="inputDateTo" value="<?php echo date("Y-m-d", strtotime($ListUserResult["surveyDateTo"])) ;?>" required placeholder="" >
</div>
<div class="form-group col-md-6">
  <label for="inputTimeTo">Time to:</label>
  <input type="time" class="form-control " id="inputTimeTo" name="inputTimeTo" value="<?php echo date("H:i", strtotime($ListUserResult["surveyDateTo"])) ;?>" required placeholder="" >
</div>

<div class="form-group col-md-6">
  <label for="inputStatus">Status:</label>
  <select class="custom-select" id="inputStatus" name="inputStatus">
    <option value="1" <?php echo ($ListUserResult["Status"] == 1) ? 'selected' : '';?> >Enabled</option>
    <option value="0" <?php echo ($ListUserResult["Status"] == 0) ? 'selected' : '';?> >Disabled</option>
  </select>
</div>

<input type="hidden" class="form-control " id="inputAutoID" name="inputAutoID" value="<?php echo $ListUserResult["surveytypeId"] ;?>" required readonly placeholder="" >
</div>

<div class="form-group">
  <div id="AddResultAssessor"></div>
</div>

  </div>
  <div class="card-footer text-muted">
    <button type="submit" name="submit" class="btn btn-purple btn-block" ><i class="fas fa-save"></i> Save change</button>
  </div>
</div>

  </form>
  <iframe id="iframe_edit_form" name="iframe_edit_form" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

</div><!-- .container -->


<?php include "templates/footer.php";?>


    <script type="text/javascript">
    function ServiceAddResult(AddResult) {
        if(AddResult == 1) {
          $("#AddResultAssessor").html("<div class='alert alert-success' role='alert'>เรียบร้อยแล้ว</div>");
          setInterval('window.location.href = "results.php"', 1000);
        }else {
          $('#AddResultAssessor').html("<div class='alert alert-danger text-center' role='alert'>ไม่สำเร็จ</div>");
        }
    }
    </script>