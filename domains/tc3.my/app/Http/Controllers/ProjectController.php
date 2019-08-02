 <?php namespace App\Http\Controllers;  
 
use Carbon\Carbon;
use TC\Reps\ProjectRepositoryInterface;


class ProjectController extends BaseController {

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
   protected $prj;

   function __construct(ProjectRepositoryInterface $prj) {
      $this->prj = $prj;
   }

   public function myProjectTimelines($value='')
   {
   	$data = array();
      //date of month before
      $data['bday'] = Carbon::create(null, null, null, 00, 00, 00, 'MSK')->subMonth()->timestamp;    
      //date of month +3m
      $data['eday'] = Carbon::create(null, null, null, 23, 59, 59, 'MSK')->addMonths(3)->timestamp;
      
      $pr = $this->prj->get();
      $data['PROJECTS'] = $this->rebuidArrayForChart($pr);
     return View::make('project_timelines', $data);
   }

   public function rebuidArrayForChart($result) {
      $out = array();
      foreach ($result as $key => $value) {
         if($value->item_type == 'P') {
            $out[$value->id] = array('P' => $value, 'M'=> array(), 'TS' => array());
         }
         else {
            $out[$value->main_project]['M'][$value->id] = $value;
            $out[$value->main_project]['TS'][] = array("label" => $value->name, 
                                                       "times" => array(array("starting_time" => $value->start_date_unix, 
                                                                              "ending_time" =>   $value->due_date_unix)));
         }
      }
      //var_dump($out);
      return $out;

              $ar = array();
        $ar[] = array("label" => "C123", "times" => array(array("starting_time" => 1355752800000, "ending_time" => 1355759900000), array("starting_time" => 1355767900000, "ending_time" => 1355774400000)));
        $ar[] = array("label" => "C321", "times" => array(array("starting_time" => 1355759910000, "ending_time" => 1355759910000), array("starting_time" => 1355767900000, "ending_time" => 1355774400000)));
        $ar[] = array("label" => "C456", "times" => array(array("starting_time" => 1355761910000, "ending_time" => 1355763910000), array("starting_time" => 1355767900000, "ending_time" => 1355774400000)));
        return Response::json($ar);
   }



}