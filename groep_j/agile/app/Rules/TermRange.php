<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TermRange implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(\d{4})\/(\d{4})$/', $value, $matches)) {
            $fail('Het termijn formaat is: YYYY/YYYY.');
            return;
        }

        $startYear = (int) $matches[1];
        $endYear = (int) $matches[2];

        if ($endYear !== $startYear + 1) {
            $fail('Het termijn moet opeenvolgende jaren zijn (bijv. 2024/2025).');
        }
    }
}
