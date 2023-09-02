<?php

/**
 * BSD 2-Clause License
 * 
 * Copyright (c) 2019, Soora JP
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 
 * 1. Redistributions of source code must retain the above copyright notice, this
 *    list of conditions and the following disclaimer.
 * 
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace SooraJP\KNNC;

use SooraJP\KNNC\Data;

class Util
{

    public static function isChar(string $char)
    {
        return mb_strlen($char) === 1;
    }

    /**
     * $char が num の文字に該当するかを確認する。
     * ※ num の文字の一覧は \SooraJP\KNNC\Data.php を参照のこと。
     * 
     * @param string $char
     * @return bool
     */
    public static function isNum(string $char)
    {

        switch(true)
        {

            case !self::isChar($char):
                return false;

            case is_numeric($char):
            case array_key_exists($char, Data::NUM_GENERAL):
            case array_key_exists($char, Data::NUM_COMPLEX):
                return true;

        }

        return false;

    }

    /**
     * $char が place の文字に該当するかを確認する。
     * ※ place の文字の一覧は \SooraJP\KNNC\Data.php を参照のこと。
     * 
     * @param string $char
     * @return bool
     */
    public static function isPlace(string $char)
    {

        switch(true)
        {

            case !self::isChar($char):
                return false;

            case array_key_exists($char, Data::PLACE_GENERAL):
            case array_key_exists($char, Data::PLACE_COMPLEX):
                return true;

        }

        return false;

    }

    /**
     * $str が rank の文字列に該当するかを確認する。
     * ※ rank の文字列の一覧は \SooraJP\KNNC\Data.php を参照のこと。
     * 
     * @param string $str
     * @return bool
     */
    public static function isRank(string $str)
    {

        switch(true)
        {

            case array_key_exists($str, Data::RANK_GENERAL):
            case array_key_exists($str, Data::RANK_COMPLEX):
                return true;

        }

        return false;

    }

    /**
     * $char が rank の文字列の一部に該当するかを確認する。
     * ※ rank の文字列の一部の一覧は \SooraJP\KNNC\Data.php を参照のこと。
     * 
     * @param string $char
     * @return bool
     */
    public static function isRankPart(string $char)
    {
        return array_key_exists($char, Data::RANK_PART);
    }

    /**
     * $char を数値に変換します。
     * 等価となる数値が見つからなかった場合は false を返します。
     * @param string $char
     * @return int or false
     */
    public static function toNum(string $char)
    {

        if(!self::isChar($char))
            return false;

        if(is_numeric($char))
            return (int)$char;

        if(array_key_exists($char, Data::NUM_GENERAL))
            return Data::NUM_GENERAL[$char];

        if(array_key_exists($char, Data::NUM_COMPLEX))
            return Data::NUM_COMPLEX[$char];

        return false;

    }

    /**
     * $char を数値に変換します。10の指数表現の指数部となります。
     * 等価となる数値が見つからなかった場合は false を返します。
     * @param string $char
     * @return int or false
     */
    public static function toPlace(string $char)
    {

        if(!self::isChar($char))
            return false;

        if(array_key_exists($char, Data::PLACE_GENERAL))
            return Data::PLACE_GENERAL[$char];

        if(array_key_exists($char, Data::PLACE_COMPLEX))
            return Data::PLACE_COMPLEX[$char];

        return false;

    }
    
    /**
     * $str を数値に変換します。10の指数表現の指数部となります。
     * 等価となる数値が見つからなかった場合は false を返します。
     * @param string $str
     * @return int or false
     */
    public static function toRank(string $str)
    {

        if(array_key_exists($str, Data::RANK_GENERAL))
            return Data::RANK_GENERAL[$str];

        if(array_key_exists($str, Data::RANK_COMPLEX))
            return Data::RANK_COMPLEX[$str];

        return false;

    }

    /**
     * 仮の数値に加算しても影響がないかを確認する。
     * 例として、1000に100を足しても問題はないが、1000に1000を足すのは問題があるといえる。
     * 被加算数の0の数と加算数の桁数を見て判断を行う。
     * 加算しても問題がない場合は true 、加算すると問題がある場合は false を返す。
     */
    public static function whetherAllowToAdd ($added, $incremental)
	{
		if($added === 0)
			return true;

		for($count = 0; $added >= 10 && $added % 10 === 0; $count++, $added /= 10);
		return strlen(sprintf("%.0F", (string)$incremental)) <= $count;
    }
    
    public static function num2kan(int $num, int $convertType = ConvertType::GENERAL)
    {

        if($num < 0 || 9 < $num)
            return false;

        return array_search($num, ($convertType & ConvertType::COMPLEX) ? Data::NUM_COMPLEX : Data::NUM_GENERAL, true);
        
    }

    public static function place2kan(int $num, int $convertType = ConvertType::GENERAL)
    {

        if($num < 1 || 3 < $num)
            return false;

        return array_search($num, ($convertType & ConvertType::COMPLEX) ? Data::PLACE_COMPLEX : Data::PLACE_GENERAL, true);

    }

    public static function rank2kan(int $num, int $convertType = ConvertType::GENERAL)
    {

        if($num % 4 !== 0)
            return false;

        return array_search($num, ($convertType & ConvertType::COMPLEX) ? Data::RANK_COMPLEX : Data::RANK_GENERAL, true);

    }



}