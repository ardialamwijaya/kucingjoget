<?php
/**
 * Created by PhpStorm.
 * User: Ardi
 * Date: 22/04/2018
 * Time: 05.45
 */
namespace ccxt;
require_once "php/binance.php";
class myBinance extends binance
{
    public function __construct($options=array()){
        if(file_exists('nonce.dat')){$noncearray=file('nonce.dat',FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);$nonce=$noncearray[0];$nonce++;}else{$nonce=1;}  // Assume we have new keys if nonce.dat does not exist.
        if(file_exists('nonce.dat')){if(file_exists('nonce.old')){unlink('nonce.old');} rename('nonce.dat','nonce.old');}
        file_put_contents('nonce.dat',$nonce,LOCK_EX);  // File contains latest used nonce.
        parent::__construct(array_merge(array('i'=>$nonce),$options));
    }
    public function nonce(){
        if(file_exists('nonce.dat')){$noncearray=file('nonce.dat',FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);$nonce=$noncearray[0];$nonce++;}else{$nonce=1;}  // Assume we have new keys if nonce.dat does not exist.
        if(file_exists('nonce.dat')){if(file_exists('nonce.old')){unlink('nonce.old');} rename('nonce.dat','nonce.old');}
        file_put_contents('nonce.dat',$nonce,LOCK_EX);  // File contains latest used nonce.
        $this->i=$nonce;
        return $this->i;
    }
}