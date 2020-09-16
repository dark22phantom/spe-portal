<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;
use Session;
use App\User;

class TransactionController extends Controller{

    protected $urlGeneratedToken = 'http://localhost/spe-api/public/index.php/generate-token';
    protected $urlTransaction = 'http://localhost/spe-api/public/index.php/transaction/store';

    public function index(){
        $customers = User::all();
        $transactions = \DB::table('transactions as t')
                            ->join('users as u','t.customer_id','=','u.id')
                            ->select('t.*','u.name')
							->orderBy('created_at','DESC')
                            ->get();

        return view('admin.transaction.index',['customers' => $customers, 'transactions' => $transactions]);
    }

    public function store(Request $request){
        $inputs = request()->validate([
            'customer' => ['required','not_in:0'],
            'transaction_amount' => ['required','numeric','gt:0']
        ]);

        $email = auth()->user()->email;
        $password = auth()->user()->password;

        $response = Http::post($this->urlGeneratedToken, [
            'email' => $email,
            'password' => $password
        ]);

        if($response->status() == 200){
            $datas = $response->json();
            $token = $datas['data']['token'];

            $response = Http::withHeaders(['token' => $token])
                            ->post($this->urlTransaction, [
                                'customer_id' => request()->customer,
                                'transaction_amount' => request()->transaction_amount
                            ]);

            if($response->status() == 200){
                $datas = $response->json();
                Session::flash('success-api', $datas['message']);
            }else{
                Session::flash('alert-api', $datas['message']);
            }

        }else{
            Session::flash('alert-api', 'Api is not working. Please try again!');
        }

        return redirect()->route('transaction.index');
    }
}