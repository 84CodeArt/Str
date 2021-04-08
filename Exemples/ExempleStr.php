<?php
include_once(__DIR__.'/../vendor/autoload.php');

use CodigoseCafe\StrUTF8\Str;
class ExempleStr
{
    public function print($string)
    {
        return Str::fixUTF8( $string);
    }
    
}

print_r((new ExempleStr())->print(['ApresentaÃ§Ã£o', 'cotaÃ§Ã£o', 'documentaÃ§Ã£o', 'funÃ§Ãµes' , 'aÃ§Ã£o','Funda\u008do Municipal De Sade Pblica De Paulo Frontin']));
// SAIDA: Apresentação, cotação, documentação, funções e ação