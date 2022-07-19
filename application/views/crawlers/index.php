<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

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
      top: 24px;
      right: 30px;
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
      <h4 class="heading-title">Crawler</h4>
   </div>
</header>

<main class="page-content">
   <div class="mb-3">
      <h4>Crawlers <a href="<?php echo base_url(); ?>addcrawler" class="float-end btn btn-primary">Add Crawler <i class="lni lni-circle-plus"></i> </a></h4>
   </div>

   <form method="post" action="<?php echo base_url(); ?>finding_value">
      <div class="row filter-box">
         <div class="col-sm-8">
            <div class="card">
               <div class="card-body search-box">
                  <input type="input" class="form-control rounded-pill" id="" name="search_input" placeholder="SEARCH KEYWORD">
                  <button type="submit">
                     <i class="bi bi-search"></i>
                  </button>
               </div>
            </div>
         </div>
         <div class="col-sm-4">
            <div class="card">
               <div class="card-body">
                  <select name="filter_input" id="" class="form-control rounded-pill" onchange="this.form.submit()">
                     <option value="">---Select Filter---</option>
                     <option value="1">A-Z</option>
                     <option value="2">Z-A</option>
                  </select>
               </div>
            </div>
         </div>
      </div>
   </form>

   <div class="row">
      <div class="col-sm-12">
         <div class="pr_new_list">
            <?php if (isset($hasresult) && $hasresult == 0) { ?>
               <div class="card">
                  <div class="card-body text-center">
                     <p class="m-0"> Sorry, No serach result !</p>
                  </div>
               </div>
            <?php } ?>



            <?php foreach ($crawlers as $crawler) {  ?>
               <div class="card">

                  <div class="card-body position-relative">
                     <div class="user_name">
                        <?php echo ($crawler->full_name != '' ? $crawler->full_name : '') ?></a>
                     </div>
                     <p><?php echo ($crawler->email != '' ? $crawler->email : '') ?>

                     <div class="d-flex">
                        
                        <a class="me-2 bg-light  btn btn-sm rounded-pill" href="#">Assigned Client :
                           <?php
                           assignedClientListInCrawler($crawler->id);
                           ?>
                        </a>
                        <a class="me-2 bg-light  btn btn-sm rounded-pill" href="#">Connected Groups :
                           <?php
                           totalConnectedGroupsInCrawler($crawler->id);
                           ?>
                        </a>
                        <span class="me-2 btn btn-sm rounded-pill  <?php echo ($crawler->active == 1 ? 'bg-light-success  text-success' : 'bg-light-danger  text-danger') ?>  ">
                           <?php echo ($crawler->active == 1 ? 'Active' : 'Deactive') ?>
                        </span>

                     </div>

                     <div class="crawlerDelete">
                        <div>
                           <a class="btn btn-primary rounded mb-2" href="<?= base_url(); ?>editcrawlerinfo/<?= $crawler->id; ?>">
                              <i class="bi bi-pencil-fill m-0"></i>
                           </a>
                           <br>
                           <a class="btn btn-danger rounded" id="deleteCrawler" data-id="<?= $crawler->id; ?>">
                              <i class="bi bi-trash-fill m-0"></i>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
            <div class="list_pagination">

               <?php

               echo $links;

               ?>
            </div>
         </div>
      </div>
   </div>
</main>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>

<style>
   .crawlerDelete{
      position: absolute;
      top: 0;
      bottom: 0;
      right: 0;
      padding-left: 20px;
      padding-right: 20px;
      background: #ceeae9;
      border-radius: 0px 25px 25px 0px;
      display: flex;
      align-items: center;
      justify-content: center;
   }

</style>

<script>
   $(document).ready(function() {

      //sweetalert
      $(document).on('click', '#deleteCrawler', function() {
         var Id = $(this).attr('data-id');
         // console.log(Id);

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
                     url: "<?php echo base_url() ?>deletecrawler/" + Id,
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
</script>