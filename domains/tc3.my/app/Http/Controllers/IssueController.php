<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use TC\Reps\ProjectRepositoryInterface;
use App\Helpers\AttachmentSaver;
use TC\Reps\IssueRepository;
use Input;
use Log;
use DB;
use View;
use Config;

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

   protected $irep;

   function __construct(IssueRepository $ir)
   {
        $this->irep = $ir;
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
      $data['id'] = $id;
      $data['result_details'] = Input::get("text");
      Log::info(Input::get("text"));
      /*if( Input::has("text") ) { 
         $data['result_details'] = Input::get("text");
         Log::info("Received ID: $id and text: " . $data['result_details'] );
      }
      else {
         Log::info("Received ID: $id, no text provided" );
      }
      */
      $data['test_impact'] =    Input::get("comment");
      $data['new_time'] =       Input::get("new_time");
      


      $update_res = $this->irep->UpdateIssue($data);
      $check_flag = Input::get("check_flag");
      if($check_flag) {
         $check_res = $this->irep->CheckIssue($id);
         Log::info("CheckIssue ID: $id with result: $check_res");
         return $check_res;         
      }
      else {
          //if we're completing (not just checking issue, try to attach)
          $att = Input::get("attachment");
         //attach files if any
         if($att) {
          $officer = Config::get('crm.crm_officer_id');        
          //insert crm_att
          DB::beginTransaction();     
          $att_id = DB::connection('oracle')->table('crm.crm_att')->insertGetId(
              array(//'amnd_date' => date('d-M-Y H:i:s'), 
                    'amnd_officer' => $officer,
                    'amnd_state'=> 'A',
                    //'input_date'=> date('d-M-Y H:i:s'), 
                    'source__oid' => $id, //attach to issue
                    'source_code' => 'I' ), 'id' //second parameter reflects autoincrementing column
          );
          DB::commit();
          //make command
          $crm_blob = Config::get('crm.blob_path');
          $blob_command = "load;crmha1:1521/cust2.openwaygroup.spb.ru;agorokhov;destroer13;crm."; 
          $command = "$crm_blob $blob_command;$att_id;$att";
          $cb_out = [];
          Log::info($command);
          exec($command, $cb_out);
          //dd($command);
          Log::info($cb_out);
         }
         return $update_res;
      }
   }

   public function testIssueCompletionComplete($id='')
   {
     //complete issue
     $r = $this->irep->completeIssuePDO($id);
     //if ok
     //read notfication text
     $sql = "select id, mail_text from crm.crm_notif where crm_issue__oid = $id and amnd_state = 'A' and status is null";
     $results = DB::select($sql);

     Log::info("Complete result: $r");
     Log::info("SQL used: $sql");

     $data['id'] = $id;
     if (count($results) > 0) {
          
         $data['mail_text'] = nl2br(htmlspecialchars($results[0]->mail_text));
         $data['notif_id'] = $results[0]->id;
         return View::make('partials.notify_dialog', $data);
     }
     else
     {
         Log::info("Error complete result: $r");
         $data['err_text'] = $r;
         return View::make('partials.error_dialog', $data);
     }
   }

   public function testIssueCompletionNotify($id='')
   {
     //send notification
     //dd('error');    
     $stmt = "update crm.crm_notif set status = 'W' where id = $id and amnd_state = 'A' and status is null";
     Log::info("Updating notification: ".$id );                    

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
     $sql = "select min(crm_issue__oid) crm_issue__oid from crm.crm_notif where id = $id";
     $results = DB::select($sql);
     if (count($results) > 0) {
         Log::info("Closing issue: ".$results[0]->crm_issue__oid );
         $r = $this->irep->completeIssuePDO($results[0]->crm_issue__oid);
         return $r;
     }


     //return 'OK';    
     //re-retrieve issue, prepare issue partial an send  back for replace
     //idea is to update issue - probably make it bacground flash and 
     //change it color to normal gradually
   }

   public function testIssueCompletionCancel($id='')
   {
      $stmt = "update crm.crm_notif set amnd_state = 'C', amnd_date = sysdate where id = $id and amnd_state = 'A' and status is null";
     DB::beginTransaction();     
     try 
     {
         DB::statement($stmt);
         Log::info("Deleted notification: ".$id );   
     }
     catch ( Exception $e )
     {
         DB::rollback(); 
         //dd($e);
         Log::info("Shit happened: ".$e->getMessage() );   
         return $e->getMessage();
     }     
     DB::commit();
   }

   public function testPage () 
   {
      $this->irep->test();
   }


   //issue complete here 

}