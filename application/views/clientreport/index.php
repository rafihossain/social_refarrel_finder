<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

<!-- daterangepicker -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- lightpick -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>main_assets/lightpick/lightpick.css" />
<link href="<?php echo base_url() ?>main_assets/select2/css/select2.min.css" rel="stylesheet">

<header class="top-header">
   <nav class="navbar navbar-expand gap-3 d-md-none ">
      <div class="mobile-toggle-icon fs-3">
         <i class="bi bi-list"></i>
      </div>
   </nav>
   <div class="header-page">
      <h4 class="heading-title">Client Report</h4>
   </div>
</header>

<main class="page-content" id="client_report">

   <div class="container">
      <div class="row">
         <div class="col-12 col-lg-12 col-xl-12">
                
                <?php if($this->session->flashdata('success')):?>
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
                  
           
                  <h4 class="text-primary mb-0">Client Report</h4>
                  <hr>
                  <ul class="nav nav-tabs nav-primary" role="tablist">
                     <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#clientReport" role="tab" aria-selected="true">
                           <div class="d-flex align-items-center">
                              <div class="tab-icon">
                              </div>
                              <div class="tab-title">Client Report</div>
                           </div>
                        </a>
                     </li>
                     <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#generateClientPdf" role="tab" aria-selected="false">
                           <div class="d-flex align-items-center">
                              <div class="tab-icon">
                              </div>
                              <div class="tab-title">Generate Client PDF</div>
                           </div>
                        </a>
                     </li>
                     <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#viewClientPdfs" role="tab" aria-selected="false">
                           <div class="d-flex align-items-center">
                              <div class="tab-icon">
                              </div>
                              <div class="tab-title">View Client PDFs</div>
                           </div>
                        </a>
                     </li>
                  </ul>
                  <div class="tab-content py-3">

                     <div class="tab-pane fade show active" id="clientReport" role="tabpanel">
                        <form method="post" action="<?php echo base_url();?>create_report">
                           <div class="row">
                              <div class="col-12">
                                 <div class="mb-3">
                                    <label for="">Account</label>
                                    <select class="form-control account" name="account_id" id="accountDropdown">
                                       <option value="">---Select Account---</option>
                                       <?php foreach($accounts as $account) : ?>
                                          <option value="<?= $account->id ?>">
                                             <?= $account->full_name.'('.$account->email.')'; ?>
                                          </option>
                                       <?php endforeach; ?>
                                    </select>
                                 </div>

                                 <div class="mb-3">
                                    <label for="">Tags <a href="<?php echo base_url()?>managetag">Manage Tag Lists</a></label>
                                    <select class="form-control tag_lists" name="clients_tag" id="tagLists">
                                       <option value="">---Select Tag---</option>
                                       <?php foreach($taglists as $tag) : ?>
                                          <option value="<?= $tag->id; ?>"><?= $tag->tag_list_name; ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                    <textarea class="form-control" id="tag" name="client_tag" rows="3"></textarea>
                                 </div>

                                 <div class="mb-3">
                                    <label for="">Display Name</label>
                                    <input type="text" class="form-control" id="clientName" name="client_name" value="">
                                 </div>
                                 <div class="mb-3">
                                    <label for="">Product Insights (optional)</label>
                                    <textarea class="form-control" id="" rows="3" name="product_insights"></textarea>
                                 </div>
                                 <div class="row">
                                    <div class="col-6">
                                       <div class="mb-3">
                                          <label for="" class="form-label">From</label>
                                          <input type="text" class="form-control" id="datepicker_from" name="date_from">
                                       </div>
                                    </div>
                                    <div class="col-6">
                                       <div class="mb-3">
                                          <label for="" class="form-label">To</label>
                                          <input type="text" class="form-control" id="datepicker_to" name="date_to">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="mb-3">
                                    <button type="submit" class="btn btn-primary  py-3">Generate Report</button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>

                     <div class="tab-pane fade" id="generateClientPdf" role="tabpanel">
                        <form method="post" action="<?php echo base_url();?>client_pdf" enctype="multipart/form-data">
                           <div class="col-12">
                              <div class="row">
                                 <div class="mb-3">
                                    <label for="">Client</label>
                                    <!-- endclienttags -->
                                    <select class="form-control" name="client_account_id" id="" required>
                                       <option value="">---Select Client Tag---</option>
                                       <?php foreach($endclienttags as $endclienttag) : ?>
                                          <option value="<?= $endclienttag->end_client_id; ?>">
                                          <?= $endclienttag->end_client_tag; ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('client_tag'); ?>
                                 </div>
                                 <div class="dataInsight">
                                    <div class="row">
                                       <div class="col-8">
                                          <div class="mb-3">
                                             <label for="">Trends & Insight - Bullet</label>
                                             <textarea class="form-control" id="" rows="3" name="input_insight[]"></textarea>
                                          </div>
                                          <?php echo form_error('input_insight'); ?>
                                       </div>
                                       <div class="col-4">
                                          <div class="mt-5">
                                             <button class="btn btn-primary addInsight">Add More</button>
                                             <button class="btn btn-danger removeInsight">Remove</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="mb-3">
                                    <label for="">Updates & Improvements</label>
                                    <textarea class="form-control" id="" rows="3" name="weekly_tweaks"></textarea>
                                 </div>
                                 <?php echo form_error('update_improv'); ?>
                                 <div class="dataImage">
                                    <div class="row">
                                       <div class="col-8">
                                          <div class="mb-3">
                                             <label for="">Upload Screenshots Image</label>
                                             <input type="file" name="image_screenshots[]" required>
                                          </div>
                                          <?php echo form_error('image_screenshots'); ?>
                                          <?php echo $error; ?>
                                       </div>
                                       <div class="col-4">
                                          <div class="mt-4">
                                             <button class="btn btn-primary addImage">Add More</button>
                                             <button class="btn btn-danger removeImage">Remove</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="mb-3">
                                    <label for="" class="form-label">Date Range</label>
                                    <input type="text" class="form-control" id="dateRangePicker" name="date_range" value="" required>
                                 </div>
                                 <?php echo form_error('date_range'); ?>
                                 <div class="mb-3">
                                    <button type="submit" class="btn btn-primary  py-3">Generate Report</button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="tab-pane fade" id="viewClientPdfs" role="tabpanel">
                        <div class="table-responsive">
                           <table id="example" class="table table-striped table-bordered" style="width:100%">
                              <thead>
                                 <tr>
                                    <th>Client</th>
                                    <th>Tag</th>
                                    <th>Report Dates</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php foreach($clienttabledata as $clienttable) : ?>
                                 <tr>
                                    <td><?= $clienttable->end_client; ?></td>
                                    <td><?= $clienttable->end_client_tag; ?></td>
                                    <td><?= $clienttable->date_from .' until '. $clienttable->date_to; ?></td>
                                    <td><?= $clienttable->date_created; ?></td>
                                    <td>
                                       <a href="<?php echo base_url(); ?>view_clientpdf/<?= $clienttable->pdf_id; ?>">View Report</a>
                                    </td>
                                    <td>
                                       <a class="btn btn-sm btn-danger" id="clientDelete" data-id="<?= $clienttable->pdf_id; ?>">
                                          <i class="bi bi-trash-fill"></i>
                                       </a>
                                    </td>
                                 </tr>
                                 <?php endforeach; ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            
      </div>
   </div>


