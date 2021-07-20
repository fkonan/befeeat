<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;

class Login extends Model
{
   public $usuario, $password;
   protected static $_table = 'tmp_fake';
}
