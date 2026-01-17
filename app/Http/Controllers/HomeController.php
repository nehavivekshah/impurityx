<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
use App\Models\Buyer_product_enquiries;

class HomeController extends Controller
{
    public function home()
    {
        // Basic counts
        // $totalOrders = Orders::count();
        // $totalPendingOrders = Orders::whereIn('status', ['requested', 'pending'])->count();
        // $totalStartedOrders = Orders::whereIn('status', ['active', 'selected', 'cancelled'])->count();

        // $totalCompleteOrders = Orders::where('seller_status','accepted')->count();
        
        // $totalBiddings = Biddings::count();

        // $totalPosts = Posts::count();
        // $totalActivePosts = Posts::where('status', '1')->count();

        // $totalProducts = Products::count();
        // $totalActiveProducts = Products::where('status', '1')->count();

        // $totalUsers = User::count();
        // $totalSellers = User::where('role', '4')->count();
        // $totalActiveSellers = User::where('role', '4')->where('status', '1')->count();
        // $totalBuyers = User::where('role', '5')->count();
        // $totalActiveBuyers = User::where('role', '5')->where('status', '1')->count();

        // // Past 6 months labels (e.g., Jan, Feb, Mar...)
        // $months = collect(range(5, 0))->map(fn($i) => Carbon::now()->subMonths($i)->format('M'));

        // // Get buyer orders count grouped by month (numeric month)
        // $buyerOrders = Orders::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        //     ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
        //     ->groupBy('month')
        //     ->pluck('count', 'month');

        // // Get seller biddings count grouped by month (numeric month)
        // $sellerBiddings = Biddings::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        //     ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
        //     ->groupBy('month')
        //     ->pluck('count', 'month');

        // // Convert collections to arrays for lookup
        // $buyerOrdersArray = $buyerOrders->toArray();
        // $sellerBiddingsArray = $sellerBiddings->toArray();

        // // Build chart data for Blade
        // $orderStats = [
        //     'labels' => $months->toArray(),
        //     'buyerOrders' => $months->map(function ($label, $i) use ($buyerOrdersArray) {
        //         $monthNum = Carbon::now()->subMonths(5 - $i)->format('n');
        //         return (int) ($buyerOrdersArray[$monthNum] ?? 0);
        //     })->toArray(),
        //     'sellerBiddings' => $months->map(function ($label, $i) use ($sellerBiddingsArray) {
        //         $monthNum = Carbon::now()->subMonths(5 - $i)->format('n');
        //         return (int) ($sellerBiddingsArray[$monthNum] ?? 0);
        //     })->toArray(),
        // ];

        // // Dummy income/spending values (you can replace with real calculations)
        // $incomePercent = $totalCompleteOrders > 0
        //     ? round(($totalOrders * $totalCompleteOrders) / 100)
        //     : 0;
        // $spendingPercent = $totalPendingOrders > 0
        //     ? round((($totalStartedOrders+$totalPendingOrders) * $totalStartedOrders) / 100)
        //     : 0;
    
        $AdminNotActiveBidsCount = Orders::where('orders.status', 'pending')->count();
        
        $AdminPendingBidsCount = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('biddings.status', 'selected')
            ->where('orders.status', 'selected')
            ->count();
        
        $newBuyersCount = User::where('role', '5')->where('status', '0')->count();
    
        $newSellersCount = User::where('role', '4')->where('status', '0')->count();
    
        $AdminInterMailCount = Orders::whereIn('seller_status', ['order-initiated','order-task-completed','delivery-initiated','delivery-completed','accepted'])
            ->where('orders.status','!=','closed')->count();
            
        $nowdate = now();
    
        $myActiveBidsCount = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('biddings.status', 'pending')
            ->where('orders.status', 'active')
            ->where('orders.auction_end', '>', $nowdate)
            ->count();
            
        $myNonActiveBidsCount = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('biddings.status', 'pending')
            ->where('orders.status', 'active')
            ->where('orders.auction_end', '<', $nowdate)
            ->count();
    
        $myAPBidsCount = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.status', 'active')
            ->where('biddings.status', 'pending')
            ->where('orders.auction_end', '>', $nowdate)
            ->count();
            
        $myBuyerActiveCount = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.status', '=', 'active')
            ->groupBy('orders.buyer_id')
            ->count();
            
        $mySellerActiveCount = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.status', '=', 'active')
            ->groupBy('biddings.seller_id')
            ->count();

        $myActiveBids = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.status', '=', 'active')
            ->where('orders.auction_end', '>', $nowdate)
            ->selectRaw('COUNT(biddings.id) as total_bids, SUM(biddings.price) as total_amount')
            ->first();
        
        $myABBidsCount = $myActiveBids->total_bids ?? 0;
        $myABBidsAmount = $myActiveBids->total_amount ?? 0;

        $myAABids = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.status', 'selected')
            ->selectRaw('COUNT(biddings.id) as total_bids, SUM(biddings.price) as total_amount')
            ->first();
        
        $myAABidsCount = $myAABids->total_bids ?? 0;
        $myAABidsAmount = $myAABids->total_amount ?? 0;
        
        $now = Carbon::now();
        
        // MTD: 1st of current month → today
        $mtdStart = $now->copy()->startOfMonth();
        
        // YTD: Start of Indian financial year
        $ytdStart = $now->month >= 4
            ? Carbon::create($now->year, 4, 1)           // Current year 1 April
            : Carbon::create($now->year - 1, 4, 1);      // Previous year 1 April
        
        // CTD: From beginning → today (no date filter)
        $ctdStart = null;
        
        $mtd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('biddings.status', 'awarded')
            ->whereDate('biddings.created_at', '>=', $mtdStart)
            ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $ytd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('biddings.status', 'awarded')
            ->whereDate('biddings.created_at', '>=', $ytdStart)
            ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $ctd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('biddings.status', 'awarded')
            ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        // Final Values
        // $mtdCount = $mtd->count ?? 0;
        // $ytdCount = $ytd->count ?? 0;
        // $ctdCount = $ctd->count ?? 0;
        
        // $mtdAmount = $mtd->amount ?? 0;
        // $ytdAmount = $ytd->amount ?? 0;
        // $ctdAmount = $ctd->amount ?? 0;
        
        $oCmtd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', 'accepted')
            ->whereDate('biddings.created_at', '>=', $mtdStart)
            ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $oCytd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', 'accepted')
            ->whereDate('biddings.created_at', '>=', $ytdStart)
            ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $oCctd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', 'accepted')
            ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
            ->first();
            
        $wipOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'order-initiated')
            ->where('orders.status', 'awarded')
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $wipOrdercount = $wipOrder->count ?? 0;
        $wipOrderAmt = $wipOrder->amount ?? 0;
            
