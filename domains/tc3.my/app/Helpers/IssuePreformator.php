<?php namespace App\Helpers;

class IssuePreformator {

    public static function PrepareIssue($issue)
    {
    	$issue->details = self::CutOriginals($issue->details);
        return $issue;
    }

    public static function CutOriginals($email)
    {
    	$pos = strpos($email , '-----Original Message-----');
		if($pos!==false) {
			$email = substr( $email, 0 ,$pos);
		}
		$pos = strpos($email, '-----BEGIN PGP MESSAGE-----');
		if ($pos!==false)	{
			$email = substr( $email, 0 ,$pos);
		}
        return $email;
    }

    public static function IdtToLinks($text)
    {
    	return preg_replace("/([IC]\d{9,10})/", "<a href='/case/$1'>$1</a>", $text);
    }

    public static function JiraIDtoLinks($text) {
        //cut off existent jira links, leave only Jira IDs (for possible mixed notations - IDs and links)
        $res = str_replace('https://ows-jira/browse/', '', $text);
        //make links
        $res = preg_replace("/([A-Z]{2,9}-\d{2,9})/", "<a  class='jiralink' href='https://ows-jira/browse/$1'>$1 &nbsp;</a>", $res);
        return $res;
    }

}
