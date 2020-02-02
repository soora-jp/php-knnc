# Japanese-Kanji Numeral string and Numeric Converter (KNNC)

## Introduction

This is a PHP library for converting between Japanese-Kanji numeral string and numeric (int or float).

## Requirement

PHP 5.4 or later

## Installation

Install this KNNC library using Composer.

```sh
composer require soora-jp/knnc
```

## Getting started

### Convert Japanese-Kanji numeral string to numeric

```php
SooraJP\KNNC::kan2num('一万二千三百四十五');
```

Result: 12345

### Convert umeric to Japanese-Kanji numeral string

**ConvertType** General

```php
SooraJP\KNNC::num2kan(123456789);
// "一億二三四五万六七八九"
```

**ConvertType** General Strict

```php
SooraJP\KNNC::num2kan(123456789, SooraJP\KNNC\ConvertType::STRICT);
// "一億二千三百四十五万六千七百八十九"
```

**ConvertType** Complex

```php
SooraJP\KNNC::num2kan(123456789, SooraJP\KNNC\ConvertType::COMPLEX);
// "壱億弐参四五万六七八九"
```

**ConvertType** Complex Strict

```php
SooraJP\KNNC::num2kan(123456789, SooraJP\KNNC\ConvertType::COMPLEX | SooraJP\KNNC\ConvertType::STRICT);
"壱億弐千参百四拾五萬六千七百八拾九"
```

## Reference example

**kan2num()**  
・「九千弐拾参」->「9023」  
・「123百万」->「123000000」  
・「1億1万」->「100010000」  
・「1万1億」->「false」  
・「1万1234」->「12345」  
・「1万12345」->「false」  

## Specification like a bug

**kan2num()**  
・「二十万12345」->「212345」

## To be changed in the future
・kan2num: If there is a character such as a "円" at the end, ignore it without returning false.  
・num2kan: Make it possible to omit "一" of "一千".


## LICENSE

```txt
BSD 2-Clause License

Copyright (c) 2019, Soora JP
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this
   list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice,
   this list of conditions and the following disclaimer in the documentation
   and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
```
