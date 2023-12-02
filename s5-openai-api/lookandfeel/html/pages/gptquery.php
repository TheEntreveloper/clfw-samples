<?php
!defined('CL_DIR') ? die(':-)') : '';
$feedback = isset($feedback) ? '<span style="color:red;">' . $feedback . '</span>' : '';
$img = $gptchat = '';
if (isset($apiquery)) {
    if ($apiquery === 'completion') {
        $gptchat = $gptoutput ?? '[Welcome, how may I help you?]';
    } else if ($apiquery === 'genimage') {
        if (isset($gptoutput)) {
            if (is_array($gptoutput)) {
                foreach($gptoutput as $newimage) {
                    $img .= '<div><img src="'.$newimage.'" /></div>';
                }
            } else {
                $img = '<div>'.$gptoutput.'</div>';
            }
        }
    }
}
?>
<section class="py-50px">
    <div class="container">
        <div class="row text-center">
            <div class="col">
                <div class="card mb-5 m-5 rounded-3 shadow-sm border-0" style="background-color: var(--bs-card-cap-bg);">
                    <form method="post" action="index.php">
                        <div class="align-items-center">
                            <span><?php echo ($feedback ?? '&nbsp;'); ?></span>
                            <h5 class="mb-4">What do you want ChatGPT to help you with today?</h5>
                            <div class="row">
                                <div class="col-md-12 container my-3">
                                    <select class="form-select" name="apientry" id="apientry">
                                        <option selected value="">Query type</option>
                                        <option value="genimage" <?php echo $apiquery === 'genimage' ? 'selected' : ''; ?>>Image generation</option>
                                        <option value="completion" <?php echo $apiquery === 'completion' ? 'selected' : ''; ?>>Chat completion</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="compl">
                                <div class="col-md-12 container">
                                    <div class="row">
                                        <div class="col-md-12 container">
                                            <input type="text" name="sysrole" class="form-control" placeholder="Optional System role. Ex.: You are an experienced assistant">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 container my-3">
                                            <textarea id="infocnt" name="content" cols="80" rows="7" class="form-control"><?php echo $gptchat;?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 container my-3">
                                            <input type="text" name="userrole" class="form-control" placeholder="Type your request here">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="imggen">
                                <div class="col-md-12 container">
                                    <div class="row">
                                        <div class="col-md-12 container">
                                            <input type="text" name="sysrole" class="form-control" placeholder="Describe the image you would like to generate" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 container my-3">
                                            <span id="newimg"><?php echo $img;?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="clkey" value="ai/gpt" />
                        <input type="hidden" name="<?php echo CSRF_KEY; ?>" value="<?php echo $csrf ?? ''; ?>" />
                        <button type="submit" class="btn btn-outline-primary shadow-sm" id="submbtn">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
<script>
    function onApiQueryChanged(lt) {
        if (lt !== undefined && lt !== '') {
            $('#submbtn').css('display', 'block');
            switch (lt) {
                case 'completion':
                    $('#compl').css('display', 'block');
                    $('#imggen').css('display', 'none');
                    break;
                case 'genimage':
                    $('#compl').css('display', 'none');
                    $('#imggen').css('display', 'block');
                    break;
            }
        } else {
            $('#submbtn').css('display', 'none');
        }
    }
    $(function() {
        $('#compl').css('display', 'none');
        $('#imggen').css('display', 'none');
        $('#submbtn').css('display', 'none');
        let lt = $('#apientry').val();
        onApiQueryChanged(lt);

        $('#apientry').click(function() {
            let lt = $('#apientry').val();
            onApiQueryChanged(lt);
        });
    });
</script>
