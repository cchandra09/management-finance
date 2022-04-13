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
class ManagementController extends Controller
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
        $transactionIn = Transaction::where('status', '1')
                                    ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_in'))
                                    ->first()->total_transaction_in;
        $transactionOut = Transaction::where('status', '0')
                                    ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_out'))
                                    ->first()->total_transaction_out;
        $transaction = Transaction::join('transaction_details as td', 'td.transaction_id', '=', 'transactions.id')->get();
        if($transactionOut == 0){
            $percentage = 100;
        }else{
            $percentage = $transactionIn / $transactionOut * 100;
        }
        $differenceTransaction = $transactionIn - $transactionOut;
        return view('management.index', compact(['transaction', 'transactionIn', 'transactionOut', 'percentage', 'differenceTransaction']));
    }

    public function getUsers(Request $request){

        $user = $request->user();
        if($user->role_id == 3){
            return redirect()->route('employee.dashboard');
        }
        $user = User::where('role_id', 3)->get();
        return view('management.users.index', compact(['user']));
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

        $getPurcashePrice = Transaction::where('status', '1')
                                    ->where('user_id', $id)
                                    ->join('transaction_details as td', 'td.transaction_id', '=', 'transactions.id')
                                    ->select(DB::raw('(td.purcashe_price * qty) as total'))
                                    // ->select(DB::raw('coalesce(SUM(td.purcashe_price), 0) as purcashe_price, SUM(td.qty) as total_qty'))
                                    ->when($month, function($query) use ($month, $year) {
                                        $query->whereMonth('date_transaction', '=', $month)
                                        ->whereYear('date_transaction', '=', $year);
                                    })
                                    ->when($request->start_date, function($query) use ($request) {
                                        $query->whereDate('date_transaction', '>=', $request->start_date)
                                        ->whereDate('date_transaction', '<=', $request->end_date);
                                    })
                                    ->get();

        $getSalePrice = Transaction::where('user_id', $id)
                                ->join('transaction_details as td', 'td.transaction_id', '=', 'transactions.id')
                                ->select(DB::raw('(td.price * qty) as total'))
                                // coalesce(SUM(td.price), 0) as salePrice, SUM(td.qty) as total_qty
                                ->when($month, function($query) use ($month, $year) {
                                    $query->whereMonth('date_transaction', '=', $month)
                                    ->whereYear('date_transaction', '=', $year);
                                })
                                ->when($request->start_date, function($query) use ($request) {
                                    $query->whereDate('date_transaction', '>=', $request->start_date)
                                    ->whereDate('date_transaction', '<=', $request->end_date);
                                })
                                ->get();
        $transactionSalePrice = 0;
        foreach($getSalePrice as $key=>$value)
        {
            $transactionSalePrice+= $value->total;
        }

        $transactionPurcashePrice = 0;
        foreach($getPurcashePrice as $key=>$value)
        {
            $transactionPurcashePrice+= $value->total;
        }

        // $transactionSalePrice = $getSalePrice->salePrice * $getSalePrice->total_qty; 
        // $transactionPurcashePrice = $getPurcashePrice->purcashe_price * $getSalePrice->total_qty; 
        if($transactionSalePrice == 0){
            $percentage = 100;
        }else{
            $percentage = $transactionPurcashePrice / $transactionSalePrice * 100;
        }

        $differenceTransaction = $transactionSalePrice - $transactionPurcashePrice;
        $tranactionAssetFirst = ($differenceTransaction/100) * 5;
        // $differenceTransaction = $transactionIn - $transactionOut;
        $user = User::where('id', $id)->first();
        return view('management.users.detail', compact(['data', 'id', 'transactionSalePrice', 'transactionPurcashePrice', 'tranactionAssetFirst','transaction', 'user','differenceTransaction']));
 
    }

    private function getYearlyTransactionSummary($year, $userId)
    {
        $rawQuery = 'MONTH(date_transaction) as month';
        $rawQuery .= ', count(`id`) as count';
        $rawQuery .= ', sum(if(status = 1, amount, 0)) AS income';
        $rawQuery .= ', SUM(total_purcashe) AS total_purcashe';
        $rawQuery .= ', sum(if(status = 0, amount, 0)) AS spending';

        $reportsData = DB::table('transactions')->select(DB::raw($rawQuery))
            ->where(DB::raw('YEAR(date_transaction)'), $year)
            ->where('user_id', $userId)
            ->groupBy(DB::raw('YEAR(date_transaction)'))
            ->groupBy(DB::raw('MONTH(date_transaction)'))
            ->orderBy('date_transaction', 'asc')
            ->distinct()
            ->get();

        $reports = [];
        $transactionSalePrice = 0;
        $transactionPurcashePrice = 0;
        foreach ($reportsData as $keys=>$report) {
            $key = str_pad($report->month, 2, '0', STR_PAD_LEFT);
            $reports[$key] = $report;
            $differenceTransaction = $report->income - $report->total_purcashe;
            $reports[$key]->tranactionAssetFirst = ($differenceTransaction/100) * 5;
            $reports[$key]->difference = $report->income - $report->spending;
        }

        return collect($reports);
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

    public function indexProfile(Request $request)
    {
 
       $user = User::where('id', $request->user()->id)->first();
 
 
       return view('management.profile', compact(['user']));
 
    }
 
    public function updateProfile(Request $request)
    {
        DB::beginTransaction();
        try{
                if(!empty($request->image)){

                    $imageName = time().'.'.$request->image->extension();  
                
                    $request->image->move(public_path('images'), $imageName);
                }
    
                $user = $request->user();
                $user = User::findOrFail($user->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->gender = $request->gender;
                $user->no_hp = $request->no_hp;
                $user->district = $request->district;
                $user->photo_profile = !empty($request->image) ? $imageName : $user->photo_profile;
                $user->save();
                DB::commit();
                Alert::success('Berhasil Update Profile!');
    
                return redirect()->back();
 
        }catch(\Exception $e){
            DB::rollback();
            Alert::error('Error', $e->getMessage());
            return $e->getMessage();
        }
    }
 
    public function updatePassword(Request $request)
    {
       DB::beginTransaction();
       try{
 
          $user = User::findOrFail(Auth::user()->id);
          $hasher = app('hash');
          if (!empty($request->old_password) &&$hasher->check($request->old_password, $user->password)) {
     
             if(!empty($request->new_password) && $request->confirmation_password == $request->new_password){
 
                 $user->password = Hash::make($request->new_password);
                 $user->user_password = $request->new_password;
                 $user->save();
                 DB::commit();
                 Alert::success('Success', 'Sukses Ganti Password!');
                 return back();
 
             }else{
                 Alert::error('Error', 'new'.$request->confirmation_password. '-'. $request->new_password);
                 return back();
             }
 
         }else{
             Alert::error('Error', 'Password lama yang anda masukan salah!');
             return back();
         }
         DB::commit();
         Alert::success('Berhasil Update Profile!');
 
         return redirect()->back();
 
       }catch(\Exception $e){
           DB::rollback();
           Alert::error('Error', $e->getMessage());
           return $e->getMessage();
       }
    }

}
