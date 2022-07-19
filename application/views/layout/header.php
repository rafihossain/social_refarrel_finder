<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo base_url(); ?>main_assets/images/favicon.png" type="image/png" />
  <!--plugins-->
  <link href="<?php echo base_url(); ?>main_assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="<?php echo base_url(); ?>main_assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/css/style.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/css/icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">


  <!-- loader-->
  <link href="<?php echo base_url(); ?>main_assets/css/pace.min.css" rel="stylesheet" />

  <!--Theme Styles-->
  <link href="<?php echo base_url(); ?>main_assets/css/dark-theme.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/css/light-theme.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/css/semi-dark.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>main_assets/css/header-colors.css" rel="stylesheet" />
  <script src="<?php echo base_url(); ?>main_assets/js/jquery.min.js"></script>
  <!-- Bootstrap bundle JS -->
  <script src="<?php echo base_url(); ?>main_assets/js/bootstrap.bundle.min.js"></script>
  <!--plugins-->
  <title>Social Referral Finder</title>

</head>

<body>

  <!--start top header-->
  <header class="top-header" style="background-color: #194E6C;">
    <nav class="navbar navbar-expand gap-3">
      <div class="mobile-toggle-icon fs-3">
        <i class="bi bi-list"></i>
      </div>

      <div class="top-navbar-right ms-auto">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item dropdown dropdown-user-setting rs_header_div d-flex align-items-center">

            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret  d-flex align-items-center " href="#" data-bs-toggle="dropdown">

              <?php
              $accountLevel = $this->session->userdata('account_level');

              if ($accountLevel == 'admin') { ?>

                <?php echo $this->session->userdata('full_name'); ?>

              <?php } else if ($accountLevel == 'client') { ?>

                <?php echo $this->session->userdata('full_name'); ?>

              <?php } else { ?>

                <?php echo $this->session->userdata('full_name'); ?>

              <?php } ?>

              <div class="user-setting ms-2">
                <i class="lni lni-chevron-down"></i>
              </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="#">
                  <div class="d-flex align-items-center">

                    <div class="ms-3">
                      <h6 class="mb-0 dropdown-user-name"><?php echo $this->session->userdata('full_name'); ?></h6>
                      <small class="mb-0 dropdown-user-designation text-secondary"><?php echo $this->session->userdata('account_level'); ?></small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <?php if ($accountLevel == 'admin') { ?>

                <?php } else if ($accountLevel == 'client') { ?>
                  <a class="dropdown-item" href="<?= base_url() ?>clientaccount">
                    <div class="d-flex align-items-center">
                      <div class=""><i class="bi bi-person-fill"></i></div>
                      <div class="ms-3"><span>Profile</span></div>
                    </div>
                  </a>
                <?php } else if ($accountLevel == 'crawler') { ?>
                  <a class="dropdown-item" href="<?= base_url() ?>crawler_account">
                    <div class="d-flex align-items-center">
                      <div class=""><i class="bi bi-person-fill"></i></div>
                      <div class="ms-3"><span>Profile</span></div>
                    </div>
                  </a>
                <?php } else { ?>
                  <a class="dropdown-item" href="<?= base_url() ?>ambassadors_account/<?= $this->session->userdata('id'); ?>">
                    <div class="d-flex align-items-center">
                      <div class=""><i class="bi bi-person-fill"></i></div>
                      <div class="ms-3"><span>Profile</span></div>
                    </div>
                  </a>
                <?php } ?>
              </li>

              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item" href="<?php echo base_url(); ?>logout">
                  <div class="d-flex align-items-center">
                    <div class=""><i class="bi bi-lock-fill"></i></div>
                    <div class="ms-3"><span>Logout</span></div>
                  </div>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>