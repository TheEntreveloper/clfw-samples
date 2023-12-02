<?php
!defined('CL_DIR') ? die(':-)') : '';
$feedback = isset($feedback) ? '<span style="color:red;">'.$feedback.'</span>' : '';
?>
<section class="py-50px">
    <div class="container">
<div class="row">
                <div class="card mb-5 m-5 rounded-3 shadow-sm border-1" style="background-color: var(--bs-card-cap-bg);">
                    <form method="post" action="index.php">
                        <?php echo($feedback ?? '&nbsp;');?>
                        <h5>Login Information</h5>
                        <div class="row mb-3">
                            <div class="form-group col-md-6">
                                <input type="text" name="username" value="<?php echo $username ?? '';?>" class="form-control" placeholder="username" aria-label="username"
                                   aria-describedby="reg-username" required="" id="username">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required="" oninput="valPwd()">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <input type="password" name="rpwd" class="form-control" id="inputPassword2" placeholder="Password" required="" oninput="valPwd()">
                            </div>
                        </div>
                        <h5>Contact Information</h5>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <input type="text" name="firstname" value="<?php echo $fname ?? '';?>" class="form-control" placeholder="First name" required="" id="fname">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <input type="text" name="lastname" value="<?php echo $lname ?? '';?>" class="form-control" placeholder="Last name" required="" id="lname">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <input type="email" name="email" value="<?php echo $email ?? '';?>" class="form-control" id="email" placeholder="Email" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck" required="">
                                <label class="form-check-label" for="gridCheck">
                                        I have read and agree to the <a href="#" onclick="showTerms('disclaimer.html');">Terms and disclaimer</a>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary mt-4">Sign up</button>
                        <input type="hidden" name="clkey" value="user/register" />
                        <input type="hidden" name="<?php echo CSRF_KEY; ?>" value="<?php echo $csrf ?? ''; ?>" />
                    </form>
                </div>
                <div class="col-md-3 col-xs-12"></div>
            </div>
        </div>
</section>
<script>
    function valPwd() {
        let passwfield = $('#password');
        let passw2 = $('#inputPassword2').val();
        let errors = 0;let errMsg = '';let sep = '';
        if (passwfield.val().length<8) {
            errMsg = 'Minimum required password length is 8 characters'
            errors++;sep = ' and ';
        }
        if (passwfield.val() !== passw2) {
            errors++;
            errMsg = errMsg + sep + 'Passwords must match';
        }
        if (errors === 0) {
            passwfield[0].setCustomValidity('');
        } else {
            let errLbl = ' errors';
            if (errors === 1) { errLbl = ' error'; }
            errMsg += ' (' +  + errors + errLbl + ')';
            passwfield[0].setCustomValidity(errMsg);
        }
    }
</script>
