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

namespace MacFJA\RedisSearch;

use function is_scalar;
use MacFJA\RedisSearch\Helper\DataHelper;
use MacFJA\RedisSearch\Helper\RedisHelper;
use Predis\Client;

class Configuration
{
    /** @var Client */
    private $redis;

    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }

    public function getOption(string $optionName): string
    {
        return $this->redis->executeRaw(['FT.CONFIG', 'GET', $optionName]);
    }

    /**
     * @return array<float|int|string>
     */
    public function getAll(): array
    {
        $rawResult = $this->redis->executeRaw(['FT.CONFIG', 'GET', '*']);

        return RedisHelper::getPairs($rawResult);
    }

    /**
     * @param float|int|string $value
     * @psalm-suppress RedundantConditionGivenDocblockType
     */
    public function setOption(string $optionName, $value): bool
    {
        DataHelper::assert(is_scalar($value));
        $rawResult = $this->redis->executeRaw(['FT.CONFIG', 'GET', $optionName, $value]);

        return 'OK' === $rawResult;
    }
}
