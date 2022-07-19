<style>
   #show_form {
      display: none;
   }

   .filter-box .form-control {
      background-color: #CEEAE9;
      border: 1px solid #CEEAE9;
   }

   .search-box {
      position: relative;
   }

   .search-box .form-control {
      padding-right: 50px;
   }

   .search-box button {
      position: absolute;
      top: 14px;
      right: 12px;
      border: none;
      background: transparent;
      opacity: .5;
   }

   .hover-effects {
      position: relative;
      min-width: 100px;
      text-align: center;
   }

   .hover-effects .button-groups {
      display: none;
   }

   .hover-effects:hover .button-groups {
      display: flex;
      position: absolute;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      background: rgba(0, 0, 0, .2);
      border-radius: 60px;
      align-items: center;
      justify-content: center;
   }

   .hover-effects:hover .button-groups a {
      font-size: 12px;
      line-height: 12px;
      padding: 5px;
   }

   .replybtn_main {
      position: relative;
   }

   .replybtn_plus {
      padding-right: 60px;
   }

   .custome_plusbtn {
      position: absolute;
      bottom: 0;
      right: 10px;
      background: transparent;
      padding: 0;
      margin: 0;
      color: #194E6C;
      width: 40px;
      height: 38px;
      border: none;
      font-size: 30px;
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
      <h4 class="heading-title">Profile</h4>
      <div class="row heading-content">
         <div class="col-md-8">
            <div class="row">
               <div class="col-md-4">
                  <span>Name</span>
                  <h4><?= $info->full_name; ?></h4>
               </div>
               <div class="col-md-4">
                  <span>Email</span>
                  <h4><?= $info->email; ?></h4>
               </div>
               <!-- <div class="col-md-4">
                  <span>Phone</span>
                  <h4>+1 879 663 2121</h4>
               </div> -->
            </div>
         </div>
         <div class="col-md-4 text-end">
            <i class="bi bi-pencil-square editProfileICon" data-id ="<?= $info->id; ?>" data-name="<?= $info->full_name; ?>" data-email="<?= $info->email; ?>"></i>
         </div>
      </div>
   </div>
</header>

<!--new profile body-->
<main class="page-content rs-tab-content">


   <div class="row">
      <div class="col-12 col-lg-12 col-xl-12">
         <div class="card">
            <div class="card-body">
               <div class="facebook-group">
                  <h4 class="text-primary">Manage Facebook Groups</h4>
                  <br>

                  <form method="post" action="<?php echo base_url(); ?>ambassadors_account/<?= $this->session->userdata('id'); ?>">
                     <div class="row">
                        <div class="col-md-4 mb-2 filter-box">
                           <select name="category_filter" id="" class="form-control rounded-pill" onchange="this.form.submit()">
                              <option value="">---Category Filter---</option>
                              <option value="1">A-Z</option>
                              <option value="2">Z-A</option>
                           </select>
                        </div>
                        <div class="col-md-8 mb-2">
                           <div class="row filter-box">
                              <div class="col-sm-8">
                                 <div class="search-box">
                                    <!-- <input type="text" class="group_filter_value" value=""> -->
                                    <input type="input" class="form-control rounded-pill searchInput" id="" name="search_input" placeholder="SEARCH GROUP NAME">
                                    <button type="button" id="searchBtn">
                                       <i class="bi bi-search"></i>
                                    </button>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <select name="group_filter" id="" class="form-control rounded-pill groupFilter">
                                    <option value="">---Group Filter---</option>
                                    <option value="1">A-Z</option>
                                    <option value="2">Z-A</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>

                  <form method="post" action="<?php echo base_url(); ?>ambassador_profile">
                     <div class="row groups_categories g-0">
                        <div class="col-md-4">
                           <div class="category-box">
                              <h5 class="text-primary">Group Categories</h5>
                              <div class="category-box-content">
                                 <select name="multiple_category[]" id="groupCategory" class="form-control" multiple size="8">
                                    <?php foreach ($usersinfo as $info) : ?>
                                       <option value="<?= $info->user_id; ?>" countgroup="0" attr="<?= $info->full_name; ?>"><?= $info->full_name; ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="row">
                              <div class="col-md-4">
                                 <h5 class="text-primary">Select groups <span class="total_groups"></span></h5>
                              </div>
                              <div class="col-md-4">
                                 <h5 class="text-primary"><a href="#" class="btn btn-outline-primary" id="selectAll">Select All</a></h5>
                              </div>
                              <div class="col-md-4">
                                 <h5 class="text-primary"><a href="#" class="btn btn-outline-danger" id="deselectAll">Deselect All</a></h5>
                              </div>
                           </div>
                           <div class="groups_list">

                           </div>
                        </div>
                     </div>
               </div>

               <div class="table-responsive mt-5">
                  <table id="client_fb_groups" border="0" class="table table-striped table-bordered" cellpadding="15">
                     <thead>
                        <tr>
                           <th>Id</th>
                           <th>Name</th>
                           <th>URL</th>
                           <th>Category</th>
                           <th>Type</th>
                           <th>Join Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody id="fbtbody">

                     </tbody>
                  </table>

                  <textarea name="group" class="d-none" id="groupData"></textarea>
               </div>

            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12 col-lg-12 col-xl-12">
         <div class="card">
            <div class="card-body">
               <div class="keyword-list">
                  <h4 class="text-primary">Keywords</h4>
                  <br>
                  <div class="keyword-details">
                     <div class="col-md-4">
                        <div class="row align-items-end">
                           <div class="col-md-10">
                              <label for="">Add New Keyword</label>
                              <input type="text" class="form-control keyword-value">
                           </div>
                           <div class="col-md-2">
                              <button type="button" class="btn btn-primary custom-btn addkeyword">Add</button>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <label for="">Suggested Keywords</label>
                        <div class="suggestion-btnlist">
                           <div class="show-keyword"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="table-responsive">
                  <table id="client_keyword" class="table table-striped table-bordered d-none" style="width:100%">
                     <thead>
                        <tr>
                           <th>id</th>
                           <th>Keyword</th>
                           <th>Must-Include Keyword(s)</th>
                           <th>Must-Include Condition</th>
                           <th>Must-Exclude Keyword(s)</th>
                           <th>Recommended Reply</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody id="keyTable">

                     </tbody>
                  </table>

                  <textarea name="keyword" class="d-none" id="keywordData"></textarea>
               </div>

            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12 col-lg-12 col-xl-12">
         <div class="card">
            <div class="card-body">
               <div class="notification-settings">
                  <h4 class="text-primary">Notifications</h4>
                  <br>

                  <div class="notification_form">
                     <div class="row mb-4">

                        <div class="col-md-8">
                           <label class="form-label">Email Addresses*</label>
                           <input type="text" class="form-control" name="notification_address" placeholder="Email Addressess" required>
                        </div>

                        <div class="col-md-4">
                           <label class="form-label">Intervals</label>
                           <select class="form-control" name="notification_interval" id="notification_interval">
                              <option value="1">Every In 1 hour</option>
                              <option value="2">Every In 2 hour</option>
                              <option value="3">Every In 3 hour</option>
                              <option value="4">Every In 4 hour</option>
                              <option value="5">Every In 5 hour</option>
                           </select>
                        </div>
                        <div class="col-md-12 info mt-2">
                           <i class="las la-info-circle"></i><span> You can add mulitple email addresses seprated by comma</span>
                        </div>
                     </div>

                     <div class="row mb-4">
                        <div class="col-md-4">
                           <label class="form-label">Time Zones</label>
                           <select class="form-control" name="notification_timezone" id="notification_timezone">
                              <?php
                              foreach ($timezones as $tz) : ?>
                                 <option value="<?php echo $tz; ?>"><?php echo $tz; ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="col-md-4">
                           <label class="form-label">Starts At*</label>
                           <input type="time" class="form-control" name="notification_starts" required>
                        </div>
                        <div class="col-md-4">
                           <label class="form-label">Ends At*</label>
                           <input type="time" class="form-control" name="notification_ends" required>
                        </div>

                     </div>

                  </div>

                  <div class="col-md-8 text-center m-auto">
                     <button type="submit" class="btn btn-primary w-100 py-2">Update</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </form>
</main>

<!--  Modal content for the above example -->
<div id="editProfile" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Profile Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form action="" id="edit_profile_form">
               <div class="container">
                  <div class="row">

                     <div class="col-md-12 mb-2">
                        <label for="">Name</label>
                        <input type="hidden" class="form-control" name="profile_id" value="">
                        <input type="text" class="form-control" name="profile_name" value="">
                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="profile_email" value="">
                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">Old Password</label>
                        <input type="text" class="form-control" name="old_password" id="oldPassword">
                     </div>
                     <div class="col-md-12 mb-2">
                        <label for="">New Password</label>
                        <input type="text" class="form-control" name="new_password" id="newPassword">
                        <span class="text-danger error_pass"></span>
                     </div>
                  </div>

                  <div class="d-flex mt-4">
                     <a class="btn btn-outline-danger btn-rounded" data-bs-dismiss="modal">Cancel</a>
                     <button type="button" class="btn btn-primary ms-auto btn-rounded" id="updateProfile">Update Profile</button>
                  </div>
               </div>
            </form>
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--  Modal content for the above example -->
<div id="keywordModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="myExtraLargeModalLabel">Keywords</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="container">
               <form action="" id="keywordModalForm">
                  <button type="button" class="btn rounded-pill keyword-btntag" id="keyword"></button>

                  <div class="col-md-12 mb-4">
                     <div class="row">
                        <div class="col-md-6">
                           <label class="form-label">Must-Include Keyword(s)</label>
                           <input type="text" name="must_include_keywords" class="form-control" id="mustIncludeKeywords" placeholder="Insert your Must-Include keywords" />
                        </div>
                        <div class="col-md-6">
                           <label class="form-label">Must-Include Condition:</label>
                           <select name="must_include_condition" class="form-control" id="mustIncludeCondition">
                              <option value="all">All keywords</option>
                              <option value="one" selected>At least one keyword</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 mb-4">
                     <label class="form-label">Must-Exclude Keyword(s) <i class="fa fa-question-circle"></i></label>
                     <input type="text" name="must_exclude_keywords" class="form-control" id="mustExcludeKeywords" placeholder="Insert your Must-Exclude keywords" />
                  </div>

                  <div class="col-md-12 mb-4">
                     <div class="row">
                        <div class="replybtn_main">
                           <label class="form-label">Your Recommended Reply for this keyword</label>
                           <input type="text" name="recommended_reply[]" class="form-control addRecommendedReply replybtn_plus" placeholder="Recommended Reply..." />
                           <button class="prplusbtn custome_plusbtn"> + </button>
                        </div>
                     </div>
                     <div id="append_html"></div>
                  </div>

                  <div class="col-md-12 d-flex mt-4">
                     <a class="btn btn-outline-danger btn-rounded btn-lg" data-bs-dismiss="modal">Cancel</a>
                     <button type="button" class="btn btn-primary ms-auto btn-rounded btn-lg saveKeyword">Save</button>
                  </div>
               </form>

            </div>
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--  Modal content for the above example -->
<div id="suggestedKeywordModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="myExtraLargeModalLabel">Keywords</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="suggested-keyword-content"></div>
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


<script>
   var groupArray = [];
   var keywordArray = [];
   var crawler_id = 0;
   var statusValue = [];

   window.addEventListener('DOMContentLoaded', (event) => {

      $('#groupCategory').val($("#groupCategory option:first").val());
      crawler_id = $("#groupCategory option:first").val();
      var text = $("#groupCategory option:selected").attr('attr');

      var action = 'add';
      let countGroup = $("#groupCategory option:selected").attr('countgroup');
      console.log(countGroup);
      countGroup = parseInt(countGroup);

      $("#groupCategory option:selected").attr('countgroup', countGroup);
      let totalCountGroups = 0;
      $("[countgroup]").each(function() {
         totalCountGroups += parseInt($(this).attr("countgroup"));
      });
      $(".total_groups").html(totalCountGroups);


      $.ajax({
         url: "<?php echo base_url() ?>fb_group_category",
         type: "post",
         data: {
            crawler_id: crawler_id
         },
         dataType: "JSON",

         success: function(data) {

            var appendText = '';

            if (data != undefined && data != '') {
               // var statusValue = [];
               for (var i = 0; i < data.length; i++) {

                  if (data[i].status == 1) {
                     statusValue.push(data[i].status == 1);
                  }

                  var check = '';
                  if (data[i].status == 1) {
                     check = "checked";
                  } else {
                     check = "";
                  }

                  var g = i + 1;
                  appendText += '<div class="group-list-item"><div class="check-box ' + check + '" style="width:40%"><div class="checkbox_noselect"><input type="checkbox" ' + check + ' onChange="setData(' + data[i].id + ', this)" id="checkBoxItem_' + g + '" name="group_id" value="' + data[i].id + '"></div><label for="checkBoxItem_' + g + '" class="select_checkbox" data-id="' + g + '">' + data[i].fb_group_name + ' </label></div><div class="facebook-link"><a href="' + data[i].fb_group_uri + '">' + data[i].fb_group_uri + '</a></div></div>';

                  $('.groups_list').html(appendText);
               }

               var xyz = '' + text + ' (' + statusValue.length + ')';
               $("#groupCategory option:selected").attr('countgroup', statusValue.length);
               $("#groupCategory option:selected").text(xyz);

               $(".total_groups").html(statusValue.length);
               g++;

            } else {
               $('.groups_list').html('<div class="alert alert-danger" role="alert">No Data Found.</div>');
            }
         }
      });
   });

   $(document).ready(function() {
      /*--new profile code--*/
      $(document).on('change', '#checkValidEmail', function() {
         var email = $(this).val();
         validateEmail(email);
      });

      $('#ChangePassword').on('click', function() {
         $('#show_form').toggle();
      });

      $('.editProfileICon').on('click', function() {
         $("#edit_profile_form")[0].reset();

         $('input[name=profile_id]').val(`${$(this).data('id')}`);
         $('input[name=profile_name]').val(`${$(this).data('name')}`);
         $('input[name=profile_email]').val(`${$(this).data('email')}`);


         $('#editProfile').modal('show');
      });

      $('#updateProfile').click(function() {

         var profileEditInfo = $('#edit_profile_form').serialize();

         $.ajax({
            type: "post",
            url: "<?php echo base_url() ?>update_profile_info",
            data: profileEditInfo,
            dataType: "JSON",
            success: function(data) {

               if (data['info']) {
                  // console.log('info');
                  $('#editProfile').modal('hide');
                  $("#edit_profile_form")[0].reset();
                  window.location.reload();
               } else if (data['success']) {
                  $('#editProfile').modal('hide');
                  $("#edit_profile_form")[0].reset();

                  $('.error_pass').html('');
                  $('.success_pass').html(data.success);
                  window.location.reload();
               } else {
                  // console.log('error');
                  $('.error_pass').html(data.error);
               }
            }
         });

      });

      /*---new group code---*/
      $('#switch_user').on('change', function() {
         var data = $(this).val();
         // alert(data);
      });

      $('#selectAll').on('click', function() {

         var checkBoxSelect = [];
         $('.rs-tab-content .checkbox_noselect input:checkbox').each(function() {
            $(this).parent().parent().addClass("checked");

            $(this).prop("checked", true);

            if ($(this).is(":checked")) {
               checkBoxSelect.push($(this).val());
            }
         });

         var text = $("#groupCategory option:selected").attr('attr');
         console.log(text);

         var xyz = '' + text + ' (' + checkBoxSelect.length + ')';
         $("#groupCategory option:selected").attr('countgroup', checkBoxSelect.length);
         $("#groupCategory option:selected").text(xyz);

         let countGroup = $("#groupCategory option:selected").attr('countgroup');
         console.log(countGroup);

         var action = 'add';
         countGroup = parseInt(countGroup);

         $("#groupCategory option:selected").attr('countgroup', countGroup);

         let totalCountGroups = 0;
         $("[countgroup]").each(function() {
            totalCountGroups += parseInt($(this).attr("countgroup"));
         });
         console.log(totalCountGroups);

         $(".total_groups").html(totalCountGroups);

         $.ajax({
            url: "<?php echo base_url() ?>select_all_facebook_groups",
            type: "post",
            data: {
               crawler_id: crawler_id,
               group_id: checkBoxSelect,
               action: action
            },
            dataType: "JSON",
            success: function(data) {
               // console.log(data);
               var fbGroupName = data.cgroupinfo.fb_group_name;
               var fbGroupUrl = data.cgroupinfo.fb_group_uri;
               var fbGroupCategory = data.cgroupinfo.group_category;
               var fbGroupType = data.cgroupinfo.type;
               var join_status = data.cgroupinfo.connected;

               var crawlerId = data.cgroupinfo.crawler_id;


               var myarr = {
                  'crawler_id': crawlerId,
                  'fb_group_name': fbGroupName,
                  'fb_group_uri': fbGroupUrl,
                  'group_category': fbGroupCategory,
                  'type': fbGroupType,
                  "join_status": join_status,
               }

               groupArray.push(myarr);

               $('#groupData').val(JSON.stringify(groupArray));
               showInsertedFbGroupData(groupArray);

            }
         });
      });

      $('#deselectAll').on('click', function() {

         var checkBoxDeselect = [];
         $('.rs-tab-content .checkbox_noselect input:checkbox').each(function() {
            $(this).parent().parent().removeClass("checked");
            $(this).prop("checked", false);

            checkBoxDeselect.push($(this).val());

         });

         var text = $("#groupCategory option:selected").attr('attr');
         console.log(text);

         var xyz = '' + text + ' (0)';
         $("#groupCategory option:selected").attr('countgroup', parseInt(checkBoxDeselect.length) - checkBoxDeselect.length);
         $("#groupCategory option:selected").text(xyz);

         let countGroup = $("#groupCategory option:selected").attr('countgroup');
         action = 'delete';
         countGroup = parseInt(countGroup);

         $("#groupCategory option:selected").attr('countgroup', countGroup);

         let totalCountGroups = 0;
         $("[countgroup]").each(function() {
            totalCountGroups += parseInt($(this).attr("countgroup"));
         });
         console.log(totalCountGroups);
         $(".total_groups").html(totalCountGroups);


         var action = 'delete';

         $.ajax({
            url: "<?php echo base_url() ?>unselect_all_facebook_groups",
            type: "post",
            data: {
               crawler_id: crawler_id,
               group_id: checkBoxDeselect,
               action: action
            },
            dataType: "JSON",
            success: function(data) {}
         });
      });

      $('.groupFilter').on('change', function() {
         var groupFilter = $(this).val();
         // $('.group_filter_value').val(groupFilter);

         $.ajax({
            url: "<?php echo base_url() ?>search_facebook_groups",
            type: "post",
            data: {
               crawler_id: crawler_id,
               search_input: '',
               filter_value: groupFilter
            },
            dataType: "JSON",
            success: function(data) {

               var appendText = '';

               if (data != undefined && data != '') {
                  for (var i = 0; i < data.length; i++) {

                     var check = ''
                     if (data[i].status == 1) {
                        check = "checked";
                     } else {
                        check = "";
                     }

                     var g = i + 1;
                     appendText += '<div class="group-list-item"><div class="check-box ' + check + '" style="width:40%"><div class="checkbox_noselect"><input type="checkbox" ' + check + ' onChange="setData(' + data[i].id + ', this)" id="checkBoxItem_' + g + '" name="group_id" value="' + data[i].id + '"></div><label for="checkBoxItem_' + g + '" class="select_checkbox" data-id="' + g + '">' + data[i].fb_group_name + ' </label></div><div class="facebook-link"><a href="' + data[i].fb_group_uri + '">' + data[i].fb_group_uri + '</a></div></div>';

                     $('.groups_list').html(appendText);
                  }
                  g++;

               } else {
                  $('.groups_list').html('<div class="alert alert-danger" role="alert">No Data Found.</div>');
               }

            }
         });
         // console.log(groupFilter);
         // 
         // var groupFilter = $(this).val();
      });

      $('#searchBtn').on('click', function() {

         var searchInput = $(this).parent().find('.searchInput').val();

         $.ajax({
            url: "<?php echo base_url() ?>search_facebook_groups",
            type: "post",
            data: {
               crawler_id: crawler_id,
               search_input: searchInput,
               filter_value: 1
            },
            dataType: "JSON",
            success: function(data) {

               var appendText = '';

               if (data != undefined && data != '') {
                  for (var i = 0; i < data.length; i++) {

                     var check = ''
                     if (data[i].status == 1) {
                        check = "checked";
                     } else {
                        check = "";
                     }

                     var g = i + 1;
                     appendText += '<div class="group-list-item"><div class="check-box ' + check + '" style="width:40%"><div class="checkbox_noselect"><input type="checkbox" ' + check + ' onChange="setData(' + data[i].id + ', this)" id="checkBoxItem_' + g + '" name="group_id" value="' + data[i].id + '"></div><label for="checkBoxItem_' + g + '" class="select_checkbox" data-id="' + g + '">' + data[i].fb_group_name + ' </label></div><div class="facebook-link"><a href="' + data[i].fb_group_uri + '">' + data[i].fb_group_uri + '</a></div></div>';

                     $('.groups_list').html(appendText);
                  }
                  g++;

               } else {
                  $('.groups_list').html('<div class="alert alert-danger" role="alert">No Data Found.</div>');
               }

            }
         });
      });

      $('#groupCategory').on("change", function() {
         crawler_id = $(this).val();
         var text = $("#groupCategory option:selected").attr('attr');

         $.ajax({
            url: "<?php echo base_url() ?>fb_group_category",
            type: "post",
            data: {
               crawler_id: crawler_id
            },
            dataType: "JSON",

            success: function(data) {

               var appendText = '';

               if (data != undefined && data != '') {
                  var statusValue2 = [];
                  for (var i = 0; i < data.length; i++) {

                     if (data[i].status == 1) {
                        statusValue2.push(data[i].status == 1);
                     }

                     var check = ''
                     if (data[i].status == 1) {
                        check = "checked";
                     } else {
                        check = "";
                     }

                     var g = i + 1;
                     appendText += '<div class="group-list-item"><div class="check-box ' + check + '"><div class="checkbox_noselect"><input type="checkbox" ' + check + ' onChange="setData(' + data[i].id + ', this)" id="checkBoxItem_' + g + '" name="group_id" value="' + data[i].id + '"></div><label for="checkBoxItem_' + g + '" class="select_checkbox" data-id="' + g + '">' + data[i].fb_group_name + ' </label></div><div class="facebook-link"><a href="' + data[i].fb_group_uri + '">' + data[i].fb_group_uri + '</a></div></div>';

                     $('.groups_list').html(appendText);
                  }
                  var xyz = '' + text + ' (' + statusValue2.length + ')';
                  $("#groupCategory option:selected").attr('countgroup', statusValue2.length);
                  $("#groupCategory option:selected").text(xyz);


                  let countGroup = $("#groupCategory option:selected").attr('countgroup');
                  // console.log(countGroup);
                  countGroup = parseInt(countGroup);

                  $("#groupCategory option:selected").attr('countgroup', countGroup);
                  let totalCountGroups = 0;
                  $("[countgroup]").each(function() {
                     totalCountGroups += parseInt($(this).attr("countgroup"));
                  });
                  $(".total_groups").html(totalCountGroups);

                  g++;

               } else {
                  $('.groups_list').html('<div class="alert alert-danger" role="alert">No Data Found.</div>');
               }
            }
         });
      });

      $(document).on("click", ".rs-tab-content .checkbox_noselect input:checkbox", function() {
         $(this).parent().parent().toggleClass("checked");
      });

      $("#groups_categories select option").click(function() {
         $(this).toggleClass('active');
      });

      /*---new keyword code---*/

      $('.addkeyword').click(function() {
         $('#keywordModalForm')[0].reset();
         $('#keywordModal').modal('show');

         var suggestedKey = $('.keyword-value').val();
         // console.log(suggestedKey);
         $('.keyword-btntag').html(suggestedKey);

      });
      $('.suggested-key').click(function() {
         $('#keywordModal').modal('show');
         var suggestedKey = $(this).val();
         $('.keyword-btntag').html(suggestedKey);
         // $('.suggested-key').val(suggestedKey);
      });

      /*========================================
        Add Multiple Recommendation Keyword
      ==========================================*/

      $(document).delegate(".recomreply", "click", function() {
         // e.preventDefault();
         // alert('hello');

         // console.log(this);
         // console.log($(this).find('.row').html());

         $(this).multifield({
            section: '.row',
            btnAdd: '.addrecomreply',
            btnRemove: '.removerecomreply',
            max: 4,
            locale: 'default'
         });

      });


      /*========================================
          Add Multiple Recommendation Keyword
      ==========================================*/

      var div_i = 0;
      $('.prplusbtn').on('click', function(e) {
         e.preventDefault();
         div_i = div_i + 1;
         var html = '';
         html += '<div class="col-12 mb-3 rs_main_divs" id="keyid' + div_i + '">';
         html += '<label>' + (div_i == 1 ? "2nd" : (div_i == 2 ? "3rd" : (div_i + 1) + "th")) + ' Keywords</label><br />';

         html += '<div class="row">';
         html += '<div class="replybtn_main"><input type="text" name="recommended_reply[]" class="form-control addRecommendedReply replybtn_plus" placeholder="Recommended Reply..." />';
         html += '<button nid="' + div_i + '" class="prminusbtn custome_plusbtn"> - </button></div>';
         html += '</div>'
         $('#append_html').append(html);

      });

      $("#append_html").delegate(".prminusbtn", "click", function(e) {
         e.preventDefault();
         div_i = div_i - 1;
         let id = 'keyid' + $(this).attr('nid');
         $('#' + id).remove();
      });

      $('.saveKeyword').click(function() {

         // $('.keyword-value').val('');
         $('#keywordModal').modal('hide');

         var keyword = $('#keyword').html();
         var mustIncludeKeywords = $('#mustIncludeKeywords').val();
         var mustIncludeCondition = $('#mustIncludeCondition').val();
         var mustExcludeKeywords = $('#mustExcludeKeywords').val();

         let storeRecom = [];
         $('.addRecommendedReply').each(function() {
            storeRecom.push($(this).val());
         });
         console.log(storeRecom);

         var recommendedReply = storeRecom.toString();

         if (recommendedReply == '') {
            alert('RecommendedReply is Empty');
            return;
         }


         var arrKeyword = {
            'keyword': keyword,
            'must_include_keywords': mustIncludeKeywords,
            'must_include_condition': mustIncludeCondition,
            'must_exclude_keywords': mustExcludeKeywords,
            'recommended_reply': recommendedReply,
         }

         keywordArray.push(arrKeyword);

         console.log(keywordArray);


         showSuggestedKeyword(keywordArray);

         $('#keywordData').val(JSON.stringify(keywordArray));
         showInsertedKeywordData(keywordArray);

      });


   });


   /*====================================
            Insert Keyword Table Data
   ======================================*/
   function keywordDelete(id) {
      keywordArray.splice(id, 1);

      var html = " ";
      for (i = 0; i < keywordArray.length; i++) {
         var g = i + 1;

         html += '<tr><td>' + g + '</td><td>' + keywordArray[i].keyword + '</td><td>' + keywordArray[i].must_include_keywords + '</td><td>' + keywordArray[i].must_include_condition + '</td><td>' + keywordArray[i].must_exclude_keywords + '</td><td>' + keywordArray[i].recommended_reply + '</td><td><a class="btn btn-danger" onclick="keywordDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></td></tr>';
      }

      $('#keyTable').html(html);
   }

   function showInsertedKeywordData(data) {

      $('#keyword').val('');
      $('.recommendedReply').val('');
      $('#mustIncludeKeywords').val('');
      $('#mustIncludeCondition').val('');
      $('#mustExcludeKeywords').val('');

      var html = "";

      for (var i = 0; i < data.length; i++) {
         var g = i + 1;

         html += '<tr><td>' + g + '</td><td>' + data[i].keyword + '</td><td>' + data[i].must_include_keywords + '</td><td>' + data[i].must_include_condition + '</td><td>' + data[i].must_exclude_keywords + '</td><td>' + data[i].recommended_reply + '</td><td><a class="btn btn-danger" onclick="keywordDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></td></tr>';
      }

      $('#keyTable').html(html);

   }

   function validateEmail(email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if (!emailReg.test(email)) {
         // $('.error_show').html('<div class="alert alert-danger" role="alert">Enter validate email address!</div>');
         $('.error_show').html('<div class="alert alert-danger" role="alert">Enter validate email address!</div>');
      } else {
         $('.error_show').html('');
      }
   }

   function myFunction() {
      var showPass = document.getElementById("showPass");

      if (showPass.type === 'password') {
         showPass.type = 'text';
      } else {
         showPass.type = 'password';
      }
   }


   function setData(x, y) {

      var action = '';
      var check = $("input:checkbox[value='" + x + "']").prop("checked");

      let countGroup = $("#groupCategory option:selected").attr('countgroup');

      if (check == true) {
         action = 'add';
         countGroup = parseInt(countGroup) + 1;
      } else {
         action = 'delete';
         countGroup = parseInt(countGroup) - 1;
      }

      $("#groupCategory option:selected").attr('countgroup', countGroup);

      let totalCountGroups = 0;
      $("[countgroup]").each(function() {
         totalCountGroups += parseInt($(this).attr("countgroup"));
      });

      var text = $("#groupCategory option:selected").attr('attr');
      var xyz = '' + text + ' (' + countGroup + ')';
      $("#groupCategory option:selected").text(xyz);
      $(".total_groups").html(totalCountGroups);

      $.ajax({
         url: "<?php echo base_url() ?>fetch_client_onboarding_groups",
         type: "post",
         data: {
            'crawler_id[]': crawler_id,
            group_id: x,
            action: action
         },
         dataType: "JSON",
         success: function(data) {
            if (data.action == 'add') {
               // console.log('group selected');
               var fbGroupName = data.cgroupinfo.fb_group_name;
               var fbGroupUrl = data.cgroupinfo.fb_group_uri;
               var fbGroupCategory = data.cgroupinfo.group_category;
               var fbGroupType = data.cgroupinfo.type;
               var join_status = data.cgroupinfo.connected;

               var crawlerId = data.cgroupinfo.crawler_id;


               var myarr = {
                  'crawler_id': crawlerId,
                  'fb_group_name': fbGroupName,
                  'fb_group_uri': fbGroupUrl,
                  'group_category': fbGroupCategory,
                  'type': fbGroupType,
                  "join_status": join_status,
               }

               groupArray.push(myarr);

               $('#groupData').val(JSON.stringify(groupArray));
               showInsertedFbGroupData(groupArray);

               // console.log(groupArray);
            }
         }
      });

   }


   function showInsertedFbGroupData(data) {
      var html = "";

      for (var i = 0; i < data.length; i++) {
         var g = i + 1;

         html += '<tr><td>' + g + ' <input type="hidden" name="crawler_id" value="' + data[i].crawler_id + '"> </td><td class="text-wrap">' + data[i].fb_group_name + '</td><td class="text-wrap">' + data[i].fb_group_uri + '</td><td>' + data[i].group_category + '</td><td>' + data[i].type + '</td><td>' + (data[i].join_status == 1 ? '<span class="badge bg-success rounded-pill">Joined</span>' : '<span class="badge bg-warning rounded-pill text-black">Not joined</span>') + '</td><td><a class="btn btn-primary" onclick="clickFunctionEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a class="btn btn-danger" onclick="fbGroupDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></td></tr>';
      }

      $('#fbtbody').html(html);

   }

   function fbGroupDelete(id) {
      groupArray.splice(id, 1);
      $('#groupData').val(groupArray)
      var html = "";

      for (var i = 0; i < groupArray.length; i++) {
         var g = i + 1;

         html += '<tr><td>' + g + '<input type="hidden" name="crawler_id" value="' + groupArray[i].crawler_id + '"></td><td class="text-wrap">' + groupArray[i].fb_group_name + '</td><td class="text-wrap">' + groupArray[i].fb_group_uri + '</td><td>' + groupArray[i].group_category + '</td><td>' + groupArray[i].type + '</td><td>' + (groupArray[i].join_status == 1 ? '<span class="badge bg-success rounded-pill">Joined</span>' : '<span class="badge bg-warning rounded-pill text-black">Not joined</span>') + '</td><td><a class="btn btn-primary" onclick="clickFunctionEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a onclick="fbGroupDelete(' + i + ')" class="btn btn-danger" id="deleteGroup" data-id="" title="Delete"><i class="bi bi-trash-fill"></i></a></td></tr>';
      }

      $('#fbtbody').html(html);
   }

   function clickFunctionEdit(id) {
      // console.log(id);
      $('#clientFbGroupsModal').modal('show');
      var html = '';
      html += '<div class="row" id=""><div class="col-md-12 mb-2"><label class="form-label">FB Group Name</label><input type="hidden" name="crawler_id" class="crawler_id" value="' + groupArray[id].crawler_id + '"><input type="text" class="form-control fb_group_name" name="group_name" placeholder="FB Group Name" value="' + groupArray[id].fb_group_name + '"></div><div class="col-12  mb-2"><label class="form-label">FB Group URL</label><input type="text" class="form-control fb_group_url" name="group_url" placeholder="FB Group URL" value="' + groupArray[id].fb_group_uri + '"></div><div class="col-12 mb-2"><label class="form-label">FB Group Category</label><input type="text" class="form-control fb_group_category" name="group_category" placeholder="FB Group Category" value="' + groupArray[id].group_category + '"></div><div class="col-12  mb-2"><label class="form-label">Type</label><select name="type" class="form-control fb_group_type"><option value="private">Private</option><option value="public">Public</option></select></div><div class="col-12  mb-2"><label class="form-label">Join Status</label><select name="join_status" class="form-control join_status"><option value="1">Join</option><option value="0">Not join</option></select></div><br><div class="col-12 "><button type="button" class="btn btn-primary px-5 w-100 group_replace" onclick="groupReplace(' + id + ')"> Update Groups</button></div></div>';
      $('#groups_update').html(html);
   }

   function groupReplace(id) {
      $('#clientFbGroupsModal').modal('hide');

      var crawler_id = $('.crawler_id').val();
      var group_name = $('.fb_group_name').val();
      var group_url = $('.fb_group_url').val();
      var group_category = $('.fb_group_category').val();
      var type = $('.fb_group_type').val();
      var join_status = $('.join_status').val();

      var myarr = {
         'crawler_id': crawler_id,
         'fb_group_name': group_name,
         'fb_group_uri': group_url,
         'group_category': group_category,
         'type': type,
         "join_status": join_status
      }

      groupArray.splice(id, 1, myarr);

      $('#groupData').val(JSON.stringify(groupArray))
      showInsertedFbGroupData(groupArray);
   }


   function suggestedKeywordDelete(id) {
      keywordArray.splice(id, 1);

      var html = "";
      for (var i = 0; i < keywordArray.length; i++) {
         var g = i + 1;

         html += '<button type="button" class="btn rounded-pill btn-custome suggested-key hover-effects mt-4 me-2" value="' + keywordArray[i].keyword + '">' + keywordArray[i].keyword + '<div class="button-groups"><a class="btn btn-primary btn-sm me-2" onclick="suggestedKeywordEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a class="btn btn-danger btn-sm" onclick="suggestedKeywordDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></div></button>';
      }

      $('.show-keyword').html(html);
   }

   function suggestedKeywordUpdate(id) {
      $('#suggestedKeywordModal').modal('hide');

      var keyword = keywordArray[id].keyword;
      // console.log(keyword);

      var mustIncludeKeywords = $('.mustIncludeKeywords').val();
      var mustIncludeCondition = $('.mustIncludeCondition').val();
      var mustExcludeKeywords = $('.mustExcludeKeywords').val();

      let storeRecom = [];
      $('.editRecommendedReply').each(function() {
         storeRecom.push($(this).val());
      });
      console.log(storeRecom);

      var recommendedReply = storeRecom.toString();
      // var recommendedReply = substring.substring(1);


      var arrKeyword = {
         'keyword': keyword,
         'must_include_keywords': mustIncludeKeywords,
         'must_include_condition': mustIncludeCondition,
         'must_exclude_keywords': mustExcludeKeywords,
         // 'recommended_reply': storeRecom,
         'recommended_reply': recommendedReply,
      }
      // console.log(arrKeyword);
      keywordArray.splice(id, 1, arrKeyword);

      // showSuggestedKeyword(keywordArray);

      $('#keywordData').val(JSON.stringify(keywordArray));
      showSuggestedKeyword(keywordArray);
   }

   function suggestedKeywordEdit(id) {
      $('#suggestedKeywordModal').modal('show');
      var html = '';

      var text = keywordArray[id].recommended_reply;
      var splitText = text.split(',');
      // console.log(splitText);

      var recomText = '';
      if (splitText.length > 0) {
         for (var j = 0; j < splitText.length; j++) {
            recomText += '<div class="row"><div class="col-md-8"><div class="mb-3"><label for="">Your Recommended Reply for this keyword</label><input type="text" name="recommended_reply[]" class="form-control editRecommendedReply" placeholder="Recommended Reply..."value="' + splitText[j] + '" /></div></div><div class="col-md-4"><div class="mt-4"><button class="btn btn-primary addrecomreply">+</button><button class="btn btn-danger removerecomreply d-inline" style="display: none;">-</button></div></div></div>';
         }
      }


      html += '<div class="container"><button type="button" class="btn rounded-pill btn-primary btn-custome suggested-key pr-2 mb-3 keyword" id="keyword" value="' + keywordArray[id].keyword + '">' + keywordArray[id].keyword + '</button><div class="col-md-12 mb-4"><div class="row"><div class="col-md-6"><label class="form-label">Must-Include Keyword(s)</label><input type="text" name="must_include_keywords" class="form-control mustIncludeKeywords" placeholder="Insert your Must-Include keywords" value="' + keywordArray[id].must_include_keywords + '" /></div><div class="col-md-6"><label class="form-label">Must-Include Condition:</label><select name="must_include_condition" class="form-control mustIncludeCondition"><option value="all">All keywords</option><option value="one" selected>At least one keyword</option></select></div></div></div><div class="col-md-12 mb-4"><div class="row"><div class="col-md-6"><label class="form-label">Must-Exclude Keyword(s) <i class="fa fa-question-circle"></i></label><input type="text" name="must_exclude_keywords" class="form-control mustExcludeKeywords" placeholder="Insert your Must-Exclude keywords" value="' + keywordArray[id].must_exclude_keywords + '" /></div></div></div><div class="recomreply"><div class="col-12 mb-2">' + recomText + '</div></div><div class="col-md-12 d-flex mt-4"><a class="btn btn-outline-danger btn-rounded btn-lg" data-bs-dismiss="modal">Cancel</a><button type="submit" class="btn btn-primary ms-auto btn-rounded btn-lg" onclick="suggestedKeywordUpdate(' + id + ')">Update</button></div></div>';

      $('.suggested-keyword-content').html(html);

   }

   function showSuggestedKeyword(data) {
      $('#keyword').val('');
      $('.recommendedReply').val('');
      $('#mustIncludeKeywords').val('');
      // $('#mustIncludeCondition').val('At least one keyword');
      $('#mustExcludeKeywords').val('');
      $('.keyword-btntag').val('');

      var html = "";
      for (var i = 0; i < data.length; i++) {
         var g = i + 1;

         html += '<button type="button" class="btn rounded-pill btn-custome suggested-key hover-effects mt-4 me-2" value="' + data[i].keyword + '">' + data[i].keyword + '<div class="button-groups"><a class="btn btn-primary btn-sm me-2" onclick="suggestedKeywordEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a class="btn btn-danger btn-sm" onclick="suggestedKeywordDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></div></button>';

      }

      $('.show-keyword').html(html);
   }
</script>