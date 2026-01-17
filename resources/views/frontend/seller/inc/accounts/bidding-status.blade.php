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
                    @foreach($myorders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><strong>
                                    @if(!empty($order->financial_year) && !empty($order->fy_sequence))
                                        {{ $order->financial_year . '-' . str_pad($order->fy_sequence, 3, '0', STR_PAD_LEFT) }}
                                    @else
                                        {{ date('y', strtotime($order->order_date)) . (date('y', strtotime($order->order_date)) + 1) . '-' . str_pad($order->order_id, 4, '0', STR_PAD_LEFT) }}
                                    @endif
                                </strong></td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</td>
                            <td>{{ $order->sku ?? '' }}</td>
                            <td>{{ $order->cas_no ?? '' }}</td>
                            <td>{{ $order->impurity_name ?? '' }}</td>
                            <td>{{ $order->qty_reqd }} {{ $order->uom }}</td>
                            <td>{{ $order->rate_pu }}</td>
                            <td>{{ $order->l1_rate ?? '--' }}</td>
                            <td>{{ $order->days ?? '--' }}</td>
                            <td>{{ $order->off_temp ?? '--' }}</td>
                            <td>{{ $order->expdly_dt ? \Carbon\Carbon::parse($order->expdly_dt)->format('d M, Y') : '--' }}
                            </td>
                            <td>{{ $order->dly_city ?? '--' }}</td>
                            <td>{{ $order->bid_end_time ? \Carbon\Carbon::parse($order->bid_end_time)->format('d M, Y H:i') : '--' }}
                            </td>
                            <td>
                                @if($order->bidding_status == 'awarded')
                                    Awarded
                                @else
                                    In Process
                                @endif
                            </td>
                            <td>
                                @if($order->bidding_status == 'awarded')
                                    {{ $order->seller_status ?? '--' }}
                                @else
                                    --
                                @endif
                            </td>
                        </tr>
                    @endforeach
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

@section('footlink')

    <script>

        new DataTable('#example');

    </script>

    <script>

        $(document).ready(function () {

            $('.view').click(function () {
                var selector = $(this);
                var selectorId = selector.attr("id");
                var pagename = selector.attr("data-page");
                $('.content').html("<div class='spinner'><p style='text-align: center; margin: 35px; font-size: 14px; font-weight: 500; opacity: 0.9;'>Loading...</p></div>");
                $.ajax({
                    type: 'get',
                    url: "/dbaction",
                    data: { selectorId: selectorId, pagename: pagename },

                    beforeSend: function () {
                        $('.modal').attr("style", "display:flex;width:100%;height:100vh;");
                    },
                    success: function (response) {
                        $('.content').html(response);
                        //alert(response);
                        console.log(response);
                    },
                    complete: function (response) {
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