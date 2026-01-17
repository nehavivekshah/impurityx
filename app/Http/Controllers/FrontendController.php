<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\MailModel;
use App\Models\Branches;
use App\Models\User;
use App\Models\Seller;
use App\Models\Usermetas;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Sliders;
use App\Models\Galleries;
use App\Models\Contacts;
use App\Models\Enquiries;
use App\Models\Pages;
use App\Models\Orders;
use App\Models\Biddings;
use App\Models\Reviews;
use App\Models\Posts;
use App\Models\Post_categories;
use App\Models\Communications;
use App\Models\Notices;
use App\Models\Buyer_product_enquiries;

use Carbon\Carbon;

class FrontendController extends Controller
{
    public function index() {
        // Fetch only the first "Home" page (no need for get() unless expecting multiple)
        $output = Pages::where('title', 'Home')
            ->where('status', 1)
            ->first();
    
        // Get active sliders
        $sliders = Sliders::where('status', 1)->get();
    
        // Get all active categories
        $categories = Categories::where('type', 2)->where('status', 1)->get();
    
        // Get latest 'new' products
        $products = Products::where('new', 1)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();
    
        // Get latest 'featured' products
        $featuredProducts = Products::where('featured', 1)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

    
        return view('frontend.index', [
            'output'     => $output,
            'sliders'    => $sliders,
            'categories' => $categories,
            'products'   => $products,
            'featuredProducts'   => $featuredProducts
        ]);
    }
    
    public function about() {
        
        $about = Pages::where('title','LIKE','About Us')
            ->where('status','=','1')->get();
        
        $mission = Pages::where('title','LIKE','Mission')
            ->where('status','=','1')->get();
        
        $vission = Pages::where('title','LIKE','Vission')
            ->where('status','=','1')->get();
        
        return view('frontend/about-us',['about'=>$about,'mission'=>$mission,'vission'=>$vission]);
    }
    
    public function faq() {
        
        $about = Pages::where('title','LIKE','About Us')
            ->where('status','=','1')->get();
        
        $mission = Pages::where('title','LIKE','Mission')
            ->where('status','=','1')->get();
        
        $vission = Pages::where('title','LIKE','Vission')
            ->where('status','=','1')->get();
        
        return view('frontend/how-it-works',['about'=>$about,'mission'=>$mission,'vission'=>$vission]);
    }
    
    public function blog(Request $request, $category_slog = null) {
        $query = Posts::where('status', 1);
    
        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
    
        // Category filter
        if ($category_slog) {
            $query->where('category',$category_slog); 
        }
    
        $posts = $query->latest()->paginate(10);
    
        $categories = Post_categories::where('status', 1)->get();
    
        return view('frontend.blog', compact('posts', 'categories', 'category_slog'));
    }

    public function blogArticle($category_slog, $article_slog) {
        $categories = Post_categories::where('status', 1)
            ->withCount(['posts' => function ($query) {
                $query->where('status', 1);
            }])
            ->get();

        $post = Posts::where('slog', $article_slog)
            ->where('status', 1)
            ->firstOrFail();

        // Related posts (optional)
        $relatedPosts = Posts::where('category', $category_slog)
            ->where('id', '!=', $post->id)
            ->where('status', 1)
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.blog-details', compact('post', 'categories', 'relatedPosts'));
    }
    
    public function products(Request $request) {
        
        $pagetitle = "Categories";
        
        $query = Products::where('status', '1');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('cas_no', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }
        
        $products = $query->orderBy('id','desc')->get();
        
        return view('frontend.products',['products'=>$products,'pagetitle'=>$pagetitle]);
    }
    
