<?php namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Log;

class AttachmentLoader {
    //TODO: refactor this

    protected static $fs = '//fs/p';  //P:
    protected static $disk = 'P:';  //P:
    protected static $base_dir = '/BANKS.LOG'; 

    function __construct(CustomerRepositoryInterface $cust_rep) 
    {
            
    }
    
    public static function loadAtt($iss_id, $att_path) 
    {
        $u = Config::get('database.connections.oracle.username');
        $p = Config::get('database.connections.oracle.password');
        $s = Config::get('crm.crm_conn_str');
        $crmblob = Config::get('crm.blob_path');

        //insert into crm.crm_att 
        //(amnd_date, amnd_officer, amnd_state, input_date, source__oid, source_code)
        //values(sysdate, 8616, 'A', sysdate, 4821384, 'I');

        //select id.currval into :loc_variable from dual

        $crm_creds = "$s;$u;$p;crm.";
        $att_id = 4448534;
        $file_path = 'c:\tmp\2\emvperso_scona_vis.ini';
        $command = $crmblob.' '.implode(';', ['load',$crm_creds, $att_id, $file_path]);
        //dd($command);
        exec($command, $out);
    }
 
}