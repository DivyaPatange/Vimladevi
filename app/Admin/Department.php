<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "departments";
    protected $fillable = ['department'];

    public function student_bt(){
        return $this->hasMany('App\Admin\StudentBT','department');
    }

    public function faculty_bt(){
        return $this->hasMany('App\Admin\FacultyBT','department', 'id');
    }
}
