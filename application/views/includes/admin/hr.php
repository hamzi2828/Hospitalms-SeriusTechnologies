<?php if ( !empty( $access ) and in_array ( 'hr', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'hr' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-user-plus"></i>
            <span class="title"> HR </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'hr_members', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'index' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/hr/index' ) ?>">
                        All Employees
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'add_hr_members', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'add' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/hr/add' ) ?>">
                        Add Employee
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'all_salary_sheets', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sheets' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/hr/sheets' ) ?>">
                        All Salary Sheets
                    </a>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'salary_sheet', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'sheet' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/hr/sheet' ) ?>">
                        Add Salary Sheet
                    </a>
                </li>
            <?php endif; ?>
            <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
            <?php if ( !empty( $access ) and in_array ( 'search_salary_sheet', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'search' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/hr/search' ) ?>">
                        Search Salary Sheet
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>