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
class EmployeeController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth');
   }
   public function index(Request $request)
   {

      $user = $request->user();
      $transactionIn = Transaction::where('user_id', $request->user()->id)
                                 ->where('status', '1')
                                 ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_in'))
                                 ->first()->total_transaction_in;
      $transactionOut = Transaction::where('user_id', $request->user()->id)
                                 ->where('status', '0')
                                 ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_out'))
                                 ->first()->total_transaction_out;
      $transaction = Transaction::where('user_id', $user->id)->get();
      $percentage = $transactionIn / $transactionOut * 100;
      $differenceTransaction = $transactionIn - $transactionOut;
      return view('employee.index', compact(['transaction', 'transactionIn', 'transactionOut', 'percentage', 'differenceTransaction']));
   }

   public function indexTransaction(Request $request)
   {
        $user = $request->user();
        $year = !empty($request->year) ? $request->year : 2022;
        $transaction = Transaction::where('user_id', $user->id)
                                    ->whereYear('date_transaction', '=', $year)
                                    ->get();
        $transactionIn = Transaction::where('user_id', $request->user()->id)
                                 ->where('status', '1')
                                 ->whereYear('date_transaction', '=', $year)
                                 ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_in'))
                                 ->first()->total_transaction_in;
        $transactionOut = Transaction::where('user_id', $request->user()->id)
                                 ->where('status', '0')
                                 ->whereYear('date_transaction', '=', $year)
                                 ->select(DB::raw('coalesce(SUM(amount), 0) as total_transaction_out'))
                                 ->first()->total_transaction_out;
        $differenceTransaction = $transactionIn - $transactionOut;
        return view('employee.transactions.index', compact(['transaction', 'transactionIn', 'transactionOut', 'differenceTransaction']));
   }

   public function createTransaction(Request $request)
   {
      $user = $request->user();
      $categories = Category::all();
      return view('employee.transactions.add', compact(['categories']));
   }

   public function storeTransaction(Request $request)
   {
      DB::beginTransaction();
      try{
         
         $user = $request->user();

         $storeTransaction = new Transaction();
         $storeTransaction->date_transaction = $request->date_transaction;
         $storeTransaction->amount = $request->amount;
         $storeTransaction->status = $request->status;
         $storeTransaction->description = $request->description;
         $storeTransaction->category_id = $request->category_id;
         $storeTransaction->user_id = $user->id;
         $storeTransaction->save();
         
         DB::commit();
         return redirect('/employee/transactions');

         return "Hello";
      }catch(\Exception $e){
         DB::rollback();
         return $e->getMessage();
      }

   }

   public function editTransaction(Request $request, $id)
   {
      $user = $request->user();
      $categories = Category::all();
      $transaction = Transaction::where('id', $id)->first();
      return view('employee.transactions.edit', compact(['transaction', 'categories']));
   }

   public function updateTransaction (Request $request, $id)
   {
      DB::beginTransaction();
      try{
         
         $user = $request->user();

         $storeTransaction = Transaction::findOrFail($id);
         $storeTransaction->date_transaction = $request->date_transaction;
         $storeTransaction->amount = $request->amount;
         $storeTransaction->status = $request->status;
         $storeTransaction->description = $request->description;
         $storeTransaction->category_id = $request->category_id;
         $storeTransaction->user_id = $user->id;
         $storeTransaction->save();
         
         DB::commit();
         return redirect('/employee/transactions');

         return "Hello";
      }catch(\Exception $e){
         DB::rollback();
         return $e->getMessage();
      }

   }

   public function deleteTransaction($id)
   {
       DB::beginTransaction();
       try{
           $check = Transaction::where('id', $id)->first();
           if(empty($check)){
               Alert::error('Error', 'Tidak Ada Data!!');
               return redirect('/employe/transactions');
           }

           Transaction::where('id', $id)->delete();

           DB::commit();
           Alert::success('Berhasil Menghapus Data!');

           return redirect()->back();

       }catch(\Exception $e){
           DB::rollback();
           Alert::error('Error', $e->getMessage());
           return $e->getMessage();
       }
   }

   public function indexProfile(Request $request)
   {

      $user = User::where('id', $request->user()->id)->first();


      return view('employee.profile', compact(['user']));

   }

   public function updateProfile(Request $request)
   {
       DB::beginTransaction();
       try{

         $user = $request->user();
         $user = User::findOrFail($user->id);
         $user->name = $request->name;
         $user->email = $request->email;
         $user->gender = $request->gender;
         $user->no_hp = $request->no_hp;
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

   public function indexReport(Request $request)
   {
      $year = !empty($request->year) ? $request->year : 2022;
      $data = $this->getYearlyTransactionSummary($year, auth()->id());
      return view('employee.reports.index', compact(['data']));

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

    public function printReport(Request $request)
    {
        $year = !empty($request->year) ? $request->year : 2022;
        $data = $this->getYearlyTransactionSummary($year, auth()->id());

    	$pdf = PDF::loadview('employee.reports.pdf',['data'=>$data]);
    	return $pdf->download('laporan-transaction-pdf.pdf');
    }
}
