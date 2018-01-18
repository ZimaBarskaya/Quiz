<?php


namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;



class AjaxController extends Controller {
  public function __construct()
  {
  }
   public function index(){
      $msg = "This is a simple message.";
      return response()->json(array('msg'=> $msg), 200);
   }
}
