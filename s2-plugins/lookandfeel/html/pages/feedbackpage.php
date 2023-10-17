<?php
// prevent direct internet access to this file
!defined('CL_DIR') ? die(':-)') : '';
$color = $feedbackcolor ?? 'red';
$feedback = isset($feedback) ? '<span style="color:'.$color.';">'.$feedback.'</span>' : '';
?>
<div class="row">
    <div class="col-12 center"><h3><?php echo $feedbacktitle ?? ''; ?></h3></div>
</div>
<div class="row ">
    <div class="col-12">
        <?php echo $feedback ?? ''; ?>
    </div>
</div>
