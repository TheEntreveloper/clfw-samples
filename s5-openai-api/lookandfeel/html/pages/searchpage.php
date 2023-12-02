<?php
// prevent direct internet access to this file
!defined('CL_DIR') ? die(':-)') : '';
// so, this is a simplified search page, as our simple search functionality is now inside our Plugin

?>
<div class="bg-body-tertiary p-5 m-5 rounded">
    <div class="row">
        <div class="col-12 center"><h3><?php echo $title ?? 'Your search results';?></h3></div>
    </div>
    <div class="row ">
        <div class="col-12">
            <?php if (isset($results) && count($results) > 0) {
                foreach ($results as $result) {?>
            <div class="row">
                <div class="col-md-6">
                    <?php echo $result['page'];?>
                </div>
                <div class="col-md-6">
                    <?php echo $result['fragment'];?>
                </div>
            </div>
               <?php }
                ?>

            <?php }?>
        </div>
    </div>
</div>
