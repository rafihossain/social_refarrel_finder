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
                                    <h2 class="card-title text-center text-light fw-light mb-4">SIGN UP</h2>

                                    <?php if (empty($success)) : ?>
                                        <form class="form-body" method="post" action="<?php echo base_url(); ?>signup">
                                            <div class="row g-3 text-white">
                                                <div class="col-12">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" name="crawler_name"
                                                    placeholder="Enter name">
                                                    <div class="mt-2 text-neutral"><?php echo form_error('crawler_name'); ?></div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="crawler_email"
                                                    placeholder="Enter email">
                                                    <div class="mt-2 text-neutral"><?php echo form_error('crawler_email'); ?></div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" class="form-control" name="crawler_password" placeholder="Enter password">
                                                    <div class="mt-2 text-neutral"><?php echo form_error('crawler_password'); ?></div>
                                                </div>
                                                <div class="col-12 mb-4">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-neutral rounded-0 text-uppercase">signup</button>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center text-light text-uppercase">
                                                    <p class="mb-0">ALREADY HAVE ACCOUNT? <a href="<?php echo base_url(); ?>" class="text-neutral">SIGNIN</a> HERE</p>
                                                </div>
                                            </div>
                                        </form>
                                    <?php endif; ?>

                                    <?php if (isset($success)) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo $success; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (isset($success)) : ?>
                                        <div class="col-12 text-center text-light">
                                            <p class="mb-0">PLEASE LOGIN !</p>
                                            <br>
                                            <a href="<?php echo base_url(); ?>" class="text-neutral">
                                                <button type="button" class="btn btn-neutral rounded-0 text-uppercase w-100">LOGIN</button>
                                            </a>
                                        </div>
                                    <?php endif; ?>
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