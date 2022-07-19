<?php

if (count($reports) > 0) {
   $i = 1;
   foreach ($reports as $report) {
?>


   <div class="row">
      <div class="col-12 col-lg-12 col-xl-12">
         <div class="recommendation-item">
            <div class="card">
               <div class="card-body">
                  <h4 class="d-flex"><?php echo $report['fb_request_full_name']; ?><span class="ms-auto"><?php echo $report['date']; ?></span></h4>
                  <p class="recommendation-details"><?php echo $report['fb_request_content']; ?></p>

                  <div class="d-flex recom_reply_<?= $i; ?>">
                     <button type="button" class="btn recommendation-btn"><?php echo $report['keyword_id']; ?></button>

                     <div id="tag_div_<?= $report['id']; ?>" class="ms-2">
                        <?php echo $report['tags']; ?>
                     </div>

                     <div class="text-right addclass ms-auto">
                        <a href="javascript:void(0)" onclick="show_modal_tags(<?= $report['id']; ?>) "><i class="las la-edit recomTagIcon"></i></a>

                        <button type="button" class="btn recommendation-arrow-down" data-id="<?= $i; ?>">
                           <img src="<?php echo base_url() ?>main_assets/images/corner-down-right.png" alt="corner down right">
                        </button>
                        <button type="button" class="btn recommendation-cross-btn" style="display: none;" data-id="<?= $i; ?>">
                           <img src="<?php echo base_url() ?>main_assets/images/cross.png" alt="cross-btn">
                        </button>
                     </div>

                     <div class="recommendation-reply-box" style="display: none;">
                        <div class="card">
                           <div class="card-body text-start">
                              <h4 class="recommendation-title">Recommended Replies</h4>
                              <div class="replies-list">
                                 <?php
                                    $reply = $report['recmannded_reply'];
                                    $replyExplode = explode(',', $reply['keywords']->recommended_reply);
                                 
                                 if(count($replyExplode) > 0){
                                 
                                 foreach($replyExplode as $replyValue) :
                                    $input_id = 'txtRE_' . $reply['id'];
                                 ?>
                                 
                                 <div class="card">
                                    <div class="card-body d-flex">
                                       <p class="replies-text"><?php echo $replyValue; ?></p>
                                       <input class="form-control" type="hidden" id="<?php echo $input_id; ?>" value="<?php echo $replyValue; ?>">

                                       <button type="button" class="btn recommendation-replies">
                                          <img src="<?php echo base_url() ?>main_assets/images/replies.png" alt="Recommendation Replies" onclick="open_post('<?php echo $reply['post_link']; ?>','<?php echo $input_id; ?>')">
                                       </button>
                                    </div>
                                 </div>
                                 <?php endforeach; } ?>
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
               <div class="card-footer d-flex">
                  <span class="me-4 d-flex align-items-center recommendation-facebook">
                     <i class="las la-globe me-2 recommendation-icon"></i> Facebook
                  </span>
                  <span class="me-4 d-flex align-items-center recommendation-keyword">
                     <i class="las la-tag me-2 recommendation-icon"></i> <?php
                     $str = trim($report['tags'],',');
                     $explode = explode(',',$str);
                     if(count($explode) > 0){
                        echo count($explode)-1;
                     }
                     ?>
                  </span>  
                  <span class="me-4 d-flex align-items-center recommendation-groups">
                     <i class="las la-user-friends me-2 recommendation-icon"></i> <?php echo $report['fb_group_id']; ?>
                  </span>
               </div>
            </div>
         </div>
      </div>
   </div>

<?php
      $i++;
   }
}
?>

<div class="list_pagination">
   <?php echo $links; ?>
</div>

<script>

   $('.recommendation-arrow-down').click(function() {
      $('.recommendation-cross-btn').css({
         "display": "none"
      });
      $('.recommendation-arrow-down').css({
         "display": "block"
      });
      $('.recommendation-reply-box').hide();

      var id = 'recom_reply_' + $(this).attr('data-id');
      var parent = $('.' + id).parent();
      var parentfind = parent.find('.recommendation-reply-box');
      parentfind.toggle();
      parent.find('.recommendation-cross-btn').css({
         "display": "block"
      });
   });
   $('.recommendation-cross-btn').click(function() {
      var id = 'recom_reply_' + $(this).attr('data-id');
      var parent = $('.' + id).parent();
      var parentfind = parent.find('.recommendation-reply-box');
      parentfind.css({
         "display": "none"
      });

      $('.recommendation-cross-btn').css({
         "display": "none"
      });
      $('.recommendation-arrow-down').css({
         "display": "block"
      });
   });



</script>