

	<?php include "templates/header.php";?>
	<?php include "templates/navber.php";?>


    <div class="container-fluid">
      <div class="row">

        <div class="col-xl-12 col-md-6 mb-4">
          <div class="card my-4">

            <!--Content-->

                <div class="dashboard-area">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <!--<a class="position-absolute ml-3 mt-3 text-white" href="#" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit cover images"><i class="fas fa-cog"></i></a>-->
                                        <div class="row">
                                            <div class="col-md-6 ml-auto mr-auto">
                                               <div class="profiles p-3 my-4 text-center">
                                                    <div class="avatars">
                                                        <a href="#">
                                                            <img src="../img/photo_emp/square/<?php echo $SesUserID ;?>.jpg" alt="Avatar Image" width="100" class="avatar-lg rounded-circle border border-dark img-fluid" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="avatar images">
                                                        </a>
                                                    </div>
                                                    <div class="names">
                                                        <h5 class="title text-dark"><?php echo $resultSQL["EmpUserName"]."\n".$resultSQL["EmpUserSurname"] ;?></h5>
                                                        <h6 class="title text-dark"><?php echo $resultSQL["EmpUserEmail"] ;?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>

                                    <div class="row px-3 px-md-0 px-lg-0 px-xl-3 py-3 mx-auto">
                                        <div class="col-lg-4 col-sm-6">
                                            <a class="member-item" href="profile_user_course.php">
                                                <div class="card mb-2 mb-md-5 py-3">
                                                    <div class="content">
                                                        <div class="row">
                                                            <div class="col-6 d-flex justify-content-center align-items-center">
                                                                <div class="icon-big text-greenblue text-center">
                                                                    <i class="fas fa-table"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 d-flex justify-content-center align-items-center">
                                                                <div class="numbers">
                                                                    <p>Request</p>
                                                                    Course
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <a class="member-item" href="profile_user_course_calendar.php">
                                                <div class="card mb-2 mb-md-5 py-3">
                                                    <div class="content">
                                                        <div class="row">
                                                            <div class="col-6 d-flex justify-content-center align-items-center">
                                                                <div class="icon-big text-greenblue text-center">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 d-flex justify-content-center align-items-center">
                                                                <div class="numbers">
                                                                    <p>Training</p> 
                                                                    Calendar
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <!--
                                        <div class="col-lg-4 col-sm-6">
                                            <a class="member-item" href="#">
                                                <div class="card mb-2 mb-md-5 py-3">
                                                    <div class="content">
                                                        <div class="row">
                                                            <div class="col-6 d-flex justify-content-center align-items-center">
                                                                <div class="icon-big text-greenblue text-center">
                                                                    <i class="fas fa-users"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 d-flex justify-content-center align-items-center">
                                                                <div class="numbers">
                                                                    <p>Training</p>
                                                                    Results
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        -->
                                    </div>
                                
            </div>
          </div>
         </div>

    </div><!-- .row -->
 </div><!-- .container-fluid -->

  <?php include "templates/footer.php";?>