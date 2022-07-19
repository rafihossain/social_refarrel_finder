<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<main class="page-content">
  <div class="row">
    <div class="col-12 col-lg-12 col-xl-12  ">
      <div class="card  ">
        <div class="card-body">

          <h4 class="mb-0 text-uppercase text-primary">Add Crawler</h4>
          <hr />
          <form class="row g-3" method="post" action="<?php echo base_url(); ?>submitcrawler">

            <div class="col-12">
              <label class="form-label">Crawler Name</label>
              <input name="name" type="text" class="form-control" name="crawler_name" required>
            </div>

            <div class="col-12">
              <label class="form-label">Crawler Email</label>
              <input name="email" type="email" id="emailValiditeCheck" class="form-control" name="client_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>

              <div class="email_validite_message"></div>
            </div>

            <div class="col-12">
              <label class="form-label">Crawler Password</label>
              <input name="password" type="password" class="form-control" required>
            </div>


            <div class="col-12">
              <div class="form-check form-switch">
                <input class="form-check-input" name="active" value="1" type="checkbox" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">Crawler Enabled Or Disabled</label>
              </div>
            </div>
            <div class="col-12 text-center">
              <button type="submit" class="btn btn-primary px-5" id="nexBtn">Next</button>
            </div>
          </form>

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

  $('#emailValiditeCheck').on("change", function() {
    // alert('hi');
    var email = $(this).val();
    // console.log(crawler_id);
    $.ajax({
      url: "<?php echo base_url(); ?>email_validite_check",
      type: "post",
      data: {
        email: email
      },
      success: function(data) {

        if(data == 'success'){
          $('.email_validite_message').html('<span class="text-success">Email Available !!</span>');
          $("#nexBtn").attr("disabled", false);
        }else{
          $('.email_validite_message').html('<span class="text-danger">This email is already taken! please enter new email address !!</span>');
          $("#nexBtn").attr("disabled", true);
        }

      }
    });

  });
</script>