<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cpf implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
            for ( $i = 0; $i < strlen( $digitos ); $i++  ) {
                $soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );
                $posicoes--;
            }
     
            $soma_digitos = $soma_digitos % 11;
     
            if ( $soma_digitos < 2 ) {
                $soma_digitos = 0;
            } else {
                $soma_digitos = 11 - $soma_digitos;
            }
     
            $cpf = $digitos . $soma_digitos;
            
            return $cpf;
        }

        if ( ! $value ) {
            $fail('CPF inválido!');
        }
     
        $value = preg_replace( '/[^0-9]/is', '', $value );
     
        if ( strlen( $value ) != 11 ) {
            $fail('CPF inválido!');
        }   
     
        $digitos = substr($value, 0, 9);
        
        $novo_cpf = calc_digitos_posicoes( $digitos );
        
        $novo_cpf = calc_digitos_posicoes( $novo_cpf, 11 );

        if ( $novo_cpf !== $value ) {
            $fail('CPF inválido!');
        }
    }
}
