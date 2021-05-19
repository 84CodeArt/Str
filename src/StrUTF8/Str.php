<?php
namespace CodigoseCafe\StrUTF8;

class Str {
  const ICONV_TRANSLIT = "TRANSLIT";
  const ICONV_IGNORE = "IGNORE";
  const DOTS_SUMMARY = "...";
  const WITHOUT_ICONV = "";
  protected static $win1252ToUtf8 = [
        128 => "\xe2\x82\xac",
        130 => "\xe2\x80\x9a",
        131 => "\xc6\x92",
        132 => "\xe2\x80\x9e",
        133 => "\xe2\x80\xa6",
        134 => "\xe2\x80\xa0",
        135 => "\xe2\x80\xa1",
        136 => "\xcb\x86",
        137 => "\xe2\x80\xb0",
        138 => "\xc5\xa0",
        139 => "\xe2\x80\xb9",
        140 => "\xc5\x92",
        142 => "\xc5\xbd",
        145 => "\xe2\x80\x98",
        146 => "\xe2\x80\x99",
        147 => "\xe2\x80\x9c",
        148 => "\xe2\x80\x9d",
        149 => "\xe2\x80\xa2",
        150 => "\xe2\x80\x93",
        151 => "\xe2\x80\x94",
        152 => "\xcb\x9c",
        153 => "\xe2\x84\xa2",
        154 => "\xc5\xa1",
        155 => "\xe2\x80\xba",
        156 => "\xc5\x93",
        158 => "\xc5\xbe",
        159 => "\xc5\xb8"
  ];
  protected static $brokenUtf8ToUtf8 = [
        "\xc2\x80" => "\xe2\x82\xac",
        "\xc2\x82" => "\xe2\x80\x9a",
        "\xc2\x83" => "\xc6\x92",
        "\xc2\x84" => "\xe2\x80\x9e",
        "\xc2\x85" => "\xe2\x80\xa6",
        "\xc2\x86" => "\xe2\x80\xa0",
        "\xc2\x87" => "\xe2\x80\xa1",
        "\xc2\x88" => "\xcb\x86",
        "\xc2\x89" => "\xe2\x80\xb0",
        "\xc2\x8a" => "\xc5\xa0",
        "\xc2\x8b" => "\xe2\x80\xb9",
        "\xc2\x8c" => "\xc5\x92",
        "\xc2\x8e" => "\xc5\xbd",
        "\xc2\x91" => "\xe2\x80\x98",
        "\xc2\x92" => "\xe2\x80\x99",
        "\xc2\x93" => "\xe2\x80\x9c",
        "\xc2\x94" => "\xe2\x80\x9d",
        "\xc2\x95" => "\xe2\x80\xa2",
        "\xc2\x96" => "\xe2\x80\x93",
        "\xc2\x97" => "\xe2\x80\x94",
        "\xc2\x98" => "\xcb\x9c",
        "\xc2\x99" => "\xe2\x84\xa2",
        "\xc2\x9a" => "\xc5\xa1",
        "\xc2\x9b" => "\xe2\x80\xba",
        "\xc2\x9c" => "\xc5\x93",
        "\xc2\x9e" => "\xc5\xbe",
        "\xc2\x9f" => "\xc5\xb8"
  ];
  protected static $utf8ToWin1252 = [
       "\xe2\x82\xac" => "\x80",
       "\xe2\x80\x9a" => "\x82",
       "\xc6\x92"     => "\x83",
       "\xe2\x80\x9e" => "\x84",
       "\xe2\x80\xa6" => "\x85",
       "\xe2\x80\xa0" => "\x86",
       "\xe2\x80\xa1" => "\x87",
       "\xcb\x86"     => "\x88",
       "\xe2\x80\xb0" => "\x89",
       "\xc5\xa0"     => "\x8a",
       "\xe2\x80\xb9" => "\x8b",
       "\xc5\x92"     => "\x8c",
       "\xc5\xbd"     => "\x8e",
       "\xe2\x80\x98" => "\x91",
       "\xe2\x80\x99" => "\x92",
       "\xe2\x80\x9c" => "\x93",
       "\xe2\x80\x9d" => "\x94",
       "\xe2\x80\xa2" => "\x95",
       "\xe2\x80\x93" => "\x96",
       "\xe2\x80\x94" => "\x97",
       "\xcb\x9c"     => "\x98",
       "\xe2\x84\xa2" => "\x99",
       "\xc5\xa1"     => "\x9a",
       "\xe2\x80\xba" => "\x9b",
       "\xc5\x93"     => "\x9c",
       "\xc5\xbe"     => "\x9e",
       "\xc5\xb8"     => "\x9f"
  ];
  
