<?php namespace TC\Reps;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

/**
* 
*/
class CustomerRepository implements CustomerRepositoryInterface
{   
    protected $sql;
 

    function __construct()
    {
        
       
    }

    public function get() {   
        $this->sql = "select  id, name, fax_number from crm.crm_cust where amnd_state = 'A' and crm_supp_type__id in (23, 1) and status = 'Active' order by name";
        $results = DB::select($this->sql);
     return $results; 
    }
}


