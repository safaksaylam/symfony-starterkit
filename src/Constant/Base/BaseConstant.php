<?php

namespace App\Constant\Base;

/**
 * Class BaseConstant
 *
 * @package App\Constant\Base
 */
abstract class BaseConstant implements BaseConstantInterface
{
    final protected static function get(array $values = [], $key)
    {
        if (null === $key) {
            return $values;
        }

        if (array_key_exists($key, $values)) {
            return $values[$key];
        }

        return null;
    }
}
