<?php namespace TC\Reps;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

/**
* 
*/
class CasesRepository implements CasesRepositoryInterface
{	
	protected $sql;
	protected $init_sql;	

	function __construct()
	{
		
		$this->init_sql = "select cs.*, cs.record_idt, cs.name, cs.open_date, cs.hd_time used_time, cs.issues_in_case,
                     cs.due_date, cc.name cust_name, cs.project, cs.is_open, cs.on_our_side, cc.fax_number,
                     dl.name as dl_name, dl.code as dl_code, 
                     case when cs.severity_level = 1 then 'B' when cs.severity_level = 3 then 'C' when cs.severity_level = 23 then 'D' when cs.severity_level = 2 then 'A' end as cat,
                     case when cs.project is not null then 100 else round((due_date - sysdate)) end as remain_time, 
                     (select u.last_nam||' '||u.first_nam from crm.crm_user u where id = cs.owner and amnd_state = 'A') officer_name
                   from crm.crm_case cs, crm.crm_cust cc, crm.crm_dlv_type dl
                   where  cc.id = cs.crm_cust__id 
                   and dl.id = cs.delivery_type 
            		  and cs.amnd_state = 'A'";

      $this->sql = $this->init_sql;      		  
		$this->order_by = ' order by cs.open_date';
	}

	public function  withCDT($cdt) {
		$this->sql .= "and cs.record_idt = '$cdt'";
		return $this;
	}


	public function  withIDT($idt) {
		//TODO: refactor this
        $results = DB::select("select crm_case__oid from crm.crm_issue 
                                   where issue_idt = '".$idt."' and amnd_state = 'A'");
        if (count($results) > 0) {
            $case_id = $results[0]->crm_case__oid;
        }   
        
        return $this->withId($case_id);
	}	


	public function  withId($case_id) {
		$this->sql .= "and cs.id = $case_id";
		return $this;
	}

	public function  forUser($id) {
		 $this->sql .= " and cs.owner = $id";
        return $this;
	}

	public function  forManager($id) {
		 $this->sql .= " and cs.manager = $id";
        return $this;
	}


	public function  myManaged() {
		 $uid = Config::get('crm.crm_user_id');
		 $this->forManager($uid);
       return $this;
	}

	public function  onOurSide() {
		 $this->sql .= " and cs.on_our_side = 'Y'";
        return $this;
	}

  public function  onOurSideWithPings() {
     $this->sql .= " and ( cs.on_our_side = 'Y' or cs.id in ( select crm_case__oid from crm.crm_issue where issue_type = 1337 and amnd_state = 'A' and is_active = 'W' ))";
        return $this;
  }

	public function forMe()
    {   
        $uid = Config::get('crm.crm_user_id');
        return $this->forUser($uid);
    }

    public function myIssues(){
    	$this->forMe()->isOpen()->onOurSideWithPings();
    	return $this;
    }

    public function myCases(){
      $this->forMe()->isOpen();
      return $this;
    }


	public function  forCustomer($id) {

	}

	public function  isOpen($flag = 'Y') {
		$this->sql .= " and cs.is_open = '$flag'";
		return $this;
	}

	public function  forLastDays($days) {

	}	

	public function maxRecords($n_records = 100)
    {
        $this->sql .= " and rownum <= $n_records";
        return $this;
    }

    public function orderBy($columns) {   
        $this->order_by = " order by $columns";
        return $this; 
    }    

    public function get_sql(){
    	return $this->sql;
    }

    public function get() {   
        $this->sql .= $this->order_by;
        $results = DB::select($this->sql);
        $this->sql = $this->init_sql;
     return $results; 
    }


    public function forLenta() {   
        $this->sql .= " and cs.id in 
        (
            select distinct crm_case__oid from crm.crm_issue ci where 
            end_date >= sysdate - 1 and
            project is null and
            help_desk_user in 
            (
                               
                select distinct crm_user__id from crm.crm_officer where e_mail in (
                   'agorokhov@openwaygroup.com',
                   'sloginova@openwaygroup.com',
                   'antsvetkov@openwaygroup.com',
                   'ekarpova@openwaygroup.com',
                   'asmirnov@openwaygroup.com',
                   'agamburg@openwaygroup.com',
                   'vegai@openwaygroup.com',
                   'varkhipov@openwaygroup.com',
                   'amatveeva@openwaygroup.com',
                   'vyakovlev@openwaygroup.com',
                   'anikitin@openwaygroup.com',
                   'vsadovskaya@openwaygroup.com',
                   'sglazkov@openwaygroup.com'
                    ) 
            )
            and amnd_state = 'A'
        )"; 

     return $this; 
 	}


}


