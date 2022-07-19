<style>
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



<!--new profile body-->
<main class="page-content rs-tab-content">

  <div class="row">
    <div class="col-12 col-lg-12 col-xl-12">
      <div class="card">
        <div class="card-body">
          <div class="facebook-group">
            <h4 class="text-primary">Manage Facebook Groups</h4>
            <br>

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

            <form method="post" action="<?php echo base_url(); ?>clientgroups">
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

            <form id="addFBGroup" method="post" action="<?php echo base_url(); ?>clientaddgroup">
              <div class="row groups_categories g-0">
                <div class="col-md-4">
                  <div class="category-box">
                    <h5 class="text-primary">Group Categories</h5>
                    <div class="category-box-content">
                      <select name="multiple_category[]" id="groupCategory" class="form-control" multiple size="8">
                        <?php foreach ($usersinfo as $info) : ?>
                          <option value="<?= $info->id; ?>" countgroup="0" attr="<?= $info->full_name; ?>"><?= $info->full_name; ?></option>
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

          <div class="cl_add_group"></div>

          <div class="col-md-8 text-center m-auto">
              <button type="submit" class="btn btn-primary py-2" id="for_group">Insert Facebook Groups</button>
          </div>

        </div>
      </div>
    </div>
  </div>

  </form>

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

</main>

<script>
  var groupArray = [];
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
        'crawler_id[]': crawler_id
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

    $('#for_group').click(function(e) {
      e.preventDefault();

      if (groupArray.length == 0) {
          $('.cl_add_group').html('<div class="alert alert-danger" role="alert">Please Add Group.</div>');
          return;
      }

      $('#addFBGroup').submit();

    });

    $(document).on("click", ".rs-tab-content .checkbox_noselect input:checkbox", function() {
      $(this).parent().parent().toggleClass("checked");
    });

    $("#groups_categories select option").click(function() {
      $(this).toggleClass('active');
    });


  });

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

  function showInsertedFbGroupData(data) {
    var html = "";

    for (var i = 0; i < data.length; i++) {
      var g = i + 1;

      html += '<tr><td>' + g + ' <input type="hidden" name="crawler_id" value="' + data[i].crawler_id + '"> </td><td class="text-wrap">' + data[i].fb_group_name + '</td><td class="text-wrap">' + data[i].fb_group_uri + '</td><td>' + data[i].group_category + '</td><td>' + data[i].type + '</td><td>' + (data[i].join_status == 1 ? '<span class="badge bg-success rounded-pill">Joined</span>' : '<span class="badge bg-warning rounded-pill text-black">Not joined</span>') + '</td><td><a class="btn btn-primary" onclick="clickFunctionEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a class="btn btn-danger" onclick="fbGroupDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></td></tr>';
    }

    $('#fbtbody').html(html);

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
</script>