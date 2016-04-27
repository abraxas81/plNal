<?php

namespace App\Services;

class PorukeOperaterima
{
    /**
     * Get an inspiring quote.
     * Taylor & Dayle made this commit from Jungfraujoch. (11,333 ft.)
     * @var $code
     * @return string
     * */
    public static function sqlPoruka($code)
    {
        switch ($code){
            case 1451: $message = 'Postoje zavisni podaci ovog sloga'; break;
            case 1054: $message = 'Nepoznati stupac u popisu polja'; break;
            case 1452: $message = 'Nemoguće je dodati ili ažurirati, nije ispravna vrijednost stranog ključa'; break;
            case 1062: $message = 'Vrijednost se već nalazi u bazi'; break;
            default : $message ='Nepoznata greška, molimo obratite se administratoru';break;
        }
        return $message;
    }
}
