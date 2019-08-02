<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

use App\Helpers\IssuePreformator;

//Bindings
App::bind('TC\Reps\IssuesRepositoryInterface',  'TC\Reps\IssuesRepository');
App::bind('TC\Reps\CasesRepositoryInterface',   'TC\Reps\CasesRepository');
App::bind('TC\Reps\ProjectRepositoryInterface', 'TC\Reps\ProjectRepository');
App::bind('TC\Reps\CustomerRepositoryInterface', 'TC\Reps\CustomerRepository');


// Routes
 //Route::group(['middleware' => 'CrmAuth'], function()
 //{
      Route::get('/iss', 'CaseController@listIssues');
      Route::get('/my_cases', 'CaseController@myCases');  //ex CaseController@myIssues
      Route::get('/my_issues', 'CaseController@myIssuesStub');
      Route::get('/lenta', 'CaseController@lenta');
      Route::get('/case/{idt?}', 'CaseController@viewCase');
      Route::get('/projects', 'ProjectController@myProjectTimelines');

      Route::get('/search', 'CaseController@search');
      Route::post('/search', 'CaseController@search');

      Route::get('/timeline', 'TimelineController@timeline');
      Route::get('/timeseries', 'TimelineController@timeseries');

      Route::get('/manage/{idt?}', 'CaseController@manage');

      //-----------------------------AJAX routes
      //returns total timings for periods for current user 
      Route::get('/totals', 'CaseController@getTotals');
      //saves attachment to P, outputs path to  folder on P
      Route::get('/saveonp/{idt}', 'IssueController@saveAttachments');
      //lists attachments for issue
      Route::get('/saveonp/{idt}/list', 'IssueController@listAtachments');

      //-----------------------------issue completion workflow
      //upadate issue text, do complete, send notification, complete again to close/
      Route::post('/issue_complete/{id}/update',   'IssueController@testIssueCompletionUpdate');
      Route::get( '/issue_complete/{id}/complete', 'IssueController@testIssueCompletionComplete');
      Route::get( '/issue_complete/{id}/notify',   'IssueController@testIssueCompletionNotify');
      Route::get( '/issue_complete/{id}/cancel',   'IssueController@testIssueCompletionCancel');
      Route::get( '/issue_complete/test',   'IssueController@testPage');
 //});
      
Route::get('/test_tns', 'TestController@testTns');
Route::get('/test_dialog', 'TestController@testDialog');
Route::get('/test_page', 'TestController@testPage');

Route::get('/phpinfo', function() {
   phpinfo();
});

Route::get('/mem/numbers', function()
{
   return View::make('mem/numbers_cards');
});

Route::get('/mem/abc', function()
{
   return View::make('mem/abc_cards');
});

Route::get('/mem/rndseq', function()
{
   return View::make('mem/random_sequence');
});



Route::get('/', function()
{
   return View::make('hello');
});

Route::get('/att', 'TestController@testAtt');

Route::get('/infos/{str}', function($str)
{
   $client = new GuzzleHttp\Client;
   $response = $client->request('POST', 'https://infosearcher.cdt.spb.openwaygroup.com', [
    'form_params' => [
        'searchQuery_isvoc' => $str,
        'submitQuery_isvoc' => 'Search',
    ],
    'verify' => false
   ]);
	return $response;
});

Route::controllers([
   'auth' => 'Auth\AuthController'
]);




//TODO: move to presenter class
//Acts like view presenter for issues
View::composer('partials.issue', function($view){
   $data = $view->getData();
   //details
   $data['issue']->details = htmlspecialchars($data['issue']->details);  
   $data['issue']->details = IssuePreformator::CutOriginals($data['issue']->details);   
   $data['issue']->details = IssuePreformator::IdtToLinks($data['issue']->details);
   $data['issue']->details = IssuePreformator::JiraIDtoLinks($data['issue']->details);
   $data['issue']->details = str_replace("\n\r","<br/>",$data['issue']->details);
   $data['issue']->details = str_replace("\r","<br/>",$data['issue']->details);


   // r-like newsimbol added in IssueRepository for CRM-compatibility (\r used in edit multiline window)
   $data['issue']->result_details = str_replace("\r", "", $data['issue']->result_details);   
         
   //result details
   // TODO: fix bug with showing input fields in I404079286 
      //dd($data['issue']);
   if(isset($data['issue']->end_date)) {
      $data['issue']->result_details =  htmlspecialchars($data['issue']->result_details);
      $data['issue']->result_details = str_replace("\n","<br/>",$data['issue']->result_details);
      $data['issue']->result_details =  IssuePreformator::IdtToLinks($data['issue']->result_details);
      $data['issue']->result_details =  IssuePreformator::JiraIDtoLinks($data['issue']->result_details);
   }
   
   //test impacts aka comment
   if(isset($data['issue']->test_impact) && isset($data['issue']->end_date)) {
      $data['issue']->test_impact =     IssuePreformator::IdtToLinks($data['issue']->test_impact);
      $data['issue']->test_impact =     IssuePreformator::JiraIDtoLinks($data['issue']->test_impact);
   }
   /*
   if(Request::url() == 'http://tc2.my/search/asd'){

   } */
}); 