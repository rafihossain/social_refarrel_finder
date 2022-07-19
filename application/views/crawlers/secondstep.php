<main class="page-content">
  <div class="row">
    <div class="col-12 col-lg-12 col-xl-12 ">

      <div class="card">
        <div class="card-body">

          <h4 class="mb-0 text-uppercase text-primary">Add FB Group <a class="btn text-light radius-30 bg-primary" href="javascript:void(0)" id="addFbGroup"><i class="m-0 bx bx-plus"></i></a></h4>
          <hr />
          <div id="fbgroups_input">
            <div class="form-group mb-2">
              <label class="form-label">FB Group Name</label>
              <input type="text" class="form-control group_name" name="group_name" required>
            </div>
            <div class="form-group mb-2">
              <label class="form-label">FB Group URL</label>
              <input type="text" class="form-control group_url" name="group_url" required>
            </div>
            <div class="form-group mb-2">
              <label class="form-label">FB Group Category</label>
              <input type="text" class="form-control group_category" name="group_category" required>
            </div>

            <div class="form-group mb-2">
              <label class="form-label">Type</label>
              <select name="type" id="type" class="form-control type">
                <option value="private">Private</option>
                <option value="public">Public</option>
              </select>
            </div>
            <div class="form-group mb-2">
              <label class="form-label">Join Status</label>
              <select name="join_status" class="form-control join_status">
                <option value="1">Join</option>
                <option value="0">Not join</option>
              </select>
            </div>
            <div class="col-md-12 text-center mt-2">
                <div class="cl_add_group"></div>
            </div>
            <br>
            <div class="form-group mb-2 text-center">
              <button class="btn btn-primary px-5 group_add">Add</button>
            </div>
          </div>

          <div class="row mb-5">
            <div class="col-12 d-flex align-items-center">
              <form method="post" action="<?= base_url() ?>fbgroup_csv" enctype="multipart/form-data">
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

        </div>

      </div>
    </div>
  </div>

  <div class="row" id="show_div">
    <div class="col-12 col-lg-12 col-xl-12">
      <div class="table-responsive">
        <table border="0" class="table table table-striped align-middle">
          <thead class="table-secondary">
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
          <tbody id="newgroup" style="height:120px">

          </tbody>
        </table>
      </div>
      <form id="crawlerAddGroup" method="post" action="<?php echo base_url(); ?>submitsndstep">
        <textarea name="group" style="display:none;" id="groupid"></textarea>
        <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary px-5" id="for_group">Next</button>
        </div>
      </form>
    </div>
  </div>
</main>

