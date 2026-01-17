<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Orders;
use App\Models\User;
use App\Mail\MailModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CheckExpiredBids
{
    public function handle($request, Closure $next)
    {
        // Get expired "open" orders
        $expiredOrders = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->select(
                'orders.id as order_id',
                'orders.buyer_id',
                'orders.auction_end',
                DB::raw('COUNT(biddings.id) as total_bids')
            )
            ->where('orders.status', 'active')
            ->where('orders.auction_end', '<', now())
            ->groupBy('orders.id', 'orders.buyer_id', 'orders.auction_end')
            ->get();

        foreach ($expiredOrders as $order) {
            $buyer = User::find($order->buyer_id);

            if (!$buyer || !$buyer->email) {
                continue; // skip if no valid buyer email
            }

            if ($order->total_bids > 0) {
                // Case 1: Offers exist
                $details = [
                    'buyer_name'  => $buyer->first_name . ' ' . $buyer->last_name,
                    'order_id'    => $order->order_id,
                    'auction_end' => date('d M, Y H:i', strtotime($order->auction_end)),
                ];

                $subject  = "Offer Submission Window Closed – Select the Best Offer for Your Order on ImpurityX";
                $template = "emails.offer_selection_notification";

            } else {
                // Case 2: No offers
                $details = [
                    'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
                    'order_id'   => $order->order_id,
                ];

                $subject  = "We apologize - No Offers Received for Your Order #{$order->order_id}";
                $template = "emails.no_offers_notification";
            }

            // Send email
            //Mail::to($buyer->email)->send(new MailModel($details, $subject, $template));
            // try {
            //     Mail::to($buyer->email)->send(new MailModel($details, $subject, $template));
            // } catch (\Exception $e) {
            //     if (str_contains($e->getMessage(), '550 User support@impurityx.com has exceeded')) {
            //         // Skip sending, maybe log it
            //         \Log::warning("Skipped email to {$buyer->email} due to quota limit.");
            //     } else {
            //         throw $e; // rethrow other errors
            //     }
            // }

            // Mark expired
            //Orders::where('id', $order->order_id)->update(['status' => 'expired']);
        }

        return $next($request);
    }
}
