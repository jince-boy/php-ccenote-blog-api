<?php

namespace App\Utils;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class Keyword
{

    /**
     * 判断是否为评论关键字
     * @param string $text
     * @return bool
     * @throws FileNotFoundException
     */
    public function isKeyword(string $text): bool
    {
        $keywords = explode(',', trim(Storage::disk('local')->get('keywords.txt')));
        $count=0;
        $pattern="/".implode("|",$keywords)."/i";
        if(preg_match_all($pattern,$text,$matches)){
            $patternList=$matches[0];
            $count=count($patternList);
        }
        if($count==0){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 获取评论关键字
     * @return string
     * @throws FileNotFoundException
     */
    public function getKeywords(): string
    {
        return trim(Storage::disk('local')->get('keywords.txt'));
    }

    /**
     * 设置评论关键字
     * @param string $keyword
     * @return bool
     */
    public function setKeywords(string $keyword): bool
    {
        return (bool)Storage::disk('local')->put('keywords.txt', $keyword);
    }
}
