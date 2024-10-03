<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php if ( validation_errors () != false ) { ?>
        <div class="alert alert-danger validation-errors">
            <?php echo validation_errors (); ?>
        </div>
    <?php } ?>
    <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
        <div class="alert alert-danger">
            <?php echo $this -> session -> flashdata ( 'error' ) ?>
        </div>
    <?php endif; ?>
    <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
        <div class="alert alert-success">
            <?php echo $this -> session -> flashdata ( 'response' ) ?>
        </div>
    <?php endif; ?>
    <form class="login-form" method="post">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
        <input type="hidden" name="action" value="do_login">
        <h4 class="form-title">Hybrid ERP AI Based Solution</h4>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>
				 Enter any username and password.
			</span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username"
                       name="username"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password"
                       name="password"/>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue pull-right">
                Login <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>
    <!-- END LOGIN FORM -->
</div>