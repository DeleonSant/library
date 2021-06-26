<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store()
    {
        return Author::create($this->validateRequest());
    }

    public function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'dob' => 'required'
        ]);
    }
}