</main>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="<?php echo base_url() ?>main_assets/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>main_assets/lightpick/lightpick.js"></script>

<!-- multifield -->
<script src="<?php echo base_url(); ?>main_assets/js/jquery.multifield.min.js"></script>
<script>

var tags = '<?php echo json_encode($taglists); ?>';
var accounts = '<?php echo json_encode($accounts); ?>';
//console.log(accounts);


   $(".account").select2();
   $(".tag_lists").select2();

   $('input[id="dateRangePicker"]').daterangepicker();

   $('.dataInsight').multifield({
      section: '.row',
      btnAdd: '.addInsight',
      btnRemove: '.removeInsight',
      max: 4,
      locale: 'default'
   });

   $('.dataImage').multifield({
      section: '.row',
      btnAdd: '.addImage',
      btnRemove: '.removeImage',
      max: 6,
      locale: 'default'
   });

   var picker = new Lightpick({
      field: document.getElementById('datepicker_from'),
      secondField: document.getElementById('datepicker_to'),
      singleDate: false,
      format: 'YYYY-MM-DD'
   });


   //client section
   $('#accountDropdown').on('change', function (e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url(); ?>getclinetinfo",
        type: "post",
        data: {client_id: $(this).val()},
        success: function(data) {
           console.log(data);
         $('#clientName').val(data);
        }
    });
   });

   $('#tagLists').on('change', function (e) {
      e.preventDefault();

      let tagid = $(this).val();
      var alltags =  JSON.parse(tags);
      for(var i=0; i < alltags.length; i++ ){
         if(alltags[i].id == tagid){
            $('#tag').val(alltags[i].tags);
         }
      }
   });
   
   
   // sweetalert
   
   $(document).on('click', '#clientDelete', function() {
      var clientId = $(this).attr('data-id');

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
               url: "<?php echo base_url() ?>delete_clientreport/"+clientId,
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
   
   
   
   

</script>