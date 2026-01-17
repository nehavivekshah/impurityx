<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Models\Categories;
use App\Models\Colors;
use App\Models\Sizes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function categories() {
        $userRole = Auth::user()->role;
    
        // Base query builder
        $query = Categories::leftJoin('branches','categories.branch','=','branches.id')
            ->leftJoin('categories as cate','categories.parent','=','cate.id')
            ->leftJoin('categories as scate','cate.parent','=','scate.id')
            ->select(
                'cate.title as parentname',
                'scate.title as sparentname',
                'branches.name as branch',
                'categories.*'
            );
    
        // Role-based filtering
        if ($userRole == '11') {
            $categories = $query->orderBy('categories.status', 'ASC')->get();
            return view('backend.categories', ['categoryLists' => $categories]);
        }
    
        // Role 0 or others: show only active
        $categories = $query->orderBy('categories.id', 'ASC')->get();
    
        // Generate rows
        $generateHtmlRows = function($items) use ($userRole) {
            $output = '';
    
            foreach ($items as $key => $item) {
                $output .= '<tr>
                    <td>' . ($key + 1) . '</td>';
    
                $output .= '<td><img src="' . asset('/public/assets/frontend/img/category/icons/' . $item->icon) . '" class="input-img rounded" /></td>';
    
                $output .= '<td><img src="' . asset('/public/assets/frontend/img/category/' . $item->img) . '" class="input-img rounded" /></td>
                    <td>';
    
                if (!empty($item->parentname)) {
                    $output .= '<strong>' . htmlspecialchars($item->parentname) . '</strong><br> -';
                }
    
                if (!empty($item->sparentname)) {
                    $output .= '<strong>' . htmlspecialchars($item->sparentname) . '</strong><br> --';
                }
    
                $output .= htmlspecialchars($item->title) . '</td>
                    <td>';
    
                $statusLabel = $item->status == '1' ? 'Active' : 'Deactive';
                $statusClass = $item->status == '1' ? 'alert-success' : 'alert-danger';
                $newStatus = $item->status == '1' ? '2' : '1';
    
                $output .= '<a href="javascript:void(0)" class="notify ' . $statusClass . ' status" id="' . $item->id . '" data-status="' . $newStatus . '" data-page="CategoryStatus">' . $statusLabel . '</a>';
    
                $output .= '</td>
                    <td>' . date_format(date_create($item->created_at), 'd M, Y') . '</td>
                    <td style="width:150px;">
                        <a href="manage-category?id=' . $item->id . '" class="notify-btn alert-primary" title="Edit Details"><i class="bx bx-edit"></i></a>
                        <a href="javascript:void(0)" class="notify-btn alert-danger delete" id="' . $item->id . '" data-page="delCategory" title="Delete"><i class="bx bx-trash"></i></a>
                    </td>
                </tr>';
            }
    
            return $output;
        };
    
        $categoryLists = $generateHtmlRows($categories);
        $collectionLists = $generateHtmlRows($categories); // Same data used again — if logic differs later, split the query.
    
        return view('backend.categories', [
            'categoryLists' => $categoryLists,
            'collectionLists' => $collectionLists
        ]);
    }

    public function manageCategory(Request $request) {

        $categories = Categories::where('id','=',$request->id)
            ->orderBy('status', 'ASC')->get();

        $categoryList = Categories::where('type','=','1')->orderBy('id', 'ASC')->get();

        return view('backend.manageCategory',['categories'=>$categories,'categoryList'=>$categoryList]);
    }

    public function manageCategoryPost(Request $request) {
        
        function slog($string) {
           $string = str_replace(' ', '-', strtolower($string)); // Replaces all spaces with hyphens.
        
           return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        }
        
        if($request->id == ''):
            
            $categories = new Categories();
            
            $categories->branch = Auth::user()->branch ?? '';
            $categories->title = $request->cate_title ?? '';
            $categories->slog = slog($request->cate_title ?? '');
            $categories->parent = $request->cate_parent ?? '0';

            if(!empty($request->cate_parent)){
                $categories->type = '2';
            }else{
                $categories->type = '1';
            }

            if(!empty($request->file('cate_icon'))):
                
                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName1 = time().".".$request->cate_icon->extension();
                $request->cate_icon->move(public_path("/assets/frontend/img/category/icons"), $fileName1);

            endif;

            $categories->icon = $fileName1 ?? '';

            if(!empty($request->file('cate_img'))):
                
                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time().".".$request->cate_img->extension();
                $request->cate_img->move(public_path("/assets/frontend/img/category"), $fileName);

            endif;

            $categories->img = $fileName ?? '';

            $categories->status = '1';
            
            $categories->save();

            return back()->with('success', 'Successfully Added!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        else:

            $categories = Categories::find($request->id);
            
            $categories->title = $request->cate_title ?? '';
            $categories->slog = slog($request->cate_title ?? '');
            $categories->parent = $request->cate_parent ?? '0';

            if(!empty($request->cate_parent)){
                $categories->type = '2';
            }else{
                $categories->type = '1';
            }

            if(!empty($request->file('cate_icon'))):
                
                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName1 = time().".".$request->cate_icon->extension();
                $request->cate_icon->move(public_path("/assets/frontend/img/category/icons"), $fileName1);

            endif;

            $categories->icon = $fileName1 ?? '';

            if(!empty($request->file('cate_img'))):
                
                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                // ]);
                $fileName = time().".".$request->cate_img->extension();
                $request->cate_img->move(public_path("/assets/frontend/img/category"), $fileName);

                $categories->img = $fileName ?? '';

            endif;
            
            $categories->updated_at = Now();
            
            $categories->update();

            return back()->with('success', 'Successfully Updated!!');

            return back()->with('error', 'Oops, Somethings went worng.');

        endif;
    }
    
    public function exportCategoryMaster()
    {
        $now = Carbon::now();
    
        // Get all categories
        $categories = DB::table('categories')->get();
    
        // CSV setup
        $filename = "category_master_" . $now->format('Ymd_His') . ".csv";
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=$filename");
    
        $handle = fopen('php://output', 'w');
    
        // CSV headers
        $headers = [
            'ID', 'Title', 'Slug', 'Parent ID',
            'Image', 'Icon', 'Status', 'Created At', 'Updated At'
        ];
        fputcsv($handle, $headers);
    
        foreach ($categories as $cat) {
            $row = [
                $cat->id,
                $cat->title,
                $cat->slog,
                $cat->parent,
                !empty($cat->img) ? asset('public/' . $cat->img) : 'N/A',
                !empty($cat->icon) ? asset('public/' . $cat->icon) : 'N/A',
                ucfirst($cat->status),
                Carbon::parse($cat->created_at)->format('d M, Y H:i'),
                Carbon::parse($cat->updated_at)->format('d M, Y H:i')
            ];
    
            fputcsv($handle, $row);
        }
    
        fclose($handle);
        exit;
    }

}