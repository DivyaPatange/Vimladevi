<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class DepartmentLibrary extends Model
{
    protected $table = "department_libraries";

    protected $fillable = ['department_id', 'category' ,'book_no', 'allocation_date'];

    public function book_name(){
        return $this->belongsTo('App\Admin\StudentBook','book_no', 'book_no');
    }
    public function pustak_pedhi(){
        return $this->belongsTo('App\Admin\LibraryBook','book_no', 'book_no');
    }
}
