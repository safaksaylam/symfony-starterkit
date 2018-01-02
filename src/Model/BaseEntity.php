<?php

namespace App\Model;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class BaseEntity
 *
 * @package \App\Model
 * @Gedmo\SoftDeleteable()
 */
class BaseEntity
{
    use TimestampableEntity, SoftDeleteableEntity;
}