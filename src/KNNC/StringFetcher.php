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

/**
 * Class StringFetcher.
 * 
 * Fetch the string from the specified location for the specified number of characters.
 * 
 * @package SooraJP\KNNC
 */
class StringFetcher 
{

    /** @var string */
    private $str;

    /** @var int */
    private $len;

    /** @var int */
    private $cnt;

    /** @var int */
    public $ptLen;

    /** @var bool */
    public $spacePadding;

    /** @var bool */
    public $fromEnd;

    /**
     * StringFetcher constructor. 
     * 
     * @param string $str
     * @param int $ptLen Number of characters in the string to be extracted at a time.
     * @param bool $spacePadding Whether to fill the remaining characters with single-byte spaces.
     * @param bool $fromEnd Whether to fetch string from the end.
     */
    public function __construct(string $str, int $ptLen = 1, bool $spacePadding = false, bool $fromEnd = false)
    {

        $this->str = $str;
        $this->len = mb_strlen($str);
        $this->cnt = 0;

        $this->ptLen = $ptLen;
        $this->spacePadding = 0;
        $this->fromEnd = $fromEnd;

    }

    /**
     * Fetch string.
     * 
     * @return string|false
     */
    public function fetch()
    {

        if($this->fetchedAll())
            return false;

        // 今回の取り出し開始場所計算
        $thisTimeStart = $this->cnt;
        $thisTimeStart *= $this->fromEnd ? -1 : 1;

        // 今回の取り出し文字数計算
        $thisTimeLen = ($this->len <= $this->cnt + $this->ptLen) ? $this->len - $this->cnt : $this->ptLen;

        $result = mb_substr($this->str, $thisTimeStart, $thisTimeLen);
        $padding = str_repeat(' ', $this->ptLen - $thisTimeLen);
        $result = $this->fromEnd ? $padding.$result : $result.$padding;
        
        $this->cnt += $thisTimeLen;

        return $result;

    }

    /**
     * Check if all character strings have been fetched.
     * 
     * @return bool
     */
    public function fetchedAll()
    {
        return ($this->len <= $this->cnt);
    }

}