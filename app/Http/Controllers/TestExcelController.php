<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;

class TestExcelController extends Controller
{
    //


    public function index()
    {


        $excel = App::make('excel');

        $excel->load('file.xlsx', function($reader) {

            $results = $reader->get();

          //  var_dump($results);

            echo "<hr/>";
            //var_dump($reader->first());
            //$reader->row->firstname;

            echo "<hr/>";

          //  $results = $reader->takerows(1);

            //var_dump($results);

             $excelArray = $reader->toArray();

            // var_dump($excelArray);

            $excelSheetOne = $excelArray[0];

            foreach($excelSheetOne as $row)
            {
                echo "Name: $row[name]<br/>";
            }

        });
    }
}
