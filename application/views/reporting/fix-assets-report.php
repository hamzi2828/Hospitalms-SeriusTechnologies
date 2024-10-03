<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2 col-lg-offset-1">
                    <label for="month">Month</label>
                    <select name="month" id="month" class="form-control select2me" data-placeholder="Select"
                            data-allow-clear="true">
                        <option></option>
                        <?php
                            foreach ( months as $monthNumber => $monthName ) {
                                $searchMonth = $this -> input -> get ( 'month' );
                                
                                if ( !empty( $searchMonth ) )
                                    $selected = ( $searchMonth == $monthNumber ) ? 'selected="selected"' : '';
                                else
                                    $selected = ( $monthNumber == date ( 'm' ) ) ? 'selected="selected"' : '';
                                
                                echo '<option value="' . $monthNumber . '" ' . $selected . '>' . $monthName . '</option>';
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="year">Year</label>
                    <select name="year" id="year" class="form-control select2me" data-placeholder="Select"
                            data-allow-clear="true">
                        <option></option>
                        <?php
                            $currentYear = date ( 'Y' );
                            $lastYear    = $currentYear - 5;
                            
                            for ( $year = $currentYear; $year >= $lastYear; $year-- ) {
                                $searchYear = $this -> input -> get ( 'year' );
                                
                                if ( !empty( $searchYear ) )
                                    $selected = ( $searchYear == $year ) ? 'selected="selected"' : '';
                                else
                                    $selected = ( $year == date ( 'Y' ) ) ? 'selected="selected"' : '';
                                
                                echo '<option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
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
                
                <div class="form-group col-lg-2">
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
                    <i class="fa fa-globe"></i> Fix Assets Register
                </div>
                <?php if ( count ( $reports ) > 0 ) : ?>
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
                        <?php
                            $month = $this -> input -> get ( 'month' );
                            $year  = $this -> input -> get ( 'year' );
                            if ( !empty( $month ) && !empty( $year ) ) {
                                ?>
                                <th>Total Accumulative Depreciation</th>
                                <th>
                                    WDV
                                    <?php
                                        $timestamp = mktime ( 0, 0, 0, $month, 1 );
                                        echo date ( "M", $timestamp ) . ', ' . $year;
                                    ?>
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
                        $counter            = 1;
                        $netAccumulativeDep = 0;
                        $netPrice           = 0;
                        $wdv                = 0;
                        $netWDV             = 0;
                        $financial_year     = date ( $year . '-07' );
                        
                        if ( count ( $reports ) > 0 ) {
                            foreach ( $reports as $report ) {
                                $itemDepreciation = array ();
                                $depreciation     = 0;
                                $disposed         = get_store_disposed_asset ( $report -> id );
                                $acc_head         = get_account_head ( $report -> account_head_id );
                                $netPrice         += $report -> value;
                                $totalValue       = $report -> value;
                                $depreciationRate = ( $report -> depreciation / 100 ); // 10%
                                $netAccumulative  = 0;
                                $filter_date      = strtotime ( date ( $year . '-' . $month ) );
                                $searchDateTime   = strtotime ( date ( $year . '-' . $month . '-01' ) );
                                $purchaseDateTime = strtotime ( $report -> purchase_date );
                                $numberOfMonths   = ( date ( 'Y', $searchDateTime ) - date ( 'Y', $purchaseDateTime ) ) * 12 + ( date ( 'm', $searchDateTime ) - date ( 'm', $purchaseDateTime ) );
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
                                    <td>
                                        <?php
                                            for ( $i = 0; $i < $numberOfMonths; $i++ ) {
                                                $monthlyDepreciationExpense          = ( $totalValue * $depreciationRate ) / 12;
                                                $totalValue                          -= $monthlyDepreciationExpense;
                                                $netAccumulative                     += $monthlyDepreciationExpense;
                                                $itemDepreciation[ $report -> id ][] = $monthlyDepreciationExpense;
                                            }
                                            
                                            $depreciation = round ( $netAccumulative, 2 );
                                            $wdv          = ( $report -> value - $depreciation );
                                            
                                            if ( !empty( $disposed ) ) {
                                                $dispose_date = strtotime ( date ( 'Y-m', strtotime ( $disposed -> dispose_date ) ) );
                                                if ( $filter_date > $dispose_date )
                                                    $wdv = 0;
                                                
                                                if ( $filter_date >= $dispose_date && count ( $itemDepreciation ) > 0 ) {
                                                    $lastDepreciation = end ( $itemDepreciation[ $report -> id ] );
                                                    $depreciation     -= round ( $lastDepreciation, 2 );
                                                }
                                                
                                                if ( $filter_date > strtotime ( $financial_year ) ) {
                                                    $depreciation    = 0;
                                                    $netAccumulative = 0;
                                                }
                                            }
                                            
                                            $netWDV             += $wdv;
                                            $netAccumulativeDep += $depreciation;
                                            echo number_format ( $depreciation, 2 );
                                        
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo number_format ( $wdv, 2 ) ?>
                                    </td>
                                    <td>
                                        <?php echo !empty( $disposed ) ? date_setter_without_time ( $disposed -> dispose_date ) : '-' ?>
                                    </td>
                                    <td>
                                        <?php echo !empty( $disposed ) ? number_format ( $disposed -> value, 2 ) : '-' ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="6"></th>
                        <th><?php echo number_format ( $netPrice, 2 ) ?></th>
                        <th></th>
                        <th><?php echo number_format ( $netAccumulativeDep, 2 ) ?></th>
                        <th><?php echo number_format ( $netWDV, 2 ) ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script src="https://rawcdn.githack.com/FuriosoJack/TableHTMLExport/v2.0.0/src/tableHTMLExport.js"></script>
<script type="text/javascript">
    $ ( document ).on ( 'click', '#download-fix-assets-report', function () {
        $ ( "#fix-assets-report-table" ).tableHTMLExport ( {
                                                               type    : 'csv',
                                                               filename: "Fix-assets-register-<?php echo $month . '-' . $year ?>.csv",
                                                           } );
    } )
</script>
