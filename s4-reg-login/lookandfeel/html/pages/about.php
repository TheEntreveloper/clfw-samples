<?php
// prevent direct internet access to this file
!defined('CL_DIR') ? die(':-)') : '';
$color = $feedbackcolor ?? 'red';
$feedback = isset($feedback) ? '<span style="color:'.$color.';">'.$feedback.'</span>' : '';
?>
<div class="bg-body-tertiary p-5 m-5 rounded">
    <div class="row ">
        <div class="col-12">
            <?php echo $feedback ?? ''; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 center"><h3>About This Sample</h3></div>
    </div>
    <div class="row ">
        <div class="col-12">
            <p><b>S4 Reg-Login</b> shows how to implement a Plugin that allows users to register and login into the App.</p>
            <p>To keep it simple, we have not included email address validation in this sample. We will include it in a
                follow up sample, or you can adapt the email validation of Sample 3 (S3) to this sample.</p>
            <p>You can try the functionality, after local installation by submitting the form below. Please note that you
                must fill the correct MySql connection details (see <i>config/configData.php</i>)</p>
            <p><u>Without the above details, the App will not work as expected in your environment.</u></p>
            <p>
                <u>You are free to use this sample for personal or commercial applications.</u>
            </p>
        </div>
    </div>
</div>
