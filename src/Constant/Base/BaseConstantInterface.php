<?php

namespace App\Constant\Base;

/**
 * Interface BaseConstantInterface
 *
 * @package App\Constant\Base
 */
interface BaseConstantInterface
{
    /**
     * @param null $key
     * @return mixed
     */
    public static function getValues($key = null);

    /**
     * @param $constant
     * @return mixed
     */
    public static function getConstantValue($constant);
}
