<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 09/02/2024
 * Time: 23:20
 */

namespace App\Controllers;


class Category extends BaseController
{
    public function index()
    {
        return view('list/category_list');
    }
} 