   static function strlen($text){
    return (function_exists('mb_strlen') && ((int) ini_get('mbstring.func_overload')) & 2) ?
           mb_strlen($text,'8bit') : strlen($text);
  }
   static function utf8_decode($text, $option = self::WITHOUT_ICONV)
  {
    if ($option == self::WITHOUT_ICONV || !function_exists('iconv')) {
       $o = utf8_decode(
         str_replace(array_keys(self::$utf8ToWin1252), array_values(self::$utf8ToWin1252), self::toUTF8($text))
       );
    } else {
       $o = iconv("UTF-8", "Windows-1252" . ($option == self::ICONV_TRANSLIT ? '//TRANSLIT' : ($option == self::ICONV_IGNORE ? '//IGNORE' : '')), $text);
    }
    return $o;
  }
   static function normalizeEncoding($encodingLabel)
  {
    $encoding = strtoupper($encodingLabel);
    $encoding = preg_replace('/[^a-zA-Z0-9\s]/', '', $encoding);
    $equivalences = array(
        'ISO88591' => 'ISO-8859-1',
        'ISO8859'  => 'ISO-8859-1',
        'ISO'      => 'ISO-8859-1',
        'LATIN1'   => 'ISO-8859-1',
        'LATIN'    => 'ISO-8859-1',
        'UTF8'     => 'UTF-8',
        'UTF'      => 'UTF-8',
        'WIN1252'  => 'ISO-8859-1',
        'WINDOWS1252' => 'ISO-8859-1'
    );
    if(empty($equivalences[$encoding])){
      return 'UTF-8';
    }
    return $equivalences[$encoding];
  }
   static function encode($encodingLabel, $text)
  {
    $encodingLabel = self::normalizeEncoding($encodingLabel);
    if($encodingLabel == 'ISO-8859-1') return self::toLatin1($text);
    return self::toUTF8($text);
  }

   static function toWin1252($text, $option = self::WITHOUT_ICONV) {
    if(is_array($text)) {
      foreach($text as $k => $v) {
        $text[$k] = self::toWin1252($v, $option);
      }
      return $text;
    } elseif(is_string($text)) {
      return static::utf8_decode($text, $option);
    } else {
      return $text;
    }
  }
   static function toISO8859($text, $option = self::WITHOUT_ICONV) {
    return self::toWin1252($text, $option);
  }
   static function toLatin1($text, $option = self::WITHOUT_ICONV) {
    return self::toWin1252($text, $option);
  }
   static function UTF8FixWin1252Chars($text){
    return str_replace(array_keys(self::$brokenUtf8ToUtf8), array_values(self::$brokenUtf8ToUtf8), $text);
  }
   static function removeBOM($str=""){
    if(substr($str, 0,3) == pack("CCC",0xef,0xbb,0xbf)) {
      $str=substr($str, 3);
    }
    return $str;
  }
  

