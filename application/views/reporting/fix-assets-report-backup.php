<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2">
                    <label for="start-date">Start Date</label>
                    <input type="text" id="start-date" name="start-date" class="form-control date date-picker"
                           value="<?php echo $this -> input -> get ( 'start-date' ); ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="end-date">End Date</label>
                    <input type="text" id="end-date" name="end-date" class="form-control date date-picker"
                           value="<?php echo $this -> input -> get ( 'end-date' ); ?>">
                </div>
                <div class="form-group col-lg-4">
                    <label for="item">Fix Asset Item</label>
                    <select name="item-id" id="item" class="form-control select2me" data-placeholder="Select"
                            data-allow-clear="true">
                        <option></option>
                        <?php
                            if ( count ( $stores ) > 0 ) {
                                foreach ( $stores as $storeItem ) {
                                    ?>
                                    <option
                                            value="<?php echo $storeItem -> id ?>" <?php echo $this -> input -> get ( 'item-id' ) == $storeItem -> id ? 'selected="selected"' : ''; ?>>
                                        <?php echo $storeItem -> item ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="depreciation-charge">Depreciation Charge</label>
                    <select name="depreciation-charge" id="depreciation-charge" class="form-control select2me"
                            data-placeholder="Select"
                            data-allow-clear="true">
                        <option></option>
                        <option value="annual" <?php echo $this -> input -> get ( 'depreciation-charge' ) == 'annual' ? 'selected="selected"' : ''; ?>>
                            Annual
                        </option>
                        <option value="purchase-date" <?php echo $this -> input -> get ( 'depreciation-charge' ) == 'purchase-date' ? 'selected="selected"' : ''; ?>>
                            Date of Purchase
                        </option>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn-block btn btn-primary" style="margin-top: 25px;">Search
                    </button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Fix Assets Report
                </div>
                <?php if ( count ( $reports ) > 0 ) : ?>
                    <?php /* <a href="<?php echo base_url ( '/invoices/store-fix-assets-report/?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn" style="margin-left: 10px" target="_blank">
                        Print
                    </a> */ ?>
                    <a href="javascript:void(0)" class="pull-right print-btn" id="download-fix-assets-report">
                        Download CSV
                    </a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto;">
                <table class="table table-striped table-bordered table-hover" id="fix-assets-report-table">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Account Head</th>
                        <th> Code</th>
                        <th> Fix Asset Item</th>
                        <th> Location</th>
                        <th> Purchase Date</th>
                        <th> Price</th>
                        <th> Depreciation (%)</th>
                        <th> Depreciation Charge</th>
                        <?php
                            if ( count ( $filters ) > 0 ) {
                                for ( $year = $filters[ 'start_year' ]; $year <= $filters[ 'end_year' ]; $year++ ) {
                                    if ( $year > 0 ) {
                                        ?>
                                        <th>
                                            As of
                                            <?php echo date ( 'M', strtotime ( $this -> input -> get ( 'end-date' ) ) ) . ' ' . $year ?>
                                        </th>
                                        <?php
                                    }
                                }
                            }
                            
                            if ( !empty( $this -> input -> get ( 'end-date' ) ) ) {
                                ?>
                                <th>Total Accumulative Depreciation</th>
                                <th>
                                    WDV
                                    <?php echo date ( 'M', strtotime ( $this -> input -> get ( 'end-date' ) ) ) . ' ' . $filters[ 'end_year' ] ?>
                                </th>
                                <?php
                            }
                        
                        ?>
                        <th> Disposed Date</th>
                        <th> Disposed Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter         = 1;
                        $netValue        = 0;
                        $netWDVValue     = 0;
                        $netAccumulative = 0;
                        $yearsTotal      = array ();
                        
                        if ( count ( $reports ) > 0 ) {
                            foreach ( $reports as $report ) {
                                $last_depreciation      = 0;
                                $depSum                 = 0;
                                $disposed               = get_store_disposed_asset ( $report -> store_id );
                                $total_accumulative_dep = 0;
                                $netValue               += $report -> value;
                                $acc_head               = get_account_head ( $report -> account_head_id );
                                $wdv                    = 0;
                                $financial_year         = null;
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $acc_head -> title ?></td>
                                    <td><?php echo $report -> code ?></td>
                                    <td><?php echo $report -> item ?></td>
                                    <td><?php echo $report -> location ?></td>
                                    <td><?php echo date_setter_without_time ( $report -> purchase_date ) ?></td>
                                    <td><?php echo number_format ( $report -> value, 2 ) ?></td>
                                    <td><?php echo number_format ( $report -> depreciation, 2 ) ?></td>
                                    <td><?php echo string_to_title ( $report -> depreciation_charge ) ?></td>
                                    <?php
                                        $value = $report -> value;
                                        if ( count ( $filters ) > 0 ) {
                                            for ( $year = $filters[ 'start_year' ]; $year <= $filters[ 'end_year' ]; $year++ ) {
                                                if ( $year > 0 ) {
                                                    $depreciation           = calculate_depreciation_value ( $report -> purchase_date, $value, $report -> depreciation, $report -> depreciation_charge, $year, $depSum, $disposed );
                                                    $depSum                 += $depreciation;
                                                    $value                  -= $depreciation;
                                                    $total_accumulative_dep += $depreciation;
                                                    $financial_year         = date ( $year . '-06-30' );
                                                    ?>
                                                    <td>
                                                        <?php
                                                            $last_depreciation += $depreciation;
                                                            
                                                            if ( isset( $yearsTotal[ $year ] ) )
                                                                $yearsTotal[ $year ] += $depreciation;
                                                            else
                                                                $yearsTotal[ $year ] = $depreciation;
                                                            
                                                            echo $depreciation > 0 ? number_format ( $depreciation, 2 ) : '-';
                                                        ?>
                                                    </td>
                                                    <?php
                                                }
                                            }
                                            
                                            if ( !empty( $disposed ) ) {
                                                $end_date               = date ( 'Y-m-d', strtotime ( $this -> input -> get ( 'end-date' ) ) );
                                                $current_financial_year = strtotime ( $financial_year );
                                                $search_end             = strtotime ( $end_date );
                                                $dispose_date           = strtotime ( $disposed -> dispose_date );
                                                
                                                if ( $search_end > $dispose_date )
                                                    $wdv = 0;
                                                else
                                                    $wdv = ( $report -> value - $total_accumulative_dep );

                                                if ( $search_end > $current_financial_year ) {
                                                    $total_accumulative_dep = 0;
                                                }
                                                
                                            }
                                            else
                                                $wdv = ( $report -> value - $total_accumulative_dep );
                                            
                                            $wdv = max ( $wdv, 0 );
                                            ?>
                                            <td>
                                                <?php echo number_format ( $total_accumulative_dep, 2 ); ?>
                                            </td>
                                            <td><?php echo number_format ( ( $wdv ), 2 ) ?></td>
                                            <?php
                                        }
                                        $netAccumulative += $total_accumulative_dep;
                                    ?>
                                    <td>
                                        <?php echo !empty( $disposed ) ? date_setter_without_time ( $disposed -> dispose_date ) : '-' ?>
                                    </td>
                                    <td>
                                        <?php echo !empty( $disposed ) ? number_format ( $disposed -> value, 2 ) : '-' ?>
                                    </td>
                                </tr>
                                <?php
                                $netWDVValue += $wdv;
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6"></td>
                        <td>
                            <strong><?php echo number_format ( $netValue, 2 ) ?></strong>
                        </td>
                        <td colspan="2"></td>
                        <?php
                            if ( count ( $filters ) > 0 ) {
                                for ( $year = $filters[ 'start_year' ]; $year <= $filters[ 'end_year' ]; $year++ ) {
                                    if ( $year > 0 ) {
                                        ?>
                                        <td>
                                            <strong>
                                                <?php echo number_format ( $yearsTotal[ $year ], 2 ) ?></strong>
                                        </td>
                                        <?php
                                    }
                                }
                                ?>
                                <td>
                                    <strong><?php echo number_format ( $netAccumulative, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $netWDVValue, 2 ) ?></strong>
                                </td>
                                <?php
                            }
                        ?>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script src="https://rawcdn.githack.com/FuriosoJack/TableHTMLExport/v2.0.0/src/tableHTMLExport.js"></script>
<?php if ( count ( $filters ) > 0 ) : ?>
    <script type="text/javascript">
        $ ( document ).on ( 'click', '#download-fix-assets-report', function () {
            $ ( "#fix-assets-report-table" ).tableHTMLExport ( {
                                                                   type    : 'csv',
                                                                   filename: "<?php echo $filters[ 'start_year' ] . '-' . $filters[ 'end_year' ] ?>.csv",
                                                               } );
        } )
    </script>
<?php endif; ?>
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>
