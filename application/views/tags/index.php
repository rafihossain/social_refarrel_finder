<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

<header class="top-header">
   <nav class="navbar navbar-expand gap-3 d-md-none ">
      <div class="mobile-toggle-icon fs-3">
         <i class="bi bi-list"></i>
      </div>
   </nav>
   <div class="header-page">
      <h4 class="heading-title">Tags</h4>
   </div>
</header>

<main class="page-content">
  <div class="card">
    <div class="card-body">
      <h2>Tags</h2>
      <p>Define your tags below. You will be able to assign one or multiple tags to recommendation requests to better filter results.</p>

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

      <form method="post" action="<?php echo base_url(); ?>addclienttags">
        <br>
        <p><b>New Tag</b></p>
        <div class="mb-3">
          <label for="tag" class="form-label">Enter a new tag (only lowercase and hyphens. No spaces or special characters.)</label>
          <input class="form-control" type="text" id="tag" name="tag" onkeyup="return forceLower(this);" />
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" value="1" name="daily_report" id="daily_report" checked>
          <label class="form-check-label" for="daily_report">Include in daily report (when feature is turned on in settings)</label>
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" value="1" name="export_report" id="export_report" checked>
          <label class="form-check-label" for="export_report">Include in export report</label>
        </div>
        <button type="submit" class="btn btn-primary px-5" id="tagValidation">Add Tag </button>
      </form>
    </div>
  </div>





  <?php if (count($tags) > 0) { ?>
    <div class="table-responsive mt-3">
      <table id="mytble" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Tag</th>
            <th>Include in Daily Report</th>
            <th>Include in Export Report</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php $i = 0;
          foreach ($tags as $tag) {  ?>
            <tr>
              <td><?php echo $i = $i + 1; ?></td>
              <td>
                <div class="d-flex align-items-center gap-3 cursor-pointer">
                  <div class="">
                    <p class="mb-0"><?php echo $tag->tag ?></p>
                  </div>
                </div>
              </td>
              <td><?php echo ($tag->daily_report == 1 ? 'Yes' : 'No') ?></td>
              <td><?php echo ($tag->export_report == 1 ? 'Yes' : 'No') ?></td>
              <td>
                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                  <a class="btn btn-danger" href="<?php echo base_url() ?>deleteclienttags/<?php echo $tag->id; ?>" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="bi bi-trash-fill"></i></a>
                </div>
              </td>
            </tr>
          <?php } ?>

        </tbody>
      </table>
    </div>
  <?php } ?>

</main>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js" integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  $(document).ready(function() {
    $('#mytble').DataTable();
  });

  function forceLower(strInput){
    strInput.value=strInput.value.toLowerCase();
  }

</script>