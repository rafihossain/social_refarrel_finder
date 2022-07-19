<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

<main class="page-content">
  <div class="card">
    <div class="card-body">
      <h2>Edit Keywords</h2>


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

      <form method="post" action="<?php echo base_url(); ?>updateCrwalerkeyword/<?php echo $keyword->id; ?>/<?php echo $cid; ?>">
        <div class="col-12 mb-3">
          <label class="form-label">Client Name</label>
          <input type="text" class="form-control" value="<?php echo $cinfo->end_client;  ?>" />
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Master Keyword (one keyword only)</label>
          <input type="text" name="keyword" class="form-control" placeholder="Insert your keyword" value="<?php echo $keyword->keyword;  ?>" />
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Your Recommended Reply for this keyword</label>

          <textarea name="recommended_reply" class="form-control" cols="30" rows="10"><?php echo $keyword->recommended_reply;  ?></textarea>
        </div>


        <div class="col-12">
          <button type="submit" class="btn btn-primary px-5">Update Keyword</button>
        </div>

        <!--<div class="d-flex mt-4">-->
        <!--  <a class="btn btn-outline-danger btn-rounded" href="<?php echo base_url() ?>editcrawler/<?php echo $cid; ?>">Cancel</a>-->
        <!--  <button type="submit" class="btn btn-primary ms-auto btn-rounded">Update</button>-->
        <!--</div>-->


      </form>

    </div>
  </div>

</main>