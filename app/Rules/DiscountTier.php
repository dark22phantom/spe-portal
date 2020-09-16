<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DiscountTier implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $checkAmountDb = $this->checkAmountTier($value);

        return $checkAmountDb;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The amount must not be in another tier range.';
    }

    public function checkAmountTier($amount){
        $datas = \DB::table('discount_tiers')->get();
        foreach($datas as $data){
            if($data->min_amount <= $amount && $data->max_amount >= $amount){
                return false;
            }
        }
        return true;
    }
}
