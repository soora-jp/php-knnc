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

class Data
{

    const NUM_GENERAL = [
        '〇' => 0,
		'一' => 1,
		'二' => 2,
		'三' => 3,
		'四' => 4,
		'五' => 5,
		'六' => 6,
		'七' => 7,
		'八' => 8,
		'九' => 9,
    ];

    const NUM_COMPLEX = [
        '零' => 0,
        '壱' => 1,
        '壹' => 1,
        '弌' => 1,
        '弐' => 2,
        '貳' => 2,
        '弍' => 2,
        '参' => 3,
        '參' => 3,
        //'?'  => 3,
        '四' => 4,
        '肆' => 4,
        '五' => 5,
        '伍' => 5,
        '六' => 6,
        '陸' => 6,
        '七' => 7,
        '漆' => 7,
        //'?'  => 7,
        '質' => 7,
        '八' => 8,
        '捌' => 8,
        '九' => 9,
		'玖' => 9,
    ];

    const PLACE_GENERAL = [
        '十' => 1,
		'百' => 2,
		'千' => 3,
    ];

    const PLACE_COMPLEX = [
        '拾' => 1,
        //'廿' => 20, // |--- Warning --------------------------------------------------|
        //'?'  => 20, // | ここはコメントを外しても正常に動作しません。                 |
        //'卅' => 30, // | ご希望がありましたら実装しようと思いますのでご連絡ください。 |
        //'丗' => 30, // |--------------------------------------------------------------|
		//'?'  => 40,
		'百' => 2,
        '佰' => 2,
        '陌' => 2,
		'千' => 3,
        '仟' => 3,
        '阡' => 3,
    ];

    const RANK_GENERAL = [
        '万' => 4,
		'億' => 8,
		'兆' => 12,
		'京' => 16,
		'垓' => 20,
		//'??' => 24,
		'穣' => 28,
		'溝' => 32,
		'澗' => 36,
		'正' => 40,
		'載' => 44,
		'極' => 48,
		'恒河沙' => 52,
		'阿僧祇' => 56, 
		'那由他' => 60,
		'不可思議' => 64, 
		'無量大数' => 68, 
    ];

    const RANK_COMPLEX = [
        '萬' => 4,
		'億' => 8,
		'兆' => 12,
		'京' => 16,
		'垓' => 20,
        //'?' => 24,
		//'??' => 24,
		'穣' => 28,
		'溝' => 32,
		'澗' => 36,
		'正' => 40,
		'載' => 44,
		'極' => 48,
		'恒河沙' => 52,
		'阿僧祇' => 56, 
		'那由他' => 60,
		'不可思議' => 64, 
		'無量大数' => 68, 
    ];

    const RANK_PART = [
        '恒' => true,
        '河' => true,
        '沙' => true,
        '恒河' => true,
        '阿' => true,
        '僧' => true,
        '祇' => true,
        '阿僧' => true,
        '那' => true,
        '由' => true,
        '他' => true,
        '那由' => true,
        '不' => true,
        '可' => true,
        '思' => true,
        '議' => true,
        '不可' => true,
        '不可思' => true,
        '無' => true,
        '量' => true,
        '大' => true,
        '数' => true,
        '無量' => true,
        '無量大' => true,
    ];

}