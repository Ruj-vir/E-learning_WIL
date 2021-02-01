<?php include "templates/header.php"; ?>


<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-xl-12 col-md-6 mb-4">

                <div class="card my-4">
                    <div class="card-header text-uppercase">
                        <i class="fas fa-chalkboard-teacher"></i> Register User
                    </div>
                    <div class="card-body">

                        <ul class="list-group list-group-flush">
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

                            if ($ListIRow > 0) {
                                $iScore = 1;
                                $ListObj = sqlsrv_query($connRequest, $ListSql);
                                while ($ListResult = sqlsrv_fetch_array($ListObj, SQLSRV_FETCH_ASSOC)) {
                                    $StatusRegister = $ListResult["TrainHdrStatus"];

                            ?>
                                    <div class="form-row">
                                        <div class="col-md-3 mb-2">
                                            <div class="d-flex align-items-center p-3 text-white-50 bg-dark rounded">
                                                <img class="rounded mr-3" src="../../img/photo_emp/square/<?php print $resultSQL["EmpUserID"]; ?>.jpg" alt="Images" width="48" height="48">
                                                <div class="lh-100">
                                                    <small class="text-white"><?php print $resultSQL["EmpUserID"]; ?></small>
                                                    <h6 class="mb-0 text-white text-uppercase lh-100"><?php print $resultSQL["EmpUserName"] . "\n" . $resultSQL["EmpUserSurname"]; ?></h6>
                                                </div>
                                            </div>
                                            <div class="form-group mt-2">
                                                <ul>
                                                    <li><small>Position:</small> <?php print $resultSQL["EmpUserPosition"]; ?></li>
                                                    <li><small>Section:</small> <?php print $resultSQL["EmpUserSection"]; ?></li>
                                                    <li><small>Dept:</small> <?php print $resultSQL["EmpUserDepartment"]; ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-9 mb-2">
                                            <li class="list-group-item careers border rounded">
                                                <div onclick="location.href='register_user_detail.php?ItemReqNo=<?php echo $ListResult['ReqNo']; ?>&j0dsu36gpd9gsu9sdj9'">
                                                    <div class="row">
                                                        <div class="col-lg-3 mb-2">
                                                            <div class="card-text">
                                                                <strong class="mr-2"><?php echo $iScore . " )"; ?></strong>
                                                                Course: <strong><?php echo $ListResult["ReqRemark"]; ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 mb-2">
                                                            <div class="card-text">Date: <strong><?php echo date_format($ListResult["ReqDate"], 'd/m/Y') . " - " . date_format($ListResult["TrnTime"], 'd/m/Y'); ?></strong></div>
                                                            <div class="card-text">Time: <strong><?php echo date_format($ListResult["ReqDate"], 'H:i') . " - " . date_format($ListResult["TrnTime"], 'H:i'); ?></strong></div>
                                                        </div>
                                                        <div class="col-lg-3 mb-2">
                                                            <div class="card-text">Location: <strong><?php echo $ListResult["TrainRecPlace"]; ?></strong></div>
                                                        </div>
                                                        <div class="col-lg-2 mb-2">
                                                            <button type="button" class="btn btn-greenblue btn-sm btn-block" onclick="location.href='register_user_detail.php?ItemReqNo=<?php echo $ListResult['ReqNo']; ?>&j0dsu36gpd9gsu9sdj9'"><span class="mr-2">Let's go</span><i class="fas fa-arrow-right"></i></button>
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

        </div>
    </div>
    </div>
</header>


<?php include "templates/footer.php"; ?>