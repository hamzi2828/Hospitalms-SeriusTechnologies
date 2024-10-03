<div class="content">
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
    <!-- BEGIN REGISTRATION FORM -->
    <form method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="register_member">
        <h3>Sign Up</h3>
        <p>
            Enter your personal details below:
        </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Full Name</label>
            <div class="input-icon">
                <i class="fa fa-font"></i>
                <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="name" required minlength="3" maxlength="100" value="<?php echo set_value('name') ?>"/>
            </div>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email" required minlength="3" maxlength="100" value="<?php echo set_value('email') ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Address</label>
            <div class="input-icon">
                <i class="fa fa-check"></i>
                <input class="form-control placeholder-no-fix" type="text" placeholder="Address" name="address" required minlength="3" maxlength="500" value="<?php echo set_value('address') ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Phone</label>
            <div class="input-icon">
                <i class="fa fa-phone"></i>
                <input class="form-control placeholder-no-fix" type="text" placeholder="Phone" name="phone" required minlength="11" maxlength="11" value="<?php echo set_value('phone') ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">CNIC</label>
            <div class="input-icon">
                <i class="fa fa-credit-card"></i>
                <input class="form-control placeholder-no-fix" type="text" placeholder="CNIC" name="cnic" required minlength="13" maxlength="13" value="<?php echo set_value('cnic') ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Role</label>
            <div class="input-icon">
                <i class="fa fa-ban"></i>
                <select name="role" class="form-control" style="padding-left: 30px;color: #a4a4a4;">
                    <option value=""> Select role </option>
                    <option value="admin"> Administrator </option>
                    <option value="receptionist"> Receptionist </option>
                    <option value="doctor"> Doctor </option>
                    <option value="accountant"> Accountant </option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" required/>
            </div>
        </div>
        <div class="form-actions">
            <a id="register-back-btn" href="<?php echo base_url() ?>" type="button" class="btn">
                <i class="m-icon-swapleft"></i> Back
            </a>
            <button type="submit" id="register-submit-btn" class="btn blue pull-right">
                Sign Up <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->
</div>

<style>
    .validation-errors p {
        color: #a94442 !important;
    }
</style>