    public function category($category_slog) {
        // Fetch the category by slog first
        $category = Categories::where('slog', $category_slog)->first();
    
        if (!$category) {
            abort(404, 'Category not found.');
        }
    
        // Then fetch products belonging to the found category
        $products = Products::where('category', $category->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
    
        $pagetitle = $category->title ?? 'Products';
    
        return view('frontend.products', [
            'products' => $products,
            'pagetitle' => $pagetitle,
        ]);
    }

    public function productDetails($product_slog) {
        // Fetch the product with its category
        $product = Products::leftJoin('categories', 'products.category', '=', 'categories.id')
            ->select('categories.title as category_title', 'categories.slog as cslog', 'products.*')
            ->where('products.slog', $product_slog)
            ->where('products.status', 1)
            ->first();
    
        // If no product found, abort with 404
        if (!$product) {
            abort(404, 'Product not found.');
        }
    
        // Fetch related products from the same category
        $rel_products = Products::leftJoin('categories', 'products.category', '=', 'categories.id')
            ->select('categories.title as category_title', 'categories.slog as cslog', 'products.*')
            ->where('categories.id', $product->category)
            ->where('products.slog', '!=', $product_slog)
            ->where('products.status', 1)
            ->limit(4)
            ->get();
    
        return view('frontend.product-details', [
            'product' => $product,
            'rel_products' => $rel_products
        ]);
    }

    public function productDetailsPost(Request $request,$product_slog) {
        try {
            $validated = $request->validate([
                'qty' => 'required|integer|min:1',
                'delivery_date' => 'required|date|after_or_equal:today',
                'delivery_location' => 'required|string|max:255',
                'specific_requirements' => 'nullable|string',
                'attachments.*' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
                'buyerId' => 'required|integer|exists:users,id',
            ]);
    
            $product = Products::where('slog', $product_slog)->first();
            if (!$product) {
                return back()->with('error', 'Product not found.');
            }
    
            $uploadedFiles = [];

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if ($file->isValid()) {
                        // Unique file name
                        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
                        // Move file to public folder
                        $file->move(public_path('assets/frontend/img/products/files'), $fileName);
            
                        // Save relative path
                        $uploadedFiles[] = 'assets/frontend/img/products/files/' . $fileName;
                    }
                }
            }

            $order = Orders::where('buyer_id', $validated['buyerId'])
                ->where('product_id', $product->id)
                ->whereNotIn('status', ['cancelled', 'closed', 'awarded'])
                ->count();

            if ($order > 0) {
                return back()->with('error', 'This product order has already been requested.');
            }
    
            $order = new Orders();
            $order->product_id = $product->id;
            $order->buyer_id = $validated['buyerId'];
            $order->quantity = $validated['qty'];
            $order->delivery_date = $validated['delivery_date'];
            $order->delivery_location = $validated['delivery_location'];
            $order->specific_requirements = $validated['specific_requirements'] ?? null;
            $order->attachments = json_encode($uploadedFiles);
            $order->status = 'pending'; // default
            $order->save();
    
            return redirect()->back()->with('success', 'Your order has been submitted successfully.');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while submitting your order.');
        }
    }
    
    public function contactUs() {
        
        $contacts = Contacts::where('id','=','1')->get();
        
        return view('frontend/contact-us',['contacts'=>$contacts]);
    }
    
    public function supportPolicy() {
        
        $output = Pages::where('title','LIKE','Support-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/support-policy',['output'=>$output]);
    }
    
    public function returnPolicy() {
        
        $output = Pages::where('title','LIKE','Return-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/return-policy',['output'=>$output]);
    }
    
    public function sellerPolicy() {
        
        $output = Pages::where('title','LIKE','Seller-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/seller-policy',['output'=>$output]);
    }
    
    public function buyerPolicy() {
        
        $output = Pages::where('title','LIKE','Buyer-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/buyer-policy',['output'=>$output]);
    }
    
    public function nonDisclosureAgreement() {
        
        $output = Pages::where('title','LIKE','NDA-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/non-disclosure-agreement',['output'=>$output]);
    }
    
    public function refundPolicy() {
        
        $output = Pages::where('title','LIKE','Refund-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/refund-policy',['output'=>$output]);
    }
    
    public function privacyPolicy() {
        
        $output = Pages::where('title','LIKE','Privacy-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/privacy-policy',['output'=>$output]);
    }
    
    public function termsConditions() {
        
        $output = Pages::where('title','LIKE','Terms-Conditions')
            ->where('status','=','1')->first();
        
        return view('frontend/terms-conditions',['output'=>$output]);
    }
    
    public function contactForm(Request $request){
        
        $name = $request->name ?? '';
        $email = $request->email ?? '';
        $phone = $request->phone ?? '';
        $msg = $request->message ?? '';
        
        $contact = new Enquiries();
        //name	email	phone	msg	
        $contact->name = $request->name ?? '';
        $contact->email = $request->email ?? '';
        $contact->phone = $request->phone ?? '';
        $contact->msg = $request->message ?? '';
        $contact->status = '1';
        
        $to = "support@impurityx.com";
        $subject = "Received";
        
        $message = "New contact form message received from website<br><br><b>Name:</b> $name<br><b>Email Id:</b>$email<br><b>Phone:</b> $phone<br><b>Messsage:</b> $msg";
        
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // More headers
        $headers .= 'From: ImpurityX <admin@'.$request->getHost().'>' . "\r\n";
        
        mail($to,$subject,$message,$headers);
        
        $contact->save();

        return redirect('/contact-us')->with('success', 'Successfully Submitted!!');

        return redirect('/contact-us')->with('error', 'Oops, Somethings went worng.');
        
    }
    
    public function register() {
        return view('frontend/buyer-register');
    }

    public function registerPost(Request $request) {
        // Validate the incoming request
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mob' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'company' => 'required|string|max:255',
            'trade' => 'required|string|max:255',
            'incomTaxno' => 'required|string|max:255',
            'taxNo' => 'required|string|max:255',
            'regAddress' => 'required|string|max:500',
            'comAddress' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);
    
        try {
            // Create User
            $user = new User();
            $user->first_name = $request->fname;
            $user->last_name = $request->lname;
            $user->mob = $request->mob;
            $user->whatsapp = $request->whatsapp;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->branch = '1';
            $user->photo = '';
            $user->dob = '';
            $user->gender = '';
            $user->role = '5';
            //$user->notify = '1';
            $user->status = '0';
            $user->save();
    
            // Create Usermeta
            $meta = new Usermetas();
            $meta->uid = $user->id;
            $meta->company = $request->company;
            $meta->trade = $request->trade;
            $meta->panno = $request->incomTaxno;
            $meta->vat = $request->taxNo;
            $meta->regAddress = $request->regAddress;
            $meta->comAddress = $request->comAddress;
            $meta->city = $request->city;
            $meta->pincode = $request->pincode;
            $meta->state = $request->state;
            $meta->country = $request->country;
            $meta->status = '1';
            $meta->save();
    
            // Attempt login
            //if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                //session(['users' => $user]);
            
            if(!empty($user->id)){
                
                // Generate OTP
                $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                
                // Store OTP in session with expiry
                session([
                    'otp_code'       => $otp,
                    'otp_email'      => $user->email,
                    'otp_expires_at' => now()->addMinutes(10),
                ]);
                
                // Prepare details for the Mailable + Blade view
                $details = [
                    'user_name'       => trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->name ?? 'User'),
                    'otp'             => $otp,
                    'expires_minutes' => 10,
                    'brand'           => 'ImpurityX',
                    'support_email'   => 'support@' . request()->getHost(),
                ];
                
                // Send using your MailModel wrapper and a dedicated view
                Mail::to($user->email)->send(
                    new MailModel(
                        $details,
                        "Verify your email address",
                        "emails.otp_verification" // <-- create this Blade view (below)
                    )
                );
                
                // Redirect to OTP verify page
                return redirect()
                    ->route('otp.show', ['email' => $user->email])
                    ->with('success', 'Your account was created. We emailed you a 6-digit code.');

                
                //return redirect('/')->with('success', 'Your request has been submitted please check your email');// . $user->first_name . '!'
            }
    
            return back()->with('error', 'Something went wrong during login.');
    
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function show(Request $request) {
        $email = $request->query('email') ?? session('otp_email');

        return view('frontend/buyer-otp', [
            'email' => $email
        ]);
    }
    
    protected function sendOtpMail(User $user, string $otp, string $subject = 'Verify your email address', string $view = 'emails.otp_verification'): void {
        $details = [
            'user_name'       => trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->name ?? 'User'),
            'otp'             => $otp,
            'expires_minutes' => 10,
            'brand'           => 'ImpurityX',
            'support_email'   => 'support@' . request()->getHost(),
        ];
    
        Mail::to($user->email)->send(new MailModel($details, $subject, $view));
    }

    public function verifyOtp(Request $request) {
        
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|string|size:6',
        ]);
    
        // Pull session data
        $otp       = session('otp_code');
        $otpEmail  = session('otp_email');
        $otpExpiry = session('otp_expires_at');
    
        if (!$otp || !$otpEmail || !$otpExpiry) {
            return back()->withErrors(['code' => 'OTP session expired. Please request a new one.']);
        }
    
        // Validate email & OTP (case-insensitive email, constant-time code compare)
        $emailMatches = Str::lower($request->email) === Str::lower($otpEmail);
        $codeMatches  = hash_equals((string)$otp, (string)$request->code);
        $notExpired   = now()->lt($otpExpiry);
    
        if ($emailMatches && $codeMatches && $notExpired) {
            // Clear OTP from session
            session()->forget(['otp_code','otp_email','otp_expires_at']);
    
            // Activate / verify user
            $user = User::where('email', $request->email)->first();
            if ($user) {
                //$user->status = '1';
                $user->email_verified_at = now();
                $user->save();
            }
    
            return redirect('/')->with('success', 'Email verified successfully!');
        }
    
        return back()->withErrors(['code' => 'Invalid or expired code']);
        
    }
    
    public function resendOtp(Request $request) {
        
        $email = session('otp_email');
        if (!$email) {
            return back()->withErrors(['email' => 'No pending verification.']);
        }
    
        // Regenerate OTP
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    
        session([
            'otp_code'       => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);
    
        // Try to fetch user for nicer personalization (optional)
        $user = User::where('email', $email)->first();
        if (!$user) {
            // Minimal stub for mailing if the user record isn't found
            $user = new User();
            $user->email = $email;
            $user->first_name = 'there';
            $user->last_name  = '';
            $user->name       = null;
        }
    
        // Send via MailModel + the same Blade view
        $this->sendOtpMail($user, $otp, 'Your new OTP code', 'emails.otp_verification');
    
        return back()->with('success', 'A new OTP has been sent to your email.');
        
    }
    
    public function login() {
        return view('frontend/buyer-login');
    }
    
    public function loginPost(Request $request) {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
    
        // Logout seller & admin
        Auth::guard('seller')->logout();
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
    
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            
            if ($user->status != '1') {
                Auth::guard('web')->logout();
                return back()->with('error', 'Your account is inactive. Please contact the support team for assistance.');
            }
    
            if ($user->role == '5') {
                session(['users' => $user]);
                return redirect('/')->with('success', 'Welcome Back, ' . $user->first_name . '!');
            }
    
            Auth::guard('web')->logout();
            return back()->with('error', 'You are not authorized as a buyer.');
        }
    
        return back()->with('error', 'Invalid login credentials.');
    }
    
    public function forgotPassword() {
        return view('frontend/forgot-password');
    }
    
    public function forgotPasswordPost(Request $request) {
        
        $user = User::where('email','=',$request->username)->where('status','=','1')->get();
        
        /*if(count($user)>0){
            
            session(['useremail' => $request->username]);

            $to = $request->username;
            $subject = "Reset Password Link - ImpurityX";
            
            $message = "Hi, <br><br>Click the link to reset your new password https://".$request->getHost().'/reset-password/'.$user[0]->id.$user[0]->password;
            
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: ImpurityX <support@impurityx.com>' . "\r\n";
            
            $mail = mail($to,$subject,$message,$headers);
            
            if($mail == true){
                return redirect('/login')->with('success', 'Password reset link has been sent to your registered email ID. please check it');
            }else{
                return back()->with('error', 'Oops somethings went worng. Please try again');
            }
            
        }*/ 
        
        if (count($user) > 0) {
        
            session(['useremail' => $request->username]);
        
            // Generate secure reset link https://".$request->getHost().'/reset-password/'.$user[0]->id.$user[0]->password;
            $resetLink = 'https://' . $request->getHost() . '/reset-password/' . $user[0]->id .'$impx'. md5($user[0]->password);
        
            // Prepare mail details
            $details = [
                'user_name'     => trim(($user[0]->first_name ?? '') . ' ' . ($user[0]->last_name ?? '')) ?: ($user[0]->name ?? 'User'),
                'reset_link'    => $resetLink,
                'brand'         => 'ImpurityX',
                'support_email' => 'support@impurityx.com',
            ];
            
            $token = $user[0]->id .'$impx'. md5($user[0]->password);
            $email = $user[0]->id;
            
            DB::table('password_reset_tokens')->insert([
                'email' => $email,  // e.g. $key[0]
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        
            // Send mail using your MailModel and a Blade view
            Mail::to($request->username)->send(
                new MailModel(
                    $details,
                    "Reset Password Link - ImpurityX",
                    "emails.password_reset" // <-- create this Blade view
                )
            );
        
            return redirect('/login')->with('success', 'Password reset link has been sent to your registered email ID. Please check it.');
        } else{
            return back()->with('error', 'Invalid email address. Please try again');
        }
    }
    
    public function resetPassword($resetPassword) {
        return view('frontend/reset-password',['key'=>$resetPassword]);
    }
    
    public function resetPasswordPost(Request $request) {
        $request->validate([
            'secretkey' => 'required|string',
            'password' => 'required|confirmed|min:6',
        ]);
        
        $key = explode('$impx',($request->secretkey ?? ''));
    
        $reset = DB::table('password_reset_tokens')
            ->where('email', $key[0])
            ->first();
    
        if ($reset && ($request->secretkey == $reset->token)) {
            User::where('id', $key[0])->update([
                'password' => Hash::make($request->password)
            ]);
    
            DB::table('password_reset_tokens')->where('email', $key[0])->delete();
    
            return redirect('/login')->with('success', 'Password reset successful! Please login with your new password.');
        }
    
        return back()->with('error', 'Invalid or expired reset token.');
    }

    public function logout(Request $request) {
        // Logout from buyer guard
        Auth::guard('web')->logout();
    
        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/')->with('success', 'Logged out successfully!');
    }

    public function myAccount($page, Request $request) {
        
        //dd($request);
        if($page == 'supports' && !empty($request->communicationId)){
            
            $request->validate([
                'communicationId' => 'required|string',
                'orderNo' => 'nullable|string',
                'casNo' => 'nullable|string',
                'impurityName' => 'nullable|string',
                'message' => 'required|string',
            ]);
        
            // Generate Communication ID
            //$last = Communications::orderBy('id', 'desc')->first();
        
            // Save to DB
            $comm = new Communications();
            $comm->communication_id = $request->communicationId;
            $comm->order_no = $request->orderNo;
            $comm->cas_no = $request->casNo;
            $comm->impurity_name = $request->impurityName;
            $comm->message = $request->message;
            $comm->user_id = auth()->id();
            $comm->type = '1';
            $comm->save();
        
            return redirect()->back()->with('success', 'Message sent successfully!');
            
        }
        
        //dd($request);
        if($page == 'communication-sellers' && !empty($request->orderNo)){
            
            if(empty($request->replyId)){
                
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
                
                $getBiddingDetails = Biddings::where('order_id','=',$orderId)
                    ->where('status','=','awarded')->first();
            
                // Save to DB
                $comm = new Communications();
                $comm->communication_id = $request->communicationId;
                $comm->order_no = $request->orderNo;
                $comm->cas_no = $request->casNo;
                $comm->impurity_name = $request->impurityName;
                $comm->message = $request->message;
                $comm->user_id = auth()->id();
                $comm->seller_id = $getBiddingDetails->seller_id;
                $comm->type = '0';
                $comm->save();
            
                return redirect()->back()->with('success', 'Message sent successfully!');
                
            }else{
                
                $request->validate([
                    'replyId' => 'required',
                    'message' => 'required|string',
                ]);
                
                $comm = Communications::find($request->replyId);
                
                $comm->reply = $request->message;
                $comm->status = 'closed';
                $comm->save();
        
                $previous = url()->previous();
                $cleanUrl = strtok($previous, '?');
                
                return redirect($cleanUrl."?id=".($request->replyId ?? ''))->with('success', 'Submitted');
                
            }
            
        }
        
        if($page == 'request-order' && !empty($request->requestID)){
            
            // Validate input
            $request->validate([
                'requestID'           => 'required|string|max:255',
                'casNumber'           => 'required|string|max:255',
                'impurityName'        => 'required|string|max:255',
                'synonynName'         => 'required|string|max:255',
                'impuritytype'        => 'required|string|max:50',
                'quantity'            => 'nullable|numeric',
                'uom'                 => 'required|string|max:20',
                'purity'              => 'nullable|numeric',
                'potency'             => 'nullable|numeric',
                'deliveryTime'        => 'nullable|numeric',
                'deliveryPlace'        => 'nullable|string',
                'impurityDescription' => 'nullable|string',
                'certification'       => 'nullable|string|max:255',
                'supportingDocuments' => 'nullable|string',
                'Product_files.*'     => 'nullable|file|mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx|max:2048',
            ]);
            
            function slog($string) {
                $string = str_replace(' ', '-', strtolower($string));
                return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
            }
            
            $getProduct = Products::orderBy('id', 'DESC')->first();

            if ($getProduct) {
                $skuId = 'SKU' . str_pad($getProduct->id, 5, '0', STR_PAD_LEFT);
            } else {
                $skuId = 'SKU00001'; // default if no products exist
            }
            
            // Save Product
            $product = new Products();
            $product->name          = $request->impurityName;
            $product->slog          = slog($request->impurityName);
            $product->sku           = $skuId ?? '';
            $product->cas_no        = $request->casNumber;
            $product->uom           = $request->uom;
            $product->synonym       = $request->synonynName;
            $product->purity        = $request->purity;
            $product->potency       = $request->potency;
            $product->impurity_type = $request->impuritytype;
            $product->img           = '';
            $product->gallery       = '';
            $product->sdes          = '';
            $product->tags          = '';
            $product->ainfo         = '';
            $product->stocks        = '';
            $product->review        = '';
            $product->des           = $request->impurityDescription;
            $product->status        = 0;
            $product->save();
            
            // Save Order
            $order = new Orders();
            $order->product_id            = $product->id;
            $order->buyer_id              = auth()->id();
            $order->quantity              = $request->quantity;
            $order->delivery_date         = $request->deliveryTime ? now()->addDays($request->deliveryTime) : null;
            $order->delivery_location     = $request->deliveryPlace;
            $order->specific_requirements = $request->supportingDocuments;
            $order->status                = "requested";
            $order->save();
            
            // Save Buyer Product Enquiry
            $enquiry = new Buyer_product_enquiries();
            $enquiry->request_id = $request->requestID;
            $enquiry->product_id = $product->id;
            $enquiry->order_id   = $order->id;
            $enquiry->user_id    = auth()->id();
            $enquiry->status     = 0;
            $enquiry->save();
            
            if ($request->hasFile('Product_files')) {
                $attachmentFiles = [];
                foreach ($request->file('Product_files') as $file) {
                    $fileName = 'F' . time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('/assets/frontend/img/products/files'), $fileName);
                    $attachmentFiles[] = $fileName;
                }
                $order->attachments = json_encode($attachmentFiles);
                $order->save();
            }
        
            return redirect()->back()->with('success', 'Message sent successfully!');
            
        }
        
        if($page == 'supports'){
            
            if(!empty($request->id)){
                $getCom = Communications::where('id',$request->id)->first();
            }
            
            $communications = Communications::where('user_id',auth()->id())->where('type','1')->orderBy('id', 'desc')->get();
            
            $getCommunications = Communications::orderBy('id', 'desc')->first();

            if ($getCommunications) {
                $communicationId = 'CBA-' . str_pad($getCommunications->id, 5, '0', STR_PAD_LEFT);
            } else {
                $communicationId = 'CBA-00001'; // first communication ID
            }


            return view('frontend/buyer-dashboard',['page'=>$page,'communications'=>$communications,'communicationId'=>$communicationId,'getCom'=>($getCom ?? [])]);
            
        }
        
        if($page == 'communication-sellers'){
            
            if(!empty($request->id)){
                $getCom = Communications::where('id',$request->id)->first();
            }
            
            $communications = Communications::where('user_id',auth()->id())->where('type','0')->orderBy('id', 'desc')->get();
            
            $getCommunications = Communications::orderBy('id', 'desc')->first();

            if ($getCommunications) {
                $communicationId = 'CBS-' . str_pad($getCommunications->id, 5, '0', STR_PAD_LEFT);
            } else {
                $communicationId = 'CBS-00001'; // first communication ID
            }

            return view('frontend/buyer-dashboard',['page'=>$page,'communications'=>$communications,'communicationId'=>$communicationId,'getCom'=>($getCom ?? [])]);
            
        }
        
        if($page == 'request-order'){
            
            if(!empty($request->id)){
                $getRnpo = Buyer_product_enquiries::leftJoin('products', 'buyer_product_enquiries.product_id', '=', 'products.id')
                    ->leftJoin('orders', 'buyer_product_enquiries.order_id', '=', 'orders.id')
                    ->select(
                        // Buyer Product Enquiries
                        'buyer_product_enquiries.id as enquiry_id',
                        'buyer_product_enquiries.request_id',
                        'buyer_product_enquiries.status',
                        'buyer_product_enquiries.created_at',
                        'buyer_product_enquiries.updated_at',
                
                        // Product fields
                        'products.name',
                        'products.sku',
                        'products.cas_no',
                        'products.synonym',
                        'products.uom',
                        'products.purity',
                        'products.potency',
                        'products.impurity_type',
                        'products.des',
                
                        // Order fields
                        'orders.id as order_id',
                        'orders.quantity',
                        'orders.delivery_date',
                        'orders.delivery_location',
                        'orders.specific_requirements',
                        'orders.attachments',
                        'orders.status as order_status'
                    )
                    ->where('buyer_product_enquiries.id', $request->id)
                    ->orderBy('buyer_product_enquiries.id', 'desc')
                    ->first();

            }
            
            $rnpo = Buyer_product_enquiries::leftJoin('products','buyer_product_enquiries.product_id','=','products.id')
                ->leftJoin('orders','buyer_product_enquiries.order_id','=','orders.id')
                ->select('products.name','products.sku','products.uom','orders.quantity','orders.delivery_date','buyer_product_enquiries.*')
                ->where('buyer_product_enquiries.user_id',auth()->id())->orderBy('id', 'desc')->get();
            
            
            $get_buyer_product_enq = Buyer_product_enquiries::orderBy('id', 'desc')->first();

            if ($get_buyer_product_enq) {
                $nextId = $get_buyer_product_enq->id + 1;
            } else {
                $nextId = 1; // Start from 1 if no records exist
            }
            
            $reqId = 'REQ-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

            
            // Get Categories List
            $categories = Categories::where('type', '1')
                ->where('status', '1')
                ->orderBy('id', 'ASC')
                ->get();
        
            $categoriesOptions = '';
        
            foreach ($categories as $category) {
                $selected = ($category->id ?? '') == ($products[0]->category ?? '') ? 'selected' : '';
                $categoriesOptions .= '<option value="' . $category->id . '" ' . $selected . '>' . $category->title . '</option>';
        
                // Get Subcategories
                $scategories = Categories::where('parent', $category->id)
                    ->where('type', '2')
                    ->where('status', '1')
                    ->orderBy('id', 'ASC')
                    ->get();
        
                foreach ($scategories as $scategory) {
                    $sselected = ($scategory->id ?? '') == ($products[0]->category ?? '') ? 'selected' : '';
                    $categoriesOptions .= '<option value="' . $scategory->id . '" ' . $sselected . '> - ' . $scategory->title . '</option>';
        
                    // Get Child Categories
                    $ccategories = Categories::where('parent', $scategory->id)
                        ->where('type', '3')
                        ->where('status', '1')
                        ->orderBy('id', 'ASC')
                        ->get();
        
                    foreach ($ccategories as $ccategory) {
                        $cselected = ($ccategory->id ?? '') == ($products[0]->category ?? '') ? 'selected' : '';
                        $categoriesOptions .= '<option value="' . $ccategory->id . '" ' . $cselected . '> -- ' . $ccategory->title . '</option>';
                    }
                }
            }

            return view('frontend/buyer-dashboard',['page'=>$page,'reqId'=>$reqId,'rnpo'=>$rnpo,'categoriesOptions' => $categoriesOptions,'getRnpo'=>($getRnpo ?? [])]);
            
        }
        
        if($page == 'my-profile'){
            
            if(!empty($request->email)){
                $user = auth()->user();
            
                $request->validate([
                    'first_name'     => 'required|string|max:255',
                    'last_name'      => 'nullable|string|max:255',
                    'contact'        => 'nullable|max:15',
                    'whatsapp'        => 'nullable|max:15',
                    'email'          => 'required|email|unique:users,email,' . $user->id,
                    'password'       => 'nullable|string|min:6|confirmed',
                    'profile_photo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            
                    // UserMeta fields
                    'company'        => 'nullable|string|max:255',
                    'trade'          => 'nullable|string|max:255',
                    'panno'          => 'nullable|string|max:50',
                    'vat'            => 'nullable|string|max:50',
                    'regAddress'     => 'nullable|string|max:500',
                    'comAddress'     => 'nullable|string|max:500',
                    'city'           => 'nullable|string|max:100',
                    'pincode'        => 'nullable|string|max:20',
                    'state'          => 'nullable|string|max:100',
                    'country'        => 'nullable|string|max:100',
                ]);
            
                // Update basic details
                $user->first_name = $request->first_name;
                $user->last_name  = $request->last_name;
                $user->email      = $request->email;
                $user->mob      = $request->contact;
                $user->whatsapp      = $request->whatsapp;
            
                // If password is entered, update it
                if ($request->filled('password')) {
                    $user->password = bcrypt($request->password);
                }
            
                // If profile photo uploaded public/assets/frontend/img/users/ 
                if ($request->hasFile('profile_photo')) {
                    $file = $request->file('profile_photo'); // get uploaded file
                    $filename = time().'.'.$file->getClientOriginalExtension(); // unique name
                    $file->move(public_path('assets/frontend/img/users/'), $filename); // move to folder
                    $user->photo = $filename; // save filename in DB
                }

                $user->save();
                
                $usermetas = Usermetas::where('uid',$user->id)->first();
                $usermetas->company    = $request->company;
                $usermetas->trade      = $request->trade;
                $usermetas->panno      = $request->panno;
                $usermetas->vat        = $request->vat;
                $usermetas->regAddress = $request->regAddress;
                $usermetas->comAddress = $request->comAddress;
                $usermetas->city       = $request->city;
                $usermetas->pincode    = $request->pincode;
                $usermetas->state      = $request->state;
                $usermetas->country    = $request->country;
                $usermetas->save();
            
                return back()->with('success', 'Profile updated successfully.');
            }
            
            $user = User::leftJoin('usermetas','users.id','=','usermetas.uid')
                ->where('users.id',Auth::User()->id)->first();

            return view('frontend/buyer-dashboard',['page'=>$page,'user'=>$user]);
            
        }
        
        /*if($page == 'my-notices'){
            
            $notices = Notices::where('type','buyers')->orderBy('id','desc')->get();

            return view('frontend/buyer-dashboard',['page'=>$page,'notices'=>($notices ?? [])]);
            
        }*/
        
        if ($page == 'my-notices') {
            $user = session('users');
            $user = User::find($user->id);
        
            $notify = json_decode(($user->notify ?? ''),true) ?? [];
            if (!is_array($notify)) {
                $notify = [];
            }
            
            if (($notify['notice'] ?? 0) == 1) {
                $notify['notice'] = 0;
                $user->notify = $notify;
                $user->save();
            }
        
            $notices = Notices::where('type', 'buyers')
                ->orderBy('id', 'desc')
                ->get();
        
            return view('frontend/buyer-dashboard', [
                'page' => $page,
                'notices' => $notices ?? []
            ]);
        }

        
        if($page == 'delivery-acceptance'){
            
            if(!empty($request->id)){
                $order = Orders::findOrFail($request->id);
    
                $order->seller_status = "accepted";
            
                $order->save(); // use save() instead of update()
                
                $bid = Biddings::where('order_id',$order->id)
                    ->where('status','awarded')->first();
                
                // Identify Seller (logged in user)
                $seller = User::where('id',$bid->seller_id)->first();
                
                $buyers = User::findOrFail($order->buyer_id);
                
                // Prepare mail details
                $details = [
                    'seller_name'    => trim(($seller->first_name ?? '') . ' ' . ($seller->last_name ?? '')) ?: ($seller->name ?? 'Seller'),
                    'buyer_name'     => trim(($buyers->first_name ?? '') . ' ' . ($buyers->last_name ?? '')) ?: 'Buyer',
                    'order_id'       => $order->id,
                    'completed_date' => now()->format('d M Y'),
                    'brand'          => 'ImpurityX',
                    'support_email'  => 'support@impurityx.com',
                ];
                
                // Send Email to Seller
                Mail::to($seller->email)->send(
                    new MailModel(
                        $details,
                        "Delivery Accepted by Buyer – Order Completed",
                        "emails.delivery_accepted_seller"
                    )
                );

                
                return back()->with('success', 'Order status updated successfully.');
            }
            
            $myorders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
                ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->leftJoin('users as sellers', 'biddings.seller_id', '=', 'sellers.id')
                ->select(
                    'sellers.first_name',
                    'sellers.last_name',
                    'products.name',
                    'products.sku',
                    'products.img',
                    'products.slog',
                    'products.uom',
                    'biddings.price',
                    'biddings.created_at as awarded_date',
                    'biddings.days',
                    'orders.*'
                )
                ->where('orders.buyer_id',Auth::User()->id)
                ->where('orders.status','awarded')
                ->where('biddings.status','awarded')
                ->orderBy('orders.id', 'desc')
                ->get();

            return view('frontend/buyer-dashboard',['page'=>$page,'myorders'=>$myorders]);
            
        }
        
        if($page == 'process-orders'){
            
            $myorders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
                ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->leftJoin('users as sellers', 'biddings.seller_id', '=', 'sellers.id')
                ->select(
                    'orders.id as order_id',
                    'orders.created_at as order_date',
                    'orders.quantity as qty_reqd',
                    'orders.status',
                    'orders.seller_status',
                    'orders.delivery_date as expdly_dt',
                    'products.name as impurity_name',
                    'products.sku',
                    'products.cas_no',
                    'products.uom',
                    'biddings.price as rate_pu',
                    DB::raw('(biddings.price * orders.quantity) as order_val'),
                    'biddings.days',
                    'biddings.created_at as awarded_date',
                    'sellers.first_name as seller_fname',
                    'sellers.last_name as seller_lname',
                    'sellers.email as seller_email'
                )
                ->where('orders.buyer_id', Auth::id())
                ->where('orders.status', 'awarded')
                ->whereIn('orders.seller_status', ['','order-initiated','order-task-completed','delivery-initiated','delivery-completed','accepted'])
                ->where('biddings.status', 'awarded')
                ->orderBy('orders.id', 'desc')
                ->get();
            
            return view('frontend.buyer-dashboard', [
                'page' => 'process-orders',
                'myorders' => $myorders
            ]);
            
        }
        
        if($page == 'completed-orders'){
            
            $myorders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
                ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->leftJoin('users as sellers', 'biddings.seller_id', '=', 'sellers.id')
                ->select(
                    'orders.id as order_id',
                    'orders.created_at as order_date',
                    'orders.quantity as qty_reqd',
                    'orders.status',
                    'orders.seller_status',
                    'orders.delivery_date as expdly_dt',
                    'products.name as impurity_name',
                    'products.sku',
                    'products.cas_no',
                    'products.uom',
                    'biddings.price as rate_pu',
                    DB::raw('(biddings.price * orders.quantity) as order_val'),
                    'biddings.days',
                    'biddings.created_at as awarded_date',
                    'sellers.first_name as seller_fname',
                    'sellers.last_name as seller_lname',
                    'sellers.email as seller_email'
                )
                ->where('orders.buyer_id', Auth::id())
                ->where('orders.status', 'closed')
                ->where('biddings.status', 'awarded')
                ->orderBy('orders.id', 'desc')
                ->get();
            
            return view('frontend.buyer-dashboard', [
                'page' => 'completed-orders',
                'myorders' => $myorders
            ]);
            
        }
        
        if($page == 'all-orders'){
            
            $myorders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
                ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->leftJoin('users as sellers', 'biddings.seller_id', '=', 'sellers.id')
                ->select(
                    'orders.id as order_id',
                    'orders.created_at as order_date',
                    'orders.quantity as qty_reqd',
                    'orders.status',
                    'orders.seller_status',
                    'orders.delivery_date as expdly_dt',
                    'products.name as impurity_name',
                    'products.sku',
                    'products.cas_no',
                    'products.uom',
                    'biddings.price as rate_pu',
                    DB::raw('(biddings.price * orders.quantity) as order_val'),
                    'biddings.days',
                    'biddings.created_at as awarded_date',
                    'sellers.first_name as seller_fname',
                    'sellers.last_name as seller_lname',
                    'sellers.email as seller_email'
                )
                ->where('orders.buyer_id', Auth::id())
                ->whereIn('orders.status', ['awarded','closed'])
                ->where('biddings.status', 'awarded')
                ->orderBy('orders.id', 'desc')
                ->get();
            
            return view('frontend.buyer-dashboard', [
                'page' => 'all-orders',
                'myorders' => $myorders
            ]);
            
        }
        
        if($page == 'purchase-report'){
            
            $myorders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
                ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->leftJoin('users as sellers', 'biddings.seller_id', '=', 'sellers.id')
                ->leftJoin('usermetas as sellerMetas', 'biddings.seller_id', '=', 'sellerMetas.uid')
                ->select(
                    'orders.id as order_id',
                    'orders.created_at as order_date',
                    'orders.quantity as qty_reqd',
                    'orders.invoice_no',
                    'orders.status',
                    'orders.seller_status',
                    'orders.delivery_date as expdly_dt',
                    'products.name as impurity_name',
                    'products.sku',
                    'products.cas_no',
                    'products.uom',
                    'products.gst',
                    'biddings.price as rate_pu',
                    DB::raw('(biddings.price * orders.quantity) as order_val'),
                    'biddings.days',
                    'biddings.created_at as awarded_date',
                    'sellers.first_name as seller_fname',
                    'sellers.last_name as seller_lname',
                    'sellers.email as seller_email',
                    'sellerMetas.vat'
                )
                ->where('orders.buyer_id', Auth::id())
                ->whereIn('orders.status', ['awarded','closed'])
                ->whereIn('orders.seller_status', ['accepted'])
                ->where('biddings.status', 'awarded')
                ->orderBy('orders.id', 'desc')
                ->get();
            
            return view('frontend.buyer-dashboard', [
                'page' => 'purchase-report',
                'myorders' => $myorders
            ]);
            
        }
        
        $lowestPriceSub = DB::table('biddings')
            ->select('order_id', DB::raw('MIN(price) as l1_rate'))
            ->groupBy('order_id');
        
        $awardedDateSub = DB::table('biddings')
            ->select('order_id', DB::raw('MAX(updated_at) as awarded_date'))
            ->where('status', 'awarded')
            ->groupBy('order_id');
        
        /*$myorders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
            // join subqueries
            ->leftJoinSub($lowestPriceSub, 'lp', function ($join) {
                $join->on('orders.id', '=', 'lp.order_id');
            })
            ->leftJoinSub($awardedDateSub, 'aw', function ($join) {
                $join->on('orders.id', '=', 'aw.order_id');
            })
            ->select(
                'users.first_name',
                'users.last_name',
                'products.name',
                'products.sku',
                'products.img',
                'products.slog',
                'products.uom',
                'products.cas_no',
                'orders.*',
                DB::raw('lp.l1_rate as l1_rate'),
                DB::raw('aw.awarded_date as awarded_date')
            )
            ->where('orders.buyer_id', Auth::user()->id)
            ->orderByRaw("
                CASE 
                    WHEN orders.status = 'active' 
                     AND orders.auction_end IS NOT NULL 
                     AND orders.auction_end > NOW() 
                    THEN 0 ELSE 1 END
            ")
            ->orderBy('orders.id', 'desc')
            ->get();*/
            
        $myorders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
            // join subqueries
            ->leftJoinSub($lowestPriceSub, 'lp', function ($join) {
                $join->on('orders.id', '=', 'lp.order_id');
            })
            ->leftJoinSub($awardedDateSub, 'aw', function ($join) {
                $join->on('orders.id', '=', 'aw.order_id');
            })
            ->select(
                'users.first_name',
                'users.last_name',
                'products.name',
                'products.sku',
                'products.img',
                'products.slog',
                'products.uom',
                'products.cas_no',
                'orders.*',
                DB::raw('lp.l1_rate as l1_rate'),
                DB::raw('aw.awarded_date as awarded_date'),
                DB::raw("
                    CASE 
                        WHEN lp.l1_rate IS NULL THEN 'No Offer Recd'
                        ELSE orders.status 
                    END as display_status
                ")
            )
            ->where('orders.buyer_id', Auth::user()->id)
            ->orderByRaw("
                CASE 
                    WHEN orders.status = 'active' 
                     AND orders.auction_end IS NOT NULL 
                     AND orders.auction_end > NOW() 
                    THEN 0 ELSE 1 END
            ")
            ->orderBy('orders.id', 'desc')
            ->get();
        
        $viewBiddings = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.last_name',
                'products.name',
                'products.sku',
                'products.img',
                'products.slog',
                'products.uom',
                'orders.*'
            )
            ->where('orders.buyer_id',Auth::User()->id)
            ->whereIn('orders.status', ['active'])
            ->orderByRaw("
                CASE 
                    WHEN orders.status = 'active' AND orders.auction_end IS NOT NULL AND orders.auction_end > NOW() THEN 0
                    ELSE 1
                END
            ")
            ->orderBy('orders.id', 'desc')
            ->get();
            
        $nowdate = now();
        
        $myActiveBidsCount = Orders::where('buyer_id', auth()->id())
            ->where('auction_end', '>', $nowdate)
            ->where('status', 'active') // <-- add status filter
            ->count();
        
        
        $myAPBidsCount = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.buyer_id', auth()->id())
            ->where('orders.auction_end', '>', $nowdate)
            ->where('orders.status', 'active') // <-- add status filter
            ->count();
        
        // $myABBidsCount = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
        //     ->where('orders.buyer_id', auth()->id())
        //     ->where('orders.status', 'active') // <-- add status filter
        //     ->count();

        $myActiveBids = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.buyer_id', auth()->id())
            ->where('orders.status', 'active')
            ->where('orders.auction_end', '>', $nowdate)
            ->selectRaw('COUNT(biddings.id) as total_bids, SUM(biddings.price) as total_amount')
            ->first();
        
        $myABBidsCount = $myActiveBids->total_bids ?? 0;
        $myActiveBidsAmount = $myActiveBids->total_amount ?? 0;

        $myAABids = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.buyer_id', auth()->id())
            ->where('biddings.status', 'selected')
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
            ->where('orders.buyer_id', auth()->id())
            ->whereDate('biddings.created_at', '>=', $mtdStart)
            ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $ytd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('biddings.status', 'awarded')
            ->where('orders.buyer_id', auth()->id())
            ->whereDate('biddings.created_at', '>=', $ytdStart)
            ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $ctd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
            ->where('biddings.status', 'awarded')
            ->where('orders.buyer_id', auth()->id())
            ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        
        // Final Values
        // $mtdCount = $mtd->count ?? 0;
        // $ytdCount = $ytd->count ?? 0;
        // $ctdCount = $ctd->count ?? 0;
        
        // $mtdAmount = $mtd->amount ?? 0;
        // $ytdAmount = $ytd->amount ?? 0;
        // $ctdAmount = $ctd->amount ?? 0;
        
        $wipOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'order-initiated')
            ->where('orders.status', 'awarded')
            ->where('orders.buyer_id', auth()->id())
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $wipOrdercount = $wipOrder->count ?? 0;
        $wipOrderAmt = $wipOrder->amount ?? 0;
        
        $otcOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'delivery-initiated')
            ->where('biddings.status', 'awarded')
            ->where('orders.buyer_id', auth()->id())
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $otcOrdercount = $otcOrder->count ?? 0;
        $otcOrderAmt = $otcOrder->amount ?? 0;
        
        $diOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'delivery-completed')
            ->where('biddings.status', 'awarded')
            ->where('orders.buyer_id', auth()->id())
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $diOrdercount = $diOrder->count ?? 0;
        $diOrderAmt = $diOrder->amount ?? 0;
        
        $completeOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'delivery-completed')
            ->where('biddings.status', 'awarded')
            ->where('orders.buyer_id', auth()->id())
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $completeOrdercount = $completeOrder->count ?? 0;
        $completeOrderAmt = $completeOrder->amount ?? 0;

        $acceptOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'accepted')
            ->where('biddings.status', 'awarded')
            ->where('orders.buyer_id', auth()->id())
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $acceptOrdercount = $acceptOrder->count ?? 0;
        $acceptOrderAmt = $acceptOrder->amount ?? 0;
        
        /*$wiplOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'order-initiated')
            ->where('orders.buyer_id', auth()->id())
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $wiplOrdercount = $wiplOrder->count ?? 0;
        $wiplOrderAmt = $wiplOrder->amount ?? 0;*/
        
        $wiplOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', 'order-initiated')
            ->where('orders.buyer_id', auth()->id())
            ->where('biddings.status', 'awarded')
            ->whereRaw("
                DATE_ADD(biddings.updated_at, INTERVAL biddings.days DAY) >= ?
            ", [now()])
            ->selectRaw('
                COUNT(DISTINCT orders.id) as count,
                SUM(biddings.price) as amount
            ')
            ->first();
        
        $wiplOrdercount = $wiplOrder->count ?? 0;
        $wiplOrderAmt   = $wiplOrder->amount ?? 0;

        
        $dilOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'delivery-initiated')
            ->where('biddings.status', 'awarded')
            ->where('orders.buyer_id', auth()->id())
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $dilOrdercount = $dilOrder->count ?? 0;
        $dilOrderAmt = $dilOrder->amount ?? 0;
        
        $completelOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->where('orders.seller_status', '=', 'delivery-completed')
            ->where('biddings.status', 'awarded')
            ->where('orders.buyer_id', auth()->id())
            ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
            ->first();
        
        $completelOrdercount = $completelOrder->count ?? 0;
        $completelOrderAmt = $completelOrder->amount ?? 0;
        
        $pendingCount  = buyer_product_enquiries::where('status', 0)->where('user_id', auth()->id())->count();
        $approvedCount = buyer_product_enquiries::where('status', 1)->where('user_id', auth()->id())->count();
        $rejectedCount = buyer_product_enquiries::where('status', 2)->where('user_id', auth()->id())->count();

        return view('frontend/buyer-dashboard',
        [
            'page'=>$page,
            'myorders'=>$myorders,
            'viewBiddings'=>$viewBiddings,
            'myActiveBidsCount'   => $myActiveBidsCount,
            'myAPBidsCount'   => $myAPBidsCount,
            'myABBidsCount'   => $myABBidsCount,
            'myActiveBidsAmount'   => $myActiveBidsAmount,
            'myAABidsCount'   => $myAABidsCount,
            'myAABidsAmount'   => $myAABidsAmount,
            'mtd'   => $mtd,
            'ytd'   => $ytd,
            'ctd'   => $ctd,
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
            'completelOrderAmt' => $completelOrderAmt,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount
        ]);
    }
    
    public function myAccountExports($page, Request $request) {
        $user = auth()->user();
        $now = Carbon::now();
        
        if($page == 'my-orders' || $page == 'delivery-acceptance'){
            $user = auth()->user();
            $now = Carbon::now();
        
            // Subqueries for L1 Rate & Awarded Date
            $lowestPriceSub = DB::table('biddings')
                ->select('order_id', DB::raw('MIN(price) as l1_rate'))
                ->groupBy('order_id');
        
            $awardedDateSub = DB::table('biddings')
                ->select('order_id', DB::raw('MAX(updated_at) as awarded_date'))
                ->where('status', 'awarded')
                ->groupBy('order_id');
        
            // Base query
            $query = Orders::query()
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('users as buyers', 'orders.buyer_id', '=', 'buyers.id')
                ->leftJoin('usermetas as buyer_metas', 'buyers.id', '=', 'buyer_metas.uid')
                ->leftJoinSub($lowestPriceSub, 'lp', function ($join) {
                    $join->on('orders.id', '=', 'lp.order_id');
                })
                ->leftJoinSub($awardedDateSub, 'aw', function ($join) {
                    $join->on('orders.id', '=', 'aw.order_id');
                })
                ->select(
                    'orders.*',
                    'products.name as product_name',
                    'products.sku as product_sku',
                    'products.uom as product_uom',
                    'products.cas_no as product_cas',
                    'buyers.first_name as buyer_fname',
                    'buyers.last_name as buyer_lname',
                    'buyers.email as buyer_email',
                    'buyers.mob as buyer_mobile',
                    'buyer_metas.company as buyer_company',
                    'buyer_metas.city as buyer_city',
                    'buyer_metas.state as buyer_state',
                    'buyer_metas.country as buyer_country',
                    DB::raw('lp.l1_rate as l1_rate'),
                    DB::raw('aw.awarded_date as awarded_date')
                );
        
            // Restrict by role
            if ($user->role == 5) {
                // Buyer → only own orders
                $query->where('orders.buyer_id', $user->id);
            } elseif ($user->role == 4) {
                // Seller → only orders they have bid on
                $query->whereIn('orders.id', function ($q) use ($user) {
                    $q->select('order_id')->from('biddings')->where('seller_id', $user->id);
                });
            }
        
            // Filters
            if ($request->status && $request->status != 'all') {
                $query->where('orders.status', $request->status);
            }
        
            if ($request->seller_status && $request->seller_status != 'all') {
                $query->where('orders.seller_status', $request->seller_status);
            }
        
            if ($request->seller_status && $request->seller_status == 'all') {
                $query->where('orders.status', 'awarded')
                    ->whereExists(function ($q) {
                        $q->select(DB::raw(1))
                            ->from('biddings')
                            ->whereColumn('biddings.order_id', 'orders.id')
                            ->where('biddings.status', 'awarded');
                    });
            }
        
            if ($request->from_date && $request->to_date) {
                $query->whereBetween('orders.created_at', [
                    Carbon::parse($request->from_date)->startOfDay(),
                    Carbon::parse($request->to_date)->endOfDay()
                ]);
            }
        
            $orders = $query->get();
        
            // File setup
            $filename = "orders_export_" . Carbon::now()->format('Ymd_His') . ".csv";
            header('Content-Type: text/csv');
            header("Content-Disposition: attachment; filename=$filename");
        
            $handle = fopen('php://output', 'w');
        
            // Headers  "L1 Rate",
            $headers = [
                "Order ID", "Product Name", "SKU", "CAS No", "Quantity", "UOM",
                "EDD", "Delivery Location", "Buyer Storage Condition", "Auction End", "Buyer Order Status",
                "Created On", "Attachments", "Awarded Date"
            ];
        
            if ($user->role != 5) {
                $headers = array_merge($headers, [
                    "Buyer Name", "Buyer Email", "Buyer Mobile",
                    "Company", "City", "State", "Country"
                ]);
            }
        
            if ($user->role == 5) {
                $headers = array_merge($headers, [
                    "Seller Name", "Seller Company", "My Offered Price", "My Offered Days", "My Delivery Deadline", "Accepted Storage Condition", "Buyers specific Requirement", "Seller Status", "Basic Order Value", "GST Rate (in %)", "GST Amt", "Gross Order Value", "Order Intiation Dt By Seller", "Order Task Completion Dt By Seller", "Delivery Initiation  Dt By Seller", "Delivery Completion Dt By Seller", "Delivery Acceptance Dt By Buyer", "Invoice Number and Date", "Courier Details"
                ]);
            } elseif ($user->role == 4) {
                $headers = array_merge($headers, [
                    "My Offered Price", "My Offered Days", "My Delivery Deadline", "Accepted Storage Condition", "Buyers specific Requirement", "My Offer Status", "Seller Status", "Basic Order Value", "GST Rate (in %)", "GST Amt", "Gross Order Value", "Order Intiation Dt By Seller", "Order Task Completion Dt By Seller", "Delivery Initiation  Dt By Seller", "Delivery Completion Dt By Seller", "Delivery Acceptance Dt By Buyer", "Invoice Number and Date", "Courier Details"
                ]);
            } else {
                // Admin
                $headers = array_merge($headers, [
                    "Bidding Count", "Lowest Bid Price", "Highest Bid Price"
                ]);
            }
        
            fputcsv($handle, $headers);
        
            foreach ($orders as $order) {
                // Attachments
                $attachments = json_decode($order->attachments, true);
                $attachmentsList = (!empty($attachments) && $request->with_attachments == 'yes')
                    ? implode(", ", array_map(fn($f) => asset('public/' . $f), $attachments))
                    : 'N/A';
        
                // Status mapping
                $displayStatus = $order->status;
                $aw_date = '';
                if ($order->status === 'active' && $order->auction_end) {
                    $displayStatus = Carbon::parse($order->auction_end) > $now ? 'Active' : 'Select Bid';
                    $aw_date = '';
                } elseif ($order->status === 'pending') {
                    $displayStatus = 'Initiate';
                    $aw_date = '';
                } elseif ($order->status === 'awarded') {
                    $displayStatus = 'Order Awarded';
                     $aw_date = $order->awarded_date ? Carbon::parse($order->awarded_date)->format('d M, Y H:i') : 'N/A';
                } elseif ($order->status === 'selected') {
                    $displayStatus = 'Admin to confirm';
                    $aw_date = '';
                } elseif ($order->status === 'cancelled') {
                    $displayStatus = 'Cancelled';
                    $aw_date = '';
                } elseif ($order->status === 'closed') {
                    $displayStatus = 'Closed';
                    $aw_date = '';
                }
        
                // Base row
                $row = [
                    date('y') . (date('y') + 1) . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                    $order->product_name ?? 'N/A',
                    $order->product_sku ?? 'N/A',
                    $order->product_cas ?? 'N/A',
                    $order->quantity ?? 0,
                    $order->product_uom ?? '',
                    Carbon::parse($order->delivery_date)->format('d M, Y'),
                    $order->delivery_location ?? '',
                    '',
                    !empty($order->auction_end) ? Carbon::parse($order->auction_end)->format('d M, Y H:i') : '--',
                    $displayStatus,
                    Carbon::parse($order->created_at)->format('d M, Y'),
                    $attachmentsList,
                    //$order->l1_rate ?? 'N/A',
                   $aw_date
                ];
                
                if ($order->seller_status === 'order-initiated') {
                    $oi_date = $order->updated_at;
                }else{ $oi_date = ''; }
                
                if ($order->seller_status === 'order-task-completed') {
                    $otc_date = $order->updated_at;
                }else{ $otc_date = ''; }
                
                if ($order->seller_status === 'delivery-initiated') {
                    $di_date = $order->updated_at;
                }else{ $di_date = ''; }
                
                if ($order->seller_status === 'delivery-completed') {
                    $dc_date = $order->updated_at;
                }else{ $dc_date = ''; }
                
                if ($order->seller_status === 'accepted') {
                    $da_date = $order->updated_at;
                }else{ $da_date = ''; }
        
                // Seller/Admin show buyer info
                if ($user->role != 5) {
                    if ($user->role == 4) {
                        $myBid = DB::table('biddings')
                            ->where('order_id', $order->id)
                            ->where('seller_id', $user->id)
                            ->first();
        
                        if ($myBid && $myBid->status == 'awarded') {
                            $row = array_merge($row, [
                                $order->buyer_fname . ' ' . $order->buyer_lname,
                                $order->buyer_email,
                                $order->buyer_mobile,
                                $order->buyer_company,
                                $order->buyer_city,
                                $order->buyer_state,
                                $order->buyer_country
                            ]);
                        } else {
                            $row = array_merge($row, array_fill(0, 7, 'N/A'));
                        }
                        
                        // Seller bid info
                        $row = array_merge($row, [
                            $myBid->price ?? 'N/A',
                            $myBid->days ?? 'N/A',
                            '',
                            '',
                            $order->specific_requirements ?? 'N/A',
                            $myBid->status ?? 'N/A',
                            $order->seller_status == 'accepted' ? 'Delivery Accepted' : 'N/A',
                            $order->l1_rate ?? 'N/A',
                            $order->gst ?? '0',
                            ((($order->l1_rate*$order->quantity)*$order->gst)/100) ?? '0',
                            (($order->l1_rate*$order->quantity)+$order->gst)+((($order->l1_rate*$order->quantity)*$order->gst)/100) ?? '0',
                            $oi_date,
                            $otc_date,
                            $di_date,
                            $dc_date,
                            $da_date,
                            ('invoice no: ' . $order->invoice_no ?? '') . ' | invoice date: ' . ($order->invoice_date ?? ''),
                            ('courier name: ' . $order->courier_name ?? '') . ' | tracking id: ' . ($order->tracking_id ?? '') . ' | courier date: ' . ($order->courier_date ?? '')
                        ]);
                    } else {
                        // Admin
                        $row = array_merge($row, [
                            $order->buyer_fname . ' ' . $order->buyer_lname,
                            $order->buyer_email,
                            $order->buyer_mobile,
                            $order->buyer_company,
                            $order->buyer_city,
                            $order->buyer_state,
                            $order->buyer_country
                        ]);
                    }
                }
        
                // Buyer view
                if ($user->role == 5) {
                    
                    $winningBid = DB::table('biddings')
                        ->where('order_id', $order->id)
                        ->where('status', 'awarded')
                        ->first();
        
                    if ($winningBid) {
                        $seller = DB::table('users')->where('id', $winningBid->seller_id)->first();
                        $sellerMeta = DB::table('usermetas')->where('uid', $winningBid->seller_id)->first();
        
                        $row = array_merge($row, [
                            $seller->first_name . ' ' . $seller->last_name ?? 'N/A',
                            $sellerMeta->company ?? 'N/A',
                            $winningBid->price ?? 'N/A',
                            $winningBid->days ?? 'N/A',
                            '',
                            '',
                            $order->specific_requirements ?? 'N/A',
                            $order->seller_status == 'accepted' ? 'Delivery Accepted' : 'N/A',
                            $order->l1_rate ?? 'N/A',
                            $order->gst ?? '0',
                            ((($order->l1_rate*$order->quantity)*$order->gst)/100) ?? '0',
                            (($order->l1_rate*$order->quantity)+$order->gst)+((($order->l1_rate*$order->quantity)*$order->gst)/100) ?? '0',
                            $oi_date,
                            $otc_date,
                            $di_date,
                            $dc_date,
                            $da_date,
                            ('invoice no: ' . $order->invoice_no ?? '') . ' | invoice date: ' . ($order->invoice_date ?? ''),
                            ('courier name: ' . $order->courier_name ?? '') . ' | tracking id: ' . ($order->tracking_id ?? '') . ' | courier date: ' . ($order->courier_date ?? '')
                        ]);
                    } else {
                        $row = array_merge($row, array_fill(0, 5, 'N/A'));
                    }
                }
        
                // Admin → bidding summary
                if ($user->role != 4 && $user->role != 5) {
                    $bids = DB::table('biddings')->where('order_id', $order->id)->get();
                    $biddingCount = $bids->count();
                    $lowestBid = $bids->min('price') ?? 'N/A';
                    $highestBid = $bids->max('price') ?? 'N/A';
                    $row = array_merge($row, [$biddingCount, $lowestBid, $highestBid]);
                }
        
                fputcsv($handle, $row);
            }
        
            fclose($handle);
            exit;
        }
        
        elseif ($page == 'supports') {
            $query = DB::table('communications')
                ->leftJoin('users as buyers', 'communications.user_id', '=', 'buyers.id')
                ->leftJoin('users as sellers', 'communications.seller_id', '=', 'sellers.id')
                ->select(
                    'communications.communication_id',
                    'communications.id',
                    'communications.message',
                    'communications.reply',
                    'communications.status',
                    'communications.created_at',
                    DB::raw("CONCAT(buyers.first_name, ' ', buyers.last_name) as buyer_name"),
                    DB::raw("CONCAT(sellers.first_name, ' ', sellers.last_name) as seller_name")
                );
        
            // Date filter
            if ($request->from_date && $request->to_date) {
                $query->whereBetween('communications.created_at', [
                    Carbon::parse($request->from_date)->startOfDay(),
                    Carbon::parse($request->to_date)->endOfDay()
                ]);
            }
        
            $query->where('communications.type', '1');
        
            // Status filter
            if ($request->seller_status && $request->seller_status !== 'all') {
                $query->where('communications.status', $request->seller_status);
            }
        
            // Role-based filtering
            $user = auth()->user();
            if ($user->role == 5) {
                // Buyer
                $query->where('communications.user_id', $user->id);
            } elseif ($user->role == 4) {
                // Seller
                $query->where('communications.seller_id', $user->id);
            }
        
            $communications = $query->get();
        
            // File setup
            $filename = "communications_export_" . Carbon::now()->format('Ymd_His') . ".csv";
        
            header('Content-Type: text/csv');
            header("Content-Disposition: attachment; filename=$filename");
        
            $handle = fopen('php://output', 'w');
        
            // CSV Header
            $headers = [
                'Sr No',
                'Communication Id',
                'Name',
                'Message',
                'Reply',
                'Status',
                'Created At'
            ];
        
            fputcsv($handle, $headers);
        
            foreach ($communications as $k => $comm) {
                // Show opposite party’s name
                if ($user->role == 4) {
                    // Seller logged in → show buyer name
                    $displayName = $comm->buyer_name ?: '-';
                } else {
                    // Buyer logged in → show seller name
                    $displayName = $comm->seller_name ?: '-';
                }
        
                $row = [
                    $k + 1,
                    $comm->communication_id,
                    $displayName,
                    $comm->message,
                    $comm->reply,
                    ucfirst($comm->status),
                    Carbon::parse($comm->created_at)->format('d M, Y H:i'),
                ];
        
                fputcsv($handle, $row);
            }
        
            fclose($handle);
            exit;
        }

        elseif ($page == 'communication-sellers' || $page == 'communication-buyers') {
            $query = DB::table('communications')
                ->leftJoin('users as buyers', 'communications.user_id', '=', 'buyers.id')
                ->leftJoin('users as sellers', 'communications.seller_id', '=', 'sellers.id')
                ->select(
                    'communications.id',
                    'communications.communication_id',
                    'communications.order_no',
                    'communications.cas_no',
                    'communications.impurity_name',
                    'communications.message',
                    'communications.reply',
                    'communications.status',
                    'communications.created_at',
                    DB::raw("CONCAT(buyers.first_name, ' ', buyers.last_name) as buyer_name"),
                    DB::raw("CONCAT(sellers.first_name, ' ', sellers.last_name) as seller_name")
                );
        
            if ($request->from_date && $request->to_date) {
                $query->whereBetween('communications.created_at', [
                    Carbon::parse($request->from_date)->startOfDay(),
                    Carbon::parse($request->to_date)->endOfDay()
                ]);
            }
            
            $query->where('communications.type', '0');
        
            if ($request->seller_status && $request->seller_status !== 'all') {
                $query->where('communications.status', $request->seller_status);
            }
        
            // Apply user-based filtering
            $user = auth()->user();
            if ($user->role == 5) {
                // Buyer
                $query->where('communications.user_id', $user->id);
            } elseif ($user->role == 4) {
                // Seller
                $query->where('communications.seller_id', $user->id);
            }
        
            $communications = $query->get();
        
            $filename = "communications_export_" . Carbon::now()->format('Ymd_His') . ".csv";
        
            header('Content-Type: text/csv');
            header("Content-Disposition: attachment; filename=$filename");
        
            $handle = fopen('php://output', 'w');
        
            // CSV Header (added Communication Id)
            $headers = [
                'ID', 'Seller Name', 'Communication Id', 'Order No', 'CAS No', 'Impurity Name', 'Buyer Name',
                'Buyer Message', 'Seller Reply', 'Status', 'Created At'
            ];
        
            fputcsv($handle, $headers);
        
            foreach ($communications as $k => $comm) {
                $row = [
                    $k+1,
                    $comm->seller_name,
                    $comm->communication_id,
                    $comm->order_no,
                    $comm->cas_no,
                    $comm->impurity_name,
                    $comm->buyer_name,
                    $comm->message,
                    $comm->reply,
                    ucfirst($comm->status),
                    Carbon::parse($comm->created_at)->format('d M, Y H:i'),
                ];
        
                fputcsv($handle, $row);
            }
        
            fclose($handle);
            exit;
        }

        elseif ($page == 'my-biddings') {
            $user = auth()->user();
        
            $query = DB::table('biddings')
                ->leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->select(
                    'biddings.id as bidding_id',
                    'biddings.status as bidStatus',
                    'orders.id as order_id',
                    'orders.created_at as order_date',
                    'products.sku as product_sku',
                    'products.cas_no as product_cas',
                    'products.name as impurity_name',
                    'orders.quantity',
                    'orders.auction_end',
                    'orders.delivery_date'
                );
        
            if (!empty($request->status) && $request->status != 'all') {
                $query->where('biddings.status', $request->status);
            }
            
            if ($user->role == 4) {
                $query->where('biddings.seller_id', $user->id);
            }
            
            if ($user->role == 5) {
                $query->where('orders.buyer_id', $user->id);
            }
            
            if ($request->from_date && $request->to_date) {
                $query->whereBetween('orders.created_at', [
                    Carbon::parse($request->from_date)->startOfDay(),
                    Carbon::parse($request->to_date)->endOfDay()
                ]);
            }
        
            $biddings = $query->get();
        
            $filename = "my_biddings_export_" . Carbon::now()->format('Ymd_His') . ".csv";
        
            header('Content-Type: text/csv');
            header("Content-Disposition: attachment; filename=$filename");
        
            $handle = fopen('php://output', 'w');
        
            // CSV Header  'L1 Bid Rate', 'Tot Offer Count',
            $headers = [
                'Sr No.', 'Order Id', 'Order Dt', 'SKU', 'CAS No',
                'Impurity Name', 'Qty Reqd', 'Bid End Dt and Time', 'Offer End Time', 'Final Order Status'
            ];
            fputcsv($handle, $headers);
        
            $sr = 1;
            foreach ($biddings as $bid) {
                // Calculate L1 (lowest bid) for this order
                $l1Bid = DB::table('biddings')
                    ->where('order_id', $bid->order_id)
                    ->min('price');
        
                // Count offers for this order  $l1Bid ?? 'N/A', $offerCount,
                $offerCount = DB::table('biddings')
                    ->where('order_id', $bid->order_id)
                    ->count();
                
                $os = '';
                if($bid->bidStatus == 'awarded'){
                    $os = "Awarded"; 
                }else{
                    $os = "In Process";
                }
        
                $row = [
                    $sr++,
                    date('y') . (date('y') + 1) . '-' . str_pad($bid->order_id, 4, '0', STR_PAD_LEFT),
                    $bid->order_date ? Carbon::parse($bid->order_date)->format('d M, Y') : '',
                    $bid->product_sku,
                    $bid->product_cas,
                    $bid->impurity_name,
                    $bid->quantity,
                    $bid->auction_end ? Carbon::parse($bid->auction_end)->format('d M, Y H:i') : '',
                    $bid->delivery_date ? Carbon::parse($bid->delivery_date)->format('d M, Y') : '',
                    $os,
                ];
        
                fputcsv($handle, $row);
            }
        
            fclose($handle);
            exit;
        }

    }

    public function cart() {
        return view('frontend/cart');
    }
    
    public function checkout() {
        return view('frontend/checkout');
    }
    
    public function wishlist() {
        return view('frontend/wishlist');
    }
    
    public function saveData(Request $request) {
        
        if($request->page == 'addtocart'){
            
            if(!empty(Auth::user()->id)){
                
                $products = Products::leftjoin('categories','products.category','=','categories.id')
                ->select('categories.discount as sprice','products.*')
                ->where('products.id','=',$request->id)->get();
                
                $total = ($products[0]->price-(($products[0]->price*$products[0]->sprice)/100))*($request->qty ?? '1');
    
                $cart = new Cart_lists();
                
                $cart->branch = Auth::user()->branch ?? '1';
                $cart->uid = Auth::user()->id ?? '';
                $cart->products = (($products[0]->id ?? '').'__'.($products[0]->title ?? '').'__'.($products[0]->price ?? '').'__'.($products[0]->sprice ?? '').'__'.($products[0]->img ?? ''));
                $cart->qty = $request->qty ?? '1';
                $cart->total = $total ?? '';
    
                $cart->status = '1';
                
                $cart->save();
            
            }else{
                
                $cart = array('pid'=>($request->id ?? ''));
                
                session(['cart' => $cart]);
                
            }
            
            return "success";
            
        }elseif($request->page == 'addwishlist'){
            
            if(!empty(Auth::user()->id)){
            
                $wishlist = new Bookmarks();
                
                $wishlist->branch = Auth::user()->branch ?? '1';
                $wishlist->uid = Auth::user()->id ?? '';
                $wishlist->pid = $request->id ?? '';
    
                $wishlist->status = '1';
                
                $wishlist->save();
                
            }else{
                
                $wishlist = array('pid'=>($request->id ?? ''));
                
                session(['wishlist' => $wishlist]);
                
            }
            
            return "success";
            
        }
    }
    
    public function sellerIndex() {
        // Fetch only the first "Home" page (no need for get() unless expecting multiple)
        $output = Pages::where('title', 'Home')
            ->where('status', 1)
            ->first();
    
        // Get active sliders
        $sliders = Sliders::where('status', 1)->get();
    
        // Get all active categories
        $categories = Categories::where('type', 2)->where('status', 1)->get();
    
        // Get latest 'new' products
        $products = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.last_name',
                'products.name',
                'products.sku',
                'products.img',
                'products.slog',
                'products.uom',
                'orders.*'
            )
            ->where(function ($q) {
                $q->where('orders.status') // include pending , pending
                  ->orWhere(function ($q2) {
                      $q2->where('orders.status', 'active')
                         ->whereNotNull('orders.auction_end')
                         ->where('orders.auction_end', '>', now()); // only not expired
                  });
            })
            ->orderBy('orders.id', 'desc')
            ->limit(8)
            ->get();

        return view('frontend.seller.index', [
            'output'     => $output,
            'sliders'    => $sliders,
            'categories' => $categories,
            'products'   => $products
        ]);
    }
    
    public function sellerAbout() {
        
        $about = Pages::where('title','LIKE','About Us')
            ->where('status','=','1')->get();
        
        $mission = Pages::where('title','LIKE','Mission')
            ->where('status','=','1')->get();
        
        $vission = Pages::where('title','LIKE','Vission')
            ->where('status','=','1')->get();
        
        return view('frontend/seller/about-us',['about'=>$about,'mission'=>$mission,'vission'=>$vission]);
    }
    
    public function sellerFaq() {
        
        $about = Pages::where('title','LIKE','About Us')
            ->where('status','=','1')->get();
        
        $mission = Pages::where('title','LIKE','Mission')
            ->where('status','=','1')->get();
        
        $vission = Pages::where('title','LIKE','Vission')
            ->where('status','=','1')->get();
        
        return view('frontend/seller/how-it-works',['about'=>$about,'mission'=>$mission,'vission'=>$vission]);
    }
    
    public function sellerBlog(Request $request, $category_slog = null) {
        $query = Posts::where('status', 1);
    
        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
    
        // Category filter
        if ($category_slog) {
            $query->where('category',$category_slog); 
        }
    
        $posts = $query->latest()->paginate(10);
    
        $categories = Post_categories::where('status', 1)->get();
    
        return view('frontend.seller.blog', compact('posts', 'categories', 'category_slog'));
    }

    public function sellerBlogArticle($category_slog, $article_slog) {
        $categories = Post_categories::where('status', 1)
            ->withCount(['posts' => function ($query) {
                $query->where('status', 1);
            }])
            ->get();

        $post = Posts::where('slog', $article_slog)
            ->where('status', 1)
            ->firstOrFail();

        // Related posts (optional)
        $relatedPosts = Posts::where('category', $category_slog)
            ->where('id', '!=', $post->id)
            ->where('status', 1)
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.seller.blog-details', compact('post', 'categories', 'relatedPosts'));
    }
    
    public function sellerProducts(Request $request) {
        
        $pagetitle = "All Products";
        
        // Get all active categories
        $categories = Categories::where('type', 2)->where('status', 1)->get();
        
        // Get latest 'new' products
        $query = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.last_name',
                'products.name',
                'products.sku',
                'products.img',
                'products.slog',
                'products.uom',
                'orders.*'
            )
            ->where(function ($q) {
                $q->where('orders.status') // include pending, pending
                  ->orWhere(function ($q2) {
                      $q2->where('orders.status', 'active')
                         ->whereNotNull('orders.auction_end')
                         ->where('orders.auction_end', '>', now()); // only not expired
                  });
            });
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'like', "%{$search}%")
                  ->orWhere('products.sku', 'like', "%{$search}%")
                  ->orWhere('products.cas_no', 'like', "%{$search}%")
                  ->orWhere('products.tags', 'like', "%{$search}%")
                  ->orWhere('users.first_name', 'like', "%{$search}%")
                  ->orWhere('users.last_name', 'like', "%{$search}%");
            });
        }
    
        
        $products = $query->orderBy('orders.id', 'desc')
            ->get();
        
        return view('frontend.seller.products',['products'=>$products,'pagetitle'=>$pagetitle]);
    }
    
    public function sellerCategory($category_slog) {
        // Fetch the category by slog first
        $category = Categories::where('slog', $category_slog)->first();
    
        if (!$category) {
            abort(404, 'Category not found.');
        }
        
        $products = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.last_name',
                'products.name',
                'products.sku',
                'products.img',
                'products.slog',
                'products.uom',
                'orders.*'
            )
            ->where('products.category', $category->id)
            ->where(function ($q) {
                $q->where('orders.status') // include pending , pending
                  ->orWhere(function ($q2) {
                      $q2->where('orders.status', 'active')
                         ->whereNotNull('orders.auction_end')
                         ->where('orders.auction_end', '>', now()); // only not expired
                  });
            })
            ->orderBy('orders.id', 'desc')
            ->get();
    
        // Then fetch products belonging to the found category
        /*$products = Products::where('category', $category->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();*/
    
        $pagetitle = $category->title ?? 'Products';
    
        return view('frontend.seller.products', [
            'products' => $products,
            'pagetitle' => $pagetitle,
        ]);
    }

    public function sellerProductDetails($product_slog,$oid) {
        // Fetch the product with its category
        $product = Products::leftJoin('categories', 'products.category', '=', 'categories.id')
            ->leftJoin('orders', 'products.id', '=', 'orders.product_id')
            ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->select(
                'categories.title as category_title',
                'categories.slog as cslog',
                'orders.id as orderId',
                'orders.quantity',
                'orders.delivery_date',
                'orders.delivery_location',
                'orders.specific_requirements',
                'orders.attachments',
                'orders.auction_end',
                'orders.bid_view_status',
                'products.*',
                DB::raw('(SELECT MIN(price) FROM biddings WHERE biddings.order_id = orders.id) as min_bid_price')
            )
            ->where('products.slog', $product_slog)
            ->where('orders.id', $oid)
            ->where('products.status', 1)
            ->first();
    
        // If no product found, abort with 404
        if (!$product) {
            abort(404, 'Product not found.');
        }
    
        // Fetch related products from the same category
        $biddings = Biddings::leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
            ->select('biddings.*')
            ->where('orders.id', $product->orderId)
            ->where('biddings.status', 'pending')
            ->orderBy('biddings.id','desc')
            ->get();
    
        return view('frontend.seller.product-details', [
            'product' => $product,
            'biddings' => $biddings
        ]);
    }

    public function sellerProductDetailsPost(Request $request, $product_slog){
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:orders,id',
                'seller_id' => 'required|integer|exists:users,id',
                'price' => 'required|numeric|min:0',
                'days' => 'required|integer|min:1',
                'storage-temp-min' => 'required|numeric',
                'storage-temp-max' => 'required|numeric|gte:storage-temp-min',
            ]);
            
            $order = Orders::where('id', $validated['order_id'])
                ->first();
                
            $getLastBidding = Biddings::where('order_id', $validated['order_id'])
                ->orderBy('id','desc')
                ->first();
    
            $bidding = new Biddings();
            $bidding->order_id = $validated['order_id'];
            $bidding->seller_id = $validated['seller_id'];
            $bidding->price = $validated['price'];
            $bidding->days = $validated['days'];
            $bidding->temp = $validated['storage-temp-min'] . ' to ' . $validated['storage-temp-max'];
            $bidding->status = 'pending';
            
            // if (
            //     Carbon::parse($order->auction_end)->greaterThanOrEqualTo(now()) 
            //     && (($getLastBidding->price ?? 100000000000) > $bidding->price)
            // ) {
            $bidding->save();
            
            // Get all earlier bidders for this order except current bidder
            /*$previousBidders = Biddings::where('order_id', $order->id)
                ->where('seller_id', '!=', $validated['seller_id'])
                ->with('seller') // relation defined in model
                ->get();*/
                                  
            /*if(count($previousBidders) > 0){
                
                foreach ($previousBidders as $bidder) {
                    if (!$bidder->seller) {
                        continue; // safety check
                    }
                
                    $details = [
                        'seller_name'    => $bidder->seller->first_name . ' ' . $bidder->seller->last_name,
                        'order_id'       => $order->id,
                        'offer_end_time' => isset($order->auction_end) 
                                                ? date('d M, Y H:i A', strtotime($order->auction_end)) 
                                                : 'N/A',
                    ];
                
                    $subject = "Better Offer Available - Update Your Offer";
                    $template = "emails.better_offer_notification";
                
                    Mail::to($bidder->seller->email)->send(new MailModel($details, $subject, $template));
                }

                
            }*/
        
            return redirect()->back()->with('success', 'Your bid has been submitted successfully.');
            // }
            
            // // Error case
            // return redirect()->back()->with('error', 'Your bid could not be submitted. Auction may be closed or your bid is too high.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while submitting your bid.');
        }
    }

    public function sellerContactUs() {
        
        $contacts = Contacts::where('id','=','1')->get();
        
        return view('frontend/seller/contact-us',['contacts'=>$contacts]);
    }
    
    public function sellerSupportPolicy() {
        
        $output = Pages::where('title','LIKE','Support-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/seller/support-policy',['output'=>$output]);
    }
    
    public function sellerReturnPolicy() {
        
        $output = Pages::where('title','LIKE','Return-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/seller/return-policy',['output'=>$output]);
    }
    
    public function sellerSellerPolicy() {
        
        $output = Pages::where('title','LIKE','Seller-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/seller/seller-policy',['output'=>$output]);
    }
    
    public function sellerBuyerPolicy() {
        
        $output = Pages::where('title','LIKE','Buyer-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/seller/buyer-policy',['output'=>$output]);
    }
    
    public function sellerNonDisclosureAgreement() {
        
        $output = Pages::where('title','LIKE','NDA-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/seller/non-disclosure-agreement',['output'=>$output]);
    }
    
    public function sellerRefundPolicy() {
        
        $output = Pages::where('title','LIKE','Refund-Policy')
            ->where('status','=','1')->get();
        
        return view('frontend/seller/refund-policy',['output'=>$output]);
    }
    
    public function sellerPrivacyPolicy() {
        
        $output = Pages::where('title','LIKE','Privacy-Policy')
            ->where('status','=','1')->first();
        
        return view('frontend/seller/privacy-policy',['output'=>$output]);
    }
    
    public function sellerTermsConditions() {
        
        $output = Pages::where('title','LIKE','Terms-Conditions')
            ->where('status','=','1')->first();
        
        return view('frontend/seller/terms-conditions',['output'=>$output]);
    }
    
    public function sellerContactForm(Request $request){
        
        $name = $request->name ?? '';
        $email = $request->email ?? '';
        $phone = $request->phone ?? '';
        $msg = $request->message ?? '';
        
        $contact = new Enquiries();
        //name	email	phone	msg	
        $contact->name = $request->name ?? '';
        $contact->email = $request->email ?? '';
        $contact->phone = $request->phone ?? '';
        $contact->msg = $request->message ?? '';
        $contact->status = '1';
        
        $to = "iwebbrella@gmail.com";
        $subject = "Received";
        
        $message = "New contact form message received from website<br><br><b>Name:</b> $name<br><b>Email Id:</b>$email<br><b>Phone:</b> $phone<br><b>Messsage:</b> $msg";
        
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // More headers
        $headers .= 'From: ImpurityX <admin@'.$request->getHost().'>' . "\r\n";
        
        mail($to,$subject,$message,$headers);
        
        $contact->save();

        return redirect('frontend/seller/contact-us')->with('success', 'Successfully Submitted!!');

        return redirect('frontend/seller/contact-us')->with('error', 'Oops, Somethings went worng.');
        
    }
    
    public function sellerRegister() {
        return view('frontend/seller/register');
    }

    public function sellerRegisterPost(Request $request) {
        // Validate the incoming request
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mob' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'company' => 'required|string|max:255',
            'trade' => 'required|string|max:255',
            'incomTaxno' => 'required|string|max:255',
            'taxNo' => 'required|string|max:255',
            'regAddress' => 'required|string|max:500',
            'comAddress' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);
    
        try {
            // Create User
            $user = new User();
            $user->first_name = $request->fname;
            $user->last_name = $request->lname;
            $user->mob = $request->mob;
            $user->whatsapp = $request->whatsapp;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->branch = '1';
            $user->photo = '';
            $user->dob = '';
            $user->gender = '';
            $user->role = '4';
            //$user->notify = '1';
            $user->status = '0';
            $user->save();
    
            // Create Usermeta
            $meta = new Usermetas();
            $meta->uid = $user->id;
            $meta->company = $request->company;
            $meta->trade = $request->trade;
            $meta->panno = $request->incomTaxno;
            $meta->vat = $request->taxNo;
            $meta->regAddress = $request->regAddress;
            $meta->comAddress = $request->comAddress;
            $meta->city = $request->city;
            $meta->pincode = $request->pincode;
            $meta->state = $request->state;
            $meta->country = $request->country;
            $meta->status = '1';
            $meta->save();
    
            // Attempt login
            //if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                //session(['users' => $user]);
            
            if(!empty($user->id)){
                
                // Generate OTP
                $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                
                // Store OTP in session with expiry
                session([
                    'otp_code'       => $otp,
                    'otp_email'      => $user->email,
                    'otp_expires_at' => now()->addMinutes(10),
                ]);
                
                // Prepare details for the Mailable + Blade view
                $details = [
                    'user_name'       => trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: ($user->name ?? 'User'),
                    'otp'             => $otp,
                    'expires_minutes' => 10,
                    'brand'           => 'ImpurityX',
                    'support_email'   => 'support@' . request()->getHost(),
                ];
                
                // Send using your MailModel wrapper and a dedicated view
                Mail::to($user->email)->send(
                    new MailModel(
                        $details,
                        "Verify your email address",
                        "emails.otp_verification"
                    )
                );
                
                // Redirect to OTP verify page
                return redirect()
                    ->route('otp.sellerShow', ['email' => $user->email])
                    ->with('success', 'Your account was created. We emailed you a 6-digit code.');
                
                //return redirect('/seller')->with('success', 'Your request has been submitted please check your email');// . $user->first_name . '!'
            }
    
            return back()->with('error', 'Something went wrong during login.');
    
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function sellerShow(Request $request) {
        $email = $request->query('email') ?? session('otp_email');

        return view('frontend/seller/seller-otp', [
            'email' => $email
        ]);
    }

    public function sellerVerifyOtp(Request $request) {
        
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|string|size:6',
        ]);
    
        // Pull session data
        $otp       = session('otp_code');
        $otpEmail  = session('otp_email');
        $otpExpiry = session('otp_expires_at');
    
        if (!$otp || !$otpEmail || !$otpExpiry) {
            return back()->withErrors(['code' => 'OTP session expired. Please request a new one.']);
        }
    
        // Validate email & OTP (case-insensitive email, constant-time code compare)
        $emailMatches = Str::lower($request->email) === Str::lower($otpEmail);
        $codeMatches  = hash_equals((string)$otp, (string)$request->code);
        $notExpired   = now()->lt($otpExpiry);
    
        if ($emailMatches && $codeMatches && $notExpired) {
            // Clear OTP from session
            session()->forget(['otp_code','otp_email','otp_expires_at']);
    
            // Activate / verify user
            $user = User::where('email', $request->email)->first();
            if ($user) {
                //$user->status = '1';
                $user->email_verified_at = now();
                $user->save();
            }
    
            return redirect('/seller/login')->with('success', 'Email verified successfully!');
        }
    
        return back()->withErrors(['code' => 'Invalid or expired code']);
        
    }
    
    public function sellerLogin() {
        return view('frontend/seller/login');
    }
    
    public function sellerLoginPost(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
    
        // Logout buyer & admin
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
    
        if (Auth::guard('seller')->attempt($credentials)) {
            $user = Auth::guard('seller')->user();
            
            if ($user->status != '1') {
                Auth::guard('seller')->logout();
                return back()->with('error', 'Your account is inactive. Please contact the support team for assistance.');
            }
    
            if ($user->role == '4') {
                session(['users' => $user]);
                return redirect('/seller')->with('success', 'Welcome Back, ' . $user->first_name . '!');
            }
    
            Auth::guard('seller')->logout();
            return back()->with('error', 'You are not authorized as a seller.');
        }
    
        return back()->with('error', 'Invalid login credentials.');
    }
    
    public function sellerResetPassword($id) {
        return view('frontend/seller/reset-password',['key'=>$id]);
    }
    
    public function sellerRasswordPost(Request $request) {
        $request->validate([
            'secretkey' => 'required|string',
            'password' => 'required|confirmed|min:6',
        ]);
        
        $key = explode('$impx',($request->secretkey ?? ''));
    
        $reset = DB::table('password_reset_tokens')
            ->where('email', $key[0])
            ->first();
    
        if ($reset && ($request->secretkey == $reset->token)) {
            User::where('id', $key[0])->update([
                'password' => Hash::make($request->password)
            ]);
    
            DB::table('password_reset_tokens')->where('email', $key[0])->delete();
    
            return redirect('/seller/login')->with('success', 'Password reset successful! Please login with your new password.');
        }
    
        return back()->with('error', 'Invalid or expired reset token.');
    }
    
    public function sellerForgotPassword() {
        return view('frontend/seller/forgot-password');
    }
    
    public function sellerForgotPasswordPost(Request $request) {
        
        $user = User::where('email','=',$request->username)->where('status','=','1')->get();
        
        if (count($user) > 0) {
        
            session(['useremail' => $request->username]);
        
            // Generate secure reset link https://".$request->getHost().'/reset-password/'.$user[0]->id.$user[0]->password;
            $resetLink = 'https://' . $request->getHost() . '/seller/reset-password/' . $user[0]->id .'$impx'. md5($user[0]->password);
        
            // Prepare mail details
            $details = [
                'user_name'     => trim(($user[0]->first_name ?? '') . ' ' . ($user[0]->last_name ?? '')) ?: ($user[0]->name ?? 'User'),
                'reset_link'    => $resetLink,
                'brand'         => 'ImpurityX',
                'support_email' => 'support@impurityx.com',
            ];
            
            $token = $user[0]->id .'$impx'. md5($user[0]->password);
            $email = $user[0]->id;
            
            DB::table('password_reset_tokens')->insert([
                'email' => $email,  // e.g. $key[0]
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        
            // Send mail using your MailModel and a Blade view
            Mail::to($request->username)->send(
                new MailModel(
                    $details,
                    "Reset Password Link - ImpurityX",
                    "emails.password_reset" // <-- create this Blade view
                )
            );
        
            return redirect('/seller/login')->with('success', 'Password reset link has been sent to your registered email ID. Please check it.');
        } else{
            return back()->with('error', 'Invalid email address. Please try again');
        }
    }
    
    public function sellerLogout(Request $request) {
        Auth::guard('seller')->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/seller/login')->with('success', 'You have been logged out.');
    }

    public function sellerMyAccount($page, Request $request) {
        
        
        if($page == 'dashboard'){
            
            // $Order_initiated = Biddings::leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
            //     ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            //     ->leftJoin('users as buyers', 'orders.buyer_id', '=', 'buyers.id')
            //     ->where('biddings.seller_id','=',Auth::User()->id)
            //     ->where('orders.seller_status','=','')
            //     ->orWhere('orders.seller_status','=','order-initiated')
            //     ->count();
            
            // $orderTaskCompleted = Biddings::leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
            //     ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            //     ->leftJoin('users as buyers', 'orders.buyer_id', '=', 'buyers.id')
            //     ->where('biddings.seller_id','=',Auth::User()->id)
            //     ->where('orders.seller_status','=','order-task-completed')
            //     ->count();
            
            // $DeliveryInitiated = Biddings::leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
            //     ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            //     ->leftJoin('users as buyers', 'orders.buyer_id', '=', 'buyers.id')
            //     ->where('biddings.seller_id','=',Auth::User()->id)
            //     ->where('orders.seller_status','=','delivery-initiated')
            //     ->count();
            
            // $DeliveryCompleted = Biddings::leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
            //     ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            //     ->leftJoin('users as buyers', 'orders.buyer_id', '=', 'buyers.id')
            //     ->where('biddings.seller_id','=',Auth::User()->id)
            //     ->where('orders.seller_status','=','delivery-completed')
            //     ->count();
                
            $nowdate = now();
            
            $myActiveBidsCount = Orders:://where('buyer_id', auth()->id())
                where('auction_end', '>', $nowdate)
                ->where('status', 'active') // <-- add status filter
                ->count();
        
            $myAPBidsCount = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
                ->where('biddings.seller_id', auth()->id())
                ->where('orders.status', 'active')
                ->count();
    
            $myActiveBids = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
                ->where('biddings.seller_id', auth()->id())
                ->where('orders.status', 'active')
                ->selectRaw('COUNT(biddings.id) as total_bids, SUM(biddings.price) as total_amount')
                ->first();
            
            $myABBidsCount = $myActiveBids->total_bids ?? 0;
            $myABBidsAmount = $myActiveBids->total_amount ?? 0;
    
            $myAABids = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
                ->where('biddings.status', 'selected')
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
                ->where('biddings.seller_id', auth()->id())
                ->whereDate('biddings.created_at', '>=', $mtdStart)
                ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $ytd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
                ->where('biddings.status', 'awarded')
                ->where('biddings.seller_id', auth()->id())
                ->whereDate('biddings.created_at', '>=', $ytdStart)
                ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $ctd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
                ->where('biddings.status', 'awarded')
                ->where('biddings.seller_id', auth()->id())
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
                ->where('biddings.seller_id', auth()->id())
                ->whereDate('biddings.created_at', '>=', $mtdStart)
                ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $oCytd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
                ->where('orders.seller_status', 'accepted')
                ->where('biddings.seller_id', auth()->id())
                ->whereDate('biddings.created_at', '>=', $ytdStart)
                ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $oCctd = Biddings::leftJoin('orders', 'orders.id', '=', 'biddings.order_id')
                ->where('orders.seller_status', 'accepted')
                ->where('biddings.seller_id', auth()->id())
                ->selectRaw('COUNT(biddings.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $wipOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->whereIn('orders.seller_status', ['order-initiated','order-task-completed'])
                ->where('biddings.seller_id', auth()->id())
                ->where('biddings.status', '=', 'awarded')
                ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $wipOrdercount = $wipOrder->count ?? 0;
            $wipOrderAmt = $wipOrder->amount ?? 0;
            
            $otcOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->where('orders.status', 'active')
                ->where('biddings.seller_id', auth()->id())
                ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $otcOrdercount = $otcOrder->count ?? 0;
            $otcOrderAmt = $otcOrder->amount ?? 0;
            
            $diOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->where('orders.seller_status', '=', 'delivery-initiated')
                ->where('biddings.seller_id', auth()->id())
                ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $diOrdercount = $diOrder->count ?? 0;
            $diOrderAmt = $diOrder->amount ?? 0;
            
            $completeOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->where('orders.seller_status', '=', 'delivery-completed')
                ->where('biddings.seller_id', auth()->id())
                ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $completeOrdercount = $completeOrder->count ?? 0;
            $completeOrderAmt = $completeOrder->amount ?? 0;
    
            $acceptOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->where('orders.seller_status', '=', 'accepted')
                ->where('biddings.seller_id', auth()->id())
                ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $acceptOrdercount = $acceptOrder->count ?? 0;
            $acceptOrderAmt = $acceptOrder->amount ?? 0;
            
            /*$wiplOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->where('orders.seller_status', '=', 'order-initiated')
                ->where('biddings.seller_id', auth()->id())
                ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $wiplOrdercount = $wiplOrder->count ?? 0;
            $wiplOrderAmt = $wiplOrder->amount ?? 0;*/
            $wiplOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->where('orders.seller_status', 'order-initiated')
                ->where('biddings.seller_id', auth()->id())
                ->where('biddings.status', 'awarded')
                ->whereRaw("
                    DATE_ADD(biddings.updated_at, INTERVAL biddings.days DAY) >= ?
                ", [now()])
                ->selectRaw('
                    COUNT(DISTINCT orders.id) as count,
                    SUM(biddings.price) as amount
                ')
                ->first();
            
            $wiplOrdercount = $wiplOrder->count ?? 0;
            $wiplOrderAmt   = $wiplOrder->amount ?? 0;

            
            $dilOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->where('orders.seller_status', '=', 'delivery-initiated')
                ->where('biddings.status', '=', 'awarded')
                ->where('biddings.seller_id', auth()->id())
                ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $dilOrdercount = $dilOrder->count ?? 0;
            $dilOrderAmt = $dilOrder->amount ?? 0;
            
            $completelOrder = Orders::leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->where('orders.seller_status', '=', 'delivery-completed')
                ->where('biddings.status', '=', 'awarded')
                ->where('biddings.seller_id', auth()->id())
                ->selectRaw('COUNT(orders.id) as count, SUM(biddings.price) as amount')
                ->first();
            
            $completelOrdercount = $completelOrder->count ?? 0;
            $completelOrderAmt = $completelOrder->amount ?? 0;
            
            $pendingCount  = buyer_product_enquiries::where('status', 0)->where('user_id', auth()->id())->count();
            $approvedCount = buyer_product_enquiries::where('status', 1)->where('user_id', auth()->id())->count();
            $rejectedCount = buyer_product_enquiries::where('status', 2)->where('user_id', auth()->id())->count();

            return view('frontend/seller/seller-dashboard',
            [//'pending_orders'=>$Order_initiated,'orderTaskCompleted'=>$orderTaskCompleted,'DeliveryInitiated'=>$DeliveryInitiated,'DeliveryCompleted'=>$DeliveryCompleted,
                'page'=>$page,
                'myActiveBidsCount'   => $myActiveBidsCount,
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
            
        }
        
        if($page == 'my-biddings'){
            
            $biddings = Biddings::leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('users as buyers', 'orders.buyer_id', '=', 'buyers.id')
                ->select(
                    'buyers.first_name as buyer_fname',
                    'buyers.last_name as buyer_lname',
                    'buyers.mob as buyer_mobile',
                    'buyers.email as buyer_email',
                    'products.id as pid',
                    'products.name as proName',
                    'products.sku',
                    'products.slog',
                    'orders.id as oid',
                    'orders.quantity',
                    'orders.delivery_date',
                    'orders.delivery_location',
                    'orders.specific_requirements',
                    'orders.attachments',
                    'orders.auction_end',
                    'orders.status as orderStatus',
                    'biddings.*'
                )
                ->where('biddings.seller_id','=',Auth::User()->id)
                ->orderBy('biddings.id', 'desc')
                ->get();

            return view('frontend/seller/seller-dashboard',['page'=>$page,'biddings'=>$biddings]);
            
        }
        
        //dd($request);
        if($page == 'supports' && !empty($request->communicationId)){
            
            $request->validate([
                'communicationId' => 'required|string',
                'orderNo' => 'nullable|string',
                'casNo' => 'nullable|string',
                'impurityName' => 'nullable|string',
                'message' => 'required|string',
            ]);
        
            // Generate Communication ID
            //$last = Communications::orderBy('id', 'desc')->first();
        
            // Save to DB
            $comm = new Communications();
            $comm->communication_id = $request->communicationId;
            $comm->order_no = $request->orderNo;
            $comm->cas_no = $request->casNo;
            $comm->impurity_name = $request->impurityName;
            $comm->message = $request->message;
            $comm->seller_id = auth()->id();
            $comm->type = '1';
            $comm->save();
        
            return redirect()->back()->with('success', 'Message sent successfully!');
            
        }
        
        if($page == 'supports'){
            
            if(!empty($request->id)){
                $getCom = Communications::where('id',$request->id)->first();
            }
            
            $communications = Communications::where('seller_id',auth()->id())->where('type','1')->orderBy('id', 'desc')->get();
            
            $getCommunications = Communications::orderBy('id', 'desc')->first();

            if ($getCommunications) {
                $communicationId = 'CSA-' . str_pad($getCommunications->id, 5, '0', STR_PAD_LEFT);
            } else {
                $communicationId = 'CSA-00001'; // first communication ID
            }

            return view('frontend/seller/seller-dashboard',['page'=>$page,'communications'=>$communications,'communicationId'=>$communicationId,'getCom'=>($getCom ?? [])]);
            
        }
        
        //dd($request);
        if($page == 'communication-buyers' && !empty($request->orderNo)){
            
            if(empty($request->replyId)){
            
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
                
                $getOrderDetails = Orders::where('id','=',$orderId)->first();
            
                // Save to DB
                $comm = new Communications();
                $comm->communication_id = $request->communicationId;
                $comm->order_no = $request->orderNo;
                $comm->cas_no = $request->casNo;
                $comm->impurity_name = $request->impurityName;
                $comm->message = $request->message;
                $comm->user_id = $getOrderDetails->buyer_id;
                $comm->seller_id = auth()->id();
                $comm->type = '0';
                $comm->save();
        
                return redirect()->back()->with('success', 'Message sent successfully!');
                
            }else{
                
                $request->validate([
                    'replyId' => 'required',
                    'message' => 'required|string',
                ]);
                
                $comm = Communications::find($request->replyId);
                
                $comm->reply = $request->message;
                $comm->status = 'closed';
                $comm->save();
        
                $previous = url()->previous();
                $cleanUrl = strtok($previous, '?');
                
                return redirect($cleanUrl."?id=".($request->replyId ?? ''))->with('success', 'Submitted');
                
            }
            
        }
        
        if($page == 'communication-buyers'){
            
            if(!empty($request->id)){
                $getCom = Communications::where('id',$request->id)->first();
            }
            
            $communications = Communications::where('seller_id',auth()->id())->where('type','0')->orderBy('id', 'desc')->get();
            
            $getCommunications = Communications::orderBy('id', 'desc')->first();

            if ($getCommunications) {
                $communicationId = 'CSB-' . str_pad($getCommunications->id, 5, '0', STR_PAD_LEFT);
            } else {
                $communicationId = 'CSB-00001'; // first communication ID
            }

            return view('frontend/seller/seller-dashboard',['page'=>$page,'communications'=>$communications,'communicationId'=>$communicationId,'getCom'=>($getCom ?? [])]);
            
        }
        
        if($page == 'my-profile'){
            
            if(!empty($request->email)){
                $user = auth()->user();
            
                $request->validate([
                    'first_name'     => 'required|string|max:255',
                    'last_name'      => 'nullable|string|max:255',
                    'contact'        => 'nullable|max:15',
                    'whatsapp'        => 'nullable|max:15',
                    'email'          => 'required|email|unique:users,email,' . $user->id,
                    'password'       => 'nullable|string|min:6|confirmed',
                    'profile_photo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            
                    // UserMeta fields
                    'company'        => 'nullable|string|max:255',
                    'trade'          => 'nullable|string|max:255',
                    'panno'          => 'nullable|string|max:50',
                    'vat'            => 'nullable|string|max:50',
                    'regAddress'     => 'nullable|string|max:500',
                    'comAddress'     => 'nullable|string|max:500',
                    'city'           => 'nullable|string|max:100',
                    'pincode'        => 'nullable|string|max:20',
                    'state'          => 'nullable|string|max:100',
                    'country'        => 'nullable|string|max:100',
                ]);
            
                // Update basic details
                $user->first_name = $request->first_name;
                $user->last_name  = $request->last_name;
                $user->email      = $request->email;
                $user->mob      = $request->contact;
                $user->whatsapp      = $request->whatsapp;
            
                // If password is entered, update it
                if ($request->filled('password')) {
                    $user->password = bcrypt($request->password);
                }
            
                // If profile photo uploaded public/assets/frontend/img/users/ 
                if ($request->hasFile('profile_photo')) {
                    $file = $request->file('profile_photo'); // get uploaded file
                    $filename = time().'.'.$file->getClientOriginalExtension(); // unique name
                    $file->move(public_path('assets/frontend/img/users/'), $filename); // move to folder
                    $user->photo = $filename; // save filename in DB
                }

                $user->save();
                
                $usermetas = Usermetas::where('uid',$user->id)->first();
                $usermetas->company    = $request->company;
                $usermetas->trade      = $request->trade;
                $usermetas->panno      = $request->panno;
                $usermetas->vat        = $request->vat;
                $usermetas->regAddress = $request->regAddress;
                $usermetas->comAddress = $request->comAddress;
                $usermetas->city       = $request->city;
                $usermetas->pincode    = $request->pincode;
                $usermetas->state      = $request->state;
                $usermetas->country    = $request->country;
                $usermetas->save();
            
                return back()->with('success', 'Profile updated successfully.');
            }
            
            $user = User::leftJoin('usermetas','users.id','=','usermetas.uid')
                ->where('users.id',Auth::User()->id)->first();

            return view('frontend/seller/seller-dashboard',['page'=>$page,'user'=>$user]);
            
        }
        
        /*if($page == 'my-notices'){
            
            $notices = Notices::where('type','sellers')->orderBy('id','desc')->get();

            return view('frontend/seller/seller-dashboard',['page'=>$page,'notices'=>($notices ?? [])]);
            
        }*/
        
        if ($page == 'my-notices') {
            $user = session('users');
            $user = User::find($user->id);
        
            $notify = json_decode(($user->notify ?? ''),true) ?? [];
            if (!is_array($notify)) {
                $notify = [];
            }
            
            if (($notify['notice'] ?? 0) == 1) {
                $notify['notice'] = 0;
                $user->notify = $notify;
                $user->save();
            }
        
            $notices = Notices::where('type', 'sellers')
                ->orderBy('id', 'desc')
                ->get();
        
            return view('frontend/seller/seller-dashboard',['page'=>$page,'notices'=>($notices ?? [])]);
        }
        
        /*if($page == 'delivery-acceptance'){
            
            $myorders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
                ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->leftJoin('users as sellers', 'biddings.seller_id', '=', 'sellers.id')
                ->select(
                    'sellers.first_name',
                    'sellers.last_name',
                    'products.name',
                    'products.sku',
                    'products.img',
                    'products.slog',
                    'products.uom',
                    'biddings.price',
                    'orders.*'
                )
                ->where('orders.buyer_id',Auth::User()->id)
                ->where('orders.status','awarded')
                ->where('biddings.status','awarded')
                ->orderBy('orders.id', 'desc')
                ->get();

            return view('frontend/seller/seller-dashboard',['page'=>$page,'myorders'=>$myorders]);
            
        }*/
        
        if($page == 'bidding-status'){
            
            $myorders = Biddings::leftJoin('orders', 'biddings.order_id', '=', 'orders.id')
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('users as buyers', 'orders.buyer_id', '=', 'buyers.id')
                ->leftJoin('users as sellers', 'biddings.seller_id', '=', 'sellers.id')
                ->select(
                    'orders.id as order_id',
                    'orders.created_at as order_date',
                    'orders.quantity as qty_reqd',
                    'orders.seller_status',
                    'orders.delivery_date as expdly_dt',
                    'products.name as impurity_name',
                    'products.sku',
                    'products.cas_no',
                    'products.uom',
                    'biddings.price as rate_pu',
                    DB::raw('(biddings.price * orders.quantity) as order_val'),
                    'biddings.days',
                    'biddings.status as bidding_status',
                    'biddings.created_at as awarded_date',
                    'buyers.first_name as buyer_fname',
                    'buyers.last_name as buyer_lname',
                    'buyers.email as buyer_email',
                    'sellers.first_name as seller_fname',
                    'sellers.last_name as seller_lname',
                    'sellers.email as seller_email'
                )
                ->where('biddings.seller_id', Auth::id())
                ->orderBy('biddings.id', 'desc')
                ->get();


            return view('frontend/seller/seller-dashboard', [
                'page' => 'bidding-status',
                'myorders' => $myorders
            ]);
            
        }
        
        if($page == 'completed-orders'){
            
            $myorders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
                ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                //->leftJoin('users as sellers', 'biddings.seller_id', '=', 'sellers.id')
                ->select(
                    'orders.id as order_id',
                    'orders.created_at as order_date',
                    'orders.quantity as qty_reqd',
                    'orders.invoice_no',
                    'orders.status',
                    'orders.delivery_location',
                    'orders.seller_status',
                    'orders.delivery_date as expdly_dt',
                    'products.name as impurity_name',
                    'products.sku',
                    'products.cas_no',
                    'products.uom',
                    'biddings.price as rate_pu',
                    DB::raw('(biddings.price * orders.quantity) as order_val'),
                    'biddings.days',
                    'biddings.created_at as awarded_date',
                    'users.first_name as seller_fname',
                    'users.last_name as seller_lname',
                    'users.email as seller_email'
                )
                ->where('biddings.seller_id', Auth::id())
                ->where('orders.status', 'closed')
                ->where('biddings.status', 'awarded')
                ->orderBy('orders.id', 'desc')
                ->get();
            
            return view('frontend/seller/seller-dashboard', [
                'page' => 'completed-orders',
                'myorders' => $myorders
            ]);
            
        }
        
        if($page == 'sales-report'){
            
            $myorders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
                ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
                ->leftJoin('users as sellers', 'biddings.seller_id', '=', 'sellers.id')
                ->leftJoin('usermetas as buyerMetas', 'orders.buyer_id', '=', 'buyerMetas.uid')
                ->select(
                    'orders.id as order_id',
                    'orders.created_at as order_date',
                    'orders.quantity as qty_reqd',
                    'orders.invoice_no',
                    'orders.status',
                    'orders.seller_status',
                    'orders.delivery_date as expdly_dt',
                    'products.name as impurity_name',
                    'products.sku',
                    'products.cas_no',
                    'products.uom',
                    'products.gst',
                    'biddings.price as rate_pu',
                    DB::raw('(biddings.price * orders.quantity) as order_val'),
                    'biddings.days',
                    'biddings.created_at as awarded_date',
                    'users.first_name as seller_fname',
                    'users.last_name as seller_lname',
                    'users.email as seller_email',
                    'buyerMetas.vat'
                )
                ->where('biddings.seller_id', Auth::id())
                ->whereIn('orders.status', ['awarded','closed'])
                ->whereIn('orders.seller_status', ['accepted'])
                ->where('biddings.status', 'awarded')
                ->orderBy('orders.id', 'desc')
                ->get();
            
            return view('frontend/seller/seller-dashboard', [
                'page' => 'sales-report',
                'myorders' => $myorders
            ]);
            
        }
        
        $myorders = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
            ->leftJoin('biddings', 'orders.id', '=', 'biddings.order_id')
            ->select(
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.mob',
                'products.name',
                'products.sku',
                'products.cas_no',
                'products.img',
                'products.slog',
                'products.uom',
                'biddings.price',
                'orders.*'
            )
            ->where('biddings.seller_id',Auth::User()->id)
            ->where('biddings.status','awarded')
            ->orderBy('orders.id', 'desc')
            ->get();
        
        /*$viewBiddings = Orders::leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'orders.buyer_id', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.last_name',
                'products.name',
                'products.sku',
                'products.img',
                'products.slog',
                'products.uom',
                'orders.*'
            )
            ->where('orders.buyer_id',Auth::User()->id)
            ->whereIn('orders.status', ['active'])
            ->orderByRaw("
                CASE 
                    WHEN orders.status = 'active' AND orders.auction_end IS NOT NULL AND orders.auction_end > NOW() THEN 0
                    ELSE 1
                END
            ")
            ->orderBy('orders.id', 'desc')
            ->get();
            
            ,'viewBiddings'=>$viewBiddings*/
        
        return view('frontend/seller/seller-dashboard',
        [
            'page'=>$page,
            'myorders'=>$myorders
        ]);
    }
    
    public function updateSellerOrderStatus(Request $request) {
        
        $order = Orders::findOrFail($request->order_id);
    
        $order->seller_status = $request->seller_status;
        $order->invoice_no    = $request->invoice_no ?? '';
        $order->courier_name    = $request->courier_name ?? '';
        $order->tracking_id    = $request->tracking_id ?? '';
        $order->courier_date    = $request->courier_date ?? '';
        $order->invoice_date  = $request->invoice_date ?? null;
    
        $order->save(); // use save() instead of update()
        
        // Identify Seller (logged in user)
        $seller = Auth::user();
        
        $buyers = User::findOrFail($order->buyer_id);
        
        if($request->seller_status == 'order-initiated'){
            
            // Prepare mail details
            $details = [
                'seller_name'    => trim(($seller->first_name ?? '') . ' ' . ($seller->last_name ?? '')) ?: ($seller->name ?? 'Seller'),
                'buyer_name'     => trim(($buyers->first_name ?? '') . ' ' . ($buyers->last_name ?? '')) ?: 'Buyer',
                'order_id'       => $order->id,
                'initiated_date' => now()->format('d M Y'),
                'brand'          => 'ImpurityX',
                'support_email'  => 'support@impurityx.com',
            ];
            
            // Send Email to Seller
            Mail::to($buyers->email)->send(
                new MailModel(
                    $details,
                    "Order Initiated!",
                    "emails.order_initiated"
                )
            );
            
        }elseif($request->seller_status == 'order-task-completed'){
            
            // Prepare mail details
            $details = [
                'seller_name'    => trim(($seller->first_name ?? '') . ' ' . ($seller->last_name ?? '')) ?: ($seller->name ?? 'Seller'),
                'buyer_name'     => trim(($buyers->first_name ?? '') . ' ' . ($buyers->last_name ?? '')) ?: 'Buyer',
                'order_id'       => $order->id,
                'completed_date' => now()->format('d M Y'),
                'brand'          => 'ImpurityX',
                'support_email'  => 'support@impurityx.com',
            ];
            
            // Send Email to Seller
            Mail::to($buyers->email)->send(
                new MailModel(
                    $details,
                    "Order Completed!",
                    "emails.order_completed"
                )
            );
            
        }elseif($request->seller_status == 'delivery-initiated'){
        
            $details = [
                'seller_name'    => trim(($seller->first_name ?? '') . ' ' . ($seller->last_name ?? '')) ?: ($seller->name ?? 'Seller'),
                'buyer_name'     => trim(($buyers->first_name ?? '') . ' ' . ($buyers->last_name ?? '')) ?: 'Buyer',
                'order_id'       => $order->id,
                'initiated_date' => now()->format('d M Y'),
                'courier_name'   => $order->courier_name ?? '',
                'tracking_id'    => $order->tracking_id ?? '',
                'brand'          => 'ImpurityX',
                'support_email'  => 'support@impurityx.com',
            ];
        
            // Send Email to Seller
            Mail::to($buyers->email)->send(
                new MailModel(
                    $details,
                    "Delivery Initiated by Seller – Order in Progress",
                    "emails.delivery_initiated"
                )
            );
            
        }else{
            
            // Prepare mail details
            $details = [
                'seller_name'    => trim(($seller->first_name ?? '') . ' ' . ($seller->last_name ?? '')) ?: ($seller->name ?? 'Seller'),
                'buyer_name'     => trim(($buyers->first_name ?? '') . ' ' . ($buyers->last_name ?? '')) ?: 'Buyer',
                'order_id'       => $order->id,
                'completed_date' => now()->format('d M Y'),
                'courier_name'   => $order->courier_name ?? '',
                'tracking_id'    => $order->tracking_id ?? '',
                'brand'          => 'ImpurityX',
                'support_email'  => 'support@impurityx.com',
            ];
        
            // Send Email to Seller
            Mail::to($buyers->email)->send(
                new MailModel(
                    $details,
                    "Delivery Completed – Awaiting Buyer’s Acceptance",
                    "emails.delivery_completed"
                )
            );
            
        }
    
        return back()->with('success', 'Order status updated successfully.');
    }

}