  /**
   * Função toUTF8
   *
   * Essa função deixa os caracteres UTF8 em paz, enquanto converte quase todos os que não são UTF8 para UTF8.
   *
   * Supõe que a codificação da sequência original seja Windows-1252 ou ISO 8859-1.
   *
   * Pode falhar na conversão de caracteres para UTF-8 se eles se enquadrarem em um destes cenários:
   *
   * 1) quando qualquer um destes caracteres: ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ × ØÙÚÛÜÝÞß
   * são seguidos por um destes: ("grupo B") ¡¢ ¤ ¥ ¦§¨ © ª «¬®¯ ° ± ²³´µ¶ • ¸¹º» ¼½¾¿
   * 
   * Por exemplo:% ABREPRESENT% C9% BB. «REPRESENTÉ»
   * O caractere "« "(% AB) será convertido, mas o" É "seguido de" »" (% C9% BB)
   * também é um caractere unicode válido e permanecerá inalterado.
   *
   * 2) quando qualquer um destes: àáâãäåæçèéêëìíîï for seguido por DOIS caracteres do grupo B,
   * 3) quando qualquer um destes: areñòó for seguido por TRÊS caracteres do grupo B.
   *
   * @name toUTF8
   * @param string $text  Qualquer string.
   * @return string  A mesma sequência, codificada em UTF8
   *
   */
  public static function toUTF8($text)
  {
    if(is_array($text))
    {
      foreach($text as $k => $v)
      {
        $text[$k] = self::toUTF8($v);
      }
      return $text;
    }
    if(!is_string($text)) {
      return $text;
    }
    $max = self::strlen($text);
    $buf = "";
    for($i = 0; $i < $max; $i++){
        $c1 = $text{$i};
        if($c1>="\xc0"){ // Deve ser convertido para UTF8, se ainda não estiver UTF8
          $c2 = $i+1 >= $max? "\x00" : $text{$i+1};
          $c3 = $i+2 >= $max? "\x00" : $text{$i+2};
          $c4 = $i+3 >= $max? "\x00" : $text{$i+3};
            if($c1 >= "\xc0" & $c1 <= "\xdf"){ //parece UTF8 de 2 bytes
                if($c2 >= "\x80" && $c2 <= "\xbf"){ //sim, quase certo que já é UTF8
                    $buf .= $c1 . $c2;
                    $i++;
                } else { // UTF8 inválido. vamos converter.
                    $cc1 = (chr(ord($c1) / 64) | "\xc0");
                    $cc2 = ($c1 & "\x3f") | "\x80";
                    $buf .= $cc1 . $cc2;
                }
            } elseif($c1 >= "\xe0" & $c1 <= "\xef"){ //parece UTF8 de 3 bytes
                if($c2 >= "\x80" && $c2 <= "\xbf" && $c3 >= "\x80" && $c3 <= "\xbf"){ //sim, quase certo que já é UTF8
                    $buf .= $c1 . $c2 . $c3;
                    $i = $i + 2;
                } else { //UTF8 inválido. vamos converter.
                    $cc1 = (chr(ord($c1) / 64) | "\xc0");
                    $cc2 = ($c1 & "\x3f") | "\x80";
                    $buf .= $cc1 . $cc2;
                }
            } elseif($c1 >= "\xf0" & $c1 <= "\xf7"){ // parece UTF8 de 4 bits
                
                if($c2 >= "\x80" && $c2 <= "\xbf" && $c3 >= "\x80" && $c3 <= "\xbf" && $c4 >= "\x80" && $c4 <= "\xbf"){ //yeah, almost sure it's UTF8 already
                    $buf .= $c1 . $c2 . $c3 . $c4;
                    $i = $i + 3;
                } else { //UTF8 inválido. vamos converter.
                    $cc1 = (chr(ord($c1) / 64) | "\xc0");
                    $cc2 = ($c1 & "\x3f") | "\x80";
                    $buf .= $cc1 . $cc2;
                }
            } else { // não se parece com UTF8, mas deve ser convertido
                    $cc1 = (chr(ord($c1) / 64) | "\xc0");
                    $cc2 = (($c1 & "\x3f") | "\x80");
                    $buf .= $cc1 . $cc2;
            }
        } elseif(($c1 & "\xc0") == "\x80"){ // precisa de conversão
              if(isset(self::$win1252ToUtf8[ord($c1)])) { // encontrado em casos especiais do Windows-1252
                  $buf .= self::$win1252ToUtf8[ord($c1)];
              } else {
                $cc1 = (chr(ord($c1) / 64) | "\xc0");
                $cc2 = (($c1 & "\x3f") | "\x80");
                $buf .= $cc1 . $cc2;
              }
        } else { // não precisa de conversão
            $buf .= $c1;
        }
    }
    return $buf;
  }
  
  public static function fixUTF8($text, $option = self::WITHOUT_ICONV){

    if(\is_bool($text)){
      return $text;
    }

    if(is_array($text)) {
      foreach($text as $k => $v) {
        $text[$k] = self::fixUTF8($v, $option);
      }
      return $text;
    }
    if(!is_string($text)) {
      return $text;
    }
    $last = "";
    while($last <> $text){
      $last = $text;
      $text = self::toUTF8(static::utf8_decode($text, $option));
    }
    $text = self::toUTF8(static::utf8_decode($text, $option));
   
    return  self::convertEspecial($text);
  }



