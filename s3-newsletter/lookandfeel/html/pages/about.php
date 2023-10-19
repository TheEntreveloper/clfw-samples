<?php
// prevent direct internet access to this file
!defined('CL_DIR') ? die(':-)') : '';
?>
<div class="bg-body-tertiary p-5 m-5 rounded">
    <div class="row">
        <div class="col-12 center"><h3>About This Sample</h3></div>
    </div>
    <div class="row ">
        <div class="col-12">
            <p><b>S3 Newsletter</b> builds on S2, and shows how to implement a Plugin that allows users to subscribe to a Newsletter.</p>
            <p>Notice that in order to do that, the plugin must be able to send emails (to confirm the user's email
                address, and to connect to a database (in order to store users email addresses and information to manage the subscription</p>
            <p>You can try the functionality, after local installation by submitting the form below. Please note that you
                must fill the correct smtp details for emails to work, as well as the correct MySql connection details (see <i>config/configData.php</i>)</p>
            <p><u>Without the above details, the App will not work as expected in your environment.</u></p>
            <p>
                Subscribe to our Newsletter!<br>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" name="email" type="email" placeholder="Type your email address" required>
                    <button class="btn btn-outline-success" type="submit" title="You will receive a confirmation message">Subscribe</button>
                    <input type="hidden" name="clkey" value="newsletter/subscribe">
                </form>
                <u>You are free to use this sample for personal or commercial applications.</u>
            </p>
        </div>
    </div>
</div>
