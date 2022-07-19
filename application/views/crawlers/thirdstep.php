
<main class="page-content">
 <div class="row">
  <div class="col-12 col-lg-12 col-xl-12 "> 
   <div class="card">
    <div class="card-body">
     
      <h4 class="mb-0 text-uppercase text-primary">Notification Setting</h4>
      <hr/>
      <form class="row g-3" method="post" action="<?php echo base_url();?>submittrdstep">
       
        <div class="col-12">
          <label class="form-label">Notification Type *</label>
          <select class="form-control"  name="notification_type" id="notification_type">
            <option value="email">Email</option>
            <option value="phone">Phone</option>
          </select>

          <!-- <input type="text" class="form-control" name="business_name" required> -->
        </div>

        

        <div class="col-12">
          <label class="form-label">Notification Address *</label>
          <input type="text" class="form-control" name="notification_address" required>
        </div>

        <div class="col-12">
          <label class="form-label">Timezone *</label>
          <select class="form-control"  name="notification_timezone" id="notification_timezone" require>
            
            <?php
            foreach($timezones as $tz){
              ?>

              <option value="<?php echo $tz; ?>"><?php echo $tz; ?></option>
            <?php   }      ?>
            
            
          </select>
        </div>



        <div class="col-12">
          <label class="form-label">Notification Interval *</label>
          <select class="form-control"  name="notification_interval" id="notification_interval" require>
            <option value="1">Every In 1 hour</option>
            <option value="2">Every In 2 hour</option>
            <option value="3">Every In 3 hour</option>
            <option value="4">Every In 4 hour</option>
            <option value="5">Every In 5 hour</option>
          </select>
        </div>
        
        <div class="col-12">
          <label class="form-label">Notification Starts *</label>
          <input type="time" class="form-control" name="notification_starts">
        </div>

        <div class="col-12">
          <label class="form-label">Notification End *</label>
          <input type="time" class="form-control" name="notification_ends">
        </div>
        
        <div class="col-12 text-center">
         <button type="submit" class="btn btn-primary px-5">Finish</button>
       </div>
     </form>
   </div>
 </div>
</div> 
</div>
</main>

