<?php namespace TC\Reps; 

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;



class NavbarRepository 
{
    
    function __construct()
    {

        # code...
    }

    public function getTotalValues($period = 'today')
    {

        $uid = Config::get('crm.crm_user_id');
        if($period == 'today') {
            $from = date('d.m.Y');
            $to   = date('d.m.Y');
        }   
        elseif ($period =='week') {
            $from = date('d.m.Y',strtotime('last monday'));
            $to   = date('d.m.Y',strtotime('today'));
        }
        elseif ($period =='month') {
            $results = DB::select("select 'month_'||to_char(rownum-1) month, m.name, m.opened||'/'||m.closed oc from
                    (select case_opened.period as name, case_opened.opened, case_closed.closed from
                      (select to_char(c.open_date,'yyyy-mm') period, count(*) opened
                      from crm.crm_case c, crm.crm_user u
                      where c.owner=u.id and c.amnd_state='A' and u.amnd_state='A'
                      and u.name in ('Gorokhov Artem') and c.open_date>=to_date('01.01.2013','dd.mm.yyyy')
                      and (c.reason<>'R6' or c.reason is null) 
                      group by to_char(c.open_date,'yyyy-mm')) case_opened,
                      (select to_char(c.close_date,'yyyy-mm') period, count(*) closed
                      from crm.crm_case c, crm.crm_user u 
                      where c.owner=u.id and c.amnd_state='A' and u.amnd_state='A'
                      and u.name in ('Gorokhov Artem') and c.close_date>=to_date('01.01.2013','dd.mm.yyyy')
                      and (c.reason<>'R6' or c.reason is null) 
                      group by to_char(c.close_date,'yyyy-mm')) case_closed
                      where case_opened.period=case_closed.period order by 1 desc) m");
            $timing = array($period => $results);
            return $timing;
        }

        $results = DB::select( "select nvl2(t.crm_project__oid, 'PRJ', 'SUP') type, sum(used_time) ut from crm.crm_action_log t where 
                                action_date between to_date('".$from." 00:00:00', 'DD.MM.YYYY hh24:MI:SS')
                                                and to_date('".$to.  " 23:59:59', 'DD.MM.YYYY hh24:MI:SS')
                                and t.action_user = ? and t.amnd_state = 'A'
                                group by nvl2(t.crm_project__oid, 'PRJ', 'SUP')
                                order by type", array($uid));


        /*
        array (size=2)
          0 => 
            object(stdClass)[181]
              public 'type' => string 'PRJ' (length=3)
              public 'ut' => string ',14' (length=3)
          1 => 
            object(stdClass)[182]
              public 'type' => string 'SUP' (length=3)
              public 'ut' => string '5,22' (length=4)
                

        */   // 
              //$values_array = str_replace(",", ".", $results[0]->ut)
        //dd($results);
        if(count($results) == 0) {
            $data['used_prj'] = number_format(0, 2);
            $data['used_sup'] = number_format(0, 2);
            $data['total'] = $data['used_prj'] + $data['used_sup'];
            $data['inv'] = number_format(0, 2);
        }
        else if(count($results) ==1){  //if only SUP or only proj passed
            if($results[0]->type =='PRJ') {
                $data['used_prj'] = number_format( str_replace(",", ".", $results[0]->ut) , 2);  
                $data['used_sup'] = number_format(0, 2);
                $data['total'] = $data['used_prj'] + $data['used_sup'];                 
                $data['inv'] = number_format(0, 2);
            }
            else {
                $data['used_prj'] = number_format(0, 2);
                $data['used_sup'] = number_format( str_replace(",", ".", $results[0]->ut), 2);  
                $data['total'] = $data['used_prj'] + $data['used_sup'];
                $data['inv'] = number_format(1, 2);
            }
        }
        else {
            $data['used_prj'] = number_format( str_replace(",", ".", $results[0]->ut), 2 );
            $data['used_sup'] = number_format( str_replace(",", ".", $results[1]->ut), 2 );
            $data['total'] = $data['used_prj'] + $data['used_sup'];
            if($data['used_sup'] >= $data['used_prj']) {
                $data['inv'] = number_format(1 - $data['used_prj'] / ($data['used_sup'] + $data['used_prj']), 2);
            }
            else{
                $data['inv'] = number_format($data['used_sup']/($data['used_sup'] + $data['used_prj']), 2);
            }
        }

        //$timing = $data;
        $timing = array($period => $data);
        return $timing;
    }
}


