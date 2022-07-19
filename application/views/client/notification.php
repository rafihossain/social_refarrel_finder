<header class="top-header">
    <nav class="navbar navbar-expand gap-3 d-md-none ">
        <div class="mobile-toggle-icon fs-3">
            <i class="bi bi-list"></i>
        </div>
    </nav>
    <div class="header-page">
        <h4 class="heading-title">Notifications</h4>
    </div>
</header>

<main class="page-content rs-tab-content">
    <form method="post" action="<?php echo base_url(); ?>client_notification">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="notification-settings">
                            <h4 class="text-primary">Notifications</h4>
                            <br>

                            <?php if ($this->session->flashdata('success')) : ?>
                                <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <div class="ms-3">
                                    <div class="text-success"><?php echo $this->session->flashdata('success'); ?></div>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif ?>

                            <div class="notification_form">
                                <div class="row mb-4">

                                    <div class="col-md-8">
                                        <label class="form-label">Email Addresses*</label>
                                        <input type="text" class="form-control" name="notification_address" placeholder="Email Addressess" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Intervals</label>
                                        <select class="form-control" name="notification_interval" id="notification_interval">
                                            <option value="1">Every In 1 hour</option>
                                            <option value="2">Every In 2 hour</option>
                                            <option value="3">Every In 3 hour</option>
                                            <option value="4">Every In 4 hour</option>
                                            <option value="5">Every In 5 hour</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 info mt-2">
                                        <i class="las la-info-circle"></i><span> You can add mulitple email addresses seprated by comma</span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Time Zones</label>
                                        <select class="form-control" name="notification_timezone" id="notification_timezone">
                                            <?php
                                            foreach ($timezones as $tz) : ?>
                                                <option value="<?php echo $tz; ?>"><?php echo $tz; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Starts At*</label>
                                        <input type="time" class="form-control" name="notification_starts" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Ends At*</label>
                                        <input type="time" class="form-control" name="notification_ends" required>
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-8 text-center m-auto">
                                <button type="submit" class="btn btn-primary py-2">Insert Notification</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>