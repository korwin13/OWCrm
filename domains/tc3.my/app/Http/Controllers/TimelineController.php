 <?php
use Carbon\Carbon;

class TimelineController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::get('/', 'HomeController@showWelcome');
    |
    */

    function __construct() {
 
    }
 
    

    public function timeline($date = '')
    {
        # code...


        var_dump(Carbon::create(null, null, null, 00, 00, 00, 'MSK'));    
        var_dump(Carbon::create(null, null, null, 23, 59, 59, 'MSK')->timestamp);    
        
        $data['bday'] = Carbon::create(2014, 02, 1, 00, 00, 00, 'MSK')->subMonth()->timestamp;    
        $data['eday'] = Carbon::create(2014, 02, 1, 23, 59, 59, 'MSK')->addMonths(3)->timestamp;

        return View::make('timeline', $data);
    }

    public function timeseries($value='')
    {
        # code...
        //date of month before
        $data['bday'] = Carbon::create(null, null, null, 00, 00, 00, 'MSK')->subMonth()->timestamp;    
        //date of month +3m
        $data['eday'] = Carbon::create(null, null, null, 23, 59, 59, 'MSK')->addMonths(3)->timestamp;

        //date of curr day 00:00 
        $data['bday'] = Carbon::create(2014, 02, 1, 00, 00, 00, 'MSK')->timestamp;    
        //date of curr day 23:59
        $data['eday'] = Carbon::create(2014, 02, 1, 23, 59, 59, 'MSK')->timestamp;

        //timestamp from normal time Carbon::now()->timestamp

 

        $ar = array();
        $ar[] = array("label" => "C123", "times" => array(array("starting_time" => 1355752800000, "ending_time" => 1355759900000), array("starting_time" => 1355767900000, "ending_time" => 1355774400000)));
        $ar[] = array("label" => "C321", "times" => array(array("starting_time" => 1355759910000, "ending_time" => 1355759910000), array("starting_time" => 1355767900000, "ending_time" => 1355774400000)));
        $ar[] = array("label" => "C456", "times" => array(array("starting_time" => 1355761910000, "ending_time" => 1355763910000), array("starting_time" => 1355767900000, "ending_time" => 1355774400000)));
        return Response::json($ar);
    }

}