<?php namespace TC\Reps;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

/**
* 
*/
class ProjectRepository implements ProjectRepositoryInterface
{   
   protected $sql;
   protected $init_sql;    

   function __construct()
   {  /*
     select pr.main_project, 
     pr.id, pr.project_officer, 
     pr.crm_cust__id,  
     pr.name, 
     pr.is_active, pr.status,
     pr.start_date, 
     pr.due_date, 
     pr.budget_total, 
     pr.used_time_total, 
     pr.item_type
     from crm.crm_project pr where amnd_state = 'A' and is_history ='N'
     and item_type in ('P', 'M')                           

     and pr.main_project in (
                                 select id from crm.crm_project pr1 where pr1.id = pr.main_project and pr1.status = 470 and pr.project_user = 57671
                             )
      
     group by pr.main_project, pr.id, pr.project_officer, pr.crm_cust__id, pr.name, pr.is_active, pr.status, pr.start_date, pr.due_date, pr.budget_total, pr.used_time_total, pr.item_type
     order by pr.main_project, pr.start_date desc




     */
     
      $this->init_sql = "select pr.main_project, 
      pr.id, pr.project_officer, 
      pr.crm_cust__id,  
      pr.name, 
      pr.is_active, pr.status,
      pr.start_date, 
      pr.due_date, 
      pr.budget_total, 
      pr.used_time_total, 
      pr.item_type,
      pr.code,
      round((pr.due_date - to_date('01011970','ddmmyyyy'))*24*60*60) as due_date_unix,
      round((pr.start_date - to_date('01011970','ddmmyyyy'))*24*60*60) as start_date_unix
      from crm.crm_project pr where amnd_state = 'A' and is_history ='N'
      and item_type in ('P', 'M')                           

      and pr.main_project in (
                              select id from crm.crm_project pr1 where pr1.id = pr.main_project and pr1.status = 470 and pr.project_user = 57671
                          )";

      $this->sql = $this->init_sql;               
      $this->order_by = ' order by pr.main_project, pr.start_date desc';
   }

    public function  withId($proj_id) {
        return $this;
    }

    public function  forUser($id) {
        $this->sql .= " and pr.project_user = $id";
        return $this;
    }


    public function  forMe($id) {
      $this->sql .= " and pr.project_user = $id";
      return $this;
    }

    public function  forCustomer($id) {

    }

    public function withCode($project_code='')
    {
        $this->sql .= " and main_project in 
                            (
                                select id from crm.crm_project pr1 where pr1.code = '$project_code' and pr1.amnd_state = 'A' and pr1.is_history ='N'
                            )";
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
}


