<?php

declare(strict_types=1);

/*
 * Copyright MacFJA
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace MacFJA\RedisSearch\Search;

use MacFJA\RedisSearch\Helper\DataHelper;
use MacFJA\RedisSearch\PartialQuery;
use RangeException;

class Filter implements PartialQuery
{
    /** @var string */
    private $fieldName;

    /** @var float */
    private $min;

    /** @var float */
    private $max;

    public function __construct(string $fieldName, float $min, float $max)
    {
        DataHelper::assert($min < $max, new RangeException('Maximum can\'t be inferior to minimum'));
        $this->fieldName = $fieldName;
        $this->min = $min;
        $this->max = $max;
    }

    public function getQueryParts(): array
    {
        return ['FILTER', $this->fieldName, $this->min, $this->max];
    }
}
