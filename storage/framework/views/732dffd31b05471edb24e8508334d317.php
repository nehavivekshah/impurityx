<div class="dashboard-area box--shadow">
    <div class="row gy-4 mt-0 mb-4">
        
        <div class="col-md-12 px-3 bg-white">
            <table id="example" class="table table-striped border rounded" style="width:100%;font-size: 14px;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Id</th>
                        <th>Order Dt</th>
                        <th>SKU</th>
                        <th>CAS No</th>
                        <th>Impurity Name</th>
                        <th>Qty</th>
                        <th>My Rate</th>
                        <th>Order Val</th>
                        <th>ExpDly Dt</th>
                        <th>Act Dly Dt</th>
                        <th>Dely City</th>
                        <th>Buyer Name</th>
                        <th>Invoice No.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $now = \Carbon\Carbon::now(); ?>
                    <?php $__currentLoopData = $myorders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center" style="min-width:50px!important;"><?php echo e($key + 1); ?></td>
                        <td><strong><?php echo e(date('y', strtotime($order->order_date)) . (date('y', strtotime($order->order_date)) + 1) . '-' . str_pad($order->order_id, 4, '0', STR_PAD_LEFT)); ?></strong></td>
                        <td><?php echo e(\Carbon\Carbon::parse($order->order_date)->format('d M, Y')); ?></td>
                        <td><?php echo $order->sku ?? ''; ?></td>
                        <td><?php echo e($order->cas_no ?? ''); ?></td>
                        <td><?php echo e($order->impurity_name ?? ''); ?></td>
                        <td><?php echo e($order->qty_reqd); ?> <?php echo e($order->uom); ?></td>
                        <td>Rs. <?php echo e($order->rate_pu ?? ''); ?></td>
                        <td>Rs. <?php echo e($order->order_val ?? ''); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($order->expdly_dt)->format('d M, Y')); ?></td>
                        <td>
                            <?php echo e(\Carbon\Carbon::parse($order->awarded_date)->addDays($order->days)->format('d M, Y')); ?>

                        </td>
                        <td><?php echo e($order->delivery_location ?? ''); ?></td>
                        <td><?php echo e($order->seller_fname ?? ''); ?> <?php echo e($order->seller_lname ?? ''); ?></td>
                        <td><?php echo e($order->invoice_no ?? ''); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Order Id</th>
                        <th>Order Dt</th>
                        <th>SKU</th>
                        <th>CAS No</th>
                        <th>Impurity Name</th>
                        <th>Qty</th>
                        <th>My Rate</th>
                        <th>Order Val</th>
                        <th>ExpDly Dt</th>
                        <th>Act Dly Dt</th>
                        <th>Dely City</th>
                        <th>Buyer Name</th>
                        <th>Invoice No.</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<section class="modal">
    <div class="modal-md">
        <div class="head">
            <div class="pop-title">View Details</div>
            <div class="dismiss"><span class="bx bx-window-close"></div>
        </div>
        <div class="content"></div>
    </div>
</section>

<?php $__env->startSection('footlink'); ?>

<script>
    
    new DataTable('#example');
    
</script>

<script>
    
    $(document).ready(function(){
        
        $('.view').click(function(){
            var selector = $(this);
            var selectorId = selector.attr("id");
            var pagename = selector.attr("data-page");
            $('.content').html("<div class='spinner'><p style='text-align: center; margin: 35px; font-size: 14px; font-weight: 500; opacity: 0.9;'>Loading...</p></div>");
            $.ajax({
                type: 'get',
                url: "/dbaction",
                data: {selectorId:selectorId,pagename:pagename},
                
                beforeSend: function(){
                    $('.modal').attr("style","display:flex;width:100%;height:100vh;");
                },
                success: function(response){
                    $('.content').html(response);
                    //alert(response);
                    console.log(response);
                },
                complete: function(response){
                    //alert(response);
                    //console.log(response);
                }
            });
        });
        
    });
</script>

<script>
  document.querySelector('.dismiss').addEventListener('click', function () {
    document.querySelector('.modal').style.display = 'none';
  });
</script>

<?php $__env->stopSection(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views//frontend/seller/inc/accounts/completed-orders.blade.php ENDPATH**/ ?>