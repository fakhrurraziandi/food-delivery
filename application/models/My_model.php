<?php

use yidas\Model;

class My_model extends Model{

    protected $primaryKey = 'id';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
}