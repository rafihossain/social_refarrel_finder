<aside class="sidebar-wrapper" data-simplebar="true">
  <div class="sidebar-header">
    <div>
      <img src="<?php echo base_url(); ?>main_assets/images/logo-icon.png" alt="logo icon" height="70">
    </div>
  </div>

  <!--navigation-->
  <ul class="metismenu" id="menu">
    <li>
      <a href="<?php echo base_url(); ?>dashboard">
        <div class="parent-icon"><i class="bi bi-speedometer"></i>
        </div>
        <div class="menu-title">Dashboard</div>
      </a>
    </li>
    <?php if ($this->session->userdata('account_level') == 'admin') { ?>
      <li>
        <a href="<?php echo base_url(); ?>crawlers">
          <div class="parent-icon"><i class="bi bi-people-fill"></i>
          </div>
          <div class="menu-title">Crawlers</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>client">
          <div class="parent-icon"><i class="bi bi-person-fill"></i>
          </div>
          <div class="menu-title">Clients</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>ambassadors">
          <div class="parent-icon"><i class="bi bi-bezier"></i>
          </div>
          <div class="menu-title">Ambassadors</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>report">
          <div class="parent-icon"><i class="bi bi-reception-4" -fill"></i>
          </div>
          <div class="menu-title">Report</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>clientreport">
          <div class="parent-icon"><i class="bi bi-file-pdf-fill"></i>
          </div>
          <div class="menu-title">Client Report</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>trigger">
          <div class="parent-icon"><i class="bi bi-check2-circle"></i>
          </div>
          <div class="menu-title">Triggers</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>plan">
          <div class="parent-icon"><i class="bi bi-bezier"></i>
          </div>
          <div class="menu-title">Manage Plans</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>notification">
          <div class="parent-icon"><i class="bi bi-bell-fill"></i>
          </div>
          <div class="menu-title">Notifications</div>
        </a>
      </li>
    <?php  }
    if ($this->session->userdata('account_level') == 'ambassador') { ?>
      <?php
      $myClient = 0;
      if ($this->session->userdata('myClient')  != NULL) {
        $myClient =  $this->session->userdata('myClient');
      }


      $query = $this->db->query("SELECT ambassador_match.user_id,ambassador_match.ambassador_id, users.full_name FROM ambassador_match INNER JOIN users ON ambassador_match.user_id=users.id where ambassador_match.ambassador_id =" . $this->session->userdata('id'));
      if (count($query->result()) > 0) { ?>
        <li class="user-switch">
          <label for="switch_user">Switch User:</label>
          <select class="form-control" id="switch_user">
            <?php foreach ($query->result() as $row) {  ?>
              <option value="<?php echo $row->user_id ?>" <?php echo ($myClient == $row->user_id ? 'selected' : ''); ?>><?php echo $row->full_name; ?></option>
            <?php } ?>
          </select>

        </li>

      <?php } ?>

      <li>
        <a href="<?php echo base_url(); ?>recommendation">
          <div class="parent-icon"><i class="fadeIn animated bx bx-like"></i>
          </div>
          <div class="menu-title">Recommendations</div>
        </a>
      </li>

      <li>
        <a href="<?php echo base_url(); ?>ambass_groups_view">
          <div class="parent-icon"><i class="fadeIn animated bx bx-group"></i>
          </div>
          <div class="menu-title">Facebook Groups</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>ambass_key_view">
          <div class="parent-icon"><i class="fadeIn animated bx bx-key"></i>
          </div>
          <div class="menu-title">Keyword</div>
        </a>
      </li>


      <li>
        <a href="<?php echo base_url(); ?>ambassadors_account/<?php echo $this->session->userdata('id'); ?>">
          <div class="parent-icon"><i class="fadeIn animated bx bx-user"></i>
          </div>
          <div class="menu-title">My Account</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>ambassadors_notification/<?php echo $this->session->userdata('id'); ?>">
          <div class="parent-icon"><i class="bi bi-bell-fill"></i>
          </div>
          <div class="menu-title">Notification Settings</div>
        </a>
      </li>

    <?php   }
    if ($this->session->userdata('account_level') == 'client') { ?>

      <li>
        <a href="<?php echo base_url(); ?>tags">
          <div class="parent-icon"><i class="fadeIn animated bx bx-purchase-tag"></i>
          </div>
          <div class="menu-title">Tags</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>client_onboarding">
          <div class="parent-icon"><i class="bi bi-info-square-fill"></i>
          </div>
          <div class="menu-title">Onboarding</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>client_recommendation">
          <div class="parent-icon"><i class="fadeIn animated bx bx-like"></i>
          </div>
          <div class="menu-title">Recommendations</div>
        </a>
      </li>


      <li>
        <a href="<?php echo base_url(); ?>clientkeyword">
          <div class="parent-icon"><i class="fadeIn animated bx bx-key"></i>
          </div>
          <div class="menu-title">Keyword</div>
        </a>
      </li>

      <li>
        <a href="<?php echo base_url(); ?>clientgroups">
          <div class="parent-icon"><i class="fadeIn animated bx bx-group"></i>
          </div>
          <div class="menu-title">Facebook Groups</div>
        </a>
      </li>

      <li>
        <a href="<?php echo base_url(); ?>clientaccount">
          <div class="parent-icon"><i class="fadeIn animated bx bx-user"></i>
          </div>
          <div class="menu-title">My Account</div>
        </a>
      </li>

      <li>
        <a href="<?php echo base_url(); ?>client_notification">
          <div class="parent-icon"><i class="bi bi-bell-fill"></i>
          </div>
          <div class="menu-title">Notification Settings</div>
        </a>
      </li>

    <?php  } ?>

    <?php
    if ($this->session->userdata('account_level') == 'crawler') { ?>

      <li>
        <a href="<?php echo base_url(); ?>tags">
          <div class="parent-icon"><i class="fadeIn animated bx bx-purchase-tag"></i>
          </div>
          <div class="menu-title">Tags</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>crawler_recommendation">
          <div class="parent-icon">
            <!-- <i class="fadeIn animated bx bx-like"></i> -->
            <i class="bi bi-check2-circle"></i>
          </div>
          <div class="menu-title">Triggers</div>
        </a>
      </li>

      <li>
        <a href="<?php echo base_url(); ?>crawler_groups">
          <div class="parent-icon"><i class="fadeIn animated bx bx-group"></i>
          </div>
          <div class="menu-title">Facebook Groups</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>crawler_keyword">
          <div class="parent-icon"><i class="fadeIn animated bx bx-key"></i>
          </div>
          <div class="menu-title">Keyword</div>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>crawler_account">
          <div class="parent-icon"><i class="fadeIn animated bx bx-user"></i>
          </div>
          <div class="menu-title">Account Settings</div>
        </a>
      </li>

    <?php  } ?>
    <!-- <li>
      <a class="dropdown-item" href="<?php echo base_url(); ?>logout">
        <div class="parent-icon">
          <i class="fadeIn animated bx bx-lock"></i>
        </div>
        <div class="menu-title">
          Logout
        </div>

      </a>
    </li> -->
  </ul>
  <div class="toggle-icon toggle-icon-sidebar ms-auto p-3 text-center">
    <i class="bx bx-right-arrow-circle"></i>
  </div>
</aside>


<script>
  window.addEventListener('DOMContentLoaded', (event) => {
    $('#switch_user').on('change', function() {
      callMyFunctionForSave($(this).val());
    })

  });

  function callMyFunctionForSave(cid) {
    $.ajax({
      url: '<?php echo base_url(); ?>set_current_user',
      type: "post",
      data: {
        "cid": cid
      },

      success: function(data) {
        console.log(data);
        window.stop();
        window.location.reload(true);

      }
    });
  }
</script>