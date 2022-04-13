<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;
use Auth;
use Alert;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use PDF;
use App\Models\Code;
use App\Models\Menu;
use App\Models\TransactionDetail;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       
    }
    public function index(Request $request)
    {
 
        $user = $request->user();
        if($user->role_id == 3){
            return redirect()->route('employee.dashboard');
        }
        // $transactionIn = Transaction::where('status', '1')
        //                             ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_in'))
        //                             ->first()->total_transaction_in;
        // $transactionOut = Transaction::where('status', '0')
        //                             ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_out'))
        //                             ->first()->total_transaction_out;
        $transactionPurcashePrice = Transaction::where('status', '1')
                ->join('transaction_details as td', 'td.transaction_id', '=', 'transactions.id')
                ->select(DB::raw('coalesce(SUM(td.purcashe_price), 0) as total_transaction_in'))
                ->first()->total_transaction_in;
        $transactionSalePrice = Transaction::where('status', '1')
                ->join('transaction_details as td', 'td.transaction_id', '=', 'transactions.id')
                ->select(DB::raw('coalesce(SUM(td.price), 0) as total_transaction_out'))
                ->first()->total_transaction_out;
        $transaction = Transaction::join('transaction_details as td', 'td.transaction_id', '=', 'transactions.id')->get();
        if($transactionSalePrice == 0){
            $percentage = 100;
        }else{
            $percentage = $transactionPurcashePrice / $transactionSalePrice * 100;
        }
        $differenceTransaction = $transactionSalePrice - $transactionPurcashePrice;
        $tranactionAssetFirst = ($differenceTransaction/100) * 5;
        return view('admin.index', compact(['transaction', 'tranactionAssetFirst','transactionPurcashePrice', 'transactionSalePrice', 'percentage', 'differenceTransaction']));
    }

    public function getUsers(Request $request){

        $user = $request->user();
        if($user->role_id == 3){
            return redirect()->route('employee.dashboard');
        }
        $code = Code::all();
        $user = User::where('role_id', 3)->get();
        $management = User::where('role_id', 2)->get();
        return view('admin.users.index', compact(['user', 'management', 'code']));
    }

    public function detailUsers(Request $request, $id)
    {
        
        $user = $request->user();
        if($user->role_id == 3){
            return redirect()->route('employee.dashboard');
        }
        $now = Carbon::now()->format('Y-m-d');
        $dateYear = Carbon::now()->format('Y');
        $dateMonth = Carbon::now()->format('m');
        $year = !empty($request->year) ? $request->year : $dateYear;
        $month = !empty($request->month) ? $request->month : $dateMonth;
        $data = $this->getYearlyTransactionSummary($year, $id);
        $transaction = Transaction::where('user_id', $id)
                                    ->when($month, function($query) use ($month, $year) {
                                        $query->whereMonth('date_transaction', '=', $month)
                                        ->whereYear('date_transaction', '=', $year);
                                    })
                                    ->when($request->start_date, function($query) use ($request) {
                                        $query->whereDate('date_transaction', '>=', $request->start_date)
                                        ->whereDate('date_transaction', '<=', $request->end_date);
                                    })
                                    ->join('transaction_details as td', 'td.transaction_id', '=', 'transactions.id')
                                    ->get();

        $transactionIn = Transaction::where('status', '1')
                                    ->where('user_id', $id)
                                    ->whereDate('date_transaction', $now)
                                    ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_in'))
                                    ->when($month, function($query) use ($month, $year) {
                                        $query->whereMonth('date_transaction', '=', $month)
                                        ->whereYear('date_transaction', '=', $year);
                                    })
                                    ->when($request->start_date, function($query) use ($request) {
                                        $query->whereDate('date_transaction', '>=', $request->start_date)
                                        ->whereDate('date_transaction', '<=', $request->end_date);
                                    })
                                    ->first()->total_transaction_in;
        $transactionOut = Transaction::where('status', '0')
                                    ->where('user_id', $id)
                                    ->whereDate('date_transaction', $now)
                                    ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_out'))
                                    ->when($month, function($query) use ($month, $year) {
                                        $query->whereMonth('date_transaction', '=', $month)
                                        ->whereYear('date_transaction', '=', $year);
                                    })
                                    ->when($request->start_date, function($query) use ($request) {
                                        $query->whereDate('date_transaction', '>=', $request->start_date)
                                        ->whereDate('date_transaction', '<=', $request->end_date);
                                    })
                                    ->first()->total_transaction_out;
        $differenceTransaction = $transactionIn - $transactionOut;
        $user = User::where('id', $id)->first();
        return view('admin.users.detail', compact(['data', 'id', 'transaction', 'user', 'transactionIn', 'transactionOut', 'differenceTransaction']));
 
    }
 
    private function getYearlyTransactionSummary($year, $userId)
     {
         $rawQuery = 'MONTH(date_transaction) as month';
         $rawQuery .= ', count(`id`) as count';
         $rawQuery .= ', sum(if(status = 1, amount, 0)) AS income';
         $rawQuery .= ', sum(if(status = 0, amount, 0)) AS spending';
 
         $reportsData = DB::table('transactions')->select(DB::raw($rawQuery))
             ->where(DB::raw('YEAR(date_transaction)'), $year)
             ->where('user_id', $userId)
             ->groupBy(DB::raw('YEAR(date_transaction)'))
             ->groupBy(DB::raw('MONTH(date_transaction)'))
             ->orderBy('date_transaction', 'asc')
             ->get();
 
         $reports = [];
         foreach ($reportsData as $report) {
             $key = str_pad($report->month, 2, '0', STR_PAD_LEFT);
             $reports[$key] = $report;
             $reports[$key]->difference = $report->income - $report->spending;
         }
 
         return collect($reports);
     }

     public function codeAngkringan(Request $request)
     {

        $user = $request->user();
        if($user->role_id == 3){
            return redirect()->route('employee.dashboard');
        }
        $code = Code::all();

        return view('admin.code.index', compact(['code']));
     }
     public function detailAngkringan(Request $request, $code_angkringan){
         
        $users = User::where('code_angkringan', $code_angkringan)->get();
        return view('admin.code.detail', compact(['users', 'code_angkringan']));
     }
     public function codeStoreAngkringan(Request $request)
     {

        $user = $request->user();
        if($user->role_id == 3){
            return redirect()->route('employee.dashboard');
        }
        $code = new Code();
        $code->code_angkringan = $request->code_angkringan;
        $code->save();

        return redirect()->back();

     }

     function codeUpdateAngkringan(Request $request, $id)
     {

        $user = $request->user();
        if($user->role_id == 3){
            return redirect()->route('employee.dashboard');
        }
        $code = Code::findOrFail($id);
        $code->code_angkringan = $request->code_angkringan;
        $code->save();
        return redirect()->back();
     }

     public function getMenu(Request $request)
     {

        $menus = Menu::all();

        return view('admin.menu.index', compact(['menus']));

     }

     public function storeMenu(Request $request)
     {
         DB::beginTransaction();
         try{

            $menu = new Menu();
            $menu->name = $request->name;
            $menu->price = $request->price;
            $menu->purchase_price = $request->purchase_price;
            $menu->qty = $request->stock;
            $menu->category = $request->category;
            $menu->save();
            DB::commit();
            return redirect()->route('admin.menu.index');

         }catch(\Exception $e){
             DB::rollback();
             return $e->getMessage();
         }
     }

     public function updateMenu(Request $request, $id)
     {
        DB::beginTransaction();
        try{

           $menu = Menu::findOrFail($id);
           $menu->name = $request->name;
           $menu->price = $request->price;
           $menu->purchase_price = $request->purchase_price;
           $menu->qty = $request->stock;
           $menu->category = $request->category;
           $menu->save();
        //    Menu::where('id', $id)->update([
        //     'name' => $request->name,
        //     'price' => $request->price,
        //     'stock' => $request->stock
        //    ]);
           DB::commit();
           return redirect()->route('admin.menu.index');

        }catch(\Exception $e){
            DB::rollback();
            return $e->getMessage();
        }
     }
     public function deleteMenu(Request $request, $id)
     {
        DB::beginTransaction();
        try{

           $menu = Menu::findOrFail($id);
           $menu->delete();
           DB::commit();
           return redirect()->route('admin.menu.index');

        }catch(\Exception $e){
            DB::rollback();
        }
     }

     public function deleteUser(Request $request, $id)
     {
         DB::beginTransaction();
         try{

            $transactions = Transaction::where('user_id', $id)->get();
            foreach($transactions as $item){
                TransactionDetail::where('transaction_id')->delete();
            }

            $transactions = Transaction::where('user_id', $id)->delete();
            User::where('id', $id)->delete();
            DB::commit();
            return redirect()->back();

         }catch(\Exception $e){
             DB::rollback();
         }
    }

    
    public function printReportTransactionUser(Request $request, $user_id)
    {
        $now = Carbon::now()->format('Y-m-d');
        $user = User::where('id', $user_id)->first();
        $transaction = Transaction::where('user_id', $user_id)
                                ->when($request->start_date, function($query) use ($request) {
                                    $query->whereDate('date_transaction', '>=', $request->start_date)
                                    ->whereDate('date_transaction', '<=', $request->end_date);
                                })
                                ->join('transaction_details as td', 'td.transaction_id', '=', 'transactions.id')
                                ->get();
        $total_transaction = Transaction::where('user_id', $user_id)
                                ->when($request->start_date, function($query) use ($request) {
                                    $query->whereDate('date_transaction', '>=', $request->start_date)
                                    ->whereDate('date_transaction', '<=', $request->end_date);
                                })
                                ->select(DB::raw('COALESCE(SUM(amount), 0) as total_transaction'))
                                ->first()->total_transaction;

        $name = "Laporant-transaction-".$user->name.".pdf";
    	$pdf = PDF::loadview('admin.users.report-pdf', ['transaction'=>$transaction, 'user' => $user, 'start_date' => $request->start_date, 'end_date' => $request->end_date, 'total_transaction' => $total_transaction]);
    	return $pdf->download($name);
    }

    public function createUserManagement(Request $request){

        DB::beginTransaction();
        try{
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_password' => $request->password,
                'role_id' => 2,
                'role_name' => 'Area Manager',
                'district' => $request->district,
                'code_angkringan' => '-'
            ]);
            DB::commit();
            return redirect()->back();

        }catch(\Exception $e){
            DB::rollback();
            return $e->getMessage();
        }
    }
    public function storeFrontOffice(Request $request){

        DB::beginTransaction();
        try{
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_password' => $request->password,
                'role_id' => 3,
                'role_name' => 'Front Office',
                'code_angkringan' => $request->code_angkringan
            ]);
            DB::commit();
            return redirect()->back();

        }catch(\Exception $e){
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function selectSearch(Request $request)
    {
    	$code_angkringan = [];

        if($request->has('q')){
            $search = $request->q;
            $code_angkringan =Code::select("id", "code_angkringan")
            		->where('code_angkringan', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($code_angkringan);
    }

    public function usersIncome(Request $request)
    {

        $users = User::where('role_id', 3)->get();
        foreach($users as $user){
            $userPurchasePrice = Transaction::join('transaction_details as td', 'td.transaction_id', '=', 'transactions.id')
                                        ->select(DB::raw('coalesce(SUM(td.purcashe_price), 0) as purchase'))
                                        ->where('user_id', $user->id)
                                        ->first()->purchase;
            $userSalePrice = Transaction::join('transaction_details as td', 'td.transaction_id', '=', 'transactions.id')
                                        ->select(DB::raw('coalesce(SUM(td.price), 0) as sales'))
                                        ->where('user_id', $user->id)
                                        ->first()->sales;

            $userIncome = $userSalePrice - $userPurchasePrice;

            $data = array(
                'name' => $user->name,
                'code_angkringan' => $user->code_angkringan,
                'income' => $userIncome
            );
            $datas[] = $data;
        }
        array_multisort(array_map(function($element){
            return $element['income'];
        }, $datas), SORT_DESC, $datas);
        return view('admin.users.income', compact(['datas']));

    }

 
}
