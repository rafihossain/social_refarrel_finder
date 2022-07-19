<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<main class="page-content">
  <div class="row">
    <div class="col-12 col-lg-12 col-xl-12 d-flex">
      <div class="card radius-10 w-100">

        <div class="card">
          <div class="card-body">
            <div class="border p-3 rounded">

              <?php if ($this->session->userdata('account_level') == 'admin') { ?>
                <h6 class="mb-0 text-uppercase">Update Crawler</h6>
              <?php } elseif ($this->session->userdata('account_level') == 'ambassador') { ?>
                <h6 class="mb-0 text-uppercase">Update Account</h6>
              <?php } elseif ($this->session->userdata('account_level') == 'admin') { ?>
                <h6 class="mb-0 text-uppercase">Update Account</h6>
              <?php } ?>
              <hr />
              <?php if ($this->session->flashdata('error')) : ?>
                <div class="alert border-0 bg-light-danger alert-dismissible fade show py-2">
                  <div class="d-flex align-items-center">
                    <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div class="ms-3">
                      <div class="text-danger"><?php echo $this->session->flashdata('error'); ?> </div>
                    </div>
                  </div>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif ?>
              <?php if ($this->session->flashdata('sucess')) : ?>
                <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
                  <div class="d-flex align-items-center">
                    <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="ms-3">
                      <div class="text-success"><?php echo $this->session->flashdata('sucess'); ?></div>
                    </div>
                  </div>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif ?>


              <form class="row g-3" method="post" action="<?php echo base_url(); ?>updtecrawlerinfo/<?php echo $id; ?>">

                <div class="col-12">
                  <label class="form-label">Crawler Name</label>
                  <input name="full_name" type="text" class="form-control" name="crawler_name" value="<?php echo $info->full_name; ?>" required>
                </div>


                <div class="col-12">
                  <label class="form-label">Crawler Email</label>
                  <input name="email" type="text" class="form-control" name="client_email" value="<?php echo $info->email; ?>" required>
                </div>

                <div class="col-12">
                  <label class="form-label">Crawler Password</label>
                  <input name="password" type="password" class="form-control">
                </div>
                <?php if ($this->session->userdata('account_level') == 'admin') { ?>
                  <div class="col-12">
                    <div class="form-check form-switch">
                      <input class="form-check-input" name="active" value="1" type="checkbox" id="flexSwitchCheckChecked" <?php echo ($info->active == 1 ? "checked" : ""); ?>>
                      <label class="form-check-label" for="flexSwitchCheckChecked">Enabled Disabled Crawler</label>
                    </div>
                  <?php  } ?>
                  </div>
                  <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary px-5">Update</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
  $("#multiple").select2({
    placeholder: "Select a programming language",
    allowClear: true
  });
</script>