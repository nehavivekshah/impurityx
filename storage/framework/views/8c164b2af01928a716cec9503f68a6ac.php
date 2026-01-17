<div class="dashboard-area box--shadow">
    <div class="row gy-4 mt-0 mb-4">
        <div class="col-md-12 px-3 bg-white">
            <table id="example" class="table table-striped border rounded" style="width:100%;font-size: 14px;">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>O_Id</th>
                        <th>O_Dt</th>
                        <th>SKU</th>
                        <th>CAS No</th>
                        <th>Impurity Name</th>
                        <th>Q Reqd</th>
                        <th>My Rate</th>
                        <th>L1 Rate</th>
                        <th>Off_Dly</th>
                        <th>Off_Temp</th>
                        <th>Rq_Dly</th>
                        <th>Dly City</th>
                        <th>Bid End Time</th>
                        <th>Ord Awards</th>
                        <th>Ord Won</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $myorders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td><strong><?php echo e(date('y', strtotime($order->order_date)) . (date('y', strtotime($order->order_date)) + 1) . '-' . str_pad($order->order_id, 4, '0', STR_PAD_LEFT)); ?></strong></td>
                        <td><?php echo e(\Carbon\Carbon::parse($order->order_date)->format('d M, Y')); ?></td>
                        <td><?php echo e($order->sku ?? ''); ?></td>
                        <td><?php echo e($order->cas_no ?? ''); ?></td>
                        <td><?php echo e($order->impurity_name ?? ''); ?></td>
                        <td><?php echo e($order->qty_reqd); ?> <?php echo e($order->uom); ?></td>
                        <td><?php echo e($order->rate_pu); ?></td>
                        <td><?php echo e($order->l1_rate ?? '--'); ?></td>
                        <td><?php echo e($order->days ?? '--'); ?></td>
                        <td><?php echo e($order->off_temp ?? '--'); ?></td>
                        <td><?php echo e($order->expdly_dt ? \Carbon\Carbon::parse($order->expdly_dt)->format('d M, Y') : '--'); ?></td>
                        <td><?php echo e($order->dly_city ?? '--'); ?></td>
                        <td><?php echo e($order->bid_end_time ? \Carbon\Carbon::parse($order->bid_end_time)->format('d M, Y H:i') : '--'); ?></td>
                        <td>
                            <?php if($order->bidding_status == 'awarded'): ?>
                                Awarded
                            <?php else: ?>
                                In Process
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($order->bidding_status == 'awarded'): ?>
                            <?php echo e($order->seller_status ?? '--'); ?>

                            <?php else: ?>
                                --
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Sr No.</th>
                        <th>O_Id</th>
                        <th>O_Dt</th>
                        <th>SKU</th>
                        <th>CAS No</th>
                        <th>Impurity Name</th>
                        <th>Q Reqd</th>
                        <th>My Rate</th>
                        <th>L1 Rate</th>
                        <th>Off_Dly</th>
                        <th>Off_Temp</th>
                        <th>Rq_Dly</th>
                        <th>Dly City</th>
                        <th>Bid End Time</th>
                        <th>Ord Awards</th>
                        <th>Ord Won</th>
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

<?php $__env->stopSection(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views//frontend/seller/inc/accounts/bidding-status.blade.php ENDPATH**/ ?>