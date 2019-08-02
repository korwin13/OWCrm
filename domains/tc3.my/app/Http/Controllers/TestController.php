<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function testTns($idt='')
    {
        $username = "agorokhov";
        $password = "";
        $db = "crm.spb.openwaygroup.com:1521/cust2.openwaygroup.spb.ru";

   // Oracle 10g принимает следующую форму: [//]host_name[:port][/service_name]. 
       // Для Oracle 11g синтаксис таков:       [//]host_name[:port][/service_name][:server_type][/instance_name]. 


        $conn = oci_connect($username, $password, $db);
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        else {
            return "TNS OK!";
        }       
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


    public function testPage()
    {
        dd("die'n'dump!");

        // return View::make('test/testpage', $data);    
    }

    public function testDialog()
    {
        return View::make('partials/notify_dialog');    
    }

    public function testAtt()
    {
                //readAtt
        //$u = Config::get('database.connections.oracle.username');
        //$p = Config::get('database.connections.oracle.password');
        //$s = Config::get('crm.crm_conn_str');
        //$crmblob = Config::get('crm.blob_path');

        $stmt = 'insert into crm.crm_att (amnd_date, amnd_officer, amnd_state, input_date, source__oid, source_code) ';
        $stmt .= "values(sysdate, 8616, 'A', sysdate, 4821384, 'I')";

        //dd(date('d.m.Y H:i:s'));
        /*
        DB::beginTransaction();     
        
        //DB::statement($stmt);

        $id = DB::connection('oracle')->table('crm.crm_att')->insertGetId(
            array('amnd_date' => date('d-M-Y H:i:s'), 
                  'amnd_officer' => 8616,
                  'amnd_state'=> 'A',
                  'input_date'=> date('d-M-Y H:i:s'), 
                  'source__oid' => 4821384,
                  'source_code' => 'I' ), 'id'
        );


        DB::commit();
        */
        $currval_sql = "select id.currval from dual";
        $results = DB::select($currval_sql);
        //$crmblob = 'c:\CRM\client\crm\CRMBlob.exe';
        //insert into crm.crm_att 
        //(amnd_date, amnd_officer, amnd_state, input_date, source__oid, source_code)
        //values(sysdate, 8616, 'A', sysdate, 4821384, 'I');
        
        dd($results);

        $crm_creds = 'crmha1:1521/cust2.openwaygroup.spb.ru;agorokhov;destroer13;crm.';
        $att_id = 4448534;
        $file_path = 'c:\tmp\2\emvperso_scona_vis.ini';
        $command = $crmblob.' '.implode(';', ['load',$crm_creds, $att_id, $file_path]);
        //dd($command);
        //exec($command, $out);

        return View::make('att', ['output' => '"'.$out.'"']);    
    }

}
