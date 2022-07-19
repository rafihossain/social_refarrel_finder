<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.time.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.date.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url() ?>main_assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css">
<!-- line awesome-->
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

<style>
   .addclass i {
      font-size: 24px;
   }

   /*============================================
            Recommendations filter
==============================================*/

   /* .pr_new_list .recommendation-reply-box {
      width: 100%;
      max-width: 403px;
      position: absolute;
      right: 90px;
      z-index: 100;
      margin-top: -25px;
   }

   .pr_new_list .recommendation-reply-box .recommendation-title {
      font-weight: 700;
      font-size: 16px;
      color: #000000;
      padding: 26px 19px 0px 19px;
   }

   .pr_new_list .recommendation-reply-box .replies-list {
      font-weight: 400;
      font-size: 12px;
      color: #000000;
      padding: 16px 19px;
   }

   .pr_new_list .recommendation-reply-box .recommendation-replies {
      background: #fff;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-left: auto;
   }

   .pr_new_list .recommendation-reply-box .card-body {
      padding: 0;
   }

   .pr_new_list .recommendation-reply-box .replies-list .card-body {
      padding: 10px;
   }

   .pr_new_list .recommendation-reply-box .replies-list .card {
      box-shadow: none;
   }

   .pr_new_list .recommendation-reply-box .replies-list .replies-text {
      color: #000000;
      font-weight: 400;
      font-size: 12px;
      margin: 0;
   }

   .page-content .recommendation-item .recommendation-reply-box .replies-list .card-body {
      border: 1px solid #CDCDCD;
      border-radius: 4px;
   } */
</style>

<header class="top-header">
   <nav class="navbar navbar-expand gap-3 d-md-none ">
      <div class="mobile-toggle-icon fs-3">
         <i class="bi bi-list"></i>
      </div>
   </nav>
   <div class="header-page">
      <h4 class="heading-title">Triggers</h4>
      <p class="heading-text">You will find here all people who requested recommendations in your connected groups with the keywords that you defined.</p>
      <div class="row heading-content">
         <div class="col-md-8">
            <div class="row">
               <div class="col-md-12">
                  <div class="search-wrapper d-flex">
                     <img src="<?php echo base_url() ?>main_assets/images/search.png" alt="input-search" class="search-icon">
                     <input type="text" class="form-control" id="txtTriggers" name="txtTriggers">
                     <button type="button" class="btn btn-primary custome-search">Search</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4 text-end custome-filter mt-3">
            <div class="filter-click">
               <img src="<?php echo base_url() ?>main_assets/images/filter.png" alt="input-search" class="filter-image">
               <span class="filter-text">Filters</span>
               <i class="las la-angle-up"></i>
            </div>

            <div class="filter-box" style="display: none;">
               <div class="card">
                  <form action="" id="filterBoxForm">
                     <div class="card-body text-start ">
                        <h4 class="filter-title mb-4">Filters</h4>
                        <div class="mb-4">
                           <label for="" class="label">Tags</label>
                           <select id="filter_tags" name="filter_tags[]" class="selectpicker form-control" data-live-search="true" data-actions-box="true" multiple>
                              <optgroup>
                                 <option value="4"> <?php echo $filtered_tags; ?></option>
                                 <option value="0" <?php if ($top_level_tag == "0") {
                                                      echo "selected='selected'";
                                                   } ?>>All Tags + Non-Tagged</option>
                                 <option value="1" <?php if ($top_level_tag == "1") {
                                                      echo "selected='selected'";
                                                   } ?>>All Tags</option>
                                 <option value="2" <?php if ($top_level_tag == "2") {
                                                      echo "selected='selected'";
                                                   } ?>>Non-Tagged</option>
                              </optgroup>
                              <?php foreach ($tags as $tag) { ?>
                                 <option value="<?php echo $tag->tag; ?>"><?php echo $tag->tag; ?></option>
                              <?php  }   ?>

                           </select>
                        </div>
                        <h6 class="mb-3 label">Date Range</h6>
                        <div class="row">

                           <div class="col-6">
                              <label class="form-label">From Date</label>
                              <input type="text" id="datepicker_from" name="datepicker_from" date_format="d/m/yyyy" value="<?php echo date("Y-m-d"); ?>" class="form-control datepicker" />
                           </div>
                           <div class="col-6">
                              <label class="form-label">To Date</label>
                              <input type="text" id="datepicker_to" name="datepicker_to" date_format="d/m/yyyy" value="<?php echo date("Y-m-d"); ?>" class="form-control datepicker" />
                           </div>

                        </div>
                        <div class="mt-4 d-flex">
                           <button type="button" class="btn btn-light btn-lg filter-reset">RESET</button>
                           <button type="button" class="btn btn-primary btn-lg ms-auto filter-btn">Apply Filter</button>
                        </div>

                     </div>
                  </form>
               </div>
            </div>
         </div>

      </div>
   </div>
   </div>
