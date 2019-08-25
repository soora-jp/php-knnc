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

namespace SooraJP;

use SooraJP\KNNC\Util;
use SooraJP\KNNC\CharFetcher;
use SooraJP\KNNC\ConvertType;

class KNNC
{



    /**
	 * |------------------------------------------------|
	 * | MEMO	 										|
	 * |------------------------------------------------|
	 * | num	 〇一二三...八九 壱弐参...捌玖 etc...	|
	 * | place	 十百千 etc...							|
	 * | rank	 万億兆京...無量大数					|
	 * |------------------------------------------------|
	 */



	/**
	 * Convert Japanese-Kanji numerals string to numeric.
	 * 
	 * Return numeric, or false in case of failure.
	 * 
	 * @param string $str
	 * @return int|float|false
	 */
    public static function kan2num(string $str)
    {

		// 最終的な計算結果
		$result = 0;

		// place に該当する文字が出現するまで一時的に数値を保持する
		$temp_num_place = 0;

		// rank に該当する文字が出現するまで一時的に数値を保持する
		$temp_num_rank = 0;

		// 複数文字の rank に対応するためのキュー
		$rank_queue = '';

		$fetcher = new CharFetcher($str);

		while($char = $fetcher->fetch())
		{

			if(Util::isRank($char))
			{

				$rank = Util::toRank($char);

				// 複数文字の rank に対応
				if($rank === false)
				{
					$rank_queue .= $char;
					if(!Util::isRank($rank_queue))
						return false;

					$rank = Util::toRank($rank_queue);
					if($rank === false)
						continue;
				}

				// rank に該当する文字が出現するまでに数値が出現しない場合 (例: 万)
				if($temp_num_place === 0 && $temp_num_rank === 0)
					return false;

				// 前後の大小関係の正当性を検証 (例: 1万1億, 1億12345万)
				$incremental = ($temp_num_place + $temp_num_rank) * 10 ** $rank;
				if(!Util::whetherAllowToAdd($result, $incremental))
					return false;

				$result += $incremental;
				$rank_queue = '';
				$temp_num_place = 0;
				$temp_num_rank = 0;

				continue;

			}

			// 複数文字の単位が途中で途切れている場合 (例: 1無量2大数)
			if($rank_queue !== '')
				return false;

			if(Util::isPlace($char))
			{
					
				$place = Util::toPlace($char);
				$temp_num_place += ($temp_num_rank ?: 1) * 10 ** $place;
				$temp_num_rank = 0;
		
				continue;
		
			}

			if(Util::isNum($char))
			{

				$num = Util::toNum($char);
				$temp_num_rank *= 10;
				$temp_num_rank += $num;

				continue;

			}

		}

		// 最後に place や rank が出現せずに終わる場合 (例: 1万2345)
		$incremental = $temp_num_place + $temp_num_rank;
		if($incremental !== 0)
		{

			// 前後の大小関係の正当性を検証 (例: 1万12345)
			if(!Util::whetherAllowToAdd($result, $incremental))
			return false;

			$result += $incremental;

		}
		
		return $result;

	}



	/**
	 * |----------------------------------------------------------------------------|
     * | 以下 ConvertType のどの組み合わせでどのような変換になるのかを例示します。	|
     * | 今回は変換対象の数値として「123456789」を利用します。						|
     * |----------------------------------------------------------------------------|
     * | GENERAL				一億二三四五万六七八九								|
     * | GENERAL | STRICT		一億二千三百四十五万六千七百八十九					|
     * | COMPLEX            	壱億弐参四五萬六七八九								|
     * | COMPLEX | STRICT   	壱億弐千参百四拾五萬六千七百八拾九					|
	 * |----------------------------------------------------------------------------|
     */



	/**
	 * Convert numeric to Japanese-Kanji numerals string.
	 * 
	 * Return string, or false in case of failure.
	 * 
	 * ConvertType::
	 *   GENERAL	Normal use
	 *   COMPLEX	Using old font, suitable for expressing money. This is an excuse for GENERAL.
	 *   STRICT		More strictly. Can be used in combination with GENERAL or COMPLEX.
	 * 
	 * ConvertType:: (in Japanese)
	 *   GENERAL	一般的な表現をします。
	 *   COMPLEX	旧字体を用いた少々複雑な表記を行います。GENERALとは排反です。
	 *   STRICT		各数値の後に千百十(拾)を挿入します。GENERALやCOMPLEXと組み合わせて利用可能です。
	 * 
	 * @param int|float $num
	 * @param int $convertType
	 * @return string|false
	 */
    public static function num2kan($num, int $convertType = ConvertType::GENERAL)
    {

		// int or float only
        if(!is_int($num) && !is_float($num))
			return false;
			
		$result = '';
		$count = 0;

		while($num > 0)
		{

			$value = $num % 10;
			$num = floor($num / 10);

			// Insert rank char
			$append = Util::rank2kan($count, $convertType);
			if($append !== false)
				$result = $append.$result;
			
			// Insert place char
			if($convertType & ConvertType::STRICT)
			{
				$append = Util::place2kan($count % 4, $convertType);
				if($append !== false)
					$result = $append.$result;
			}

			// Insert num char
			$append = Util::num2kan($value, $convertType);
			if($append === false)
				return false;
			$result = $append.$result;
			
			$count++;

		}

		return $result;

    }

}