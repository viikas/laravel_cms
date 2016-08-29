<?php

namespace App\Controllers\Site;

use App\Models\Destination;
use App\Models\Suburbs;
use App\Models\DistanceCal;
use App\Models\DistanceSuburb;
use Image,
    Input,
    Notification,
    Redirect,
    Str,
    \Illuminate\Http\Request;

class SuburbController extends \Controller {

    public function index() {

        return \View::make('site::suburb');
    }

    public function find() {
        $from = Input::get('from');
        $to = Input::get('to');
        $a = Suburbs::all();
        
        foreach ($a as $mm) {
            if ($mm->dom == 0) {
                $from = $mm->suburb . ', Sydney, Australia';
                $x = $this->getLatLong($from, 'Sydney Domestic Airport, Sydney, Australia');

                $pos = strrpos($x, ' mi');
                $intl = substr($x, 0, $pos);
                $mm->dom = $intl;
                $mm->save();
                //dd($x);
                //dd($intl);
                sleep(1);
            }
        }
        //$this->import2();
        //$this->Export();
    }

    private function getLatLong($from, $to) {

        //$from = str_replace(' ', '+', $from);
        //$to = str_replace(' ', '+', $to);
        // Our parameters
        $params = array(
            'origin' => $from,
            'destination' => $to,
            'sensor' => 'true',
            'units' => 'imperial'
        );

        $params_string = '';
        // Join parameters into URL string
        foreach ($params as $var => $val) {
            $params_string .= '&' . $var . '=' . urlencode($val);
        }

        // Request URL
        $url = 'http://maps.googleapis.com/maps/api/directions/json?' . ltrim($params_string, '&');
        //$url='https://maps.googleapis.com/maps/api/geocode/json?address=Gongabu+Kathmandu+Nepal&key=AIzaSyC4SKkEHSneGEwRqMMO_9F2ewugQcu73OM';

        ini_set('max_execution_time', 3000);

        // Make our API request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($curl);
        curl_close($curl);
        
        $directions = json_decode($return);
        //dd($directions);
        return $directions->routes[0]->legs[0]->distance->text;
        //dd($directions);
    }

