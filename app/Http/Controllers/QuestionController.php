<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;

class QuestionController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
  public function index()
  {
    return view('questions', [
        'questions' => Questions::orderBy('created_at', 'asc')->get()
    ]);
  }

  public function show($id)
  {
  }

}
