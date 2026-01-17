<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use App\Models\Buyer_product_enquiries;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function orders(Request $request)
    {

        /*$orders = Orders::leftjoin('products','orders.product_id','=','products.id')
            ->leftjoin('users','orders.buyer_id','=','users.id')
            ->select('products.name','products.sku','products.uom','users.first_name','users.last_name','users.email','orders.*')
            ->orderBy('orders.id', 'desc')
            ->get();*/

        $orders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
            ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->select(
                'products.name',
                'products.sku',
                'products.uom',
                'users.first_name',
                'users.last_name',
                'users.email',
                'orders.*',
                DB::raw("CASE WHEN biddings.id IS NULL THEN 'No Offer Recd' ELSE orders.status END as display_status")
            )
            ->distinct('orders.id')
            ->orderBy('orders.id', 'desc')
            ->get();

        return view('backend.orders', ['orders' => $orders]);

    }

    public function biddings(Request $request)
    {

        $biddings = Biddings::leftJoin('users', 'users.id', '=', 'biddings.seller_id')
            ->leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users as buyers', 'orders.buyer_id', '=', 'buyers.id')
            ->select(
                'users.first_name as seller_fname',
                'users.last_name as seller_lname',
                'users.mob as seller_mobile',
                'users.email as seller_email',
                'buyers.first_name as buyer_fname',
                'buyers.last_name as buyer_lname',
                'buyers.mob as buyer_mobile',
                'buyers.email as buyer_email',
                'products.name as proName',
                'products.sku',
                'products.uom',
                'orders.quantity',
                'orders.financial_year',
                'orders.fy_sequence',
                'orders.delivery_date',
                'orders.delivery_location',
                'orders.specific_requirements',
                'orders.attachments',
                'orders.auction_end',
                'orders.status as orderStatus',
                'biddings.*'
            )
            ->orderBy('biddings.id', 'desc')
            ->get();

        return view('backend.biddings', ['biddings' => $biddings]);

    }

    public function updateAuctionEnd(Request $request)
    {

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'auction_end' => 'required|date',
            'status' => 'required|in:pending,active,awarded,cancelled,closed',
        ]);

        $order = Orders::findOrFail($request->order_id);
        $order->auction_end = $request->auction_end;
        $order->status = $request->status;
        $order->save();

        // Update selected bid status
        $getBidding = Biddings::where('order_id', $order->id)->where('status', "selected")->first();
        if ($getBidding) {
            $getBidding->status = $order->status;
            $getBidding->save();
        }

        // Update Buyer Enquiry status
        $getBpe = Buyer_product_enquiries::where('order_id', $order->id)->first();
        if ($getBpe) {
            $getBpe->status = $order->status == 'active' ? 1 : 2;
            $getBpe->save();
        }

        $product = Products::find($order->product_id);

        if ($order->status == 'active') {
            // Buyer mail
            if ($order->buyer_id) {
                $buyer = User::find($order->buyer_id);
                if ($buyer && $buyer->email) {
                    $details = [
                        'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
                        'order_id' => (!empty($order->financial_year) && !empty($order->fy_sequence) ? $order->financial_year . '-' . str_pad($order->fy_sequence, 3, '0', STR_PAD_LEFT) : date('y') . '' . (date('y') + 1) . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT)),
                        'product_name' => $product->name ?? 'Product Name',
                        'activated_date' => now()->format('d M, Y h:i A'),
                        'expiry_date' => $order->auction_end ? date('d M, Y h:i A', strtotime($order->auction_end)) : 'N/A',
                    ];

                    Mail::to($buyer->email)->send(new MailModel($details, "Your Order is Now Live for Offers on ImpurityX", "emails.order_activated"));
                }
            }

            // Seller mails
            $sellers = User::where('role', '4')->where('status', '1')->get();
            foreach ($sellers as $seller) {
                if (!$seller->email)
                    continue;

                $details = [
                    'seller_name' => $seller->first_name . ' ' . $seller->last_name,
                    'order_id' => (!empty($order->financial_year) && !empty($order->fy_sequence) ? $order->financial_year . '-' . str_pad($order->fy_sequence, 3, '0', STR_PAD_LEFT) : date('y', strtotime($product->created_at)) . (date('y', strtotime($product->created_at)) + 1) . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT)),
                    'sku' => $product->sku ?? 'N/A',
                    'cas_no' => $product->cas_no ?? 'N/A',
                    'chemical_name' => $product->name,
                    'quantity' => $order->quantity,
                    'uom' => $product->uom ?? 'N/A',
                    'purity_spec' => $product->purity ?? 'N/A',
                    'potency_spec' => $product->potency ?? 'N/A',
                    'delivery_location' => $order->delivery_location,
                    'offer_deadline' => $order->auction_end ? date('d M, Y h:i A', strtotime($order->auction_end)) : 'N/A',
                ];

                Mail::to($seller->email)->send(new MailModel($details, "New Order Available – Submit Your Offer on ImpurityX", "emails.seller_order_activated"));
            }
        }

        // if ($order->status == 'awarded' && $getBidding) {
        //     $buyer = User::find($order->buyer_id);

        //     $seller = User::leftJoin('usermetas','users.id','=','usermetas.uid')
        //         ->where('users.id',$getBidding->seller_id)
        //         ->select('users.*','usermetas.company','usermetas.comAddress','usermetas.city','usermetas.pincode','usermetas.state','usermetas.country')
        //         ->first();

        //     if ($buyer && $buyer->email && $seller) {
        //         $details = [
        //             'buyer_name'    => $buyer->first_name . ' ' . $buyer->last_name,
        //             'order_id'      => date('y').''.(date('y')+1) .'-'. str_pad($order->id, 4, '0', STR_PAD_LEFT),
        //             'seller_company'=> $seller->company ?? 'N/A',
        //             'seller_name'   => $seller->first_name . ' ' . $seller->last_name,
        //             'seller_email'  => $seller->email,
        //             'seller_phone'  => $seller->mob ?? $seller->whatsapp ?? 'N/A',
        //             'seller_address'=> implode(', ', array_filter([
        //                 $seller->comAddress,
        //                 $seller->city,
        //                 $seller->pincode,
        //                 $seller->state,
        //                 $seller->country
        //             ])) ?: 'N/A',
        //         ];

        //         Mail::to($buyer->email)->send(new MailModel($details, "Your Selected Offer Has Been Approved – Thank You for Choosing ImpurityX", "emails.offer_admin_approved_notification"));
        //     }
        // }

        if ($order->status == 'awarded' && $getBidding) {

            $buyer = User::leftJoin('usermetas', 'users.id', '=', 'usermetas.uid')
                ->where('users.id', $order->buyer_id)
                ->select('users.*', 'usermetas.company', 'usermetas.comAddress', 'usermetas.city', 'usermetas.pincode', 'usermetas.state', 'usermetas.country')
                ->first();

            $seller = User::leftJoin('usermetas', 'users.id', '=', 'usermetas.uid')
                ->where('users.id', $getBidding->seller_id)
                ->select('users.*', 'usermetas.company', 'usermetas.comAddress', 'usermetas.city', 'usermetas.pincode', 'usermetas.state', 'usermetas.country')
                ->first();

            /** -------------------------
             * Buyer Notification
             * ------------------------- */
            if ($buyer && $buyer->email && $seller) {
                $details = [
                    'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
                    'order_id' => (!empty($order->financial_year) && !empty($order->fy_sequence) ? $order->financial_year . '-' . str_pad($order->fy_sequence, 3, '0', STR_PAD_LEFT) : date('y', strtotime($order->created_at)) . (date('y', strtotime($order->created_at)) + 1) . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT)),
                    'proName' => $seller->proName ?? '',
                    'sku' => $order->sku ?? '',
                    'cas_no' => $order->cas_no ?? '',
                    'quantity' => $order->quantity ?? '',
                    'delivery_location' => $order->delivery_location ?? '',
                    'delivery_date' => $order->delivery_date ?? '',
                    'specific_requirements' => $order->specific_requirements ?? '',
                    'seller_company' => $seller->company ?? '',
                    'seller_name' => $seller->first_name . ' ' . $seller->last_name,
                    'seller_email' => $seller->email,
                    'seller_phone' => $seller->mob ?? $seller->whatsapp ?? 'N/A',
                    'seller_address' => implode(', ', array_filter([
                        $seller->comAddress,
                        $seller->city,
                        $seller->pincode,
                        $seller->state,
                        $seller->country
                    ])) ?: 'N/A',
                ];

                Mail::to($buyer->email)->send(new MailModel($details, "Your Selected Offer Has Been Approved – Thank You for Choosing ImpurityX", "emails.offer_admin_approved_notification"));
            }

            /** -------------------------
             * Seller Notification
             * ------------------------- */
            if ($seller && $seller->email && $buyer) {
                $details = [
                    'seller_name' => $seller->first_name . ' ' . $seller->last_name,
                    'order_id' => (!empty($order->financial_year) && !empty($order->fy_sequence) ? $order->financial_year . '-' . str_pad($order->fy_sequence, 3, '0', STR_PAD_LEFT) : date('y', strtotime($order->created_at)) . (date('y', strtotime($order->created_at)) + 1) . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT)),
                    'proName' => $seller->proName ?? '',
                    'sku' => $order->sku ?? '',
                    'cas_no' => $order->cas_no ?? '',
                    'quantity' => $order->quantity ?? '',
                    'delivery_location' => $order->delivery_location ?? '',
                    'delivery_date' => $order->delivery_date ?? '',
                    'specific_requirements' => $order->specific_requirements ?? '',
                    'buyer_name' => $buyer->company ?? ($buyer->first_name . ' ' . $buyer->last_name),
                    'contact_name' => $buyer->first_name . ' ' . $buyer->last_name,
                    'buyer_email' => $buyer->email,
                    'buyer_phone' => $buyer->mob ?? $buyer->whatsapp ?? 'N/A',
                    'delivery_location' => $order->delivery_location ?? ($buyer->city ?? 'N/A'),
                ];

                $subject = "Congratulations! Your Offer Has Been Awarded on ImpurityX";
                $template = "emails.offer_awarded_to_seller";

                Mail::to($seller->email)->send(new MailModel($details, $subject, $template));
            }
        }

        if ($order->status == 'awarded') {
            return redirect()->back()->with('success', 'Order awarded successfully');
        } else {
            return redirect()->back()->with('success', 'Successfully Updated');
        }
    }

    public function exportOrderMaster(Request $request)
    {
        $now = Carbon::now();

        // Base query
        $query = DB::table('orders')
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users as buyers', 'orders.buyer_id', '=', 'buyers.id')
            ->leftJoin('usermetas as buyer_metas', 'buyers.id', '=', 'buyer_metas.uid')
            ->select(
                'orders.id',
                'orders.product_id',
                'orders.financial_year',
                'orders.fy_sequence',
                'orders.buyer_id',
                'orders.quantity',
                'orders.specific_requirements',
                'orders.delivery_date',
                'orders.delivery_location',
                'orders.auction_end',
                'orders.status',
                'orders.seller_status',
                'orders.attachments',
                'orders.created_at as order_created',
                'products.name as product_name',
                'products.sku as product_sku',
                'products.cas_no as product_cas',
                'products.uom',
                'buyers.first_name as buyer_fname',
                'buyers.last_name as buyer_lname',
                'buyers.email as buyer_email',
                'buyers.mob as buyer_mobile',
                'buyer_metas.company as buyer_company',
                'buyer_metas.city as buyer_city',
                'buyer_metas.state as buyer_state',
                'buyer_metas.country as buyer_country'
            );

        // Date filter
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('orders.created_at', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay()
            ]);
        }

        // Status filter
        if ($request->status && $request->status != 'all') {
            $query->where('orders.status', $request->status);
        }

        $orders = $query->get();

        // CSV setup
        $filename = "order_master_" . $now->format('Ymd_His') . ".csv";
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=$filename");

        $handle = fopen('php://output', 'w');

        // CSV headers
        $headers = [
            'Sr No',
            'Order ID',
            'Product Name',
            'SKU',
            'CAS No',
            'Quantity',
            'UOM',
            'Specific Requirements',
            'Delivery Date',
            'Delivery Location',
            'Auction End',
            'Status',
            'Seller Status',
            'Attachments',
            'Buyer Name',
            'Buyer Email',
            'Buyer Mobile',
            'Company',
            'City',
            'State',
            'Country',
            'Created At'
        ];
        fputcsv($handle, $headers);

        foreach ($orders as $k => $order) {
            $attachmentsList = 'N/A';
            if (!empty($order->attachments) && $request->with_attachments === 'yes') {
                $attachments = json_decode($order->attachments, true);
                if ($attachments) {
                    $attachmentsList = implode(", ", array_map(fn($f) => asset('public/' . $f), $attachments));
                }
            }

            $row = [
                $k + 1,
                (!empty($order->financial_year) && !empty($order->fy_sequence) ? $order->financial_year . '-' . str_pad($order->fy_sequence, 3, '0', STR_PAD_LEFT) : date('y', strtotime($order->created_at)) . (date('y', strtotime($order->created_at)) + 1) . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT)),
                $order->product_name ?? 'N/A',
                $order->product_sku ?? 'N/A',
                $order->product_cas ?? 'N/A',
                $order->quantity ?? 0,
                $order->uom ?? '',
                $order->specific_requirements ?? '',
                $order->delivery_date ? Carbon::parse($order->delivery_date)->format('d M, Y') : 'N/A',
                $order->delivery_location ?? '',
                $order->auction_end ? Carbon::parse($order->auction_end)->format('d M, Y H:i') : '--',
                ucfirst($order->status),
                ucfirst($order->seller_status),
                $attachmentsList,
                $order->buyer_fname . ' ' . $order->buyer_lname,
                $order->buyer_email,
                $order->buyer_mobile,
                $order->buyer_company,
                $order->buyer_city,
                $order->buyer_state,
                $order->buyer_country,
                Carbon::parse($order->order_created)->format('d M, Y H:i')
            ];

            fputcsv($handle, $row);
        }

        fclose($handle);
        exit;
    }

    public function exportSellerBiddings(Request $request)
    {
        $now = Carbon::now();
        $user = auth()->user();

        // Base query: get seller's biddings with order & product info
        $biddings = DB::table('biddings')
            ->leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users as buyers', function ($join) {
                $join->on('orders.buyer_id', '=', 'buyers.id')
                    ->where('buyers.role', 5); // ensure only buyers
            })
            ->leftJoin('users as sellers', function ($join) {
                $join->on('biddings.seller_id', '=', 'sellers.id')
                    ->where('sellers.role', 4); // ensure only sellers
            })
            ->select(
                'biddings.id as bidding_id',
                'biddings.order_id',
                'orders.financial_year',
                'orders.fy_sequence',
                'biddings.price',
                'biddings.days',
                'biddings.status as bidding_status',
                'biddings.created_at as bidding_created',
                'orders.quantity as order_quantity',
                'orders.delivery_date',
                'orders.delivery_location',
                'orders.auction_end',
                'orders.status as order_status',
                'products.name as product_name',
                'products.sku as product_sku',
                'products.cas_no as product_cas',
                'buyers.first_name as buyer_fname',
                'buyers.last_name as buyer_lname',
                'buyers.email as buyer_email',
                'buyers.mob as buyer_mobile',
                'sellers.first_name as seller_fname',
                'sellers.last_name as seller_lname',
                'sellers.email as seller_email',
                'sellers.mob as seller_mobile'
            );

        // Restrict by role
        if ($user->role == 4) {
            // Seller → only their own biddings
            $biddings->where('biddings.seller_id', $user->id);
        } elseif ($user->role == 5) {
            // Buyer → not allowed
            return back()->with('error', 'You are not allowed to export seller biddings.');
        } else {
            // Admin → see all
            // no filter
        }

        // Date filter (optional)
        if ($request->from_date && $request->to_date) {
            $biddings->whereBetween('biddings.created_at', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay()
            ]);
        }

        $biddings = $biddings->get();

        if ($biddings->isEmpty()) {
            return back()->with('error', 'No biddings found for the given filters.');
        }

        // CSV setup
        $filename = "seller_biddings_" . $now->format('Ymd_His') . ".csv";
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=$filename");

        $handle = fopen('php://output', 'w');

        // CSV headers
        $headers = [
            'Sr No',
            'Bidding ID',
            'Order ID',
            'Product Name',
            'SKU',
            'CAS No',
            'Quantity',
            'Bid Price',
            'Bid Days',
            'Bidding Status',
            'Order Status',
            'Delivery Date',
            'Delivery Location',
            'Auction End',
            'Buyer Name',
            'Buyer Email',
            'Buyer Mobile',
            'Seller Name',
            'Seller Email',
            'Seller Mobile',
            'Created At'
        ];
        fputcsv($handle, $headers);

        foreach ($biddings as $k => $b) {
            if ($b->bidding_status == 'awarded') {
                $status = ucfirst($b->order_status);
            } else {
                $status = "--";
            }
            $row = [
                $k + 1,
                $b->bidding_id,
                (!empty($b->financial_year) && !empty($b->fy_sequence) ? $b->financial_year . '-' . str_pad($b->fy_sequence, 3, '0', STR_PAD_LEFT) : date('y', strtotime($b->created_at)) . (date('y', strtotime($b->created_at)) + 1) . '-' . str_pad($b->order_id, 4, '0', STR_PAD_LEFT)),
                $b->product_name ?? 'N/A',
                $b->product_sku ?? 'N/A',
                $b->product_cas ?? 'N/A',
                $b->order_quantity ?? 0,
                $b->price ?? 'N/A',
                $b->days ?? 'N/A',
                ucfirst($b->bidding_status),
                $status,
                $b->delivery_date ? Carbon::parse($b->delivery_date)->format('d M, Y') : 'N/A',
                $b->delivery_location ?? '',
                $b->auction_end ? Carbon::parse($b->auction_end)->format('d M, Y H:i') : '--',
                trim($b->buyer_fname . ' ' . $b->buyer_lname),
                $b->buyer_email,
                $b->buyer_mobile,
                trim($b->seller_fname . ' ' . $b->seller_lname),
                $b->seller_email,
                $b->seller_mobile,
                Carbon::parse($b->bidding_created)->format('d M, Y H:i')
            ];

            fputcsv($handle, $row);
        }

        fclose($handle);
        exit;
    }

}