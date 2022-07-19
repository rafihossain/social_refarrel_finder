<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo base_url(); ?>/main_assets/images/favicon.png" type="image/png" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="<?php echo base_url(); ?>main_assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/css/style.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/css/icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  <!-- loader-->
  <link href="<?php echo base_url(); ?>main_assets/css/pace.min.css" rel="stylesheet" />

  <title>Social Referral Finder</title>
</head>

<body>
  <!--start wrapper-->
  <div class="wrapper">

    <!--start content-->
    <main class="authentication-content">
      <div class="container-fluid">
        <div class="authentication-card">
          <div class="card shadow rounded-0 overflow-hidden">
            <div class="row g-0">
              <div class="col-lg-6 mh-90  d-flex align-items-center justify-content-center">
                <img src="<?php echo base_url(); ?>main_assets/images/WhatsApp Image 2021-12-10 at 2.59 1.png" class="img-fluid logo-login" alt="">
              </div>
              <div class="col-lg-6 bg-primary d-flex align-items-center justify-content-center">
                <div class="card-body p-4 p-sm-5">
                  <h2 class="card-title text-center text-light fw-light mb-4">SIGN IN</h2>

                  <form class="form-body" method="post" action="<?php echo base_url(); ?>loginsubmit">

                    <?php if ($this->session->flashdata('message')) : ?>
                      <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('message'); ?>
                      </div>
                    <?php endif; ?>

                    <div class="row g-3">
                      <div class="col-12">

                        <div class="ms-auto position-relative">
                          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill text-primary"></i></div>
                          <input type="email" class="form-control rounded-0 ps-5 border-0" id="inputEmailAddress" name="email" placeholder="ENTER USERNAME">
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="ms-auto position-relative">
                          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill text-primary"></i></div>
                          <input type="password" class="form-control rounded-0 ps-5 border-0  " id="inputChoosePassword" name="password" placeholder="ENTER PASSWORD">
                        </div>
                      </div>


                      <div class="col-12 mb-4">
                        <div class="d-grid">
                          <button type="submit" class="btn btn-neutral rounded-0 text-uppercase">LOGIN</button>
                        </div>
                      </div>
                      <div class="col-12 text-center text-uppercase"> <a href="<?php echo base_url(); ?>forgot_pass" class="text-light">Forgot Password ?</a>
                      </div>
                      <div class="col-12 text-center text-light text-uppercase">
                        <p class="mb-0">DON’T HAVE ACCOUNT? <a href="<?php echo base_url(); ?>signup" class="text-neutral">SIGNUP</a> HERE</p>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!--end page main-->

  </div>
  <!--end wrapper-->


  <script src="<?php echo base_url(); ?>main_assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>main_assets/js/pace.min.js"></script>

</body>

</html>