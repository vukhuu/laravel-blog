<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Tag extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tags';
}
