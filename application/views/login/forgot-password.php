<div class="content">
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <?php if(validation_errors() != false) { ?>
        <div class="alert alert-danger validation-errors">
            <?php echo validation_errors(); ?>
        </div>
    <?php } ?>
    <?php if($this -> session -> flashdata('error')) : ?>
        <div class="alert alert-danger">
            <?php echo $this -> session -> flashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if($this -> session -> flashdata('response')) : ?>
        <div class="alert alert-success">
            <?php echo $this -> session -> flashdata('response') ?>
        </div>
    <?php endif; ?>
    <form method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="forget_password">
        <h3>Forget Password ?</h3>
        <p>
            Enter your e-mail address below to reset your password.
        </p>
        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
            </div>
        </div>
        <div class="form-actions">
            <a id="register-back-btn" href="<?php echo base_url() ?>" type="button" class="btn">
                <i class="m-icon-swapleft"></i> Back
            </a>
            <button type="submit" class="btn blue pull-right">
                Submit <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
</div>