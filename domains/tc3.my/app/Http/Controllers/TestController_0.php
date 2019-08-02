 <?php //namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use TC\Reps\CustomerRepositoryInterface;

class TestController extends App\Http\Controllers\Controller {

       //protected $layout = 'layout';
    protected $cust_rep;


    function __construct(CustomerRepositoryInterface $cust_rep) 
    {

        $this->cust_rep = $cust_rep;
        parent::__construct();
    }
 

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

 
    
    public function testTns($idt='')
    {
        $username = "asd";
        $password = "asd";
        $db = "crm.spb.openwaygroup.com:1521/cust2.openwaygroup.spb.ru";
        $conn = oci_connect($username, $password, $db);
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
    }

    public function completeIssueOCI()
    {
        
        DB::beginTransaction();
        DB::update('update crm.crm_issue set  HELP_DESK_OFFICER = 14287, HELP_DESK_QUEUE = 420 where id = 4117305');
        DB::commit();

        $conn = oci_connect($username, $password, $host.'/'.$db);
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }


        $me = Config::get('crm.crm_user_id');



        $stid0 = oci_parse($conn, 'update crm.crm_issue set  HELP_DESK_OFFICER = 14287, HELP_DESK_QUEUE = 420 where id = 4117305');
        oci_execute($stid0);
        oci_free_statement($stid0);

        $p = 4117305;
        $r='';

        $stid = oci_parse($conn, 'begin :r := crm.crm_c.ISSUE_COMPLETE(:p); end;');
        oci_bind_by_name($stid, ':p', $p);
        oci_bind_by_name($stid, ':r', $r, 1000);

        oci_execute($stid);
        oci_free_statement($stid);

        $r1 = oci_commit($conn);
        if (!$r1) {
            $e = oci_error($conn);
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
        }
        oci_close($conn);






        dd($r);
    }  


    public function testIssueCompletion()
    {
        $data = [];
        return View::make('test.testpage', $data);
    }

  

    public function sortout()
    {
        return View::make('sourtout_foundation_test', $data);
    }    


}