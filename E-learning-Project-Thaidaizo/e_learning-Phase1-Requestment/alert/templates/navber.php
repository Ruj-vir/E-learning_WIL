        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
							<a class="nav-link" href="../index.php">
							<div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Home
							</a>
                            <!--<div class="sb-sidenav-menu-heading">Report</div>-->
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
							  <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                                Year
                              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
							</a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
								<?php 
								$dropyear = date("Y") - 2020;
								for($i=0;$i<=$dropyear;$i++){
								$year=date('Y',strtotime("-$i year"));
								echo '<a class="nav-link" href="file_search.php?year='.$year.'&month=1">'.$year.'</a>';
								}
								?>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer bg-light">
                        <div class="small">Logged in as:</div>
                        TDA E-SMART
                    </div>
                </nav>
            </div>