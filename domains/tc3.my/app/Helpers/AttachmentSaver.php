<?php namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Log;

class AttachmentSaver {
    //TODO: refactor this

    protected static $fs = '//fs/p';  //P:
    protected static $disk = 'P:';  //P:
    protected static $base_dir = '/BANKS.LOG'; 

    function __construct(CustomerRepositoryInterface $cust_rep) 
    {
            
    }
    
    public static function SaveOnP($id) {
        //TODO: crmblob.exe load/save/saveall/open/checkin/checkout/updatelast/viewhistory/createtempl/vers_history/loadlink/openlink/shell;<server>;<user>;<pass>;<owner>;<crm_att_record_id>;<file_path>;<locaked_folder>;<amnd_officer>;<template_path>
        $crmblob_path = "u:\\CRM\\Production\\03_42\\Home\\client\\crm\\CRMBlob.exe";
        $args = "saveall;work2;agorokhov;pass;crm;4958788"; //this doesn't work for some reason

        $full_path = self::compilePath($id, 'partial');

        try
        {
            //TODO: how to call non static methods from static method (what else except $this?)
            self::createPath(self::$fs.$full_path);

            $attachments = DB::select("select id, document from crm.crm_file where crm_att__oid in 
                                    (select id from crm.crm_att where source__oid = $id)");

            if($attachments) {
                foreach ($attachments as $att) {
                    self::saveAtt($att->id, self::$fs.$full_path, $att->document);
                }
            }

        }
        catch(Exception $ex)
        {
            return 'Shit happens: '.$ex->getMessage();
        }
       return $full_path;
        
    }

    public static function saveAtt($att_id, $path, $name)
    {

        Log::info('Writing file: '.$name.' to path: '.$path);
        $file_path = iconv("utf-8", "cp1251", $path.'/'.$name);


        if(file_exists($file_path)) {
            File::delete($file_path);
        }
        //readAtt
        $u = Config::get('database.connections.oracle.username');
        $p = Config::get('database.connections.oracle.password');
        $s = Config::get('crm.crm_conn_str');

        $conn = oci_connect($u, $p, $s);
        $sql='select file_data from crm.crm_file where id = '.$att_id;
        $stmt = oci_parse($conn, $sql);
        $myLOB = oci_new_descriptor($conn, OCI_D_LOB);

        oci_execute($stmt, OCI_DEFAULT) or die ("Unable to execute query\n");
        while ( $row = oci_fetch_assoc($stmt) ) {
            $data = $row['FILE_DATA']->load();
            File::append( $file_path, $data );
        }
    }

    public static function createPath($path) {
        Log::info("Creating path: ". $path);
        $path = iconv("utf-8", "cp1251", $path);
        if(!File::isDirectory($path)) {
            if( !File::makeDirectory($path, 0777, true) )
            {
                //TODO: redo with exception type, not just message
                throw new Exception("Unable to create directory", 1);
                return;
            }

        }

    }

    public static function listAttachmentsByIssueId($id) {
       $sql = "select cf.id as id, cf.document as document, ca.source_role as direction from crm.crm_file cf, crm.crm_att ca 
               where cf.crm_att__oid = ca.id and ca. source__oid = $id";
       $attachments = DB::select($sql);
       return $attachments;
    }

    public static function compilePath($id, $type='full') {
        $idt_data = DB::select("select                                                 id, 
                                       issue_idt as                                    idt, 
       (select issue_idt from crm.crm_issue where id = i.original_issue) as            orig_idt, 
       (select replace(replace(name, ' ', '_'), ':', '-') from crm.crm_issue where id = i.original_issue) as iss_name, 
       (select replace(name, ' ', '_') from crm.crm_cust where id = i.crm_cust__id) as cust_name, 
       to_char(input_date, 'YYYYMMDD_HH24MISS') as                                 input_date    
       from crm.crm_issue i where i.id = '$id' and amnd_state ='A'");


        if($type == 'full') {
            $full_path = self::$fs.self::$base_dir;
        }
        else {
            $full_path = self::$base_dir;
        }
        $iss_name = self::stripchars($idt_data[0]->iss_name, "-");
        $iss_name = self::stripchars($iss_name, '"');
        $iss_name = str_replace('__', '_', $iss_name);
        $iss_name = str_replace('[', '', $iss_name);
        $iss_name = str_replace(']', '', $iss_name);

//        $iss_name = 'tmp';
        $cust_name = $idt_data[0]->cust_name;

        $full_path .= '/'.$cust_name.'/'.$idt_data[0]->orig_idt.'_'.$iss_name.'/'.$idt_data[0]->input_date;
        return $full_path;
    }

    public static function stripchars($s, $chars) {
        return str_replace(str_split($chars), "", $s);
    }
 
}