  public static function convertEspecial($text)
  {
    if($pos = strrpos($text, '\u')){
      $caracter = substr($text, $pos, 6);
      $utf8string = self::utf8(hexdec(str_replace("\u","", $caracter)));
      $text = str_replace($caracter, $utf8string, $text);      
    }
    return $text;
  }

  public static function utf8($num)
  {
      if($num<=0x7F)       return chr($num);
      if($num<=0x7FF)      return chr(($num>>6)+192).chr(($num&63)+128);
      if($num<=0xFFFF)     return chr(($num>>12)+224).chr((($num>>6)&63)+128).chr(($num&63)+128);
      if($num<=0x1FFFFF)   return chr(($num>>18)+240).chr((($num>>12)&63)+128).chr((($num>>6)&63)+128).chr(($num&63)+128);
      return '';
  }

  public static function uniord($c)
  {
      $ord0 = ord($c{0}); if ($ord0>=0   && $ord0<=127) return $ord0;
      $ord1 = ord($c{1}); if ($ord0>=192 && $ord0<=223) return ($ord0-192)*64 + ($ord1-128);
      $ord2 = ord($c{2}); if ($ord0>=224 && $ord0<=239) return ($ord0-224)*4096 + ($ord1-128)*64 + ($ord2-128);
      $ord3 = ord($c{3}); if ($ord0>=240 && $ord0<=247) return ($ord0-240)*262144 + ($ord1-128)*4096 + ($ord2-128)*64 + ($ord3-128);
      return false;
  }
  
  public static function html_entities($str, $option = self::WITHOUT_ICONV)
  {
      return mb_convert_encoding( self::fixUTF8($str , $option), 'HTML-ENTITIES', 'utf-8');
  }

  public static function upper($str, $option = self::WITHOUT_ICONV)
  {
      return  mb_strtoupper( self::fixUTF8($str , $option) );
  }

  public static function lower($str , $option = self::WITHOUT_ICONV)
  {
      return  mb_strtolower( self::fixUTF8($str, $option) );
  }

  public static function slug($str, $separator = '-')
  {
      $str_slug =  preg_replace("/![a-zA-Z0-9 ]/", "", self::lower( self::stripAccents(strip_tags( $str ))));
      $str_slug =  preg_replace("/ |\ /", $separator, $str_slug );
      $reg = '/'.$separator.$separator.'/';
      while (preg_match($reg, $str_slug)) {
        $str_slug = str_replace( $separator.$separator , $separator, $str_slug);
      }
      return $str_slug;
  }

  
  public static function stripAccents($str, $outherCaracter=[], $option = self::WITHOUT_ICONV)
  {
    if(\is_bool($str)){
      return $str;
    }

     $str = self::fixUTF8($str, $option);

     $stripString = preg_replace([
      "/(á|à|ã|â|ä)/",
      "/(Á|À|Ã|Â|Ä)/",
      "/(é|è|ê|ë)/",
      "/(É|È|Ê|Ë)/",
      "/(í|ì|î|ï)/",
      "/(Í|Ì|Î|Ï)/",
      "/(ó|ò|õ|ô|ö)/",
      "/(Ó|Ò|Õ|Ô|Ö)/",
      "/(ú|ù|û|ü)/",
      "/(Ú|Ù|Û|Ü)/",
      "/(Ç)/",
      "/(ç)/",
      "/(ñ)/",
      "/(Ñ)/"],
      explode(" ","a A e E i I o O u U C c n N"), $str );

      if(!empty($outherCaracter)){
        $stripString = str_replace($outherCaracter, '', $stripString);
      }
    
     return $stripString;
  }

    public static function summary($string, $limite_caracter, $dots = self::DOTS_SUMMARY, $option = self::WITHOUT_ICONV) { 
        $string = strip_tags( self::fixUTF8($string , $option) ); 
        
        if (strlen($string) >  $limite_caracter) { 
            while (substr($string, $limite_caracter,1) <> ' ' && ( $limite_caracter < strlen($string))) { 
                 $limite_caracter++; 
            }; 
        }; 
        
        return substr($string, 0, $limite_caracter) . $dots; 
    }
  
}
