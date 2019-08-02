<?php

class Crm {
	

	public function getTotalsForPeriod($period = 'DAY')
	{
		$data['uid'] = Config::get('crm.crm_user_id');

		//$r = DB::select("select 1 from dual");
		//TODO: move this to model - getTotalsForPeriod ('DAY|WEEK|MONTH') return array -> getTotalsForTimeframe
		/*$results = DB::select( "select nvl2(t.crm_project__oid, 'PRJ', 'SUP') type, sum(used_time) ut from crm.crm_action_log t where 
                            	action_date between to_date('30.07.2013 00:00:00', 'DD.MM.YYYY hh24:MI:SS')
                                   				and to_date('30.07.2013 23:59:59', 'DD.MM.YYYY hh24:MI:SS')
                            	and t.action_user = ? and t.amnd_state = 'A'
                            	group by nvl2(t.crm_project__oid, 'PRJ', 'SUP')
                            	order by type", array($data['uid']) );

		*/

		$results[0] = array('type'=>'PRJ', 'ut'=>'0.34');
		$results[1] = array('type'=>'SUP', 'ut'=>'0.54'); 
		
		if(count($results) == 0) {
			$data['used_prj'] = number_format(0, 2);
			$data['used_sup'] = number_format(0, 2);
			$data['inv'] = number_format(0, 2);
		}
		else if(count($results) ==1){
			if($results[0]->type =='PRJ') {
				$data['used_prj'] = number_format($results[0]->ut, 2);	
				$data['used_sup'] = number_format(0, 2);
				$data['inv'] = number_format(0, 2);
			}
			else {
				$data['used_prj'] = number_format(0, 2);
				$data['used_sup'] = number_format($results[0]->ut, 2);	
				$data['inv'] = number_format(1, 2);
			}
		}
		else {
			$data['used_prj'] = number_format($results[0]->ut, 2);
			$data['used_sup'] = number_format($results[1]->ut, 2);
			if($data['used_sup'] >= $data['used_prj']) {
				$data['inv'] = number_format(1 - $data['used_prj'] / ($data['used_sup'] + $data['used_prj']), 2);
			}
			else{
				$data['inv'] = number_format($data['used_sup']/($data['used_sup'] + $data['used_prj']), 2);
			}
		}

		return $data;
	}
}