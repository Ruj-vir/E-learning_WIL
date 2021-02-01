       <?php

        $CheckedCountSQL = "SELECT COUNT(DISTINCT ReqNo) AS NumChecked FROM ReqInfo WHERE (ReqChecker = '$SesUserID') AND (ReqType = 4) AND (Status = 1) ";
        $CheckedCountQuery = sqlsrv_query($connRequest, $CheckedCountSQL);
        $CheckedCountResult = sqlsrv_fetch_array($CheckedCountQuery, SQLSRV_FETCH_ASSOC);
        $NumChecked = $CheckedCountResult["NumChecked"];

        $VerifyCountSQL = "SELECT COUNT(DISTINCT ReqNo) AS NumVerify FROM ReqInfo WHERE (ReqApprover = '$SesUserID') AND (ReqType = 4) AND (Status = 2) ";
        $VerifyCountQuery = sqlsrv_query($connRequest, $VerifyCountSQL);
        $VerifyCountResult = sqlsrv_fetch_array($VerifyCountQuery, SQLSRV_FETCH_ASSOC);
        $NumVerify = $VerifyCountResult["NumVerify"];

        $AprrovedCountSQL = "SELECT COUNT(DISTINCT ReqNo) AS NumApproved FROM ReqInfo WHERE (UpdateBy = '$SesUserID') AND (ReqType = 4) AND (Status = 3) ";
        $AprrovedCountQuery = sqlsrv_query($connRequest, $AprrovedCountSQL);
        $AprrovedCountResult = sqlsrv_fetch_array($AprrovedCountQuery, SQLSRV_FETCH_ASSOC);
        $NumAprroved = $AprrovedCountResult["NumApproved"];

        $OpenCountSQL = "SELECT COUNT(DISTINCT ReqNo) AS NumOpen FROM ReqInfo WHERE (ReqIssuer = '$SesUserID') AND (ReqType = 4) AND (Status = 6) ";
        $OpenCountQuery = sqlsrv_query($connRequest, $OpenCountSQL);
        $OpenCountResult = sqlsrv_fetch_array($OpenCountQuery, SQLSRV_FETCH_ASSOC);
        $NumOpen = $OpenCountResult["NumOpen"];

        //$AllOpenCountSQL = "SELECT COUNT(DISTINCT ReqNo) AS NumOpen FROM ReqInfo WHERE (ReqType = 4) AND (Status = 9) ";
        //$AllOpenCountQuery = sqlsrv_query($connRequest, $AllOpenCountSQL);
        //$AllOpenCountResult = sqlsrv_fetch_array($AllOpenCountQuery, SQLSRV_FETCH_ASSOC);
        //$NumAllOpen = $AllOpenCountResult["NumOpen"];

        ?>

       <div id="layoutSidenav">
         <div id="layoutSidenav_nav">
           <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
             <div class="sb-sidenav-menu">
               <div class="nav">
                 <a class="nav-link" href="../index.php">
                   <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                   Home
                 </a>
                 <a class="nav-link" href="training_register_user.php">
                   <div class="sb-nav-link-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                   Register User
                 </a>
                 <a class="nav-link" href="training_register_card.php">
                   <div class="sb-nav-link-icon"><i class="fas fa-id-card-alt"></i></div>
                   Register Card
                 </a>

                 <div class="sb-sidenav-menu-heading">Flow</div>
                 <a class="nav-link" href="training_request.php">
                   <div class="sb-nav-link-icon"><i class="fas fa-file-signature"></i></div>
                   Request
                 </a>
                 <a class="nav-link" href="training_check.php">
                   <div class="sb-nav-link-icon"><i class="fas fa-clipboard-check"></i></div>
                   Check
                   <div class="sb-sidenav-collapse-arrow">
                     <span class="badge badge-pill badge-greenblue"><?php echo $NumChecked; ?></span>
                   </div>
                 </a>
                 <a class="nav-link" href="training_verify.php">
                   <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                   Verify
                   <div class="sb-sidenav-collapse-arrow">
                     <span class="badge badge-pill badge-greenblue"><?php echo $NumVerify; ?></span>
                   </div>
                 </a>
                 <a class="nav-link" href="training_approve.php">
                   <div class="sb-nav-link-icon"><i class="fas fa-file-contract"></i></div>
                   Approve
                   <div class="sb-sidenav-collapse-arrow">
                     <span class="badge badge-pill badge-greenblue"><?php echo $NumAprroved; ?></span>
                   </div>
                 </a>

                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts1">
                   <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                   Course
                   <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                 </a>
                 <div class="collapse" id="collapseLayouts1" aria-labelledby="headingOne1" data-parent="#sidenavAccordion">
                   <nav class="sb-sidenav-menu-nested nav">
                     <a class="nav-link" href="training_opening.php">
                       Opening
                     </a>
                     <a class="nav-link" href="training_confirm.php">
                       Confirm
                     </a>
                     <a class="nav-link" href="training_close.php">
                       Closing
                     </a>
                   </nav>
                 </div>


                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts2">
                   <div class="sb-nav-link-icon"><i class="far fa-newspaper"></i></div>
                   Report
                   <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                 </a>
                 <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne2" data-parent="#sidenavAccordion">
                   <nav class="sb-sidenav-menu-nested nav">
                     <a class="nav-link" href="training_report_application.php">
                      Application
                     </a>

                     <!-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts_sub2" aria-expanded="false" aria-controls="collapseLayouts_sub2">
                       <div class="sb-nav-link-icon"><i class="fas fa-print"></i></div>
                       Application
                       <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                     </a>
                     <div class="collapse" id="collapseLayouts_sub2" aria-labelledby="headingOne_sub2">
                       <nav class="sb-sidenav-menu-nested nav">
                         <a class="nav-link" href="training_report_application_request.php">
                          - Request
                         </a>
                         <a class="nav-link" href="#.php">
                          - Verify
                         </a>
                         <a class="nav-link" href="#.php">
                          - Approve
                         </a>
                       </nav>
                     </div> -->

                     <a class="nav-link" href="training_report_attendance.php">
                       Attendance
                     </a>
                     <a class="nav-link" href="training_report_plan.php">
                       Plan
                     </a>
                     <a class="nav-link" href="training_report_record.php">
                       Record
                     </a>
                   </nav>
                 </div>

                 <div class="sb-sidenav-menu-heading">OPTIONS</div>

                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts3" aria-expanded="false" aria-controls="collapseLayouts3">
                   <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                   Pending
                   <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                 </a>
                 <div class="collapse" id="collapseLayouts3" aria-labelledby="headingOne3" data-parent="#sidenavAccordion">
                   <nav class="sb-sidenav-menu-nested nav">
                     <a class="nav-link" href="pending.php?Type=1">Check</a>
                     <a class="nav-link" href="pending.php?Type=2">Verify</a>
                     <a class="nav-link" href="pending.php?Type=3">Approve</a>
                   </nav>
                 </div>

                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts4" aria-expanded="false" aria-controls="collapseLayouts4">
                   <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                   Setting
                   <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                 </a>
                 <div class="collapse" id="collapseLayouts4" aria-labelledby="headingOne4" data-parent="#sidenavAccordion">
                   <nav class="sb-sidenav-menu-nested nav">
                     <a class="nav-link" href="setting_profile.php">Profile</a>
                     <a class="nav-link" href="setting_authority.php">Authority</a>
                   </nav>
                 </div>

               </div>
             </div>
             <div class="sb-sidenav-footer bg-light">
               <div class="small">Logged in as:</div>
               TDA E-SMART
             </div>
           </nav>
         </div>

         <div id="layoutSidenav_content">
           <main>