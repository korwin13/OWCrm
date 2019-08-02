<?php namespace TC\Reps;
/**
* 
*/

use \PDO;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class IssueRepository 
{
    
    // protected $sql;
    // protected $order_by;

    function __construct() {


    }

    public function UpdateIssue($data)
    {
        //updating to result_status = 19 required for several "Complete" actions
        //YCRM_ISSUE(s.id, 'D', s.id);
        ////////////////////////////////////////////
        //  GENERIC CHECKS AND VALIDATION
        ////////////////////////////////////////////
        //mask single quotes    
        $t = $data['result_details'];
        Log::info("Received text: ".$t ); 
        
        $result_details = $data['result_details'];
        $test_impact = $data['test_impact'];
        //$result_details = str_replace("'", "''", $result_details);
        //$test_impact = str_replace("'", "''", $data['test_impact']);
        // r-like newsimbol added in IssueRepository for CRM-compatibility (\r used in edit multiline window)
        //removed befor show in edit window in routes.php 
        //0x0d 0x0a CRLF     -win
        //0x0a LF \n         -nix 
        //0x0d CR \r        
        $result_details = str_replace("\n", "\r\n", $result_details);

        $parms = array();
        $new_time = $data['new_time'];
        $id = $data['id'];

        //check if issues is mine
        $officer = Config::get('crm.crm_officer_id');        
        $queue = Config::get('crm.crm_queue_id');        

        $stmt = "update crm.crm_issue set ";
        if($result_details) { $stmt.= "result_details = ?, "; array_push($parms, $result_details); } 
        if($test_impact)    { $stmt.= "test_impact = ?, ";    array_push($parms, $test_impact); } 
        $stmt .= "new_used_time = $new_time,
                 help_desk_user = issue_user,
                 help_desk_officer = $officer,
                 help_desk_queue = $queue
                 where id = $id";
        Log::info("Updating issue: ".$stmt );                    

        DB::beginTransaction();
        try 
        {
            DB::statement($stmt, $parms);
        }
        catch ( Exception $e )
        {
            DB::rollback(); 
            //dd($e);
            return $e->getMessage();
        }     
        DB::commit();
        return "OK";
    
    }

    public function CheckIssue($id)
    {
        $r = 'ERR_NOTHING';
     
        DB::beginTransaction();     
        //workaround to get PLSQL code results into $r
        $conn = DB::connection()->getPdo();
        $stmt = $conn->prepare("begin :r := crm.crm_i.CHECK_ISSUE($id); end;");
        $stmt->bindParam(':r', $r, PDO::PARAM_STR , 4000); 
        Log::info("Executed CHECK_ISSUE with id=$id and result=|$r|");
        $stmt->execute();

        DB::commit();

        return $r;        
    }

    public function CloseIssueByAdvice(  )
    {
        //emulate ISSUE_RECLASSIFY partially
        //update issue set new 
        //do misc actions?
    }

    public function ReclassifyIssueToRequest($id)
    {
        //emulate ISSUE_RECLASSIFY partially
        //update issue set new 
        //do misc actions?
        $r = 'ERR_NOTHING';
     
        DB::beginTransaction();     

        //select id from crm.crm_iss_type where amnd_state = 'A' and code = 'INF_R';


        //update local_constants set
        //  issue = $new_issue_type_id,
        //  project = $new_sev_level_id
        //where id = stnd.ConnectionID  



        //workaround to get PLSQL code results into $r
        $conn = DB::connection()->getPdo();
        $stmt = $conn->prepare("begin :r := crm.crm_c.ISSUE_RECLASSIFY($id); end;");
        $stmt->bindParam(':r', $r, PDO::PARAM_STR , 4000); 
        $stmt->execute();

        DB::commit();

        return $r;
    }

    public function ReclassifyIssueToAdvice(  )
    {
        //select id from crm.crm_iss_type where amnd_state = 'A' and code = 'INFOADVICE';

        //emulate ISSUE_RECLASSIFY partially
        //update issue set new 
        //do misc actions?
    }

    public function RejectIssue(  )
    {
        // crm.crm_c.ISSUE_REJECT($id);
    
    }

    public function completeIssuePDO($id)
    {
        $r = 'ERR_NOTHING';
     
        DB::beginTransaction();     
        //workaround to get PLSQL code results into $r
        $conn = DB::connection()->getPdo();
        $stmt = $conn->prepare("begin :r := crm.crm_c.ISSUE_COMPLETE($id); end;");
        $stmt->bindParam(':r', $r, PDO::PARAM_STR , 4000); 
        $stmt->execute();

        DB::commit();

        return $r;
    }

    public function CreateNext($for_id)
    {
        
    }
    public function test()
    {

        //dd(PDO::PARAM_INPUT_OUTPUT);
        $iss_id = 4771266;

        $id = $iss_id;
        $r = 'ERR_NOTHING';
     
        DB::beginTransaction();     
        //workaround to get PLSQL code results into $r
        $conn = DB::connection()->getPdo();
        $stmt = $conn->prepare("begin :r := crm.crm_i.CHECK_ISSUE($id); end;");
        $stmt->bindParam(':r', $r, PDO::PARAM_STR , 4000); 
        Log::info("Executed CHECK_ISSUE with id=$id and result=|$r|");
        $stmt->execute();

        DB::commit();
        dd($r);    
    }
}
