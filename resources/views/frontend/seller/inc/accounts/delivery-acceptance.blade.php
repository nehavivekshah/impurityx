<div class="dashboard-area box--shadow">
    <div class="row gy-4 mt-0 mb-4">
        <div class="col-md-12 px-3 bg-white">
            <table id="example" class="table table-striped border rounded" style="width:100%;font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center" width="50px">#</th>
                        <th>Order ID</th>
                        <th>Product Details</th>
                        <th>Order Details</th>
                        <!--<th class="text-center">Applications</th>-->
                        <th>Seller</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created On</th>
                        <th class="text-center" width="90px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        
                        $now = \Carbon\Carbon::now();
                        
                    @endphp
                    @foreach($myorders as $key => $order)
                    <tr>
                        <td class="text-center" width="50px">{{ $key + 1 }}</td>
                        <td><strong>{{ date('y') . (date('y') + 1) . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>
                            {!! $order->sku ?? 'N/A' !!}<br>
                            {{ $order->name ?? 'N/A' }}
                        </td>
                        <td>
                            Qty: {{ $order->quantity }} {{ $order->uom }}<br>
                            Delivery: {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M, Y') }}
                        </td>
                        <td>
                            {!! $order->first_name ?? '' !!} {!! $order->last_name ?? '' !!}<br>
                            Price: {{ $order->price ?? '' }} /-
                        </td>
                        <td class="text-center">
                            @if($order->status == 'pending')
                                <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Initiate</a>
                            @elseif($order->status == 'active')
                                @if($order->auction_end > $now)
                                    <a href="javascript:void(0)" class="badge bg-success td-none">Acitve</a>
                                @else
                                    <a href="javascript:void(0)" class="badge bg-danger td-none">Select Bid</a>
                                @endif
                            @elseif($order->status == 'awarded')
                                <a href="javascript:void(0)" class="badge bg-primary td-none">Order Awarded</a>
                            @elseif($order->status == 'selected')
                                <a href="javascript:void(0)" class="badge bg-warning td-none text-dark">Admin to confirm</a>
                            @elseif($order->status == 'cancelled')
                                <a href="javascript:void(0)" class="badge bg-secondary td-none">Cancelled</a>
                            @else
                                <a href="javascript:void(0)" class="badge bg-danger td-none">closed</a>
                            @endif
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                        <td class="text-center" width="90px">
                            <a href="javascript:void(0)" id="{{ $order->id }}" class="btn btn-sm btn-info view" title="View Details" data-page="awardedorders">
                                <i class="bx bx-show"></i>
                            </a>
                            <!--<a href="javascript:void(0)" id="{{ $order->id }}" class="btn btn-sm btn-warning view" title="View Details" data-page="bids">
                                <i class="fas fa-gavel fa-flip-horizontal"></i>
                            </a>-->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center" width="50px">#</th>
                        <th>Order ID</th>
                        <th>Product Details</th>
                        <th>Order Details</th>
                        <!--<th>Requirements</th>-->
                        <!--<th class="text-center">Applications</th>-->
                        <th>Seller</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created On</th>
                        <th class="text-center" width="90px">Action</th>
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

@section('footlink')

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

@endsection