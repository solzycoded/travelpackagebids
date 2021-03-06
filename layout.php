<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/packages/index.php';

    $title = "TravelPackaeBids | ".$title;
    $user_id = get_userid();

    $packages = new Packages_List();
?>

<!DOCTYPE html> 
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <link rel="stylesheet" href="css/layout.css">
        <link rel="stylesheet" href="css/package.css">
        <link rel="stylesheet" href="css/comments.css">
        
        <style>
            body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
        </style>
    </head>
    <body>
        <!-- page content -->
        <div class="container-fluid page-content">
            
            <!-- main-header -->
            <div class="container-fluid sticky-top page-header">
                <header class="d-flex flex-wrap justify-content-center py-3 mb-4" style="margin-bottom: 0px !important;">
                  <a href="/travelpackagebids" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-4">Travelpackagebids</span>
                  </a>

                  <ul class="nav nav-pills justify-content-center">
                    <li class="nav-item"><a href="/travelpackagebids" class="nav-link text-white">Home</a></li>
                    <?php 
                        if($user_id <= 0) {
                    ?>
                        <li class="nav-item"><a href="/travelpackagebids/user/sign-in.php" class="nav-link text-white user-login">Log In</a></li>
                        <li class="nav-item"><a href="/travelpackagebids/user/sign-up.php" class="nav-link text-white user-signup">Sign Up</a></li>
                    <?php
                        } 
                        else {
                    ?>
                        <li class="nav-item dropdown" style="padding-top: 9px">
                          <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">

                            <!-- <img src="https://github.com/mdo.png" alt=""  class="rounded-circle me-2"> -->
                            <strong>
                                <i class="fas fa-circle-user" style="font-size: 20px;"></i> 
                                <?php 
                                    $profile = $packages->get_profile();
                                    $name = $profile->name;

                                    echo $name;
                                ?>
                            </strong>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                            <li><a class="dropdown-item" href="/travelpackagebids/user/profile.php?user=member"><i class="fa-solid fa-user"></i> My profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item btn" href="/travelpackagebids/user/profile.php"><i class="fa-solid fa-box"></i> My packages</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item btn logout" role="button"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a></li>
                          </ul>
                        </li>
                    <?php 
                        } 
                    ?>
                  </ul>
                </header>
            </div>
            <!-- end main-header -->

            <?php 
            	if($title=="TravelPackaeBids | Home"){
            ?>
		            <!-- jumbotron -->
		            <div class="jumbotron jumbotron-fluid bg-light page-content-intro" style="padding-top: 20px;">
		                <div class="container-fluid" style="color: white">
		                    <h1 class="display-4 intro-title">
		                        #1 marketplace to buy and sell <span style="color: #03C6C1">travel packages</span>
		                    </h1>
		                    <p class="lead packagelistings intro-others">
		                        <i class="fa-solid fa-bars-staggered"></i>
		                        Live listings: <span style="margin-right: 10px;"><?php echo $packages->noofpackages; ?></span>
		                        
		                        <span style="font-weight: bold;">Ready to sell? <a href="<?php echo '/travelpackagebids/user/'.(isset($user_id) && !empty($user_id) ? 'profile.php' : 'sign-up.php'); ?>" class="sellnow" style="color: white">Sell Now</a></span>
		                    </p>
		                </div>
		            </div>

            <?php
            	}
            ?>
            <!-- header (end)-->
            
            
            <!-- main page content -->
            <div class="container-fluid main-body">
                <br>
                <?php
                	body($packages);
                ?>
            </div>
            <!-- main page content (end) -->
            
            
            <!-- footer -->
            
            <!-- footer (end) -->
            
        </div>
        <!-- page content (end) -->
        
        <!-- make offer (modal) -->
        <div class="modal fade" id="create-package-bid" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center fw-bold" id="staticBackdropLabel"><span class="bid-action">Make an</span> Offer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body container-fluid" style="margin-top: 0;padding-top: 0">
                        <div class="row">
                            <!-- create bid section-->
                            <div class="col-12 col-lg-4 create-bid-section">
                                <div class="create-bid-status text-center d-none" style="color: white;padding: 5px;">
                                    
                                </div>
                                
                                <div id="bid-form" style="margin-top: 15px;">
                                    <!-- make an offer -->
                                    <div class="mb-3">
                                        <label for="bid-offer" class="form-label fw-bold">Offer</label>
                                        <input type="number" class="form-control" id="bid-offer" name="offer" placeholder="Make Offer Here" required>
                                    </div>
        
                                    <div class="mb-3">
                                        <label for="bid-deadline" class="form-label fw-bold">Expiration</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" id="bid-deadline" name="deadline" placeholder="e.g. 24 for 24 hours, 48 for 48 hours" required>
                                            <span class="input-group-text">hour(s)</span>
                                        </div>
                                    </div>

                                    <div class="mb-3" style="position: relative;text-align: left;">
                                        <label for="upload-file" class="form-label fw-bold">Select File <sm class="text-secondary" style="font-size: 12px;">(pdf, txt, image or word)</sm></label>
                                    
                                        <div class="uploadfile" id="upload-file">
                                            <label class="btn addpic" style="margin: 0 auto;display: flex;align-items: center;justify-content: center;" for="selectfile"> 
                                                <input class="uploadfromlib" id="selectfile" name="file" type="file" style="display:none;" accept="image/png, image/jpg, image/jpeg, .pdf, .docx, .doc, .txt">
                                                <input type="hidden" id="itenary-file" name="itenary-file" value="">
                                            
                                                <div style="text-align: center;font-size: 30px;">
                                                    <div class="mb-3 input-group">
                                                        <i class="fa fa-file-circle-plus"></i>

                                                        <div id="loader" class="fa-3x d-none" style="font-size: 22px;margin-left: 5px;">
                                                            <i class="fas fa-spinner fa-pulse"></i>
                                                        </div>

                                                        <div id="file-name" class="text-secondary d-none" style="font-size: 22px;margin-left: 5px;">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- if user wants to edit -->
                                    <input type="hidden" name="package_id" id="package-id">
        
                                    <div class="submit-package" style="margin-top: 20px;float: right;">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary" id="bid-submit" style="background-color: #03C6C1;border-color: #03C6C1;">Send Offer <i class="fa-solid fa-send"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- end create bid section-->

                            <!-- list of bids -->
                            <div class="col-12 col-lg-8" style="margin-top: 10px;">
                                <!-- bids -->
                                <div id="package-bids" class="container-fluid">
                                    
                                </div>
                                <!-- END bids -->
                            </div>
                            <!-- END list of bids -->
                        </div>
                    </div>
                    <!-- END modal body -->
                </div>
            </div>
        </div>
        <!-- make offer (modal_end) -->

        <!-- sign up (modal) -->
        <div class="modal fade" id="modal-signup-now" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center fw-bold" id="staticBackdropLabel1">Sign Up</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="text-center" id="sign-up-first">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    <!-- check if user is logged in -->
                    <?php 
                        echo $packages->is_userloggedin();
                    ?>
                </div>
            </div>
        </div>
        <!-- sign up (modal_end) -->
        
        <div class="page-footer text-center text-white container-fluid" style=" margin-top: 40px;background-color: #141424 !important;margin-bottom: 0px !important;padding: 5px 30px 5px 30px;">
            <div class="text-center" style="font-size: 14px;margin-top: 5px;margin-bottom: 7px">
                <span class="fw-bold">For enquiries & Marketing</span> Contact admin <a href="tel:+918073479109">+918073479109</a>
            </div>
            
            
        </div>
        
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <!-- font awesome library -->
        <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>
        
        <!-- my scripts -->
        <!-- <script src="js/countries.js"></script> -->
        <script src="js/1_user.js"></script>
        <script src="js/5_bids.js"></script>
        <script src="js/1_comments.js"></script>
        <script src="js/2_layout.js"></script>
        <script src="js/file-upload.js"></script>
        <script src="js/file-download.js"></script>
    </body>

</html>