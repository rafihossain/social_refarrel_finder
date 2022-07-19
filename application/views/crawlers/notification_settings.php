<style>
  #show_form {
    display: none;
  }

  #selectonchange {
    max-width: 450px;
  }
</style>

<!--new profile header-->
<header class="top-header">
   <nav class="navbar navbar-expand gap-3 d-md-none ">
      <div class="mobile-toggle-icon fs-3">
         <i class="bi bi-list"></i>
      </div>
   </nav>
   <div class="header-page">
      <h4 class="heading-title">Notification Settings For <?= $info->full_name; ?></h4>
      <p class="text-white">Manage your notifications in one place.</p>
   </div>
</header>


<main class="page-content">
  <div class="card">
    <div class="card-body">

      <p>Receive daily reports? You will receive the report of the previous day.</p>
      <select class="form-select form-select-lg mb-3" id="selectonchange" aria-label=".form-select-lg example">
        <option <?php echo $info->daily_report == 1 ? 'selected' : '';  ?> value="1">Yes</option>
        <option <?php echo $info->daily_report == 0 ? 'selected' : '';  ?> value="0">No</option>

      </select>

      <p><a href="javascript:void(0)" id="jvascriptform"> Add New Notification </a></p>


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

      <form id="show_form" action="<?php echo base_url(); ?>add_notification_settings/<?php echo $info->id; ?>" method="post">


        <div class="col-12">
          <label class="form-label">Notification Type *</label>
          <select class="form-control" name="notification_type" id="notification_type">
            <option value="email">Email</option>
            <option value="phone">Phone</option>
          </select>

          <!-- <input type="text" class="form-control" name="business_name" required> -->
        </div>
        <div class="col-12">
          <label class="form-label">Notification Address *</label>
          <input type="text" class="form-control" name="notification_address" required>
        </div>

        <div class="col-12">
          <label class="form-label">Timezone *</label>
          <select class="form-control" name="notification_timezone" id="notification_timezone" require>

            <?php
            foreach ($timezones as $tz) {
            ?>

              <option value="<?php echo $tz; ?>"><?php echo $tz; ?></option>
            <?php   }      ?>


          </select>
        </div>



        <div class="col-12">
          <label class="form-label">Notification Interval *</label>
          <select class="form-control" name="notification_interval" id="notification_interval" require>
            <option value="1">Every In 1 hour</option>
            <option value="2">Every In 2 hour</option>
            <option value="3">Every In 3 hour</option>
            <option value="4">Every In 4 hour</option>
            <option value="5">Every In 5 hour</option>
          </select>
        </div>

        <div class="col-12">
          <label class="form-label">Notification Starts *</label>
          <input type="time" class="form-control" name="notification_starts">
        </div>

        <div class="col-12 mb-3">
          <label class="form-label">Notification End *</label>
          <input type="time" class="form-control" name="notification_ends">
        </div>


        <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary px-5">Add Notification</button>
        </div>

      </form>
    </div>
  </div>


  <?php if (count($notifications) > 0) { ?>


    <div class="card">
      <div class="card-body">
        <h4>Current Notifications</h4>


        <div class="table-responsive mt-3">
          <table class="table align-middle">
            <thead class="table-secondary">
              <tr>
                <th>Address</th>
                <th>Notify</th>
                <th>Starts At</th>
                <th>Ends At</th>
                <th>Timezone</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($notifications as $noti) {   ?>
                <tr>
                  <td><?php echo $noti->notification_address; ?></td>
                  <td> Every <?php echo $noti->notification_interval; ?> hour</td>
                  <td><?php echo $noti->notification_starts; ?> </td>
                  <td><?php echo $noti->notification_ends; ?> </td>
                  <td><?php echo $noti->notification_timezone; ?> </td>
                  <td>
                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                      <a href="<?php echo base_url(); ?>deletenoti/<?php echo  $noti->id; ?>" class="btn btn-sm btn-danger"> <i class="bi bi-trash-fill"></i></a>
                    </div>
                  </td>
                </tr>

              <?php } ?>


            </tbody>
          </table>
        </div>
      </div>
    </div>

  <?php } ?>

</main>
<script>
  $(document).ready(function() {

    $('#jvascriptform').on('click', function() {
      $('#show_form').toggle();

    })

    $('#selectonchange').on('change', function() {
      var changeval = $(this).val();

      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>change_status/<?php echo $info->id; ?>",
        data: {
          changeval: changeval
        },
        dataType: "text",
        cache: false,
        success: function(data) {
          console.log(data);
          location.reload();
        }
      }); // you have missed this bracket
      return false;
    });




    // $('#ChangePassword').on('click',function(){
    //    $('#show_form').toggle();
    //         //alert(123123);
    // })

  })
</script>