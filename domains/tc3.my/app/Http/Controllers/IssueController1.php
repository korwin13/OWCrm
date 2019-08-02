 <?php
use Carbon\Carbon;
use TC\Reps\ProjectRepositoryInterface;
use helpers\AttachmentSaver;

class IssueController extends BaseController {

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

   function __construct()
   {
      parent::__construct();  
   }

   public function saveAttachments($idt)
   {
      $path = AttachmentSaver::SaveOnP($idt);
      return "<p>$path</p>";   
   }

   public function listAtachments($id) {
      $att = AttachmentSaver::listAttachmentsByIssueId($id);
      $p_path = AttachmentSaver::compilePath($id);
      
      $data['attachments'] = $att;
      $data['id'] = $id;
      $data['p_path'] = $p_path;
      return View::make('partials.save_dialog', $data);
   }

   public function testIssueCompletionUpdate($id='')
   {
        //update issue text
        $result_details = Input::get("text");
        $new_time = Input::get("new_time");
        Log::info("Received ID: $id and text: $result_details");

        //updating to result_staus = 19 required for several "Complete" actions
        //YCRM_ISSUE(s.id, 'D', s.id);
        ////////////////////////////////////////////
        //  GENERIC CHECKS AND VALIDATION
        ////////////////////////////////////////////
        //mask single quotes    
        $result_details = str_replace("'", "''", $result_details);

        //check if issues is mine

        $officer = Config::get('crm.crm_officer_id');        
        $queue = Config::get('crm.crm_queue_id');        

        $stmt = "update crm.crm_issue set 
                 result_details = '$result_details', 
                 new_used_time = $new_time,
                 help_desk_user = issue_user,
                 help_desk_officer = $officer,
                 help_desk_queue = $queue
                 where id = $id";
        Log::info("Updating issue: ".$stmt );                    

        DB::beginTransaction();
        try 
        {
            DB::statement($stmt);
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

    public function testIssueCompletionComplete($id='')
    {
        //complete issue
        $r = $this->completeIssuePDO($id);
        //if ok
        //read notfication text
        $sql = "select mail_text from crm.crm_notif where crm_issue__oid = $id and amnd_state = 'A' and status is null";
        $results = DB::select($sql);

        Log::info("Complete result: $r");
        Log::info("SQL used: $sql");

        $data['id'] = $id;
        if (count($results) > 0) {
            $data['mail_text'] = nl2br(htmlspecialchars($results[0]->mail_text));
            return View::make('partials.notify_dialog', $data);
        }
        else
        {
            $data['err_text'] = $r;
            return View::make('partials.error_dialog', $data);
        }
    }

    public function testIssueCompletionNotify($id='')
    {
        //send notification
        //dd('error');    
        $stmt = "update crm.crm_notif set status = 'W' where crm_issue__oid = $id and amnd_state = 'A' and status is null";
        Log::info("Updating notification: ".$stmt );                    

        //updating to result_staus = 19 required for several "Complete" actions
        //YCRM_ISSUE(s.id, 'D', s.id);

        DB::beginTransaction();     
        try 
        {
            DB::statement($stmt);
        }
        catch ( Exception $e )
        {
            DB::rollback(); 
            //dd($e);
            return $e->getMessage();
        }     
        DB::commit();

        //close issue finally
        $r = $this->completeIssuePDO($id);

        return 'OK';    
        //re-retrieve issue, prepare issue partial an send  back for replace
        //idea is to update issue - probably make it bacground flash and 
        //change it color to normal gradually
    }

    public function completeIssuePDO($id)
    {
        $r = 'ERR_NOTHING';
     
        DB::beginTransaction();     
        //workaround to get PLSQL code results into $r
        $conn = DB::connection()->getPdo();
        $stmt = $conn->prepare("begin :r := crm.crm_c.ISSUE_COMPLETE($id); end;");
        $stmt->bindParam(':r', $r, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT , 4000); 
        $stmt->execute();

        DB::commit();

        return $r;
    }

   //issue complete here 

}