<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>
<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/select2/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

<main class="page-content">

  <style>
    .cl_add_group {
      float: left;
      width: 100%;
    }
    .modalBtn{
      color: #d5d5d5 !important;
    }
  </style>

  <?php if ($this->session->flashdata('success')) : ?>
    <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
      <div class="d-flex align-items-center">
        <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="ms-3">
          <div class="text-success"><?= $this->session->flashdata('success'); ?></div>
        </div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>


  <form method="post" action="<?php echo base_url(); ?>editclient/<?= $sclient->end_client_id; ?>">
    <div class="container">
      <!-- New Code Start-->
      <div class="row align-items-start">
        <div class="col-md-3 col-sm-4">
          <div class="nav flex-column nav-pills me-3" style="min-width: 200px;" id="v-pills-tab" role="tablist" aria-orientation="vertical">

            <button class="nav-link active" id="client-info-tab" data-bs-toggle="pill" data-bs-target="#client-info" type="button" role="tab" aria-controls="client-info" aria-selected="true">Client Info</button>

            <button class="nav-link" id="crawler-list-tab" data-bs-toggle="pill" data-bs-target="#crawler-list" type="button" role="tab" aria-controls="crawler-list" aria-selected="false">Crawler List</button>

          </div>
        </div>
        <div class="col-md-9 col-sm-8">
          <div class="tab-content" id="v-pills-tabContent">

            <div class="tab-pane fade show active" id="client-info" role="tabpanel" aria-labelledby="client-info-tab">

              <div class="row">
                <div class="col-12 col-lg-12 col-xl-12 ">
                  <div id="clientInfo">
                    <h4 class="text-primary">Client Basic Info</h4>
                    <br>

                    <div id="client_form" class="row">

                      <div class="col-12">
                        <label class="form-label">Business Name</label>
                        <input type="text" class="form-control" name="business_name" value="<?php echo $sclient->business_name ?>" required>
                      </div>
                      <div class="col-12">
                        <label class="form-label">Client Name</label>
                        <input type="text" class="form-control" name="contact_name" value="<?php echo $sclient->end_client ?>" required>
                      </div>

                      <div class="col-12 mb-2">
                        <label class="form-label">Client Email</label>
                        <input type="email" class="form-control" name="client_email" id="checkValidEmail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Client Email" value="<?php echo $sclient->client_email ?>" required>
                      </div>
                      <div class="error_show"></div>

                      <div class="col-12 mb-2">
                        <label class="form-label">Client Tag</label>
                        <input type="text" class="form-control" id="clientTags" name="client_tag" placeholder="Enter client tag" value="<?php echo $sclient->client_email ?>" required>
                      </div>


                      <div class="col-12 mb-2">
                        <label class="form-label">Dashboard Username</label>
                        <input type="text" class="form-control" name="dashboard_user" placeholder="Dashboard Username" value="<?php echo $sclient->client_email ?>" required>
                      </div>

                      <div class="col-12 mb-2">
                        <label class="form-label">Dashboard Password</label>
                        <input type="password" class="form-control" name="dashboard_pass" id="showPass" placeholder="Dashboard Password" required>
                      </div>

                      <div class="mb-2">
                        <input type="checkbox" onclick="myFunction()"> Show Password
                      </div>

                      <div class="mt-2 col-12 text-center">
                        <button type="button" class="btn btn-primary btnNext" >Next</button>
                      </div>

                    </div>

                  </div>
                </div>
              </div>

            </div>

            <div class="tab-pane fade" id="crawler-list" role="tabpanel" aria-labelledby="crawler-list-tab">

              <div class="row">
                <div class="col-12 col-lg-12 col-xl-12 ">
                  <div id="crawlerList">
                    <h4 class="text-primary">Crawler List</h4>
                    <br>

                    <select id="filter_crawler" name="multiple_crawler[]" class="selectpicker form-control" title="Choose multiple crawler" data-live-search="true" data-actions-box="true" clid="<?php echo $sclient->end_client_id; ?>" multiple required>
                      <?php foreach ($allcrawlers as $crawler) : ?>
                          <option value="<?= $crawler['id']; ?>" 
                          
                          <?php
                            for ($i = 0; $i < count($relatedcrawlers); $i++) {
                              if($crawler['full_name'] == $relatedcrawlers[$i]){
                                echo "selected";
                              }
                            }
                          ?>
                          
                          ><?= $crawler['full_name']; ?></option>
                      <?php endforeach; ?>
                    </select>


                    <!-- <td class="mb-2">
                        <label class="form-label">Crawler Name:</label>
                        <span class="btn btn-sm btn-secondary"><?php //getAllCrawlerUnderClient($sclient->end_client_id, 0); ?></span>
                    </td> -->

                    <div id="client_form" class="row">

                      <!-- <div class="col-12 mb-2">
                        <label class="form-label">Crawler</label>
                        <select id="filter_crawler" name="multiple_crawler[]" class="selectpicker form-control" title="Choose multiple crawler" data-live-search="true" data-actions-box="true" multiple required>
                          
                        </select>
                        <div class="cl_error_show"></div>
                      </div> -->

                      <div class="mt-2 col-12 text-center">
                        <button type="submit" class="btn btn-primary btnNext" id="clientInfoNextBtn">Submit</button>
                      </div>

                    </div>

                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>

    </div>

  </form>

  <form method="post" action="<?= base_url() ?>client_fbgroupcsv" enctype="multipart/form-data">
    <input type="file" onchange="this.form.submit()" name="enter_csv" id="uploadCsvId" class="d-none" />
  </form>

  <!-- New Code End-->
