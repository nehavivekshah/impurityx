<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Colors;
use App\Models\Sizes;
use App\Models\Buyer_product_enquiries;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function products() {

        if(Auth::user()->role == '11'):

            $products = Products::orderBy('status', 'ASC')->get();

        else:

            $products = Products::where('branch','=',Auth::user()->branch)
                ->orderBy('status', 'ASC')->get();

        endif;
        
        return view('backend.products',['products'=>$products]);
    }
    
    public function requestProductAddition() {

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
                    'products.molecular_name',
                    'products.molecular_weight',
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
            ->leftJoin('users','buyer_product_enquiries.user_id','=','users.id')
            ->select('products.name','products.sku','products.uom','users.first_name','users.last_name','orders.quantity','orders.delivery_date','buyer_product_enquiries.*')
            ->orderBy('id', 'desc')->get();
            
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

        return view('backend.requestProductAddition',['reqId'=>$reqId,'rnpo'=>$rnpo,'categoriesOptions' => $categoriesOptions,'getRnpo'=>($getRnpo ?? [])]);
    }

    public function manageProduct(Request $request) {
        // Fetch product if editing
        $products = Products::where('id', '=', $request->id)->orderBy('status', 'ASC')->get();
        
        $getProduct = Products::orderBy('id', 'DESC')->first();

        if ($getProduct) {
            $uniqueSKU = 'SKU' . str_pad($getProduct->id, 5, '0', STR_PAD_LEFT);
        } else {
            $uniqueSKU = 'SKU00001'; // default if no products exist
        }

    
        // Auto-generate SKU if it's a new product
       // $skuPrefix = 'SKU-';
       // $uniqueSKU = $skuPrefix . strtoupper(uniqid());
        $sku = (count($products) == 0) ? $uniqueSKU : $products[0]->sku;
    
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
    
        return view('backend.manageProduct', [
            'products' => $products,
            'categoriesOptions' => $categoriesOptions,
            'sku' => $sku
        ]);
    }

    public function manageProductPost(Request $request)
    {
        function slog($string) {
            $string = str_replace(' ', '-', strtolower($string));
            return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        }
        
        $casNumber = $request->Product_cas ?? '';
        
        if (!$casNumber) {
            return back()->with('error', 'CAS number is required.');
        }
        
        if(empty($request->id)){
            $exists = Products::where('cas_no', $casNumber)->exists();
            
            if ($exists) {
                return back()->with('error', 'A product with this CAS number already exists in the database.');
            }
        }
        
        $value = number_format($request->Product_potency ?? 0, 2, '.', '');

        $isNew = empty($request->id);
        $products = $isNew ? new Products() : Products::find($request->id);
    
        $products->branch = Auth::user()->branch ?? '';
        $products->category = $request->Product_category ?? '';
        $products->name = $request->Product_title ?? '';
        $products->slog = slog($request->Product_title);
        $products->sku = $request->Product_sku ?? '';
        $products->cas_no = $request->Product_cas ?? '';
        $products->uom = $request->Product_uom ?? '';
        $products->synonym = $request->Product_synonym ?? '';
        $products->related_products = $request->Product_rapi ?? '';
        $products->purity = $request->Product_purity ?? '';
        $products->potency = $value;
        $products->impurity_type = $request->impurity_type ?? '';
        $products->molecular_name = $request->molecular_name ?? '';
        $products->molecular_weight = $request->molecular_weight ?? '';
        $products->hsn_code = $request->Product_hsn ?? '';
        $products->gst = $request->Product_gst ?? '';
        $products->featured = $request->Product_featured ?? '0';
        $products->new = $request->Product_new ?? '0';
        $products->status = $request->Product_active ?? '0';
    
        $products->sdes = $request->Product_sdes ?? '';
        $products->tags = $request->Product_tags ?? '';
        $products->des = $request->Product_des ?? '';
        $products->ainfo = $request->Product_ainfo ?? '';
    
        $products->stocks = implode(',', ($request->stock ?? []));
        $products->review = $isNew ? '0' : $products->review;
    
        if ($request->hasFile('Product_img1')) {
            $fileName = '1' . time() . '.' . $request->Product_img1->extension();
            $request->Product_img1->move(public_path("/assets/frontend/img/products"), $fileName);
            $products->img = $fileName;
        }
    
        $pImg = [];
        foreach (['Product_img2', 'Product_img3', 'Product_img4', 'Product_img5'] as $index => $imgKey) {
            if ($request->hasFile($imgKey)) {
                $file = $request->file($imgKey);
                $fileName = ($index + 2) . time() . '.' . $file->extension();
                $file->move(public_path("/assets/frontend/img/products"), $fileName);
                $pImg[] = $fileName;
            }
        }
        $products->gallery = implode(',', $pImg);
    
        $attachmentFiles = [];
        if ($request->hasFile('Product_files')) {
            foreach ($request->file('Product_files') as $file) {
                $fileName = 'F' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('/assets/frontend/img/products/files'), $fileName);
                $attachmentFiles[] = $fileName;
            }
            $products->file = implode(',', $attachmentFiles);
        }
    
        if ($isNew) {
            $products->save();
            return redirect('/admin/products')->with('success', 'Successfully Added!!');
        } else {
            $products->updated_at = now();
            $products->update();
            return back()->with('success', 'Successfully Updated!!');
        }
    
        return back()->with('error', 'Oops, something went wrong.');
    }
    
    public function exportProductMaster()
    {
        $now = Carbon::now();
    
        // Join products with categories
        $products = DB::table('products')
            ->leftJoin('categories', 'products.category', '=', 'categories.id')
            ->select(
                'products.id',
                'products.branch',
                'categories.title as category_name',
                'products.name',
                'products.slog',
                'products.sku',
                'products.cas_no',
                'products.uom',
                'products.synonym',
                'products.related_products',
                'products.purity',
                'products.potency',
                'products.impurity_type',
                'products.molecular_name',
                'products.molecular_weight',
                'products.img',
                'products.gallery',
                'products.sdes',
                'products.hsn_code',
                'products.gst',
                'products.file',
                'products.tags',
                'products.des',
                'products.ainfo',
                'products.stocks',
                'products.status',
                'products.created_at',
                'products.updated_at'
            )
            ->get();
    
        // CSV setup
        $filename = "product_master_" . $now->format('Ymd_His') . ".csv";
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=$filename");
    
        $handle = fopen('php://output', 'w');
    
        // CSV headers
        $headers = [
            'ID', 'Category', 'Name', 'Slug', 'SKU', 'CAS No', 'UOM',
            'Synonym', 'Related Products', 'Purity', 'Potency', 'Impurity Type',
            'Molecular Name', 'Molecular Weight', 'Image', 'Gallery', 'Short Description',
            'HSN Code', 'GST', 'File', 'Tags', 'Description',
            'Additional Info', 'Stocks', 'Status', 'Created At', 'Updated At'
        ];
        fputcsv($handle, $headers);
    
        foreach ($products as $p) {
            
            // Clean HTML + decode entities + remove newlines
            $clean = function ($value) {
                $value = strip_tags($value); // remove HTML tags
                $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $value = str_replace(["\r", "\n"], ' ', $value); // remove newlines
                return trim($value);
            };
            
            $row = [
                $p->id,
                $p->category_name ?? 'N/A',
                $p->name,
                $p->slog,
                $p->sku,
                $p->cas_no,
                $p->uom,
                $p->synonym,
                $p->related_products,
                $p->purity,
                $p->potency,
                $p->impurity_type,
                $p->molecular_name,
                $p->molecular_weight,
                !empty($p->img) ? asset('public/' . $p->img) : 'N/A',
                !empty($p->gallery) ? implode(', ', json_decode($p->gallery, true)) : 'N/A',
                $p->sdes,
                $p->hsn_code,
                $p->gst,
                $p->file,
                $clean($p->tags),
                $clean($p->des),
                $clean($p->ainfo),
                $p->stocks,
                ucfirst($p->status),
                Carbon::parse($p->created_at)->format('d M, Y H:i'),
                Carbon::parse($p->updated_at)->format('d M, Y H:i')
            ];
    
            fputcsv($handle, $row);
        }
    
        fclose($handle);
        exit;
    }

}