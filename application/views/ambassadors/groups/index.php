<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

<!--new profile header-->
<header class="top-header">
   <nav class="navbar navbar-expand gap-3 d-md-none ">
      <div class="mobile-toggle-icon fs-3">
         <i class="bi bi-list"></i>
      </div>
   </nav>
   <div class="header-page">
      <h4 class="heading-title">Facebook Groups</h4>
   </div>
</header>

<main class="page-content">
  <div class="card">
    <div class="card-body">
      <h2>Facebook Groups</h2>
      <p>Use this page to connect or disconnect Facebook groups.</p>
      <p>Currently Connected: <?php echo count($groups) ?></p>
      <p>Need more? <a href="">contact us to upgrade</a></p>

      <?php if ($this->session->flashdata('group_error')) : ?>
        <div class="alert border-0 bg-light-danger alert-dismissible fade show py-2">
          <div class="d-flex align-items-center">
            <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i>
            </div>
            <div class="ms-3">
              <div class="text-danger"><?php echo $this->session->flashdata('group_error'); ?> </div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif ?>
      <?php if ($this->session->flashdata('group_sucess')) : ?>
        <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
          <div class="d-flex align-items-center">
            <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="ms-3">
              <div class="text-success"><?php echo $this->session->flashdata('group_sucess'); ?></div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif ?>
      <p><b>Add New Group</b></p>
      <form method="post" action="<?php echo base_url(); ?>ambass_add_groups">
        <div class="col-12 mb-2">
          <label class="form-label">FB Group Name</label>
          <input type="text" class="form-control group_name" name="group_name" required>
        </div>
        <div class="col-12  mb-2">
          <label class="form-label">FB Group URL</label>
          <input type="text" class="form-control group_url" name="group_url" required>
        </div>
        <div class="form-group mb-2">
          <label class="form-label">FB Group Category</label>
          <input type="text" class="form-control group_category" name="group_category" required>
        </div>

        <div class="col-12  mb-2">
          <label class="form-label">Type</label>
          <select name="type" id="type" class="form-control type">
            <option value="private">Private</option>
            <option value="public">public</option>
          </select>
        </div>

        <div class="col-12 mb-2">
          <label class="form-label">Join Status</label>
          <select name="join_status" id="joinStatus" class="form-control">
              <option value="1">Join</option>
              <option value="0">Not join</option>
          </select>
        </div>

        <br>
        <div class="col-12 ">
          <button class="btn btn-primary px-5 group_add"> Connect Group</button>
        </div>
      </form>
    </div>
  </div>




  <?php if (count($groups) > 0) { ?>
    <div class="table-responsive mt-3">
      <table id="mytble" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Group Name</th>
            <th>URL</th>
            <th>Category</th>
            <th>Type</th>
            <th>Join Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php $i = 0;
          foreach ($groups as $group) {  ?>
            <tr>
              <td><?php echo $i = $i + 1; ?></td>
              <td>
                <div class="d-flex align-items-center gap-3 cursor-pointer">
                  <div class="">
                    <p class="mb-0"><a href="<?php echo $group->fb_group_uri ?>"><?php echo $group->fb_group_name ?></a></p>
                  </div>
                </div>
              </td>
              <td><?php echo $group->fb_group_uri; ?></td>
              <td><?php echo $group->group_category; ?></td>
              <td><?php echo $group->type; ?></td>
              <td>
                <?= ($group->connected == 1 ? '<span class="badge bg-success rounded-pill">Joined</span>' : '<span class="badge bg-warning rounded-pill text-black">Not joined</span>'); ?>
              </td>
              <td>
                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                  <a class="btn btn-danger" id="disconnectGroup" data-id="<?php echo $group->id; ?>" class="text-danger" title="Delete"><i class="bi bi-trash-fill"></i></a>
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

    //sweetalert

    $(document).on('click', '#disconnectGroup', function() {
      var Id = $(this).attr('data-id');
      // console.log(Id);

      swal({
          title: "Are you sure?",
          text: "You want to disconnect this group?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Success! Group has been Disconnect successfully!", {
              icon: "success",
            });

            $.ajax({
              url: "<?php echo base_url() ?>ambass_disconnect_group/" + Id,
              dataType: "JSON",
              success: function(data) {
                window.location.reload();
              }
            });
          } else {
            swal("Group is safe!");
          }

        });

    });



  })
</script>