</main>

<!--  Modal content for the above example -->
<div id="crawlerModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myExtraLargeModalLabel">All Crawlers Name</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <table>
          <tbody id="allCrawler">

          </tbody>
        </table>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--  Modal content for the above example -->
<div id="clientFbGroupsModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myExtraLargeModalLabel">Update group information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="groups_update"></div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>
<script src="<?php echo base_url() ?>main_assets/select2/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js" integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

  $('.selectpicker').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
      var end_client_id = $(this).attr("clid");
      var crawler_id = $(this).find('option').eq(clickedIndex).val();
      if (isSelected == true) {
          var action = "add";
      } else {
          var action = "delete";
      }
      // console.log();

      $.ajax({
          url: "<?php echo base_url(); ?>crawler_change",
          type: "post",
          data: {
              end_client_id: end_client_id,
              crawler_id: crawler_id,
              action: action,
          },
          dataType: "JSON",
          success: function(data) {

          }
      });
  });


  $('#teamId').on("change", function() {
      var Id = $(this).val();

      $.ajax({
        url: "<?php echo base_url() ?>/teammember_depand/" + Id,
        type: "get",
        dataType: "JSON",
        success: function(data) {

          $('#filter_crawler').html('');
          for (i = 0; i < data.length; i++) {
            $('#filter_crawler').append('<option value="' + data[i].user_id + '">' + data[i].full_name + '</option>');
          }

          $("#filter_crawler").selectpicker('refresh');

        }
      });

    });



  /*==================================
        Crawler Modal Section
  ===================================*/

  $('.modalBtn').on('click', function() {
    $('#crawlerModal').modal('show');
    var crawlerVal = $(this).attr('data-id');

    $.ajax({
      url: "<?= base_url() ?>crawler_name",
      type: 'POST',
      data: {
        crawlerVal: crawlerVal
      },
      success: function(data) {
        var html = '';
        $('#allCrawler').html(data);
      }
    });

  });

  $(document).ready(function() {

    $('.metismenu li a').click(function() {
      localStorage.clear();
    });
    /*========================================
                Get Active Tabs
     ==========================================*/
    $('.nav-pills button').on('shown.bs.tab', function(e) {
      localStorage.setItem('activeTab', $(e.target).attr('data-bs-target'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
      $('#v-pills-tab button[data-bs-target="' + activeTab + '"]').tab('show');
    }


    $(document).on('change', '#checkValidEmail', function() {
      var email = $(this).val();
      validateEmail(email);
    });


    $("#clientTags").selectize({
      delimiter: ",",
      persist: false,
      create: function(input) {
        return {
          value: input,
          text: input,
        };
      },
    });



    $('#example').DataTable();

    /*=============================
          Next Previous Button
    ===============================*/

    $('.btnNext').click(function() {

      var hasattr = $(this).attr('id');


      if (hasattr != undefined && hasattr == 'clientInfoNextBtn') {
        var selected = []
        selected = $('.selectpicker').val()
        if (selected.length == 0) {
          $('.cl_error_show').html('<div class="alert alert-danger" role="alert">Please select Crawler.</div>');
          return;
        }
      }
      if (hasattr != undefined && hasattr == 'for_group') {
        if (groupArray.length == 0) {
          $('.cl_add_group').html('<div class="alert alert-danger" role="alert">Please add Group.</div>');
          return;
        }
      }
      console.log(hasattr);
      //  return;
      if (hasattr != undefined && hasattr == 'for_keywordData') {
        if (keywordArray.length == 0) {
          $('.cl_add_keyword').html('<div class="alert alert-danger" role="alert">Please add keyword.</div>');
          return;
        }

      }



      $('.nav-pills > .active').next('button').trigger('click');

    });

    $('.btnPrevious').click(function() {
      $('.nav-pills > .active').prev('button').trigger('click');
    });

    $('#clickForKeyword').click(function() {
      $('#keyword_form').toggle();
    });

    $('#clickForFBGroups').click(function() {
      $('#facebook_groups').toggle();
    });


    //sweetalert

    $(document).on('click', '#deleteClient', function() {
      var Id = $(this).attr('data-id');

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
              url: "<?php echo base_url() ?>deleteclient/" + Id,
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


  function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if (!emailReg.test(email)) {
      $('.error_show').html('<div class="alert alert-danger" role="alert">Enter validate email address!</div>');
    } else {
      $('.error_show').html('');
    }
  }

  
  $('.team_search').select2();

  function myFunction() {
    var showPass = document.getElementById("showPass");

    if (showPass.type === 'password') {
      showPass.type = 'text';
    } else {
      showPass.type = 'password';
    }
  }
</script>





</main>