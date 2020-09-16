<?php
namespace App\Http\Controllers;

use App\Rules\DiscountTier;
use App\Rules\EditDiscountTier;
use Illuminate\Http\Request;
use Session;

class DiscountTierController extends Controller{
    public function index(){
        $discountTiers = \DB::table('discount_tiers')->get();

        return view('admin.discount-tier.index',['discountTiers' => $discountTiers]);
    }

    public function store(Request $request){
        $inputs = request()->validate([
            'min_amount'    => ['required','numeric','gt:0',new DiscountTier($request->get('min_amount'))],
            'max_amount'    => ['required','numeric','gt:min_amount',new DiscountTier($request->get('max_amount'))],
            'disc_prob'     => ['required','numeric','gt:0'],
            'disc_rate'     => ['required','numeric','gt:0']
        ]);

        $insertData = \DB::table('discount_tiers')->insert([
            'min_amount' => $request->get('min_amount'),
            'max_amount' => $request->get('max_amount'),
            'discount_probability' => $request->get('disc_prob'),
            'discount_rate' => $request->get('disc_rate'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if($insertData){
            Session::flash('alert-success', 'New Tier has been added!');
        }else{
            Session::flash('alert-error', 'Sorry, there is error to add new tier!');
        }

        return back();
    }

    public function edit($idTier){
        $data = \DB::table('discount_tiers')->where('id','=', $idTier)->first();
        
        return view('admin.discount-tier.edit',['data' => $data]);
    }

    public function update(Request $request, $idTier){

        $getData = \DB::table('discount_tiers')->where('id','=',$idTier)->first();

        if($getData->min_amount == $request->get('min_amount')){
            $ruleMinAmount = ['required','numeric','gt:0'];
        }else{
            $ruleMinAmount = ['required','numeric','gt:0',new EditDiscountTier($idTier)];
        }

        if($getData->max_amount == $request->get('max_amount')){
            $ruleMaxAmount = ['required','numeric','gt:0'];
        }else{
            $ruleMaxAmount = ['required','numeric','gt:min_amount',new EditDiscountTier($idTier)];
        }

        $inputs = request()->validate([
            'min_amount'    => $ruleMinAmount,
            'max_amount'    => $ruleMaxAmount,
            'disc_prob'     => ['required','numeric','gt:0'],
            'disc_rate'     => ['required','numeric','gt:0']
        ]);

        $updateData = \DB::table('discount_tiers')
                        ->where('id','=',$idTier)
                        ->update([
                            'min_amount' => $request->get('min_amount'),
                            'max_amount' => $request->get('max_amount'),
                            'discount_probability' => $request->get('disc_prob'),
                            'discount_rate' => $request->get('disc_rate'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

        if($updateData){
            Session::flash('update-success', 'Tier has been updated!');
        }else{
            Session::flash('update-error', 'Sorry, there is error to update tier!');
        }

        return redirect()->route('discount-tier.index');
    }

    public function destroy($idTier){
        
        $deleteTier = \DB::table('discount_tiers')->where('id','=', $idTier)->delete();

        Session::flash('alert-deleted', 'Tier was deleted');

        return back();
    }
}