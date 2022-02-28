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
       $transactionIn = Transaction::where('status', '1')
                                  ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_in'))
                                  ->first()->total_transaction_in;
       $transactionOut = Transaction::where('status', '0')
                                  ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_out'))
                                  ->first()->total_transaction_out;
       $transaction = Transaction::all();
       $percentage = $transactionIn / $transactionOut * 100;
       $differenceTransaction = $transactionIn - $transactionOut;
       return view('admin.index', compact(['transaction', 'transactionIn', 'transactionOut', 'percentage', 'differenceTransaction']));
    }

    public function getUsers(Request $request){

        $user = User::where('role_id', 3)->get();
        return view('admin.users.index', compact(['user']));
    }

    public function detailUsers(Request $request, $id)
    {
        $dateYear = Carbon::now()->format('Y');
        $dateMonth = Carbon::now()->format('m');
        $year = !empty($request->year) ? $request->year : $dateYear;
        $month = !empty($request->month) ? $request->month : $dateMonth;
        $data = $this->getYearlyTransactionSummary($year, $id);
        $transaction = Transaction::where('user_id', $id)
                                    ->whereMonth('date_transaction', '=', $month)
                                    ->whereYear('date_transaction', '=', $year)
                                    ->get();
        $user = User::where('id', $id)->first();
        return view('admin.users.detail', compact(['data', 'id', 'transaction', 'user']));
 
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

        $code = Code::all();

        return view('admin.code.index', compact(['code']));
     }

     public function codeStoreAngkringan(Request $request)
     {

        $code = new Code();
        $code->code_angkringan = $request->code_angkringan;
        $code->save();

        return redirect()->back();

     }

     function codeUpdateAngkringan(Request $request, $id)
     {

        $code = Code::findOrFail($id);
        $code->code_angkringan = $request->code_angkringan;
        $code->save();
        return redirect()->back();
     }
 
}