    //used once to import suburbs and zips
    private function import() {
        $file = public_path() . '\\uploads\\files\\suburbs.1.xls';
        //ini_set('max_execution_time', 30000); 
        $excel = new \PhpExcelReader;
        $excel->read($file);
        $sheet = $excel->sheets[0];

        $x = 1;
        $arr = array();
        while ($x <= $sheet['numRows']) {
            $y = 1;
            while ($y <= $sheet['numCols']) {
                $cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] : '';
                $pos = strrpos($cell, ',');
                $postal = substr($cell, $pos + 1);
                $suburb = substr($cell, 0, $pos);
                $arr0 = array();
                $arr0[0] = $suburb;
                $arr0[1] = $postal;
                $arr[] = $arr0;
                $y++;
            }
            $x++;
        }
        foreach ($arr as $a) {
            $s = new Suburbs;
            $s->suburb = $a[0];
            $s->zip = $a[1];
            $s->save();
        }
    }

    //used once to import cbd rate calculator
    private function import2() {
        $file = public_path() . '\\uploads\\files\\limo-rate.xls';
        //ini_set('max_execution_time', 30000); 
        $excel = new \PhpExcelReader;
        $excel->read($file);
        $sheet = $excel->sheets[0];

        $x = 1;
        $arr = array();
        while ($x <= $sheet['numRows']) {
            $y = 1;
            $mile = $sheet['cells'][$x][1];
            $rate = $sheet['cells'][$x][2];
            $arr0 = array();
            $arr0[0] = $mile;
            $arr0[1] = $rate;
            $arr[] = $arr0;
            $x++;
        }
        //dd($arr);
        foreach ($arr as $a) {
            $s = new \App\Models\DistanceCal();
            $s->mile = $a[0];
            print_r($a[1]);
            //$rate=sprintf("%0.2f", $a[1]);
            $s->rate = $a[1];
            $s->save();
        }
    }

    //used to export rate sheet
    private function Export() {
        $file = 'limo-rate-sheet.xls';
        \Excel::create($file, function($excel) {

                    $excel->sheet('Rate Sheet', function($sheet) {
                                //$rules=DistanceCal::all();
                                $suburbs = DistanceSuburb::all();
                                $arr = array();
                                $i = 0;
                                /* $suburbs->each(function($s) use($i,$arr)
                                  {
                                  $ai=array();
                                  $ai[0]=$s->suburb;
                                  //$row=DistanceCal::orderBy('id')->where('mile','>=',$s->cbd);
                                  $distance=$s->cbd;
                                  //dd($distance);
                                  $row=\DB::select(\DB::raw('select rate from limo_data where mile>='.$distance.' or mile<='.$distance.' limit 1'));
                                  $rate=$row[0]->rate;
                                  $ai[1]=$s->cbd;
                                  $ai[2]=$rate;
                                  $arr[$i]=$ai;
                                  $i=$i+1;
                                  //dd($arr);
                                  });
                                 */

                                foreach ($suburbs as $s) {
                                    $ai = array();
                                    $ai[0] = $s->suburb;
                                    //$row=DistanceCal::orderBy('id')->where('mile','>=',$s->cbd);
                                    $distance = $s->cbd;
                                    //dd($distance);
                                    $row = \DB::select(\DB::raw('select rate from limo_data where mile>=' . $distance . ' limit 1'));
                                    $rate = 0;
                                    //dd($row);
                                    if ($row != null) {
                                        //dd($row);
                                        if ($i == 1) {
                                            //dd($row[0]->rate);
                                        }
                                        $rate = $row[0]->rate;
                                    } else {
                                        $rate = $this->getRate($distance);
                                    }

                                    $ai[1] = $s->cbd;
                                    $ai[2] = $rate;
                                    $ai[3] = 0.00;

                                    $distance = $s->dom;
                                    //dd($distance);
                                    $row = \DB::select(\DB::raw('select rate from limo_data where mile>=' . $distance . ' limit 1'));
                                    $rate = 0;
                                    //dd($row);
                                    if ($row != null) {
                                        //dd($row);
                                        if ($i == 1) {
                                            //dd($row[0]->rate);
                                        }
                                        $rate = $row[0]->rate;
                                    } else {
                                        $rate = $this->getRate($distance);
                                    }

                                    $ai[4] = $s->dom;
                                    $ai[5] = $rate;
                                    $ai[6] = 0.00;
                                    $ai[7] = $s->intl;
                                    $ai[8] = 0.00;
                                    $ai[9] = 0.00;
                                    $arr[$i] = $ai;
                                    $i = $i + 1;
                                    //dd($arr);
                                }

                                //dd($arr);
                                $sheet->fromArray($arr);

                                /* $sheet->fromArray(array(
                                  array('data1', 'data2'),
                                  array('data3', 'data4')
                                  )); */
                            });
                })->export('xls');
    }

    private function getRate($distance) {
        if ($distance >= 28.0 && $distance < 29.0) {
            return 4.23;
        } else if ($distance >= 29.0 && $distance < 30.5) {
            return 4.19;
        } else if ($distance >= 30.5 && $distance < 31.9) {
            return 4.15;
        } else if ($distance >= 31.9 && $distance < 32.8) {
            return 4.10;
        } else if ($distance >= 32.80 && $distance < 33.95) {
            return 4.08;
        } else if ($distance >= 33.95 && $distance < 35.00) {
            return 4.01;
        } else if ($distance >= 35.00 && $distance < 36.20) {
            return 3.99;
        } else if ($distance >= 36.20 && $distance < 37.40) {
            return 3.95;
        } else if ($distance >= 37.40 && $distance < 39.00) {
            return 3.91;
        } else if ($distance >= 39.00 && $distance < 40.90) {
            return 3.87;
        } else if ($distance >= 40.90 && $distance < 42.00) {
            return 3.83;
        } else if ($distance >= 42.00 && $distance < 43.10) {
            return 3.80;
        } else if ($distance >= 43.10 && $distance < 44.30) {
            return 3.76;
        } else if ($distance >= 44.30 && $distance < 46.10) {
            return 3.74;
        } else if ($distance >= 44.30 && $distance < 46.10) {
            return 3.74;
        } else if ($distance >= 46.10 && $distance < 47.40) {
            return 3.70;
        } else if ($distance >= 47.40 && $distance < 48.90) {
            return 3.65;
        } else if ($distance >= 48.90 && $distance < 50.00) {
            return 3.60;
        } else if ($distance >= 50.00 && $distance < 52.10) {
            return 3.55;
        } else if ($distance >= 52.10 && $distance < 54.00) {
            return 3.50;
        } else if ($distance >= 54.00 && $distance < 55.00) {
            return 3.45;
        } else if ($distance >= 55.00 && $distance < 56.20) {
            return 3.41;
        } else if ($distance >= 56.20 && $distance < 58.10) {
            return 3.36;
        } else if ($distance >= 58.10 && $distance < 59.10) {
            return 3.33;
        } else if ($distance >= 59.10 && $distance < 61.10) {
            return 3.30;
        } else if ($distance >= 61.10 && $distance < 65.10) {
            return 3.25;
        } else if ($distance >= 65.10 && $distance < 68.10) {
            return 3.21;
        } else if ($distance >= 68.10) {
            return 3.15;
        }
    }

}

