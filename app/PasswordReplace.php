<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReplace extends Model {

  public $timestamps = false;
  public $table = 'password_replaces';
  public $fillable = ['remember_token','password'];

}
