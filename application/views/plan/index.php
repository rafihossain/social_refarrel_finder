<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

<header class="top-header">
   <nav class="navbar navbar-expand gap-3 d-md-none ">
      <div class="mobile-toggle-icon fs-3">
         <i class="bi bi-list"></i>
      </div>
   </nav>
   <div class="header-page">
      <h4 class="heading-title">Plan</h4>
   </div>
</header>

<main class="page-content">
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 "> 
            <h4 class="text-primary mb-4">Plan: <a class="btn text-light radius-30 bg-primary circlebtn" href="javascript:void(0)" id="clickForKeyword"><i class="m-0 bx bx-plus"></i></a> </h4>
                <p>Define and manage available plans.</p>

            <?php if($this->session->flashdata('plan_error')):?>
            <div class="alert border-0 bg-light-danger alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
            <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i>
            </div>
            <div class="ms-3">
            <div class="text-danger"><?php echo $this->session->flashdata('plan_error');?> </div>
            </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif ?>
            <?php if($this->session->flashdata('plan_sucess')):?>
            <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
            <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="ms-3">
            <div class="text-success"><?php echo $this->session->flashdata('plan_sucess');?></div>
            </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif ?>
            <div class="show_add_client_form">
          
            <form class="row g-3" method="post" action="<?php echo base_url();?>addplan">
                   
               <div class="col-12">
               <p><b>New Plan</b></p>
               </div>
               <div class="col-12">

                 <label class="form-label">Plan Name</label>
                 <input type="text" class="form-control" name="plan_name" required>
                </div>
                <div class="col-12">
                 <label class="form-label">Plan Code (must match Zoho)</label>
                 <input type="text" class="form-control" name="plan_code" required>
                </div>
               
                <div class="col-12">
                 <label class="form-label">Keywords Limit</label>
                 <input type="number" class="form-control" name="keywords_limit"  required>
                </div>

                <div class="col-12">
                 <label class="form-label">Groups Limit</label>
                 <input type="number" class="form-control" name="groups_limit" required>
                </div>
                
                 <div class="col-12 text-center">
                 <button type="submit" class="btn btn-primary px-5">Submit</button>
             </div>
                 </form> 
         </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <h4>Current Plans</h4>
           <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                 <thead>
                    <tr>
                       <th>Plan Name</th>
                       <th>Plan Code</th>
                       <th>Keywords Limit</th>
                       <th>Groups Limit</th>
                       
                      <th>Action</th>
                    </tr>
                 </thead>
                 <tbody>
                 <?php  foreach ($plans as $plan){  ?>
                       <tr>
                          <td><?php echo $plan->plan_name ?></td>
                          <td><?php echo $plan->plan_code ?></td>
                          <td><?php echo $plan->keywords_limit ?></td>
                          <td><?php echo $plan->groups_limit ?></td>
                          <td>
                            <a class="btn btn-sm btn-danger" id="deletePlan" data-id="<?= $plan->id; ?>">
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
</main>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>

<script>
$(document).ready(function(){
    $("#form").trigger('reset');
    
  $('.circlebtn').on('click',function(){
    $('.show_add_client_form').toggle();
     })

  
  //sweetalert

  $(document).on('click', '#deletePlan', function() {
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
                 url: "<?php echo base_url() ?>deleteplan/" + Id,
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
  
 
  

})

</script>

