<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class FacultyBT extends Model
{
    protected $table = "faculty_b_t_s";

    protected $fillable = ['name', 'department', 'BT_no', 'designation'];
    public function faculty_session(){
        return $this->belongsTo('App\Admin\AcademicYear','session', 'id');
    }

    public function faculty_department(){
        return $this->belongsTo('App\Admin\Department','department', 'id');
    }
}
