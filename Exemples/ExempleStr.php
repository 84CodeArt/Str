<?php
include_once(__DIR__.'/../vendor/autoload.php');

use CodigoseCafe\StrUTF8\Str;
class ExempleStr
{
    public function print($string = null)
    {
        return Str::fixUTF8( $string );
    }
    
}

echo (new ExempleStr())->print('ApresentaÃ§Ã£o, cotaÃ§Ã£o, documentaÃ§Ã£o, funÃ§Ãµes e aÃ§Ã£o');
// SAIDA: Apresentação, cotação, documentação, funções e ação