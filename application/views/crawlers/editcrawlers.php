<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<main class="page-content">
  <div class="card">
    <div class="card-body">
      <h5 class="mb-0 text-uppercase text-primary"><?php echo $info->full_name; ?></h5>
      <hr />
      <p class="mb-0"><strong>Email:</strong> <?php echo $info->email; ?> <a href="<?php echo base_url(); ?>editcrawlerinfo/<?php echo $id; ?>" class="text-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Information"><i class="bi bi-pencil-fill"></i></a></p>
      <p class="mb-0"><strong>Connected Groups:</strong> <?php totalConnectedGroupsInCrawler($id); ?></p>
    </div>
  </div>


  <div class="row">
    <div class="col-12 col-lg-12 col-xl-12 ">
      <div id="facebookgrouplist">
        <h4 class="text-primary">Facebook Groups: <a class="btn text-light radius-30 bg-primary" href="javascript:void(0)" id="clickFroFbGroup"><i class="m-0 bx bx-plus"></i></a> </h4>


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

        <form id="form_group" method="post" action="<?php echo base_url(); ?>addgroup/<?php echo $id; ?>">
          <div class="col-12 mb-2">
            <label class="form-label">FB Group Name</label>
            <input type="text" class="form-control group_name" name="group_name" placeholder="FB Group Name" required>
          </div>
          <div class="col-12  mb-2">
            <label class="form-label">FB Group URL</label>
            <input type="text" class="form-control group_url" name="group_url" placeholder="FB Group URL"
            required>
          </div>
          <div class="col-12  mb-2">
            <label class="form-label">FB Group Category</label>
            <input type="text" class="form-control" name="group_category" placeholder="FB Group Category" required>
          </div>

          <div class="col-12  mb-2">
            <label class="form-label">Type</label>
            <select name="type" id="type" class="form-control type">
              <option value="private">Private</option>
              <option value="public">public</option>
            </select>
          </div>
          <br>
          <div class="col-12 ">
            <button class="btn btn-primary px-5 group_add"> Connect Groups</button>
          </div>
        </form>
        <br>
        <div class="row">
          <div class="col-12 mb-3">
            <button class="btn btn-secondry round-btn view_all mb-2" attr="">View all</button>
            <button class="btn btn-secondry round-btn public  mb-2" attr="public">Public </button>
            <button class="btn btn-secondry round-btn private  mb-2" attr="private">Private</button>
          </div>
        </div>
        <br>
        <div class="table-responsive">
          <table id="facebook_group" border="0" class="table table-striped table-bordered" cellpadding="15">
            <thead>
              <tr>
                <th><span>Group Name</span></th>
                <th><span>Group URI</span></th>
                <th><span>Group Category</span></th>
                <th><span>Group Type</span></th>
                <th><span>Requests</span></th>
                <th><span>Action</span></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($groups as $group) {  ?>
                <tr>
                  <td class="text-wrap"><span><?php echo ($group->fb_group_name != '' ? $group->fb_group_name : '') ?></span></td>
                  <td class="text-truncate" style="max-width: 250px;">
                    <span><?php echo ($group->fb_group_uri != '' ? $group->fb_group_uri : '') ?></span>
                  </td>
                  <td class="text-wrap"><span><?php echo ($group->group_category != '' ? $group->group_category : '') ?></span></td>
                  <td class="text-wrap"><span><?php echo $group->type; ?></span></td>
                  <td><span><?php echo checkRequestByClawerId($group->fb_group_id, $id); ?></span></td>


                  <td>
                    <a class="btn btn-primary " href="<?= base_url() ?>editgroup/<?php echo $group->id; ?>/<?php echo $id; ?>" title="Edit">
                      <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a class="btn btn-danger" id="deleteGroup" data-id="<?php echo $group->id; ?>/<?php echo $id; ?>" title="Delete">
                      <i class="bi bi-trash-fill"></i>
                    </a>
                  </td>

                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php if ($this->session->flashdata('csv_error')) : ?>
    <div class="alert border-0 bg-light-danger alert-dismissible fade show py-2">
      <div class="d-flex align-items-center">
        <div class="fs-3 text-danger"><i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="ms-3">
          <div class="text-danger"><?php echo $this->session->flashdata('csv_error'); ?></div>
        </div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif ?>

  <div class="row mb-5">
    <div class="col-12 d-flex align-items-center">
      <form method="post" action="<?= base_url() ?>uploadcsv/<?php echo $id; ?>" enctype="multipart/form-data">
        <input type="file" onchange="this.form.submit()" name="enter_csv" id="uploadCsvId" class="d-none" />
        <label class="btn btn-neutral rounded-pill text-uppercase" for="uploadCsvId">
          Upload CSV
        </label>
      </form>
      <a class="btn btn-neutral rounded-pill ms-2 text-uppercase" href="<?php echo base_url() ?>main_assets/uploads/csv/social_referral_finder_csv_template.csv">
        Download Template
      </a>
    </div>
  </div>


</main>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>
<script>
  $(document).ready(function() {

    $('#clickFroMyTag').click(function() {
      $('#form_tag').toggle();
    })
    $('#clickFroFbGroup').click(function() {
      $('#form_group').toggle();
    })
    $('#clickForKeyword').click(function() {
      $('#form_keyword').toggle();
    })

  })

  $(document).ready(function() {

    var table = $('#facebook_group').DataTable({
      dom: 'Bfrtip',
      pageLength: 5,
      lengthMenu: [
      [5, 10, 20, -1],
      [5, 10, 20, 50]
      ],
      buttons: [{
        extend: 'csvHtml5',
        text: 'EXPORT TO CSV',
        className: 'btn btn-primary text-white ms-3',
        exportOptions: {
          // modifier: {
          //    page: 'current'
          // }
        }
      }]
    });


    function filterColumn(value) {
      console.log(value);
      table.column(3).search(value).draw();
    }


    $('.round-btn').on('click', function() {
      var type = $(this).attr('attr');
      filterColumn(type);
    });

    //sweetalert

    $(document).on('click', '#deleteTag', function() {
      var Id = $(this).attr('data-id');
      // console.log(Id);

      swal({
        title: "Are you sure?",
        text: "You want to delete this file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal("Success! Your file has been deleted!", {
            icon: "success",
          });

          $.ajax({
            url: "<?php echo base_url() ?>deletetag/" + Id,
            dataType: "JSON",
            success: function(data) {
              window.location.reload();
            }
          });
        } else {
          swal("Your file is safe!");
        }

      });

    });


    /*sweetalert for facebook group */

    $(document).on('click', '#deleteGroup', function() {
      var Id = $(this).attr('data-id');
      // console.log(Id);

      swal({
        title: "Are you sure?",
        text: "You want to delete this file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal("Success! Your file has been deleted!", {
            icon: "success",
          });

          $.ajax({
            url: "<?php echo base_url() ?>disconnectgroup/" + Id,
            dataType: "JSON",
            success: function(data) {
              window.location.reload();
            }
          });
        } else {
          swal("Your group is safe!");
        }

      });

    });

    /*sweetalert for keyword */

    $(document).on('click', '#deleteKeyword', function() {
      var Id = $(this).attr('data-id');
      // console.log(Id);

      swal({
        title: "Are you sure?",
        text: "You want to delete this file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal("Success! Your file has been deleted!", {
            icon: "success",
          });

          $.ajax({
            url: "<?php echo base_url() ?>deleteKeyword/" + Id,
            dataType: "JSON",
            success: function(data) {
              window.location.reload();
            }
          });
        } else {
          swal("Your file is safe!");
        }

      });

    });



  });
</script>