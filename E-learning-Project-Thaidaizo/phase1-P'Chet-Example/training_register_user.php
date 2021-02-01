<?php include "templates/header.php"; ?>
<?php include "templates/navber.php"; ?>


<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 col-md-6 mb-4">
            <div class="card shadow my-4">
                <div class="card-header text-uppercase">
                    <i class="fas fa-chalkboard-teacher"></i> Register User
                </div>
                <div class="card-body">

<?php
                        $ListSql = "SELECT DISTINCT 
                        dbo.ReqInfo.ReqNo, 
                        dbo.ReqInfo.ReqDate, 
                        dbo.ReqInfo.TrnTime, 
                        dbo.ReqInfo.ReqDay, 
                        dbo.ReqInfo.ReqHour, 
                        dbo.ReqInfo.ReqSumTime, 
                        dbo.ReqInfo.ReqRemark, 
                        dbo.ReqInfo.PicturePath,

                        EducationSystem.dbo.TrainRecHdr.TrainRecType, 
                        EducationSystem.dbo.TrainRecHdr.TrainRecEvl, 
                        EducationSystem.dbo.TrainRecHdr.TrainRecTrainer, 
                        EducationSystem.dbo.TrainRecHdr.TrainRecPlace,
                        EducationSystem.dbo.TrainRecHdr.TrainHdrStatus
                        FROM EducationSystem.dbo.TrainRecHdr 
                        INNER JOIN dbo.ReqInfo 
                        ON EducationSystem.dbo.TrainRecHdr.TrainRecNo = dbo.ReqInfo.ReqNo
                        WHERE (dbo.ReqInfo.ReqType = 4) AND (EducationSystem.dbo.TrainRecHdr.TrainHdrStatus = 1)";

                        $ListIParams = array();
                        $ListIOptions =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                        $ListIStmt = sqlsrv_query($connRequest, $ListSql, $ListIParams, $ListIOptions);
                        $ListIRow = sqlsrv_num_rows($ListIStmt);
?>

                    <div class="input-group input-group-sm mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputFilter" id="select_count"><?php print $ListIRow ;?> Topics</label>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="inputFilter" name="inputFilter" placeholder="Filter">
                    </div>

                    <ul class="list-group list-group-flush">
                        <?php

                        if ($ListIRow > 0) {
                            $iScore = 1;
                            $ListObj = sqlsrv_query($connRequest, $ListSql);
                            while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {
                                $StatusRegister = $ListResult["TrainHdrStatus"];

                        ?>
                                <li class="list-group-item careers border rounded">
                                    <div onclick="location.href='training_register_user_detail.php?ItemReqNo=<?php echo $ListResult['ReqNo']; ?>&j0dsu36gpd9gsu9sdj9'">
                                        <div class="row">
                                            <div class="col-lg-3 mb-2">
                                                <div class="d-flex align-items-center p-0">
                                                    <?php
                                                    $PicturePath = $ListResult['PicturePath'];
                                                    $array_last = explode(".", $PicturePath);
                                                    $c = count($array_last) - 1;
                                                    $lastname = strtolower($array_last[$c]);
                                                    if (($lastname == "jpg") or ($lastname == "jpeg") or ($lastname == "JPEG") or ($lastname == "JPG") or ($lastname == "png") or ($lastname == "PNG") or ($lastname == "gif") or ($lastname == "GIF")) {
                                                        echo '<img class="img-fluid img-thumbnail mr-3" src="assets/img/request/' . $PicturePath . '" alt="Images" width="48" height="48">';
                                                    } else {
                                                        echo '<img class="img-fluid img-thumbnail mr-3" src="assets/img/icon/mortarboard.png" alt="Images" width="48" height="48">';
                                                    }
                                                    ?>
                                                    <div class="lh-100">
                                                        <div class="card-text text-uppercase"><?php echo $ListResult['ReqRemark']; ?></div>
                                                        <!--<h6 class="mb-0 text-white text-uppercase lh-100"></h6>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-2">
                                                <div class="card-text"><strong>Date: </strong><?php echo date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y'); ?></div>
                                                <div class="card-text"><strong>Time: </strong><?php echo date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i'); ?></div>
                                            </div>
                                            <div class="col-lg-3 mb-2">
                                                <div class="card-text"><strong>Location: </strong><?php echo $ListResult["TrainRecPlace"]; ?></div>
                                            </div>
                                            <div class="col-lg-2 mb-2">
                                                <button type="button" class="btn btn-greenblue btn-sm btn-block" onclick="location.href='training_register_user_detail.php?ItemReqNo=<?php echo $ListResult['ReqNo']; ?>&j0dsu36gpd9gsu9sdj9'"><span class="mr-2">Let's go</span><i class="fas fa-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php
                                $iScore++;
                            }
                        } else {
                            ?>
                            <div class="alert alert-secondary text-center" role="alert">
                                No data available in table
                            </div>
                        <?php
                        }
                        ?>
                    </ul>

                </div>
            </div>
        </div>

    </div><!-- .row -->
</div><!-- .container-fluid -->

<?php include "templates/footer.php"; ?>


<script type="text/javascript">
  $(document).ready(function() {
    $("#inputFilter").on("keyup change", function() {
      var value = $(this).val().toLowerCase();
      $(".list-group .list-group-item").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>