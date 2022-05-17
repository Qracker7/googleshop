<?php
 
namespace App\Rules;
 
use Illuminate\Contracts\Validation\Rule;
use App\Useroption;

class Translation implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $local= Useroption::where('user_id', seller_id())->where('key','local')->first();
        $local=$local->value ?? ''; 
        
        $value = json_decode($value);
        return !empty($value->{$local});
    }
 
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be required.';
    }
}