<!--  Modal content for the above example -->
<div id="crawlerFbGroupsModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
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
  var baseurl = "<?php echo base_url() ?>";
  var newgroups = [];
  // console.log(newgroups);
  var string = '<?php echo json_encode($this->session->userdata('groups_data')); ?>';
  var getgroups = JSON.parse(string);



  function clickFunctionEdit(id) {
    console.log(id);
    $('#crawlerFbGroupsModal').modal('show');
    var html = '';

    // console.log(newgroups[id]);
    // console.log(newgroups[id].group_name);

    // var private = "";
    // var public = "";

    // if(newgroups[id].type == "private"){
    //   var selectedValue = newgroups[id].type;
    // }else if(newgroups[id].type == "public"){
    //   var selectedValue = newgroups[id].type;
    // }
    // if(selectedValue == 'private'){
    //   var private = "selected";
    // }
    // if(selectedValue == 'public'){
    //   var public = "selected";
    // }
    

    html += '<div class="row" id=""><div class="col-md-12 mb-2"><label class="form-label">FB Group Name</label><input type="text" class="form-control re_group_name" name="group_name" placeholder="FB Group Name" value="'+newgroups[id].group_name+'"></div><div class="col-12  mb-2"><label class="form-label">FB Group URL</label><input type="text" class="form-control re_group_url" name="group_url" placeholder="FB Group URL" value="'+newgroups[id].group_url+'"></div><div class="col-12  mb-2"><label class="form-label">FB Group Category</label><input type="text" class="form-control re_group_category" name="group_category" placeholder="FB Group Category" value="'+newgroups[id].group_category+'"></div><div class="col-12  mb-2"><label class="form-label">Type</label><select name="type" id="re_type" class="form-control"><option value="private">Private</option><option value="public">Public</option></select></div><div class="col-12  mb-2"><label class="form-label">Join Status</label><select name="join_status" id="join_status" class="form-control"><option value="1">Join</option><option value="0">Not join</option></select></div><br><div class="col-12 "><button type="button" class="btn btn-primary px-5 w-100 group_replace" onclick="groupReplace(' + id + ')"> Update Groups</button></div></div>';

    $('#groups_update').html(html);

  }

  function groupReplace(id){

      $('#crawlerFbGroupsModal').modal('hide');

      var group_name = $('.re_group_name').val();
      var group_url = $('.re_group_url').val();
      var group_category = $('.re_group_category').val();
      var type = $('#re_type').val();
      var join_status = $('#join_status').val();
      // console.log(type);
      // return;

      let newg = {
        "group_name": group_name,
        "group_url": group_url,
        "group_category": group_category,
        "type": type,
        "join_status": join_status,
      }

      // console.log(newg);

      newgroups.splice(id, 1, newg);
      // newgroups.push(replaceGroup);

      $('#groupid').val(JSON.stringify(newgroups))
      callShowDataFunction(newgroups);

  }

  





  $(document).ready(function() {
  if (getgroups != undefined) {
    newgroups = getgroups
     $('#groupid').val(JSON.stringify(newgroups))
    callShowDataFunction(newgroups);
  }
  
  
    $('#addFbGroup').click(function() {
      $('#fbgroups_input').toggle();
    });

    // var i = 0;

    $('.group_add').on('click', function() {
      var group_name = $('.group_name').val();
      var group_url = $('.group_url').val();
      var group_category = $('.group_category').val();
      var type = $('.type').val();
      var join_status = $('.join_status').val();

      if (group_name == '') {
        alert('Group Name is Empty');
        return;
      }
      if (group_url == '') {
        alert('Group Url is Empty');
        return;
      }
      if (group_category == '') {
        alert('Group Category is Empty');
        return;
      }
      let newg = {
        "group_name": group_name,
        "group_url": group_url,
        "group_category": group_category,
        "type": type,
        "join_status": join_status,
      }
    
    $('.cl_add_group').remove();
      newgroups.push(newg);

      $('#groupid').val(JSON.stringify(newgroups))
      callShowDataFunction(newgroups);
    });

  });

  function clickFunction(id) {
    newgroups.splice(id, 1);
    $('#groupid').val(JSON.stringify(newgroups))
    var html = "";
    for (var i = 0; i < newgroups.length; i++) {
      var g = i + 1;
      html += '<tr> <td>' + g + '</td><td>' + newgroups[i].group_name + '</td><td>' + newgroups[i].group_url + '</td><td>' + newgroups[i].group_category + '</td><td>' + newgroups[i].type + '</td><td>' + (newgroups[i].join_status == 1 ? '<span class="badge bg-success rounded-pill">Joined</span>' : '<span class="badge bg-warning rounded-pill text-black">Not joined</span>') + '</td><td> <div class="table-actions d-flex align-items-center gap-3 fs-6"> <a class="btn btn-primary" onclick="clickFunctionEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a class="btn btn-danger" onclick="clickFunction(' + i + ')" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="bi bi-trash-fill"></i></a> </div></td></tr>';
    }
    $('#newgroup').html(html);

  }

  function callShowDataFunction(ngroups) {
    console.log(newgroups);

    $('.group_name').val('');
    $('.group_url').val('');
    $('.group_category').val('');
    var html = "";
    for (var i = 0; i < ngroups.length; i++) {
      var g = i + 1;
      html += '<tr> <td>' + g + '</td><td>' + ngroups[i].group_name + '</td><td>' + ngroups[i].group_url + '</td><td>' + newgroups[i].group_category + '</td><td>' + ngroups[i].type + '</td><td>' + (ngroups[i].join_status == 1 ? '<span class="badge bg-success rounded-pill">Joined</span>' : '<span class="badge bg-warning rounded-pill text-black">Not joined</span>') + '</td><td> <div class="table-actions d-flex align-items-center gap-3 fs-6"> <a class="btn btn-primary" onclick="clickFunctionEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a class="btn btn-danger" onclick="clickFunction(' + i + ')" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="bi bi-trash-fill"></i></a> </div></td></tr>';
    }
    $('#newgroup').html(html);
  }
  
  /*=============================
            Next Previous Button
      ===============================*/

      $('#for_group').click(function(e) {
        e.preventDefault();
          
        //   console.log(newgroups.length);

        if (newgroups.length == 0) {
          $('.cl_add_group').html('<div class="alert alert-danger" role="alert">Please add Group.</div>');
          return;
        }

         $('#crawlerAddGroup').submit();

      });
      
    //   $('.group_add').click(function()){
    //     $('.cl_add_group').hide();         
    //   }
  
  
  
  
  
  
  
  
  
  
</script>