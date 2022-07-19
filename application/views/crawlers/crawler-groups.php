<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

<style>
  #newkeyword {
    display: none;
  }

  button#uplodcsv {
    width: 60%;
    min-width: 220px;
    margin-top: 30px;
  }

  div#for_flex {
    display: flex;
  }

  a#downloadTemplete {
    max-height: 40px;
    margin-right: 20px;
  }
</style>

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

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h2>Facebook Groups</h2>
                    <p>Use this page to connect or disconnect Facebook groups.</p>
                    <p>Currently Connected: <?php echo count($groups) ?></p>

                    <?php if ($this->session->flashdata('group_success')) : ?>
                        <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
                            <div class="d-flex align-items-center">
                                <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="text-success"><?php echo $this->session->flashdata('group_success'); ?></div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>
                    <p><b>Add New Group</b></p>
                    <form method="post" action="<?php echo base_url(); ?>crawler_groups">
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
        </div>
        <div class="col-md-5">
            <div class="card" style="min-height:160px">
                <div class="card-body text-center" id="for_flex">

                    <a href="<?php echo base_url() ?>main_assets/uploads/csv/social_referral_finder_csv_template.csv" class="btn btn-neutral rounded-pill text-uppercase" id="downloadTemplete">Download Template</a>

                    <form method="post" action="<?= base_url() ?>crawlercsv_group/<?= $this->session->userdata('id'); ?>" enctype="multipart/form-data">
                        <input type="file" onchange="this.form.submit()" name="enter_csv" id="uploadCsvId" class="d-none" />
                        <label class="btn btn-neutral rounded-pill text-uppercase" for="uploadCsvId">
                            Upload CSV
                        </label>
                    </form>

                    <!-- <button class="btn btn-primary" id="uplodcsv"> Upload CSV </button> -->
                </div>

            </div>
        </div>
    </div>

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
                                    <a class="btn btn-danger" id="deleteGroup" data-id="<?php echo $group->id; ?>" class="text-danger" title="Delete"><i class="bi bi-trash-fill"></i></a>
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

        $(document).on('click', '#deleteGroup', function() {
            var Id = $(this).attr('data-id');
            // console.log(Id);

            swal({
                    title: "Are you sure?",
                    text: "You want to disconnect this group?",
                    icon: "warning",
                    buttons: ["Cancel", "Yes"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Success! Group has been Disconnect successfully!", {
                            icon: "success",
                        });

                        $.ajax({
                            url: "<?php echo base_url() ?>crawler_groups_delete/" + Id,
                            dataType: "JSON",
                            success: function(data) {
                                window.location.reload();
                            }
                        });
                    } else {
                        swal("Group will NOT be removed!");
                    }

                });

        });



    })
</script>