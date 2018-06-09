<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ValidateApiKeyController extends Controller
{
    //

    public  function __construct() {

        $this->middleware('validateApiKey');
    }


    public function index(Request $request) {

       // echo $request->validationDone ;

      echo   booleanValue($request->validationDone);
        echo "<br/>Test Controller.";
    }
}
