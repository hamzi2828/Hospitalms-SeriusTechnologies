<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if (validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('response')) : ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('response'); ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Stock Valuation
                </div>
                <?php if ( count ( $products ) > 0 ) : ?>
                     
                     <a href="javascript:void(0)" onclick="downloadExcel()" style="margin-right: 10px"
                        class="pull-right print-btn">Download Excel</a>
                 <?php endif ?>

            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="stock_valuation_table">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>TP/Box</th>
                            <th>TP/Unit</th>
                            <th>Pack Size</th>
                            <th>Sale/Box</th>
                            <th>Sale/Unit</th>
                            <th>Total Qty</th>
                            <th>Sold Qty</th>
                            <th>Refund Qty</th>
                            <th>Available Qty</th>
                            <th>Stock Value (TP)</th>
                            <th>Stock Value (Sale)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_stock_value_tp = 0; // Initialize total Stock Value (TP)
                        $total_stock_value_sale = 0; // Initialize total Stock Value (Sale)
                        if (!empty($products)) {
                            $i = 1;
                            foreach ($products as $product) {
                                $total_qty = (int)get_product_total_quantity_by_id($product->id) ?? 0;
                                $sold_qty = (int)get_total_sold_quantity_by_product_id($product->id) ?? 0;
                                $refund_qty = (int)get_total_refonded_quantity_by_product_id($product->id) ?? 0;
                                $available_qty = $total_qty - $sold_qty + $refund_qty;

                                // Calculate Stock Value (TP) and Stock Value (Sale)
                                $stock_value_tp = $available_qty * $product->tp_unit;
                                $stock_value_sale = $available_qty * $product->sale_unit;

                                // Add to total values
                                $total_stock_value_tp += $stock_value_tp;
                                $total_stock_value_sale += $stock_value_sale;
                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $product->name; ?></td>
                                    <td>
                                        <?php
                                        $category = $this->CafeSettingModel->get_category_by_id($product->category_id);
                                        echo $category->name ?? 'not found';
                                        ?>
                                    </td>
                                    <td><?php echo $product->tp_box; ?></td>
                                    <td><?php echo $product->tp_unit; ?></td>
                                    <td><?php echo $product->quantity; ?></td>
                                    <td><?php echo $product->sale_box; ?></td>
                                    <td><?php echo $product->sale_unit; ?></td>
                                    <td><?php echo $total_qty; ?></td>
                                    <td><?php echo $sold_qty; ?></td>
                                    <td><?php echo $refund_qty; ?></td>
                                    <td><?php echo $available_qty; ?></td>
                                    <td><?php echo number_format($stock_value_tp, 2); ?></td>
                                    <td><?php echo number_format($stock_value_sale, 2); ?></td>
                                </tr>
                        <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12" style="text-align: right; font-weight: bold;">Total:</td>
                            <td style="font-weight: bold;"><?php echo number_format($total_stock_value_tp, 2); ?></td>
                            <td style="font-weight: bold;"><?php echo number_format($total_stock_value_sale, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script type="text/javascript">
    function downloadExcel() {
        try {
            // Get the HTML table
            let table = document.getElementById("stock_valuation_table");
            if (!table) {
                alert("Table not found. Please ensure the table exists.");
                return;
            }

            // Convert the table to a sheet object
            let sheet = XLSX.utils.table_to_sheet(table);

            // Create a workbook object
            let workbook = XLSX.utils.book_new();

            // Add the sheet to the workbook
            XLSX.utils.book_append_sheet(workbook, sheet, "Stock Valuation");

            // Convert the workbook to a binary string
            let wbout = XLSX.write(workbook, { bookType: "xlsx", type: "binary" });

            // Create a Blob object from the binary string
            let blob = new Blob([s2ab(wbout)], { type: "application/octet-stream" });

            // Create a download link and click it
            let url = window.URL.createObjectURL(blob);
            let a = document.createElement("a");
            a.href = url;
            a.download = "Stock_Valuation_Report.xlsx";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        } catch (error) {
            console.error("Error during Excel export: ", error);
            alert("Failed to export the data. Please check the console for details.");
        }
    }

    function s2ab(s) {
        let buf = new ArrayBuffer(s.length);
        let view = new Uint8Array(buf);
        for (let i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xff;
        return buf;
    }
</script>
