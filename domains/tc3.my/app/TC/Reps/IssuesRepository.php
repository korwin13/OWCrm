<?php namespace TC\Reps;
/**
* 
*/
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Log;

class IssuesRepository implements IssuesRepositoryInterface
{
    
    protected $sql;
    protected $order_by;

    function __construct() {
        /*$this->sql = "select ci.id, ci.issue_idt, ci.original_issue, cc.name cust_name, ci.name, 
                       (select sum(used_time) from crm.crm_issue ciall where ciall.issue_user = ci.issue_user and ciall.amnd_state = 'A' and ciall.original_issue = ci.original_issue) used_time
            from   crm.crm_issue ci, crm.crm_cust cc 
            where  cc.id = ci.crm_cust__id
            and    ci.amnd_state = 'A'";*/

        $this->sql = "select ci.id, to_char(ci.input_date, 'YYYY-MM-DD HH24:MI:SS') input_date, ci.details, ci.result_details, ci.test_impact, to_char(ci.end_date, 'YYYY-MM-DD HH24:MI:SS') end_date,
            to_char(ci.input_date, 'YYYY-MM-DD_HH24-MI-SS') iss_dir, ci.name, cc.name cust_name, ci.issue_type, 
            ci.issue_idt, ci.crm_case__oid, 
            (select u.last_nam||' '||u.first_nam from crm.crm_user u where id = ci.crm_user__id and amnd_state = 'A') user_name, 
            (select u.last_nam||' '||u.first_nam from crm.crm_user u where id = ci.issue_user and amnd_state = 'A') officer_name
            from crm.crm_issue ci, crm.crm_cust cc 
            where  cc.id = ci.crm_cust__id 
            and ci.amnd_state = 'A'";

        $this->order_by = ' order by ci.input_date desc';

    }

    public function onlySupport() {
        $this->sql .= ' and ci.project is null';
        return $this;
    }

    //show in form (on our side)
    public function activeIssues()
    {
        $this->sql .= " and (nvl(ci.to_show_in_form, 'Y') in ('Y', '?'))";
        return $this;    
    }
    
    public function onlyProject() {
        $this->sql .= ' and ci.project is not null';
        return $this;
    }


    public function forUser($uid)
    {
        $this->sql .= " and ci.issue_user = $uid";
        return $this;
    }  

    public function myActiveIssues()
    {
        $this->activeIssues()->forMe();
        return $this;
    } 

    public function withText($str)
    {
        $this->sql .= " and (lower(ci.details) like lower('%$str%')
                          or lower(ci.result_details) like lower('%$str%') 
                          or lower(ci.name) like lower('%$str%'))";
        Log::info($str);
        return $this;
    }

    public function forMe()
    {   
        $uid = Config::get('crm.crm_user_id');
        return $this->forUser($uid);
    }

    public function forLastDays($days)
    {
        $this->sql .= " and ci.input_date >= sysdate - $days";
        return $this;
    }

    public function forCustomer($cust_id)
    {
        $this->sql .= " and ci.crm_cust__id = $cust_id";
        return $this;
    }

    public function maxRecords($n_records = 100)
    {
        $this->sql .= " and rownum <= $n_records";
        return $this;
    }

    public function withIDT($idt)
    {
        //TODO: refactor this
        $results = DB::select("select original_issue from crm.crm_issue 
                                   where issue_idt = '".$idt."' and amnd_state = 'A'");
        if (count($results) > 0) {
            $odt = $results[0]->original_issue;
        }   
        
        $this->sql .= " and ci.original_issue = $odt";
        return $this;
    }

    public function withCDT($idt)
    {
        //TODO: refactor this
        $results = DB::select("select id from crm.crm_case 
                                   where record_idt = '$idt' and amnd_state = 'A'");
        if (count($results) > 0) {
            $case__oid = $results[0]->id;
        }   
        
        $this->sql .= " and ci.crm_case__oid = $case__oid";
        return $this;
    }

    public function get_sql() {   
        return $this->sql; 
    }    

    public function orderBy($columns) {   
        $this->order_by = " order by $columns";
        return $this->sql; 
    }    
    

    public function get() {   
        $this->sql .= $this->order_by;
        Log::info($this->sql);
        $results = DB::select($this->sql);
     return $results; 
    }
}

// $iss = new Issue();
// $iss->get()->withCDT()->withInterval()->withCustomer();
// $iss->get()->withOfficer()->withCustomer();
// $iss->get()->withOfficer()->withUser();
// $iss->get()->withPastdays()->withCustomer();
// $iss->get()->myCurrent();