<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search()
    {
        return view('auth.search');
    }

    public function fetch(Request $request)
    {
        if($request->value)
        {
            $output = '<option value="">-Search By-</option>'. 
            '<option value="book_no">Book No</option>'. 
            '<option value="book_name">Book Name</option>'. 
            '<option value="author_name">Author Name</option>'. 
            '<option value="publication">Publication</option>';

            return $output;
        }
    }
}