        $otcOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'delivery-initiated')
            ->where('biddings.status', 'awarded')
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $otcOrdercount = $otcOrder->count ?? 0;
        $otcOrderAmt = $otcOrder->amount ?? 0;
        
        $diOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'delivery-completed')
            ->where('biddings.status', 'awarded')
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $diOrdercount = $diOrder->count ?? 0;
        $diOrderAmt = $diOrder->amount ?? 0;
        
        $completeOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'delivery-completed')
            ->where('biddings.status', 'awarded')
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $completeOrdercount = $completeOrder->count ?? 0;
        $completeOrderAmt = $completeOrder->amount ?? 0;

        $acceptOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'accepted')
            ->where('biddings.status', 'awarded')
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $acceptOrdercount = $acceptOrder->count ?? 0;
        $acceptOrderAmt = $acceptOrder->amount ?? 0;
        
        $wiplOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'order-initiated')
            ->where('biddings.status', 'awarded')
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $wiplOrdercount = $wiplOrder->count ?? 0;
        $wiplOrderAmt = $wiplOrder->amount ?? 0;
        
        /*$dilOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'delivery-initiated')
            ->where('biddings.status', 'awarded')
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();*/
            
        $dilOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', 'order-initiated')
            ->where('biddings.status', 'awarded')
            ->whereRaw("
                DATE_ADD(biddings.updated_at, INTERVAL biddings.days DAY) >= ?
            ", [now()])
            ->selectRaw('
                COUNT(DISTINCT orders.id) as count,
                SUM(biddings.price) as amount
            ')
            ->first();
        
        $dilOrdercount = $dilOrder->count ?? 0;
        $dilOrderAmt = $dilOrder->amount ?? 0;
        
        $completelOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'delivery-completed')
            ->where('biddings.status', 'awarded')
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $completelOrdercount = $completelOrder->count ?? 0;
        $completelOrderAmt = $completelOrder->amount ?? 0;
        
        $nprCount  = Buyer_product_enquiries::where('status', 0)->count();
        
        $totalBuyersCount = User::where('role', '5')->count();
    
        $totalSellersCount = User::where('role', '4')->count();
        
        $totalActiveBuyersCount = User::where('role', '5')->where('status', '1')->count();
    
        $totalActiveSellersCount = User::where('role', '4')->where('status', '1')->count();

        return view('backend.home', 
        [//'pending_orders'=>$Order_initiated,'orderTaskCompleted'=>$orderTaskCompleted,'DeliveryInitiated'=>$DeliveryInitiated,'DeliveryCompleted'=>$DeliveryCompleted,
            'AdminInterMailCount' => $AdminInterMailCount,
            'AdminNotActiveBidsCount' => $AdminNotActiveBidsCount,
            'AdminPendingBidsCount' => $AdminPendingBidsCount,
            'nprCount' => $nprCount,
            'newBuyersCount' => $newBuyersCount,
            'newSellersCount' => $newSellersCount,
            'totalBuyersCount' => $totalBuyersCount,
            'totalSellersCount' => $totalSellersCount,
            'totalActiveBuyersCount' => $totalActiveBuyersCount,
            'totalActiveSellersCount' => $totalActiveSellersCount,
            'myBuyerActiveCount'   => $myBuyerActiveCount,
            'mySellerActiveCount'   => $mySellerActiveCount,
            
            'myActiveBidsCount'   => $myActiveBidsCount,
            'myNonActiveBidsCount'   => $myNonActiveBidsCount,
            'myAPBidsCount'   => $myAPBidsCount,
            'myABBidsCount'   => $myABBidsCount,
            'myABBidsAmount'   => $myABBidsAmount,
            'myAABidsCount'   => $myAABidsCount,
            'myAABidsAmount'   => $myAABidsAmount,
            'mtd'   => $mtd,
            'ytd'   => $ytd,
            'ctd'   => $ctd,
            'oCmtd'   => $oCmtd,
            'oCytd'   => $oCytd,
            'oCctd'   => $oCctd,
            'wipOrdercount' => $wipOrdercount,
            'wipOrderAmt' => $wipOrderAmt,
            'otcOrdercount' => $otcOrdercount,
            'otcOrderAmt' => $otcOrderAmt,
            'diOrdercount' => $diOrdercount,
            'diOrderAmt' => $diOrderAmt,
            'completeOrdercount' => $completeOrdercount,
            'completeOrderAmt' => $completeOrderAmt,
            'acceptOrdercount' => $acceptOrdercount,
            'acceptOrderAmt' => $acceptOrderAmt,
            'wiplOrdercount' => $wiplOrdercount,
            'wiplOrderAmt' => $wiplOrderAmt,
            'dilOrdercount' => $dilOrdercount,
            'dilOrderAmt' => $dilOrderAmt,
            'completelOrdercount' => $completelOrdercount,
            'completelOrderAmt' => $completelOrderAmt
        ]);
        // compact(
        //     'totalOrders',
        //     'totalBiddings',
        //     'totalPosts',
        //     'totalActivePosts',
        //     'totalProducts',
        //     'totalActiveProducts',
        //     'totalSellers',
        //     'totalActiveSellers',
        //     'totalBuyers',
        //     'totalActiveBuyers',
        //     'totalUsers',
        //     'orderStats',
        //     'incomePercent',
        //     'spendingPercent'
        // )
    }
}
