<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Mail\MailModel;
use Illuminate\Support\Facades\Mail;
use App\Models\Branches;
use App\Models\User;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Orders;
use App\Models\Biddings;
use App\Models\Galleries;
use App\Models\Sliders;
use App\Models\Contacts;
use App\Models\Enquiries;
use App\Models\Pages;
use App\Models\Reviews;
use App\Models\Posts;
use App\Models\Post_categories;
use App\Models\Settings;
use App\Models\Communications;
use App\Models\Notices;
use App\Models\Buyer_product_enquiries;

class SettingsController extends Controller
{
    public function getOrderDetails($orderNo)
    {
        $id = (int) explode('-', $orderNo)[1];

        $order = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->select('products.name', 'products.cas_no', 'orders.*')
            ->where('orders.id', $id)->first(); //->where('orders.status','awarded')

        if (Auth::User()->id == ($order->buyer_id ?? '')) {
            return response()->json([
                'status' => true,
                'cas_no' => $order->cas_no,
                'impurity_name' => $order->name
            ]);
        }

        $biddings = Biddings::where('order_id', $id)->where('status', 'awarded')->first();

        if (Auth::User()->id == ($biddings->seller_id ?? '')) {
            return response()->json([
                'status' => true,
                'cas_no' => $order->cas_no,
                'impurity_name' => $order->name
            ]);
        }

        if (Auth::User()->role == '1') {
            return response()->json([
                'status' => true,
                'cas_no' => $order->cas_no,
                'impurity_name' => $order->name
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Order not found'
        ]);
    }

    public function buyerDBaction(Request $request)
    {

        if ($request->pagename == 'orders') {

            $orders = Orders::leftJoin('users', 'users.id', '=', 'orders.buyer_id')
                ->leftJoin('products', 'products.id', '=', 'orders.product_id')
                ->select(
                    'users.first_name as buyer_fname',
                    'users.last_name as buyer_lname',
                    'users.mob as buyer_mobile',
                    'users.email as buyer_email',
                    'products.name as proName',
                    'products.uom',
                    'products.cas_no',
                    'orders.*'
                )
                ->where('orders.id', '=', $request->selectorId)
                ->first();

            $data = '<table class="table table-bordered w-100">';
            $data .= '<tr><th>Product:</th><td>' . $orders->proName . '</td></tr>';
            $data .= '<tr><th>CAS No.:</th><td>' . $orders->cas_no . '</td></tr>';
            $data .= '<tr><th>Quantity:</th><td>' . $orders->quantity . ' ' . $orders->uom . '</td></tr>';
            $data .= '<tr><th>Delivery Location:</th><td>' . $orders->delivery_location . '</td></tr>';
            $data .= '<tr><th>Delivery Date:</th><td>' . $orders->delivery_date . '</td></tr>';
            $data .= '<tr><th>Specific Requirements:</th><td>' . $orders->specific_requirements . '</td></tr>';
            $data .= '<tr><th>Offer end:</th><td>' . $orders->auction_end . '</td></tr>';
            $data .= '</table>';

            return $data;

        } elseif ($request->pagename == 'awardedorders' || $request->pagename == 'sellerawardedorders' || $request->pagename == 'sellerawardedordersexport') {

            $orders = Orders::leftJoin('users', 'users.id', '=', 'orders.buyer_id')
                ->leftJoin('products', 'products.id', '=', 'orders.product_id')
                ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->leftJoin('users as sellers', 'biddings.seller_id', '=', 'sellers.id')
                ->leftJoin('usermetas', 'sellers.id', '=', 'usermetas.uid')
                ->select(
                    'users.first_name as buyer_fname',
                    'users.last_name as buyer_lname',
                    'users.mob as buyer_mobile',
                    'users.email as buyer_email',
                    'sellers.first_name',
                    'sellers.last_name',
                    'usermetas.company',
                    'sellers.email',
                    'sellers.mob',
                    'biddings.price',
                    'biddings.days',
                    'biddings.temp',
                    'biddings.updated_at as bid_confirmed_date',
                    'products.name as proName',
                    'products.sku',
                    'products.cas_no',
                    'products.uom',
                    'orders.*'
                )
                ->where('orders.id', '=', $request->selectorId)
                ->where('biddings.status', 'awarded')
                ->first();

            $data = '<table class="table table-bordered w-100">';
            $data .= '<tr><th>Product:</th><td>' . $orders->proName . '</td></tr>';
            $data .= '<tr><th>SKU:</th><td>' . $orders->sku . '</td></tr>';
            $data .= '<tr><th>CAS No.:</th><td>' . $orders->cas_no . '</td></tr>';
            $data .= '<tr><th>Quantity:</th><td>' . $orders->quantity . ' ' . $orders->uom . '</td></tr>';
            $data .= '<tr><th>Delivery Location:</th><td>' . $orders->delivery_location . '</td></tr>';
            $data .= '<tr><th>Actual Delivery Date:</th><td>' . $orders->delivery_date . '</td></tr>';
            $data .= '<tr><th>Specific Requirements:</th><td>' . $orders->specific_requirements . '</td></tr>';
            if ($request->pagename == 'sellerawardedorders' || $request->pagename == 'sellerawardedordersexport') {
                $data .= '<tr><th>Buyer Details:</th><td>' . $orders->buyer_fname . ' ' . $orders->buyer_lname . '<br>' . $orders->buyer_email . '</td></tr>';
                $data .= '<tr><th>Final Bid Price:</th><td> Rs. ' . $orders->price . '/- </td></tr>';
                $data .= '<tr><th>Storage Temp (°C):</th><td>' . $orders->temp . '</td></tr>';
                $data .= '<tr><th>Expected Delivery Date:</th><td>' . date('Y-m-d', strtotime($orders->bid_confirmed_date . ' +' . $orders->days . ' days')) . '</td></tr>';
            } else {
                $data .= '<tr><th>Seller Details:</th><td>' . $orders->company . '<br>' . $orders->email . '<br>' . $orders->mob . '</td></tr>';
                $data .= '<tr><th>Storage Temp (°C):</th><td>' . $orders->temp . '</td></tr>';
                $data .= '<tr><th>Expected Delivery Date:</th><td>' . date('Y-m-d', strtotime($orders->bid_confirmed_date . ' +' . $orders->days . ' days')) . '</td></tr>';
                $data .= '<tr><th>Seller Price:</th><td> Rs. ' . $orders->price . '/- </td></tr>';
            }
            $data .= '</table>';

            // --------- EXPORT PDF HERE ---------
            if ($request->pagename == 'sellerawardedordersexport') {
                $data .= '<style>
                    body {
                        font-family: DejaVu Sans, sans-serif;
                        font-size: 13px;
                        line-height: 1.5;
                        color: #333;
                    }
                    .title {
                        font-size: 20px;
                        font-weight: bold;
                        text-align: center;
                        margin-bottom: 15px;
                        padding-bottom: 10px;
                        border-bottom: 2px solid #000;
                    }
                    .section-title {
                        background: #f0f0f0;
                        font-weight: bold;
                        padding: 8px 10px;
                        border-left: 4px solid #000;
                        margin-top: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 5px;
                    }
                    table td, table th {
                        padding: 8px 10px;
                        border: 1px solid #ccc;
                        vertical-align: top;
                    }
                    .label {
                        font-weight: bold;
                        width: 30%;
                        background: #fafafa;
                    }
                </style>';
                $pdf = \PDF::loadHTML($data);
                return $pdf->download('awarded-order-' . $orders->id . '.pdf');
            }

            return $data;

        } elseif ($request->pagename == 'bids') {

            $biddings = Biddings::leftJoin('users', 'users.id', '=', 'biddings.seller_id')
                ->leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
                ->leftJoin('products', 'products.id', '=', 'orders.product_id')
                ->select(
                    'products.name as proName',
                    'orders.auction_end',
                    'orders.status as orderStatus',
                    'biddings.*'
                )
                ->where('orders.id', '=', $request->selectorId)
                ->orderBy('id', 'desc')
                ->get();

            $now = now();

            $data = '';

            if ($biddings->count() > 0) {
                $data = '<table class="table table-bordered table-striped table-hover w-100" style="font-size: 14px;">';
                $data .= '<thead><tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Days</th>
                            <th>Temp</th>
                            <th>Status</th>
                            <th>Offer Time</th>
                            <th>Action</th>
                          </tr></thead><tbody>';

                // Check if any bid is already selected or awarded
                $bidAlreadyChosen = $biddings->contains(function ($b) {
                    return in_array($b->status, ['selected', 'awarded']);
                });

                foreach ($biddings as $bid) {
                    $data .= '<tr>';
                    $data .= '<td>' . $bid->proName . '</td>';
                    $data .= '<td>Rs. ' . $bid->price . '</td>';
                    $data .= '<td>' . $bid->days . '</td>';
                    $data .= '<td>' . $bid->temp . '</td>';

                    // Status display with color badges
                    $statusLabel = '';
                    switch ($bid->status) {
                        case 'awarded':
                            $statusLabel = '<span class="badge bg-primary">Order Awarded</span>';
                            break;
                        case 'selected':
                            $statusLabel = '<span class="badge bg-warning text-dark">Admin to confirm</span>';
                            break;
                        case 'pending':
                        default:
                            $statusLabel = '<span class="badge bg-secondary">Pending</span>';
                            break;
                    }
                    $data .= '<td class="font-weight-bold">' . $statusLabel . '</td>';
                    $data .= '<td>' . $bid->created_at . '</td>';

                    // Show select button only if:
                    // - No bid already chosen
                    // - Current bid is pending
                    // - Auction ended
                    if (!$bidAlreadyChosen && $bid->status == 'pending' && $bid->orderStatus != 'cancelled' && ($bid->auction_end < $now)) {
                        $data .= '<td>
                                    <button class="btn btn-sm btn-primary select-bid-btn" 
                                        data-bid-id="' . $bid->id . '">Select Bid</button>
                                  </td>';
                    } else {
                        $data .= '<td><span class="text-muted">--</span></td>';
                    }

                    $data .= '</tr>';
                }

                $data .= '</tbody></table>
                    <script>
                    $(document).on("click", ".select-bid-btn", function() {
                        var selector = $(this);
                        var selectorId = selector.data("bid-id");
                        var pagename = "bidselected";
                    
                        $.ajax({
                            type: "get",
                            url: "/dbaction",
                            data: { selectorId: selectorId, pagename: pagename },
                            success: function(response) {
                                if (response.status === "success") {
                                    alert(response.message);
                                    location.reload();
                                }
                                console.log(response);
                                // Optionally refresh table or show success message
                            }
                        });
                    });
                    </script>';
            } else {
                $data .= '<p class="text-center">No Offer yet for this Order</p>';
            }

            return $data;

        } elseif ($request->pagename == 'bidselected') {

            $bid = Biddings::find($request->selectorId);

            if ($bid) {

                $bid->status = 'selected';

                $order = Orders::find($bid->order_id);
                $order->status = 'selected';
                $order->save();

                $bid->save();

                // Get buyer info
                $buyer = User::find($order->buyer_id);

                if (!empty($order->financial_year) && !empty($order->fy_sequence)) {
                    $formattedOrderId = $order->financial_year . '-' . str_pad($order->fy_sequence, 3, '0', STR_PAD_LEFT);
                } else {
                    $month = date('m', strtotime($order->created_at));
                    if ($month >= 4) {
                        $fy_start = date('y', strtotime($order->created_at));
                        $fy_end = date('y', strtotime('+1 year', strtotime($order->created_at)));
                    } else {
                        $fy_start = date('y', strtotime('-1 year', strtotime($order->created_at)));
                        $fy_end = date('y', strtotime($order->created_at));
                    }
                    $formattedOrderId = $fy_start . '' . $fy_end . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
                }

                if ($buyer && $buyer->email) {
                    $details = [
                        'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
                        'order_id' => $formattedOrderId,
                    ];

                    $subject = "Your Selected Offer Has Been Received – Thank You for Choosing ImpurityX";
                    $template = "emails.offer_selected_notification";

                    Mail::to($buyer->email)->send(new MailModel($details, $subject, $template));
                }

                return response()->json(['status' => 'success', 'message' => 'Bid Selected Successfully']);
            }

            return response()->json(['status' => 'error', 'message' => 'Bid not found'], 404);
        } elseif ($request->pagename == 'reject_order') {

            $settings = Orders::find($request->selectorId);

            $settings->reject_order = $request->reason;
            $settings->status = 'cancelled';
            $settings->updated_at = Now();

            $settings->update();

            return response()->json([
                'status' => 'success',
                'message' => 'Order rejected successfully!'
            ]);

        } elseif ($request->pagename == 'noticeview') {

            $notices = Notices::find($request->selectorId);

            $output = '<strong>' . $notices ? $notices->notice_id . "</strong><br>" : '';
            $output .= $notices ? $notices->message : '';

            return $output;

        }
    }

    public function dbAction(Request $request)
    {

        if ($request->pagename == 'orders'):

            $orders = Orders::leftJoin('users', 'users.id', '=', 'orders.buyer_id')
                ->leftJoin('products', 'products.id', '=', 'orders.product_id')
                ->select(
                    'users.first_name as buyer_fname',
                    'users.last_name as buyer_lname',
                    'users.mob as buyer_mobile',
                    'users.email as buyer_email',
                    'products.name as proName',
                    'products.uom',
                    'orders.*'
                )
                ->where('orders.id', '=', $request->selectorId)
                ->first();

            $biddings = Biddings::leftJoin('users', 'users.id', '=', 'biddings.seller_id')
                ->leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
                ->select(
                    'users.first_name as seller_fname',
                    'users.last_name as seller_lname',
                    'users.mob as seller_mobile',
                    'users.email as seller_email',
                    'biddings.*'
                )
                ->where('orders.id', '=', $request->selectorId)
                ->get();

            if (!empty($orders->financial_year) && !empty($orders->fy_sequence)) {
                $formattedOrderId = $orders->financial_year . '-' . str_pad($orders->fy_sequence, 3, '0', STR_PAD_LEFT);
            } else {
                $month = date('m', strtotime($orders->created_at));
                if ($month >= 4) {
                    $fy_start = date('y', strtotime($orders->created_at));
                    $fy_end = date('y', strtotime('+1 year', strtotime($orders->created_at)));
                } else {
                    $fy_start = date('y', strtotime('-1 year', strtotime($orders->created_at)));
                    $fy_end = date('y', strtotime($orders->created_at));
                }
                $formattedOrderId = $fy_start . '' . $fy_end . '-' . str_pad($orders->id, 4, '0', STR_PAD_LEFT);
            }

            $data = '<table class="table table-bordered w-100">';
            $data .= '<tr><th colspan="2">Order Details</th></tr>';
            $data .= '<tr><th>Order Id:</th><td>' . $formattedOrderId . '</td></tr>';
            $data .= '<tr><th>Product:</th><td>' . $orders->proName . '</td></tr>';
            $data .= '<tr><th>Buyer:</th><td>' . $orders->buyer_fname . ' ' . $orders->buyer_lname . '</td></tr>';
            $data .= '<tr><th>Mobile:</th><td>' . $orders->buyer_mobile . '</td></tr>';
            $data .= '<tr><th>Email:</th><td>' . $orders->buyer_email . '</td></tr>';
            $data .= '<tr><th>Quantity:</th><td>' . $orders->quantity . ' ' . $orders->uom . '</td></tr>';
            $data .= '<tr><th>Delivery Location:</th><td>' . $orders->delivery_location . '</td></tr>';
            $data .= '<tr><th>Delivery Date:</th><td>' . $orders->delivery_date . '</td></tr>';
            $data .= '<tr><th>Specific Requirements:</th><td>' . $orders->specific_requirements . '</td></tr>';
            $data .= '<tr><th>Auction End:</th><td>' . $orders->auction_end . '</td></tr>';
            $data .= '</table>';

            if ($biddings->count() > 0) {
                $data .= '<h5 class="mt-4">Biddings</h5>';
                $data .= '<table class="table table-bordered w-100">';
                $data .= '<thead><tr><th>Seller</th><th>Mobile</th><th>Email</th><th>Price</th><th>Days</th><th>Temp</th><th>Status</th><th>Bid Time</th></tr></thead><tbody>';

                foreach ($biddings as $bid) {
                    $data .= '<tr>';
                    $data .= '<td>' . $bid->seller_fname . ' ' . $bid->seller_lname . '</td>';
                    $data .= '<td>' . $bid->seller_mobile . '</td>';
                    $data .= '<td>' . $bid->seller_email . '</td>';
                    $data .= '<td>Rs. ' . $bid->price . '</td>';
                    $data .= '<td>' . $bid->days . '</td>';
                    $data .= '<td>' . $bid->temp . '</td>';
                    if ($bid->status == 'selected') {
                        $data .= '<td class="badge bg-success text-white mt-1">' . $bid->status . '</td>';
                    } elseif ($bid->status == 'pending' && $orders->status == 'selected') {
                        $data .= '<td class="badge bg-secondary text-white mt-1 cursor-pointer transferOrder" data-bid-id="' . $bid->id . '">Transfer Order</td>';
                    } else {
                        $data .= '<td>' . $bid->status . '</td>';
                    }
                    $data .= '<td>' . $bid->created_at . '</td>';
                    $data .= '</tr>';
                }

                $data .= '</tbody></table>
                <script>
                    $(document).on("click", ".transferOrder", function() {
                        var selector = $(this);
                        var selectorId = selector.data("bid-id");
                        var pagename = "bidselected";
                    
                        $.ajax({
                            type: "get",
                            url: "/admin/dbaction",
                            data: { selectorId: selectorId, pagename: pagename },
                            success: function(response) {
                                location.reload();
                                if (response.status === "success") {
                                    //alert(response.message);
                                    //location.reload();
                                }
                                console.log(response);
                                // Optionally refresh table or show success message
                            }
                        });
                    });
                    </script>';
            } else {
                $data .= '<p>No biddings yet for this order.</p>';
            }

            return $data;

        elseif ($request->pagename == 'bidselected'):

            $bid = Biddings::find($request->selectorId);

            $selectedBiddings = Biddings::where('order_id', $bid->order_id)->get();

            foreach ($selectedBiddings as $selectedBidding):

                if ($selectedBidding->status == 'selected'):

                    $selectedBidding->status = 'transfered';
                    $selectedBidding->save();

                endif;

            endforeach;

            if ($bid) {

                $bid->status = 'selected';

                $order = Orders::find($bid->order_id);
                $order->status = 'selected';
                $order->save();

                $bid->save();

                // Get buyer info
                $buyer = User::find($order->buyer_id);

                if (!empty($order->financial_year) && !empty($order->fy_sequence)) {
                    $formattedOrderId = $order->financial_year . '-' . str_pad($order->fy_sequence, 3, '0', STR_PAD_LEFT);
                } else {
                    $month = date('m', strtotime($order->created_at));
                    if ($month >= 4) {
                        $fy_start = date('y', strtotime($order->created_at));
                        $fy_end = date('y', strtotime('+1 year', strtotime($order->created_at)));
                    } else {
                        $fy_start = date('y', strtotime('-1 year', strtotime($order->created_at)));
                        $fy_end = date('y', strtotime($order->created_at));
                    }
                    $formattedOrderId = $fy_start . '' . $fy_end . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
                }

                if ($buyer && $buyer->email) {
                    $details = [
                        'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
                        'order_id' => $formattedOrderId,
                    ];

                    $subject = "Your Selected Offer Has Been Received – Thank You for Choosing ImpurityX";
                    $template = "emails.offer_selected_notification";

                    Mail::to($buyer->email)->send(new MailModel($details, $subject, $template));
                }

                return response()->json(['status' => 'success', 'message' => 'Bid Selected Successfully']);
            }

            return response()->json(['status' => 'error', 'message' => 'Bid not found'], 404);

        elseif ($request->pagename == 'delorders'):

            $settings = Orders::where('id', $request->rowid)->delete();

            return "true";

        elseif ($request->pagename . $request->rowstatus == 'orderStatus1'):

            $settings = Orders::find($request->rowid);

            $settings->status = '1';
            $settings->updated_at = Now();

            $settings->update();

            return "activate";

        elseif ($request->pagename . $request->rowstatus == 'orderStatus2'):

            $settings = Orders::find($request->rowid);

            $settings->status = '2';
            $settings->updated_at = Now();

            $settings->update();

            return "deactivate";

        elseif ($request->pagename . $request->rowstatus == 'orderSellerView1'):

            $settings = Orders::find($request->rowid);

            $settings->bid_view_status = '1';
            $settings->updated_at = Now();

            $settings->update();

            return "activate";

        elseif ($request->pagename . $request->rowstatus == 'orderSellerView0'):

            $settings = Orders::find($request->rowid);

            $settings->bid_view_status = '0';
            $settings->updated_at = Now();

            $settings->update();

            return "deactivate";

        elseif ($request->pagename == 'delpostStatus'):

            $settings = Posts::where('id', $request->rowid)->delete();

            return "true";

        elseif ($request->pagename . $request->rowstatus == 'postStatus1'):

            $settings = Posts::find($request->rowid);

            $settings->status = '1';
            $settings->updated_at = Now();

            $settings->update();

            return "activate";

        elseif ($request->pagename . $request->rowstatus == 'postStatus2'):

            $settings = Posts::find($request->rowid);

            $settings->status = '2';
            $settings->updated_at = Now();

            $settings->update();

            return "deactivate";

        elseif ($request->pagename == 'delpostCategoryStatus'):

            $settings = Post_categories::where('id', $request->rowid)->delete();

            return "true";

        elseif ($request->pagename . $request->rowstatus == 'postCategoryStatus1'):

            $settings = Post_categories::find($request->rowid);

            $settings->status = '1';
            $settings->updated_at = Now();

            $settings->update();

            return "activate";

        elseif ($request->pagename . $request->rowstatus == 'postCategoryStatus2'):

            $settings = Post_categories::find($request->rowid);

            $settings->status = '2';
            $settings->updated_at = Now();

            $settings->update();

            return "deactivate";

        elseif ($request->pagename == 'delBidStatus'):

            $settings = Biddings::where('id', $request->rowid)->delete();

            return "true";

        elseif ($request->pagename == 'User'):

            //`company`, `trade`, `panno`, `vat`, `regAddress`, `comAddress`, `city`, `pincode`, `state`, `country`
            $users = User::leftJoin('usermetas', 'users.id', '=', 'usermetas.uid')
                ->where('users.id', '=', $request->selectorId)
                ->first();

            $data = '<table class="table table-bordered w-100">';
            $data .= '<tr><th>Name:</th><td>' . ($users->first_name ?? '') . ' ' . ($users->last_name ?? '') . '</td></tr>';
            $data .= '<tr><th>Mobile No.:</th><td>' . ($users->mob ?? '-') . '</td></tr>';
            $data .= '<tr><th>Email Id:</th><td>' . ($users->email ?? '-') . '</td></tr>';

            if (!empty($users->whatsapp)) {
                $data .= '<tr><th>Whatsapp No.:</th><td>' . $users->whatsapp . '</td></tr>';
            }
            if (!empty($users->company)) {
                $data .= '<tr><th>Company:</th><td>' . $users->company . '</td></tr>';
            }
            if (!empty($users->trade)) {
                $data .= '<tr><th>Trade:</th><td>' . $users->trade . '</td></tr>';
            }
            if (!empty($users->panno)) {
                $data .= '<tr><th>PAN No.:</th><td>' . $users->panno . '</td></tr>';
            }
            if (!empty($users->vat)) {
                $data .= '<tr><th>VAT:</th><td>' . $users->vat . '</td></tr>';
            }
            if (!empty($users->regAddress)) {
                $data .= '<tr><th>Registered Address:</th><td>' . $users->regAddress . '</td></tr>';
            }
            if (!empty($users->comAddress)) {
                $data .= '<tr><th>Communication Address:</th><td>' . $users->comAddress . '</td></tr>';
            }
            if (!empty($users->city)) {
                $data .= '<tr><th>City:</th><td>' . $users->city . '</td></tr>';
            }
            if (!empty($users->pincode)) {
                $data .= '<tr><th>Pincode:</th><td>' . $users->pincode . '</td></tr>';
            }
            if (!empty($users->state)) {
                $data .= '<tr><th>State:</th><td>' . $users->state . '</td></tr>';
            }
            if (!empty($users->country)) {
                $data .= '<tr><th>Country:</th><td>' . $users->country . '</td></tr>';
            }

            $data .= '</table>';

            return $data;


        elseif ($request->pagename == 'delUserStatus'):

            $getuser = User::where('id', $request->rowid)->first();

            if ($getuser && $getuser->role == '5') {
                $checkOrder = Orders::where('buyer_id', $request->rowid)->count();
                if ($checkOrder == 0) {
                    User::where('id', $request->rowid)->delete();
                    return "true";
                } else {
                    return "buyer_not_deleted";
                }
            } else {
                $checkBidding = Biddings::where('seller_id', $request->rowid)->count();
                if ($checkBidding == 0) {
                    User::where('id', $request->rowid)->delete();
                    return "true";
                } else {
                    return "seller_not_deleted";
                }
            }

            return "false";

        elseif ($request->pagename . $request->rowstatus == 'userStatus1'):

            $settings = User::find($request->rowid);

            $settings->status = '1';
            $settings->updated_at = Now();

            $settings->update();

            return "activate";

        elseif ($request->pagename . $request->rowstatus == 'userStatus2'):

            $settings = User::find($request->rowid);

            $settings->status = '2';
            $settings->updated_at = Now();

            $settings->update();

            return "deactivate";

        elseif ($request->pagename == 'delCategory'):

            $settings = Categories::where('id', $request->rowid)->delete();

            return "true";

        elseif ($request->pagename . $request->rowstatus == 'CategoryStatus1'):

            $settings = Categories::find($request->rowid);

            /*$settings->status = '1';
            $settings->updated_at = Now();

            $settings->update();*/

            if ($settings) {
                // Update category
                $settings->status = 1;
                $settings->updated_at = now();
                $settings->save();

                // Update related products
                Products::where('category', $request->rowid)
                    ->update([
                        'status' => 1,
                        'updated_at' => now(),
                    ]);
            }

            return "activate";

        elseif ($request->pagename . $request->rowstatus == 'CategoryStatus2'):

            $settings = Categories::find($request->rowid);

            /*$settings->status = '2';
            $settings->updated_at = Now();

            $settings->update();*/

            if ($settings) {
                // Update category
                $settings->status = 2;
                $settings->updated_at = now();
                $settings->save();

                // Update related products
                Products::where('category', $request->rowid)
                    ->update([
                        'status' => 2,
                        'updated_at' => now(),
                    ]);
            }

            return "deactivate";

        elseif ($request->pagename == 'productDelete'):

            $settings = Products::where('id', $request->rowid)->delete();

            return "true";

        elseif ($request->pagename . $request->rowstatus == 'productStatus1'):

            $settings = Products::find($request->rowid);

            $settings->status = '1';
            $settings->updated_at = Now();

            $settings->update();

            return "activate";

        elseif ($request->pagename . $request->rowstatus == 'productStatus2'):

            $settings = Products::find($request->rowid);

            $settings->status = '2';
            $settings->updated_at = Now();

            $settings->update();

            return "deactivate";

        elseif ($request->pagename == 'delpageStatus'):

            $settings = Pages::where('id', $request->rowid)->delete();

            return "true";

        elseif ($request->pagename . $request->rowstatus == 'pageStatus1'):

            $settings = Pages::find($request->rowid);

            $settings->status = '1';
            $settings->updated_at = Now();

            $settings->update();

            return "activate";

        elseif ($request->pagename . $request->rowstatus == 'pageStatus2'):

            $settings = Pages::find($request->rowid);

            $settings->status = '2';
            $settings->updated_at = Now();

            $settings->update();

            return "deactivate";

        elseif ($request->pagename == 'delSlider'):

            $settings = Sliders::where('id', $request->rowid)->delete();

            return "true";

        elseif ($request->pagename . $request->rowstatus == 'sliderStatus1'):

            $settings = Sliders::find($request->rowid);

            $settings->status = '1';
            $settings->updated_at = Now();

            $settings->update();

            return "activate";

        elseif ($request->pagename . $request->rowstatus == 'sliderStatus2'):

            $settings = Sliders::find($request->rowid);

            $settings->status = '2';
            $settings->updated_at = Now();

            $settings->update();

            return "deactivate";


        elseif ($request->pagename == 'delGallery'):

            $settings = Galleries::where('id', $request->rowid)->delete();

            return "true";

        elseif ($request->pagename . $request->rowstatus == 'galleryStatus1'):

            $settings = Galleries::find($request->rowid);

            $settings->status = '1';
            $settings->updated_at = Now();

            $settings->update();

            return "activate";

        elseif ($request->pagename . $request->rowstatus == 'galleryStatus2'):

            $settings = Galleries::find($request->rowid);

            $settings->status = '2';
            $settings->updated_at = Now();

            $settings->update();

            return "deactivate";

        elseif ($request->pagename == 'rnpo'):

            $getRnpo = Buyer_product_enquiries::leftJoin('products', 'buyer_product_enquiries.product_id', '=', 'products.id')
                ->leftJoin('orders', 'buyer_product_enquiries.order_id', '=', 'orders.id')
                ->select(
                    'buyer_product_enquiries.id as enquiry_id',
                    'buyer_product_enquiries.request_id',
                    'buyer_product_enquiries.status',
                    'buyer_product_enquiries.created_at',
                    'buyer_product_enquiries.updated_at',
                    'products.name',
                    'products.sku',
                    'products.cas_no',
                    'products.synonym',
                    'products.uom',
                    'products.purity',
                    'products.potency',
                    'products.impurity_type',
                    'products.des',
                    'orders.id as order_id',
                    'orders.quantity',
                    'orders.delivery_date',
                    'orders.delivery_location',
                    'orders.specific_requirements',
                    'orders.attachments',
                    'orders.status as order_status'
                )
                ->where('buyer_product_enquiries.id', $request->selectorId)
                ->orderBy('buyer_product_enquiries.id', 'desc')
                ->first();

            $data = '<div class="card p-0 border-0">';
            $data .= '<div class="card-body p-0" style="background-color: #f4f6f9; max-height: 450px; overflow-y: auto;">';

            $data .= '<table class="table table-bordered table-striped mb-0">';
            $data .= '<tbody>';

            $data .= '<tr><th width="30%">Request ID</th><td>#' . $getRnpo->request_id . '</td></tr>';

            if (!empty($getRnpo->name))
                $data .= '<tr><th>Product Name</th><td>' . $getRnpo->name . '</td></tr>';

            if (!empty($getRnpo->cas_no))
                $data .= '<tr><th>CAS Number</th><td>' . $getRnpo->cas_no . '</td></tr>';

            if (!empty($getRnpo->synonym))
                $data .= '<tr><th>Synonym</th><td>' . $getRnpo->synonym . '</td></tr>';

            if (!empty($getRnpo->impurity_type))
                $data .= '<tr><th>Type</th><td>' . ucfirst($getRnpo->impurity_type) . '</td></tr>';

            if (!empty($getRnpo->purity))
                $data .= '<tr><th>Purity</th><td>' . $getRnpo->purity . '%</td></tr>';

            if (!empty($getRnpo->potency))
                $data .= '<tr><th>Potency</th><td>' . $getRnpo->potency . '</td></tr>';

            if (!empty($getRnpo->des))
                $data .= '<tr><th>Description</th><td>' . $getRnpo->des . '</td></tr>';

            if (!empty($getRnpo->quantity))
                $data .= '<tr><th>Quantity</th><td>' . $getRnpo->quantity . ' ' . ($getRnpo->uom ?? '') . '</td></tr>';

            if (!empty($getRnpo->delivery_date))
                $data .= '<tr><th>Delivery Date</th><td>' . \Carbon\Carbon::parse($getRnpo->delivery_date)->format('d M Y') . '</td></tr>';

            if (!empty($getRnpo->delivery_location))
                $data .= '<tr><th>Delivery Location</th><td>' . $getRnpo->delivery_location . '</td></tr>';

            if (!empty($getRnpo->specific_requirements))
                $data .= '<tr><th>Specific Requirements</th><td>' . $getRnpo->specific_requirements . '</td></tr>';

            if (!empty($getRnpo->attachments)) {
                $files = json_decode($getRnpo->attachments, true);
                if ($files) {
                    $data .= '<tr><th>Attachments</th><td>';
                    foreach ($files as $file) {
                        $data .= '<a href="' . asset('/public/assets/frontend/img/products/files/' . $file) . '" class="btn btn-sm btn-dark border m-1" target="_blank">View File</a>';
                    }
                    $data .= '</td></tr>';
                }
            }

            $data .= '</tbody></table>';
            $data .= '</div>'; // card-body

            $data .= '<div class="card-footer bg-light text-center small text-muted">Last updated: '
                . ($getRnpo->updated_at ? \Carbon\Carbon::parse($getRnpo->updated_at)->format('d M Y, h:i A') : 'N/A')
                . '</div>';

            $data .= '</div>'; // card

            return $data;

        elseif (($request->pagename == 'csreply') || ($request->pagename == 'csAreply')):

            $communication = Communications::findOrFail($request->selectorId);

            if ($request->pagename == 'csreply') {
                $data = '<form action="/admin/supports" method="post">';
            } else {
                $data = '<form action="/admin/communication-sellers" method="post">';
            }

            $data .= csrf_field(); // Laravel CSRF token
            $data .= '<div class="form-group">';
            $data .= '    <input type="hidden" name="ruid" value="' . $request->selectorId . '" />';
            $data .= '</div>';

            $data .= '<div class="form-group">';
            $data .= '    <textarea class="form-control" name="rmsg" rows="5" placeholder="Write here your message..." required>' . ($communication->reply ?? '') . '</textarea>';
            $data .= '</div>';

            $data .= '<div class="form-group text-right">';
            $data .= '    <button type="submit" class="btn btn-primary">Submit</button>';
            $data .= '</div>';
            $data .= '</form>';

            return $data;

        elseif ($request->pagename == 'noticeview'):

            $notices = Notices::find($request->selectorId);

            $output = '<strong>' . $notices ? $notices->notice_id . "</strong><br>" : '';
            $output .= $notices ? $notices->message : '';

            return $output;


        elseif ($request->pagename == 'csupport'):

            $communications = Communications::find($request->selectorId);

            $output = $communications ? $communications->message : '';

            return $output;


        elseif ($request->pagename == 'cseller'):

            $communications = Communications::find($request->selectorId);

            $output = $communications ? '<strong>Impurity Name:</strong> ' . $communications->impurity_name . "<br>" : '';
            $output .= $communications ? $communications->message : '';

            return $output;


        endif;

    }

    public function getOrderEditDetails($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true, 'data' => $order]);
    }

    public function updateOrderDetails(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'quantity' => 'required|integer|min:1',
            'delivery_date' => 'required|date|after_or_equal:today',
            'delivery_location' => 'required|string|max:255',
            'specific_requirements' => 'nullable|string',
            'attachments.*' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
        ]);

        $order = Orders::find($validated['order_id']);

        //$uploadedFiles = json_decode($order->attachments ?? '[]', true);
        $uploadedFiles = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/frontend/img/products/files'), $fileName);
                    $uploadedFiles[] = 'assets/frontend/img/products/files/' . $fileName;
                }
            }
        }

        $order->update([
            'quantity' => $validated['quantity'],
            'delivery_date' => $validated['delivery_date'],
            'delivery_location' => $validated['delivery_location'],
            'specific_requirements' => $validated['specific_requirements'] ?? null,
            'attachments' => json_encode($uploadedFiles),
        ]);

        return redirect()->back()->with('success', 'Order details updated successfully.');
    }

    public function notices(Request $request)
    {

        $notices = Notices::orderBy('id', 'desc')->get();

        return view('backend.notices', ['notices' => $notices]);
    }

    public function manageNotice(Request $request)
    {

        if (!empty($request->id)) {
            $getNotice = Notices::where('id', $request->id)->first();
        }

        $noticeId = 'NOTICE-' . strtoupper(uniqid());

        return view('backend.manageNotice', ['noticeId' => $noticeId, 'getNotice' => ($getNotice ?? [])]);
    }

    public function manageNoticePost(Request $request)
    {

        $request->validate([
            'notice_id' => 'required',
            'type' => 'required',
            'message' => 'nullable|string',
        ]);

        $notice = new Notices();
        $notice->notice_id = $request->notice_id;
        $notice->message = $request->message;
        $notice->type = $request->type;
        $notice->status = "0";

        $notice->save();

        if ($request->type == 'sellers') {
            $users = User::where('role', '4')->where('status', '1')->get();
        } else {
            $users = User::where('role', '5')->where('status', '1')->get();
        }
        if ($users) {
            foreach ($users as $user) {
                $notify = json_decode(($user->notify ?? ''), true) ?? [];
                if (!is_array($notify)) {
                    $notify = [];
                }
                $notify['notice'] = 1;
                $user->notify = $notify;
                $user->save();
            }
        }

        return redirect()->back()->with('success', 'Notice Sent successfully!');

    }

    public function supports(Request $request)
    {

        if (!empty($request->id)) {
            $getCom = Communications::where('id', $request->id)->first();
        }

        $communications = Communications::leftJoin('users', 'communications.user_id', '=', 'users.id')
            ->leftJoin('users as sellers', 'communications.seller_id', '=', 'sellers.id')
            ->select('users.first_name', 'users.last_name', 'users.email', 'sellers.first_name as seller_fname', 'sellers.last_name as seller_lname', 'sellers.email as seller_email', 'communications.*')
            ->where('communications.type', '1')->orderBy('communications.id', 'desc')->get();

        $communicationId = 'COM-' . strtoupper(uniqid());

        return view('backend.supports', ['communications' => $communications, 'communicationId' => $communicationId, 'getCom' => ($getCom ?? [])]);
    }

    public function supportPost(Request $request)
    {

        $request->validate([
            'ruid' => 'required',
            'reply' => 'nullable|string',
        ]);

        $communication = Communications::findOrFail($request->ruid);

        $communication->reply = $request->rmsg;
        $communication->status = "closed";

        $communication->save();

        return redirect()->back()->with('success', 'Communication updated successfully!');

    }

    public function communicationSellers(Request $request)
    {

        if (!empty($request->id)) {
            $getCom = Communications::where('id', $request->id)->first();
        }

        $communications = Communications::leftJoin('users', 'communications.user_id', '=', 'users.id')
            ->leftJoin('users as sellers', 'communications.seller_id', '=', 'sellers.id')
            ->select('users.first_name', 'users.last_name', 'users.email', 'sellers.first_name as seller_fname', 'sellers.last_name as seller_lname', 'sellers.email as seller_email', 'communications.*')
            ->where('communications.type', '0')->orderBy('communications.id', 'desc')->get();

        //$communications = Buyer_product_enquiries::orderBy('id', 'desc')->get();

        $communicationId = 'CBS-' . strtoupper(uniqid());

        return view('backend.communicationSellers', ['communications' => $communications, 'communicationId' => $communicationId, 'getCom' => ($getCom ?? [])]);
    }

    public function manageCommunicationSellers(Request $request)
    {

        $getCom = Communications::where('id', $request->id)->first();

        if (!empty($request->p) && ($request->p == "buyer")) {
            $communicationId = 'CBS-' . strtoupper(uniqid());
        } else {
            $communicationId = 'CSB-' . strtoupper(uniqid());
        }

        return view('backend.manageCommunicationSellers', ['communicationId' => $communicationId, 'getCom' => ($getCom ?? [])]);

    }

    public function manageCommunicationSellersPost(Request $request)
    {

        $request->validate([
            'communicationId' => 'required|string',
            'orderNo' => 'required|string',
            'casNo' => 'nullable|string',
            'impurityName' => 'nullable|string',
            'message' => 'required|string',
        ]);

        // Generate Communication ID
        //$last = Communications::orderBy('id', 'desc')->first();

        $orderNo = $request->orderNo; // e.g. "2526-0014"
        $parts = explode('-', $orderNo); // Split by dash

        $orderId = (int) end($parts);

        $getBiddingDetails = Biddings::where('order_id', '=', $orderId)
            ->where('status', '=', 'awarded')->first();

        $getOrderDetails = Orders::where('id', '=', $orderId)->first();

        // Save to DB
        $comm = new Communications();
        $comm->communication_id = $request->communicationId;
        $comm->order_no = $request->orderNo;
        $comm->cas_no = $request->casNo;
        $comm->impurity_name = $request->impurityName;
        $comm->message = $request->message;
        $comm->user_id = $getOrderDetails->buyer_id;
        $comm->seller_id = $getBiddingDetails->seller_id;
        $comm->type = '0';
        $comm->save();

        return redirect()->back()->with('success', 'Message sent successfully!');

    }

    public function action()
    {

        if (Auth::user()->role == '11'):
            //`fid`, `type`, `purpose`, `remarks`,
            $settings = Settings::leftJoin('societies', 'settings.sid', '=', 'societies.id')
                ->select('societies.name', 'settings.*')->get();

        else:

            $settings = Settings::leftJoin('societies', 'settings.sid', '=', 'societies.id')
                ->select('societies.name', 'settings.*')
                ->where('settings.sid', '=', Auth::user()->sid)->get();

        endif;

        return view('backend.permissions', ['settings' => $settings]);
    }

    public function sliders()
    {

        $sliders = Sliders::get();

        return view('backend.sliders', ['sliders' => $sliders]);
    }

    public function manageSlider(Request $request)
    {

        $slider = Sliders::where('id', '=', $request->id)->get();

        return view('backend.manageSlider', ['slider' => $slider]);

    }

    public function manageSliderPost(Request $request)
    {

        if (empty($request->id)):

            $pages = new Sliders();
            $pages->branch = Auth::user()->branch ?? '1';
            $pages->title = $request->gallery_title ?? '';
            $pages->subtitle = $request->gallery_subtitle ?? '';
            $pages->link = $request->gallery_link ?? '';
            $pages->btntext = $request->gallery_btntext ?? '';

            if (!empty($request->file('gallery_imgs'))):

                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time() . "." . $request->gallery_imgs->extension();
                $request->gallery_imgs->move(public_path("assets/frontend/img/sliders"), $fileName);

            endif;

            $pages->imgs = $fileName ?? '';

            $pages->status = '1';

            $pages->save();

            return back()->with('success', 'Successfully Added!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        else:

            $pages = Sliders::find($request->id);

            $pages->branch = Auth::user()->branch ?? '1';
            $pages->title = $request->gallery_title ?? '';
            $pages->subtitle = $request->gallery_subtitle ?? '';
            $pages->link = $request->gallery_link ?? '';
            $pages->btntext = $request->gallery_btntext ?? '';

            if (!empty($request->file('gallery_imgs'))):

                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time() . "." . $request->gallery_imgs->extension();
                $request->gallery_imgs->move(public_path("assets/frontend/img/sliders"), $fileName);

                $pages->imgs = $fileName ?? '';

            endif;

            $pages->updated_at = Now();

            $pages->update();

            return back()->with('success', 'Successfully Updated!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        endif;
    }

    public function galleries()
    {

        $galleries = Galleries::get();

        return view('backend.gallery', ['galleries' => $galleries]);
    }

    public function manageGallery(Request $request)
    {

        $gallery = Galleries::where('id', '=', $request->id)->get();

        return view('backend.manageGallery', ['gallery' => $gallery]);

    }

    public function manageGalleryPost(Request $request)
    {

        if (empty($request->id)):

            $pages = new Galleries();
            $pages->branch = Auth::user()->branch ?? '1';
            $pages->title = $request->gallery_title ?? '';

            if (!empty($request->file('gallery_imgs'))):

                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time() . "." . $request->gallery_imgs->extension();
                $request->gallery_imgs->move(public_path("/assets/frontend/img/gallery"), $fileName);

            endif;

            $pages->imgs = $fileName ?? '';

            $pages->status = '1';

            $pages->save();

            return back()->with('success', 'Successfully Added!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        else:

            $pages = Galleries::find($request->id);

            $pages->branch = Auth::user()->branch ?? '1';
            $pages->title = $request->gallery_title ?? '';

            if (!empty($request->file('gallery_imgs'))):

                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time() . "." . $request->gallery_imgs->extension();
                $request->gallery_imgs->move(public_path("/assets/frontend/img/gallery"), $fileName);

            endif;

            $pages->imgs = $fileName ?? '';

            $pages->updated_at = Now();

            $pages->update();

            return back()->with('success', 'Successfully Updated!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        endif;
    }

    public function reviews()
    {

        $reviews = Reviews::get();

        return view('backend.reviews', ['reviews' => $reviews]);

    }

    public function manageReview(Request $request)
    {

        $reviews = Reviews::where('id', '=', $request->id)->get();

        return view('backend.manageReview', ['reviews' => $reviews]);

    }

    public function manageReviewPost(Request $request)
    {

        if (empty($request->id)):

            $pages = new Reviews();

            $pages->branch = Auth::user()->branch ?? '1';
            $pages->title = $request->review_title ?? '';
            $pages->rating = $request->review_star ?? '';
            $pages->name = $request->review_name ?? '';
            $pages->content = $request->review_content ?? '';

            if (!empty($request->file('review_file'))):

                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time() . "." . $request->review_file->extension();
                $request->review_file->move(public_path("/assets/frontend/img/testimonial"), $fileName);

            endif;

            $pages->imgs = $fileName ?? '';

            $pages->status = '1';

            $pages->save();

            return back()->with('success', 'Successfully Added!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        else:

            $pages = Reviews::find($request->id);

            $pages->branch = Auth::user()->branch ?? '1';
            $pages->title = $request->review_title ?? '';
            $pages->rating = $request->review_star ?? '';
            $pages->name = $request->review_name ?? '';
            $pages->content = $request->review_content ?? '';

            if (!empty($request->file('review_file'))):

                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time() . "." . $request->review_file->extension();
                $request->review_file->move(public_path("/assets/frontend/img/testimonial"), $fileName);

                $pages->imgs = $fileName ?? '';

            endif;

            $pages->updated_at = Now();

            $pages->update();

            return back()->with('success', 'Successfully Updated!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        endif;
    }

    public function postCategory()
    {

        $postCategory = Post_categories::get();

        return view('backend.postCategory', ['postCategory' => $postCategory]);

    }

    public function managePostCategory(Request $request)
    {

        $postCategory = Post_categories::where('id', '=', $request->id)->get();

        return view('backend.managePostCategory', ['postCategory' => $postCategory]);

    }

    public function managePostCategoryPost(Request $request)
    {

        function slog($string)
        {
            $string = str_replace(' ', '-', strtolower($string)); // Replaces all spaces with hyphens.

            return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        }

        if (empty($request->id)):

            $pages = new Post_categories();

            $pages->branch = Auth::user()->branch ?? '1';
            $pages->title = $request->postCategory_title ?? '';
            $pages->slog = slog($request->postCategory_title ?? '');

            if (!empty($request->file('postCategory_file'))):

                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time() . "." . $request->postCategory_file->extension();
                $request->postCategory_file->move(public_path("/assets/frontend/img/postCategory"), $fileName);

            endif;

            $pages->imgs = $fileName ?? '';

            $pages->status = '1';

            $pages->save();

            return back()->with('success', 'Successfully Added!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        else:

            $pages = Post_categories::find($request->id);

            $pages->branch = Auth::user()->branch ?? '1';
            $pages->title = $request->postCategory_title ?? '';
            $pages->slog = slog($request->postCategory_title ?? '');

            if (!empty($request->file('postCategory_file'))):

                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time() . "." . $request->postCategory_file->extension();
                $request->postCategory_file->move(public_path("/assets/frontend/img/postCategory"), $fileName);

                $pages->imgs = $fileName ?? '';

            endif;

            $pages->updated_at = Now();

            $pages->update();

            return back()->with('success', 'Successfully Updated!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        endif;
    }

    public function posts()
    {

        $posts = Posts::leftjoin('post_categories', 'posts.category', '=', 'post_categories.slog')
            ->select('post_categories.title as catetitle', 'posts.*')->get();

        return view('backend.posts', ['posts' => $posts]);

    }

    public function managePost(Request $request)
    {

        $post = Posts::where('id', '=', $request->id)->get();

        $postCategory = Post_categories::get();

        return view('backend.managePost', ['post' => $post, 'postCategory' => $postCategory]);

    }

    public function managePostPost(Request $request)
    {

        function slog($string)
        {
            $string = str_replace(' ', '-', strtolower($string)); // Replaces all spaces with hyphens.

            return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        }

        if (empty($request->id)):

            $pages = new Posts();

            $pages->branch = Auth::user()->branch ?? '1';
            $pages->title = $request->post_title ?? '';
            $pages->slog = slog($request->post_title ?? '');
            $pages->category = $request->post_category ?? '';
            $pages->content = $request->post_content ?? '';
            $pages->shortContent = $request->post_shortcontent ?? '';
            $pages->tags = $request->post_tags ?? '';
            $pages->author = $request->post_author ?? '';

            if (!empty($request->file('post_file'))):

                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time() . "." . $request->post_file->extension();
                $request->post_file->move(public_path("/assets/frontend/img/posts"), $fileName);

            endif;

            $pages->imgs = $fileName ?? '';

            $pages->status = '1';

            $pages->save();

            return back()->with('success', 'Successfully Added!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        else:

            $pages = Posts::find($request->id);

            $pages->branch = Auth::user()->branch ?? '1';
            $pages->title = $request->post_title ?? '';
            $pages->slog = slog($request->post_title ?? '');
            $pages->category = $request->post_category ?? '';
            $pages->content = $request->post_content ?? '';
            $pages->shortContent = $request->post_shortcontent ?? '';
            $pages->tags = $request->post_tags ?? '';
            $pages->author = $request->post_author ?? '';

            if (!empty($request->file('post_file'))):

                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time() . "." . $request->post_file->extension();
                $request->post_file->move(public_path("/assets/frontend/img/posts"), $fileName);

                $pages->imgs = $fileName ?? '';

            endif;

            $pages->updated_at = Now();

            $pages->update();

            return back()->with('success', 'Successfully Updated!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        endif;
    }

    public function pages()
    {

        $pages = Pages::get();

        return view('backend.pages', ['pages' => $pages]);
    }

    public function managePage(Request $request)
    {

        $pages = Pages::where('id', '=', $request->id)->get();

        return view('backend.managePage', ['pages' => $pages]);

    }

    public function managePagePost(Request $request)
    {

        if (empty($request->id)):

            $pages = new Pages();
            $pages->branch = Auth::user()->branch ?? '1';
            $pages->title = $request->page_title ?? '';
            $pages->content = $request->page_des ?? '';
            $pages->status = '1';

            $pages->save();

            return back()->with('success', 'Successfully Added!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        else:

            $pages = Pages::find($request->id);

            $pages->title = $request->page_title ?? '';
            $pages->content = $request->page_des ?? '';
            $pages->updated_at = Now();

            $pages->update();

            return back()->with('success', 'Successfully Updated!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        endif;
    }

    public function permissions()
    {

        $settings = Settings::get();

        return view('backend.permissions', ['settings' => $settings]);
    }

    public function managePermission(Request $request)
    {

        $settings = Settings::where('settings.id', '=', $request->id)->get();

        return view('backend.managePermission', ['settings' => $settings]);

    }

    public function managePermissionPost(Request $request)
    {

        $access = implode(',', $request->saccess) ?? '';
        $actions = implode(',', $request->sactions) ?? '';

        if (empty($request->id)):

            $settings = new Settings();
            $settings->branch = Auth::user()->branch ?? '';
            $settings->access = $access ?? '';
            $settings->actions = $actions ?? '';
            $settings->role = $request->srole ?? '';

            $settings->save();

            return back()->with('success', 'Successfully Added!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        else:

            $settings = Settings::find($request->id);

            $settings->access = $access ?? '';
            $settings->actions = $actions ?? '';
            $settings->role = $request->srole ?? '';
            $settings->updated_at = Now();

            $settings->update();

            return back()->with('success', 'Successfully Updated!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        endif;
    }

    public function manageProfile(Request $request)
    {

        $profiles = User::where('id', '=', Auth::user()->id)->get();

        return view('backend.manageProfile', ['profiles' => $profiles]);

    }

    public function manageProfilePost(Request $request)
    {

        $name = explode(' ', $request->mp_name);

        $pages = User::find(Auth::user()->id);

        $pages->first_name = $name[0] ?? '';
        $pages->last_name = $name[1] ?? '';
        $pages->mob = $request->mp_mob ?? '';
        $pages->email = $request->mp_email ?? '';

        $pages->update();

        return back()->with('success', 'Successfully Updated!!');

        return back()->with('error', 'Oops, Somethings went worng.');

    }

    public function managePassword(Request $request)
    {

        return view('backend.managePassword');

    }

    public function managePasswordPost(Request $request)
    {


        $user = User::find(Auth::user()->id);

        $user->password = Hash::make($request->repassword);

        $user->update();

        return back()->with('success', 'Successfully Updated!!');

        return back()->with('error', 'Oops, Somethings went worng.');

    }

}
