<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Models\Usermetas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function users() {

        $users = User::get();
        
        return view('backend.users',['users'=>$users,'page'=>'all users']);
    }

    public function buyers() {

        $users = User::where('role','=','5')->get();

        return view('backend.users',['users'=>$users,'page'=>'buyers']);
    }

    public function sellers() {

        $users = User::where('role','=','4')->get();

        return view('backend.users',['users'=>$users,'page'=>'sellers']);
    }

    public function agent() {

        $users = User::where('role','=','3')->get();

        return view('backend.users',['users'=>$users,'page'=>'agent']);
    }

    public function manager() {

        $users = User::where('role','=','2')->get();

        return view('backend.users',['users'=>$users,'page'=>'manager']);
    }

    public function admin() {

        $users = User::where('role','=','1')->get();
        
        return view('backend.users',['users'=>$users,'page'=>'admin']);
    }

    public function manageUser(Request $request)
    {
        $user = null;
        $meta = null;

        if ($request->id) {
            $user = User::find($request->id);
            $meta = Usermetas::where('uid', $request->id)->first();
        }

        return view('backend.manageUser', [
            'user' => $user,
            'meta' => $meta
        ]);
    }

    public function manageUserPost(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'mob'        => 'required|string|max:20',
            'email'      => 'required|email|max:191',
            'role'       => 'required',
        ]);

        $user = User::updateOrCreate(
            ['id' => $request->id],
            [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'mob'        => $request->mob,
                'whatsapp'   => $request->whatsapp,
                'email'      => $request->email,
                'role'        => $request->role,
                'status'     => $request->status ?? 1,
            ]
        );

        // --- Usermeta Create/Update ---
        Usermetas::updateOrCreate(
            ['uid' => $user->id],
            [
                'company'    => $request->company,
                'trade'      => $request->trade,
                'panno'      => $request->panno,
                'vat'        => $request->vat,
                'regAddress' => $request->regAddress,
                'comAddress' => $request->comAddress,
                'city'       => $request->city,
                'pincode'    => $request->pincode,
                'state'      => $request->state,
                'country'    => $request->country,
                'status'     => $request->status ?? 1,
            ]
        );

        return redirect()->route('manageUser', ['id' => $user->id])
                         ->with('success', 'User saved successfully!');
    }
    
    public function exportUserMaster($role, Request $request) {
        $now = Carbon::now();
    
        // Resolve role
        $roleId = ($role == 'seller') ? 4 : 5;
    
        // Base query
        $query = DB::table('users')
            ->leftJoin('usermetas', 'users.id', '=', 'usermetas.uid')
            ->where('users.role', $roleId)
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.branch',
                'users.photo',
                'users.mob',
                'users.whatsapp',
                'users.email',
                'users.email_verified_at',
                'users.dob',
                'users.gender',
                'users.notify',
                'users.status as user_status',
                'users.created_at as user_created',
                'usermetas.company',
                'usermetas.trade',
                'usermetas.panno',
                'usermetas.vat',
                'usermetas.regAddress',
                'usermetas.comAddress',
                'usermetas.city',
                'usermetas.pincode',
                'usermetas.state',
                'usermetas.country',
                'usermetas.status as meta_status'
            );
    
        // ✅ Date filter
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('users.created_at', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay()
            ]);
        }
    
        $users = $query->get();
    
        // File setup
        $filename = "user_master_{$role}_" . $now->format('Ymd_His') . ".csv";
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=$filename");
    
        $handle = fopen('php://output', 'w');
    
        // CSV Headers
        $headers = [
            'Sr No',
            'User ID',
            'First Name',
            'Last Name',
            'Branch',
            'Photo',
            'Mobile',
            'WhatsApp',
            'Email',
            'DOB',
            'Gender',
            'Status',
            'Created At',
            'Company',
            'Trade',
            'PAN No',
            'VAT',
            'Registered Address',
            'Communication Address',
            'City',
            'Pincode',
            'State',
            'Country',
        ];
    
        fputcsv($handle, $headers);
    
        foreach ($users as $k => $user) {
            $row = [
                $k + 1,
                $user->id,
                $user->first_name,
                $user->last_name,
                $user->branch,
                !empty($user->photo) ? asset('public/' . $user->photo) : 'N/A',
                $user->mob,
                $user->whatsapp,
                $user->email,
                $user->dob ? Carbon::parse($user->dob)->format('d M, Y') : 'N/A',
                ucfirst($user->gender),
                ucfirst($user->user_status),
                Carbon::parse($user->user_created)->format('d M, Y H:i'),
                $user->company ?? 'N/A',
                $user->trade ?? 'N/A',
                $user->panno ?? 'N/A',
                $user->vat ?? 'N/A',
                $user->regAddress ?? 'N/A',
                $user->comAddress ?? 'N/A',
                $user->city ?? 'N/A',
                $user->pincode ?? 'N/A',
                $user->state ?? 'N/A',
                $user->country ?? 'N/A',
            ];
    
            fputcsv($handle, $row);
        }
    
        fclose($handle);
        exit;
    }
    
}
