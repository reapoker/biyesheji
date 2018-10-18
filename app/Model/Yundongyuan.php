<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Yundongyuan extends Model
{
    //需要让该模型指定对应的表
    public $table = 'bs_yundongyuan';

    public function __construct(array $attributes = [])
    {
        self::unguard();
        parent::__construct($attributes);
    }
}