</header>


<main class="page-content">

   <div id="repotrs"> </div>


   <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="staticBackdropLabel">Apply Tags</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p>Select the tag(s) you want to apply to this recommendation request then click "Save".</p>
               <input type="hidden" id="recommendation_id" value="" name="recommendation_id">
               <select id="updated_tags" name="updated_tags[]" class="selectpicker" data-actions-box="true" data-live-search="true" multiple>
                  <?php foreach ($tags as $tag) { ?>
                     <option value="<?php echo $tag->tag; ?>"><?php echo $tag->tag; ?></option>
                  <?php } ?>

               </select>

            </div>
            <div class="modal-footer">
               <button type="submit" id="tag_submit" class="btn btn-primary">Save</button>
            </div>
         </div>
      </div>
   </div>

</main>

<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>


<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.time.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.date.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/form-date-time-pickes.js"></script>

<script type="text/javascript">
   $(document).ready(function() {

      $('.filter-click').click(function() {
         $('.filter-box').toggle();
      });

      $(document).on('click', '.myclass', function(e) {
         e.preventDefault();
         var hrl = $(this).attr('href');
         $.ajax({
            "url": hrl,
            "type": "POST",
            "data": '',
            success: function(response) {
               var nhtml = JSON.parse(response);
               $('#repotrs').html(nhtml);
               // console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
               //console.log(textStatus, errorThrown);
            }
         });
      });

      $('.custome-search').click(function() {
         var filter_tags = $('#filter_tags').val();
         var txtTriggers = $('#txtTriggers').val();
         var datepicker_from = $('#datepicker_from').val();
         var datepicker_to = $('#datepicker_to').val();

         $.ajax({
            "url": "<?php echo base_url() . 'getcrawlerrecommendation/0' ?>",
            "type": "POST",
            "data": {
               "filter_tags": filter_tags,
               "datepicker_from": datepicker_from,
               "datepicker_to": datepicker_to,
               "txtTriggers": txtTriggers,
               "exact_match": 1,
            },
            success: function(response) {
               var nhtml = JSON.parse(response);
               $('#repotrs').html(nhtml);
            },
            error: function(jqXHR, textStatus, errorThrown) {
               // console.log(textStatus, errorThrown);
            }
         });

      });

      $('.filter-reset').click(function() {
         // alert('hello');
         $('#filterBoxForm')[0].reset();
      });

      $('.filter-btn').click(function() {
         $('.filter-box').hide();
         var filter_tags = $('#filter_tags').val();
         var txtTriggers = $('#txtTriggers').val();
         var exact_match = $('#exact_match').val();
         var datepicker_from = $('#datepicker_from').val();
         var datepicker_to = $('#datepicker_to').val();

         if (filter_tags != '') {
            $.ajax({
               "url": "<?php echo base_url() . 'getcrawlerrecommendation/0' ?>",
               "type": "POST",
               "data": {
                  "filter_tags": filter_tags,
                  "datepicker_from": datepicker_from,
                  "txtTriggers": txtTriggers,
                  "exact_match": exact_match,
                  "datepicker_to": datepicker_to
               },
               success: function(response) {
                  var nhtml = JSON.parse(response);

                  $('#repotrs').html(nhtml);
               },
               error: function(jqXHR, textStatus, errorThrown) {
                  // console.log(textStatus, errorThrown);
               }
            });

         } else {
            alert('Please select filter tag');
            return;
         }


      });

      $('#tag_submit').on('click', function() {
         var rm_id = $('#recommendation_id').val();
         var tags = $('#updated_tags').val();
         console.log(rm_id);

         $.ajax({
            "url": "<?php echo base_url() . 'update_crawler_tag' ?>",
            "type": "POST",
            data: {
               'rm_id': rm_id,
               'tags': tags
            },
            dataType: 'html',
            success: function(data) {
               //   console.log(data);

               $('#tag_div_' + rm_id).html(data);
               $("#staticBackdrop").modal("hide");


            }

         });

      });

   });

   function open_post(post_link, input_id) {

      var input_re = document.getElementById(input_id);

      input_re.select();

      document.execCommand("copy");

      window.open(post_link, "_blank");

   }

   function show_modal_tags(ev) {
      $("#staticBackdrop").modal("toggle");
      $('#recommendation_id').val(ev);
   }
</script>