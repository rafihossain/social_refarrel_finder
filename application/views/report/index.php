<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.time.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.date.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url() ?>main_assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css">

<style>
   .addclass i {
      font-size: 24px;
   }
</style>

<!-- line awesome-->
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

<header class="top-header">
   <nav class="navbar navbar-expand gap-3 d-md-none ">
      <div class="mobile-toggle-icon fs-3">
         <i class="bi bi-list"></i>
      </div>
   </nav>
   <div class="header-page">
      <h4 class="heading-title">Reports</h4>
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
                  <div class="text-white mt-2">
                     <p>Please select crawler account, date range and then click apply in filter section before searching!</p>
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
                           <label class="form-label">Account</label>
                           <select id="crawler_account_id" name="crawler_account_id[]" class="selectpicker form-control" data-live-search="true" data-actions-box="true" multiple>
                              <?php foreach ($crawlers as $crawler) { ?>
                                 <option value="<?php echo $crawler->id; ?>"><?php echo $crawler->full_name; ?></option>
                              <?php  }   ?>
                           </select>
                        </div>

                        <div class="mb-4">
                           <label for="" class="label">Tags</label>
                           <select id="filter_tags" name="filter_tags[]" class="selectpicker form-control" data-live-search="true" data-actions-box="true" multiple>



                           </select>
                        </div>
                        <span class="tag_error"></span>
                        
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
</header>

<main class="page-content">

   <button type="button" class="btn btn-primary mb-2" id="exportToCsv">Export To CSV</button>

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
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>

<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.time.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.date.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/form-date-time-pickes.js"></script>


<script type="text/javascript">
   // var table;

$(document).ready(function(){

   $('.selectpicker').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
      // var ambassador_id = $(this).attr("clid");
      // console.log(ambassador_id);

      var account_id = $(this).find('option').eq(clickedIndex).val();
      console.log(account_id);

      if (isSelected == true) {
            var action = "add";
      } else {
            var action = "delete";
      }

      $.ajax({
            url: "<?php echo base_url(); ?>selected_account_associated_tag",
            type: "post",
            data: {
               account_id: account_id,
               action: action,
            },
            dataType: "JSON",
            success: function(data) {
               // console.log(data.tag);

               var appendText = '';
               if (data.success != undefined && data.success != '') {
                  // console.log('hi');
                  var filtered_tags = '';

                  appendText +='<optgroup><option value="4">'+filtered_tags+'</option><option value="0" selected>All Tags + Non-Tagged</option><option value="1">All Tags</option><option value="2">Non-Tagged</option></optgroup><option value="'+ data.success.tag +'">'+ data.success.tag +'</option>';

                  $('#filter_tags').html(appendText);
                  $('.tag_error').html('<div class="alert alert-success" role="alert">Tags Found.</div>');
                  $('.selectpicker').selectpicker('refresh');
               } else {
                  // console.log('hello');
                  $('.tag_error').html('<div class="alert alert-danger" role="alert">No Tags Found.</div>');
               }
            }
      });


   });

   $('.filter-reset').click(function() {
      // alert('hello');
      $('#filterBoxForm')[0].reset();
      $('#filter_tags').html('');
      $('.tag_error').html('');
      $('.selectpicker').selectpicker('refresh');
   });


   $('.filter-click').click(function() {
      $('#filter_tags').html('');
      $('.tag_error').html('');
      $('.selectpicker').selectpicker('refresh');
      $('.filter-box').toggle();
   });
   $('.custome-search').click(function() {
      var filter_tags = $('#filter_tags').val();
      var txtTriggers = $('#txtTriggers').val();
      var datepicker_from = $('#datepicker_from').val();
      var datepicker_to = $('#datepicker_to').val();
      var crawler_account_id = $('#crawler_account_id').val();

      if (crawler_account_id != '') {
         $.ajax({
            "url": "<?php echo base_url() . 'getreport/0' ?>",
            "type": "POST",
            "data": {
               "filter_tags": filter_tags,
               "datepicker_from": datepicker_from,
               "datepicker_to": datepicker_to,
               "txtTriggers": txtTriggers,
               "exact_match": 1,
               "crawler_account_id": crawler_account_id,
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
         alert('Please select crawler account in filter section!');
         return;
      }

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
            console.log(response);
         },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
      });
   });

   getAllReportWhenPageLoad();

   $('.filter-btn').click(function() {
         $('.filter-box').hide();
         $('.tag_error').html('');

        var filter_tags = $('#filter_tags').val();
        var txtTriggers = $('#txtTriggers').val();
        var exact_match = $('#exact_match').val();
        var datepicker_from = $('#datepicker_from').val();
        var datepicker_to = $('#datepicker_to').val();
        var crawler_account_id = $('#crawler_account_id').val();
         
         if (crawler_account_id != '') {
             $.ajax({
                "url": "<?php echo base_url() . 'getreport/0' ?>",
                "type": "POST",
                "data": {
                "filter_tags": filter_tags,
                "datepicker_from": datepicker_from,
                "txtTriggers": txtTriggers,
                "exact_match": exact_match,
                "datepicker_to": datepicker_to,
                "crawler_account_id": crawler_account_id,
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
            alert('Please select crawler account');
            return;
        }


      });



      /*===============================================================
                           Export To CSV
      =================================================================*/
      
      $('#exportToCsv').click(function() {

        var filter_tags = $('#filter_tags').val();
        var txtTriggers = $('#txtTriggers').val();
        var exact_match = $('#exact_match').val();
        var datepicker_from = $('#datepicker_from').val();
        var datepicker_to = $('#datepicker_to').val();
        var crawler_account_id = $('#crawler_account_id').val();

        if(filter_tags != '' && txtTriggers != '' && exact_match != '' && datepicker_from != '' && datepicker_to != '' && crawler_account_id != ''){
           if (crawler_account_id != '') {
               $.ajax({
                  "url": "<?php echo base_url() . 'export_to_csv' ?>",
                  "type": "POST",
                  "data": {
                  "filter_tags": filter_tags,
                  "datepicker_from": datepicker_from,
                  "txtTriggers": txtTriggers,
                  "exact_match": exact_match,
                  "datepicker_to": datepicker_to,
                  "crawler_account_id": crawler_account_id,
                  },
                  success: function(response) {
                     window.open('<?= base_url() ?>/file.csv');
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                     // console.log(textStatus, errorThrown);
                  }
               });
          } else {
              alert('Please select crawler account');
              return;
          }
        }else{
            $.ajax({
               "url": "<?php echo base_url() . 'export_to_csv_custom' ?>",
               "type": "POST",
               success: function(response) {
                  window.open('<?= base_url() ?>/file.csv');
               },
               error: function(jqXHR, textStatus, errorThrown) {
                  // console.log(textStatus, errorThrown);
               }
            });
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
            
                $('#tag_div_'+rm_id).html(data);
                $("#staticBackdrop").modal("hide");


            }

         });

      });




});

function getAllReportWhenPageLoad() {
   $.ajax({
      "url": "<?php echo base_url() . 'load_report' ?>",
      "type": "POST",
      success: function(response) {
         var nhtml = JSON.parse(response);
         $('#repotrs').html(nhtml);

         //console.log(response);
         // You will get response from your PHP page (what you echo or print)
      },
      error: function(jqXHR, textStatus, errorThrown) {
         console.log(textStatus, errorThrown);
      }
   });
}

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