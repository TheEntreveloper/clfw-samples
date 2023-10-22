<?php
!defined('CL_DIR') ? die(':-)') : '';
$feedback = isset($feedback) ? '<span style="color:red;">' . $feedback . '</span>' : '';
?>
<section class="py-50px">
    <div class="container">
        <div class="row text-center">
            <div class="col">
                <div class="card mb-5 m-5 rounded-3 shadow-sm border-0" style="background-color: var(--bs-card-cap-bg);">
                    <form method="post" action="index.php">
                        <div class="align-items-center">
                            <span><?php echo ($feedback ?? '&nbsp;'); ?></span>
                            <h5 class="mb-4">Login</h5>
                            <div style="row">
                                <div class="col-md-5 container">
                                    <div class="row mb-3">
                                        <div class="form-group col">
                                            <input type="text" name="username" value="<?php echo $username ?? ''; ?>" class="form-control" placeholder="username" aria-label="username" aria-describedby="reg-username" required="" id="username">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="clkey" value="user/login" />
                        <input type="hidden" name="<?php echo CSRF_KEY; ?>" value="<?php echo $csrf ?? ''; ?>" />
                        <button type="submit" class="btn btn-outline-primary shadow-sm">Login</button>
                        <div class="my-2">
                        No account yet? <a href="index.php?clkey=register">Sign Up</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
