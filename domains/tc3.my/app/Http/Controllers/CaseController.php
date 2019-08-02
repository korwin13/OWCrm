<?php namespace App\Http\Controllers;  

use TC\Reps\NavbarRepository;
use TC\Reps\IssuesRepositoryInterface;  
use TC\Reps\CasesRepositoryInterface;
use TC\Reps\PresenterCollection;
use Config;
use View;
use App\Helpers\Parser;
use Input;
use Log;

class CaseController extends BaseController {



   //protected $layout = 'layout';
    protected $nav;
    protected $irep;
    protected $crep;

    function __construct(NavbarRepository $nav, IssuesRepositoryInterface $ir, CasesRepositoryInterface $cr) {
        parent::__construct();


        //dd(Config::get('database.connections.oracle.password'));

        $this->nav = $nav;
        $this->irep = $ir;
        $this->crep = $cr;
    }
 
    public function listIssues()
    {
        return View::make('test_issues');
    }

    public function lenta()
    {
        $data['CASES'] = $this->crep->forLenta()->orderBy('officer_name, remain_time asc')->get();
        $data['count'] = count($data['CASES']);
        //var_dump($this->crep->get_sql());
        //dd($data);
        return View::make('lenta', $data);
    }

    public function listProjects()
    {
        return View::make('projects');
    }

    public function viewCase($idt)
    {
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $data['encrypted_token'] = $encrypted_token;
        $data['uid'] = Config::get('crm.crm_user_id');
        if (Parser::isIDT($idt)) {
            $data['SEQ'] = $this->irep->withIDT($idt)->get();
            $cases = $this->crep->withIDT($idt)->get();
            $data['CASE'] = $cases[0];

        }
        elseif (Parser::isCDT($idt)) {
            $data['SEQ'] = $this->irep->withCDT($idt)->get();
            $cases = $this->crep->withCDT($idt)->get();
            $data['CASE'] = $cases[0];

        }  
        //var_dump($data['CASE']);
        return View::make('case', $data);
        //return View::make('issues')->with('user', new PresenterCollection($iss_list));
    }    
    
    public function testPage($idt='')
    {
        $data['jira'] = Request::url();
        return View::make('test_content', $data);
    }

    public function search() {

        $query = Input::get('q');

        if($query) {
            $data['SEQ'] = $this->irep->forLastDays(730)->withText($query)->get();
            $data['FILTER']['text'] = $query;  
            return View::make('issues', $data);
        }

        if(Input::get('from_form')) {
            $days = Input::get('last_days');
            $customer = Input::get('cust');
            Input::get('q');
            $data['SEQ'] = $this->irep->forLastDays($days)->forCustomer($customer)->get();
            $data['FILTER']['text'] = '$query';
            return View::make('issues', $data);
        }
    }

    public function myIssues()
    {
        $data['CASES'] = $this->crep->myIssues()->orderBy('remain_time asc')->get();
        $data['count'] = count($data['CASES']);
        //var_dump($this->crep->get_sql());

        return View::make('my_issues', $data);
    }

    public function myCases()
    {
        $data['CASES'] = $this->crep->myCases()->orderBy('cs.on_our_side desc, remain_time asc')->get();
        $data['count'] = count($data['CASES']);
        //var_dump($this->crep->get_sql());

        return View::make('my_issues', $data);
    }

    public function myIssuesStub()
    {
        dd('my_cases');
    }

    // tc2.my/totals
    public function getTotals()
    {
        $ar = array();
        $ar = array_merge($ar, $this->nav->getTotalValues('today'));
        $ar = array_merge($ar, $this->nav->getTotalValues('week'));
        $ar = array_merge($ar, $this->nav->getTotalValues('month'));
        return response()->json($ar);
    }


    public function manage($idt='')
    {
        if (Parser::isIDT($idt)) {
            $data['SEQ'] = $this->irep->withIDT($idt)->get();
            $cases = $this->crep->withIDT($idt)->get();
            $data['CASE'] = $cases[0];
        }
        elseif (Parser::isCDT($idt)) {
            $data['SEQ'] = $this->irep->withCDT($idt)->get();
            $cases = $this->crep->withCDT($idt)->get();
            $data['CASE'] = $cases[0];
        }  
        $data['curr_idt'] = $idt;   
        $sql = $this->crep->isOpen('Y')->myManaged()->orderBy('cat, cs.open_date')->get_sql();
        var_dump($sql);
        $data['CASES'] = $this->crep->get();
        return View::make('case_category_columns', $data);
    }

}