<?php

namespace App\Http\Controllers;


use Response;
use App\Palabra;
use Illuminate\Http\Request;
use Redirect;

use App\Http\Controllers\Validator;


class ApalabradoController  extends Controller
{



    public function __construct()
    {
    }

    public function buscador(Request $request){


        if ($request->method()=='GET') {
          return view('welcome');
        }
        $validator = \Validator::make($request->all(), [
            'letras' => 'required|alpha|size:12|string',
            'cantidad' => 'required|integer|min:3|max:7',
        ]);

        if ($validator->fails()) {
           return Redirect::back()->withErrors($validator)->withInput();
        }

        ini_set('max_execution_time', 1200); //300 seconds = 5 minutes

        $data['letras'] = $request->input('letras');
        $data['cantidad']= $request->input('cantidad');
        for($i = 0; $i < $this->getPermCount($data['letras'],$data['cantidad']); $i++){
          $words[$i] = $this->getPerm($data['letras'],$data['cantidad'], $i);
        }

        $final = array();
        $k=0;
        $count=0;
        foreach (array_chunk($words,50000) as $t)  
        {
            $palabras[$k]=  Palabra::select('palabra')->whereIn('sin_acentos',$t)->distinct()->get();
            
            foreach ($palabras[$k] as $key => $palabra) {
            $count=$key+$count;
                $response[$count]=$palabra->palabra;
            }
            $k++;
            unset($palabras[$k]);
        }

  
           //$palabras=  Palabra::select('palabra')->whereIn('sin_acentos',$words)->distinct()->get();
        
          return view('welcome', compact('response','data'));

    }


          // Returns the total number of $count-length strings generatable from $letters.
      private function getPermCount($letters, $count)
      {
        $result = 1;
        // k characters from a set of n has n!/(n-k)! possible combinations
        for($i = strlen($letters) - $count + 1; $i <= strlen($letters); $i++) {
          $result *= $i;
        }
        return $result;
      }

      // Decodes $index to a $count-length string from $letters, no repeat chars.
      private function getPerm($letters, $count, $index)
      {
        $result = '';
        for($i = 0; $i < $count; $i++)
        {
          $pos = $index % strlen($letters);
          $result .= $letters[$pos];
          $index = ($index-$pos)/strlen($letters);
          $letters = substr($letters, 0, $pos) . substr($letters, $pos+1);
        }
        return $result;
      }
          
}
