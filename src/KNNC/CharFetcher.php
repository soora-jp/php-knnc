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
 * Fetch characters one by one from the string beginning.
 * 
 * @package SooraJP\KNNC
 */
class CharFetcher 
{

    /** @var string */
    private $str;

    /** @var int */
    private $len;

    /** @var int */
    private $cnt;

    /**
     * CharFetcher constructor. 
     * 
     * @param string $str
     */
    public function __construct(string $str)
    {

        $this->str = $str;
        $this->len = mb_strlen($str);
        $this->cnt = 0;

    }

    /**
     * Fetch char.
     * 
     * @return string|false
     */
    public function fetch()
    {

        if($this->fetchedAll())
            return false;

        $char = mb_substr($this->str, $this->cnt, 1);

        $this->cnt++;

        return $char;

    }

    /**
     * Check if all characters have been fetched.
     * 
     * @return bool
     */
    public function fetchedAll()
    {

        return ($this->len <= $this->cnt);
        
    }

}