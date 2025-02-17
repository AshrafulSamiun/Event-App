<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueEmailInTwoTables implements Rule
{

    protected $ignoreId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($ignoreId = null)
    {
        $this->ignoreId = $ignoreId;
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
       // Check if the email exists in the AccountHolder table
      // $existsInAccountHolder = DB::table('users')->where('email', $value)->exists();

       // Check if the email exists in the Bank table
       //$existsInBank = DB::table('account_holder_banks')->where('email', $value)->exists();

       $existsInAccountHolder = DB::table('users')
       ->where('email', '=', $value)
       ->when($this->ignoreId, function ($query) {
           return $query->where('account_holder_id', '!=', $this->ignoreId);
       })
       ->exists();

   // Check if the email exists in the Bank table, excluding the current record
   $existsInBank = DB::table('account_holder_banks')
       ->where('email', '=', $value)
       ->when($this->ignoreId, function ($query) {
           return $query->where('id', '!=', $this->ignoreId);
       })
       ->exists();
       

       // The email should not exist in either table
       return !$existsInAccountHolder && !$existsInBank;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The email has already been taken.';
    }
}
