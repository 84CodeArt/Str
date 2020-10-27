# StrUTF8\Str

Pacote PHP Desenvolvido por [Claudio ALexssandro Lino](https://www.linkedin.com/in/claudioalexssandrolino/).

---
## Índice
  1. [Introdução](#Introdução)
  2. [Instalação](#Instalação)
        * [Via composer](#via-composer)

---
## Introdução
Se você trabala com PHP e deseja converter uma string Windows-1252 ou ISO-8859-1 para o padrão UTF-8, ao trabalhar com sistemas legados em PHP, encontramos muitos arquivos codificados com charset ISO-8859-1. 

Muitos dados podem ter cido salvo com charset diferente do UTF-8, e quando esses dados forem ser apresentados para os usuarios, acabarem dando problemas de encode.

Esse código fará o trabalho com maestria, convertendo sem dificuldade para UTF-8 caracteres como **"apresentaÃ§Ã£o"** para **"apresentação"**.

---
## Instalação

Para adicionar o pacote (Classe) em seu projeto, você pode baixar o pacote através desse link: https://github.com/codigosecafe/str-utf8/archive/master.zip e adicionar em seu projeto através do include ou require, abordarei esse metódo na seção, **Sem composer**.

---
### Via composer
Para adicionar via composer basta acessar a raiz do seu projeto via linha de comando e executar o seguinte comando.
```shell
composer require codigosecafe/str-utf8
```
Depois de instalar o pacote **StrUTF8\Str** em seu projeto, você pode usar da seguinte forma.
```php
<?php
namespace App\Modue\MeuModulo;

use CodigoseCafe\StrUTF8\Str;

class MinhaClasse
{
    public function print($string = null)
    {
        return Str::fixUTF8( $string );
    }
    
}

echo (new MinhaClasse())->print('ApresentaÃ§Ã£o, cotaÃ§Ã£o, documentaÃ§Ã£o, funÃ§Ãµes e aÃ§Ã£o');
// SAIDA: Apresentação, cotação, documentação, funções e ação
```

---
[comment]: <> (## Sem composer)
