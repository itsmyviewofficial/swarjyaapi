<?php  
namespace App\Helpers;
use Carbon\Carbon;
use App\RoleModulePrivileges;
use App\Models\Defaults;
use App\Models\Log;

class CommonHelper 
{   
	public function v1_getVersion()
	{
		$default = Defaults::first();
		if(is_null($default))
		{
			return '1.0.0';
		}
		else
		{
			return $default->version;
		}
	}
	public function buildTree($elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

	public function strongPassword($pwd) 
	{
        if (preg_match("#.*^(?=.{8,20})(?=.*[a-zA-Z])(?=.*[0-9]).*$#", $pwd)) {
            return 1;
        } else {
            return 0;
        }
    }
	public function generateRandomHexString($length) 
	{
        return substr(bin2hex(openssl_random_pseudo_bytes(ceil($length / 2))), 0, $length);
    }

	public function randomPin()
	{
	   $hex = $this->generateRandomHexString(8);
	   $dec=hexdec($hex);
	   return substr($dec,0,6);
	}

	public function ValidateUserPrivileges($role_id, $module_id, $privilege_id)
	{
	    $count  = \DB::table('rolemoduleprivileges') 
	                    ->where('role_id','=',$role_id)
	                    ->where('module_id','=',$module_id)
	                    ->where('privilege_id','=',$privilege_id)
	                    ->count();
	    if($count>0)
	        return "true";
	    else
	        return "false";                  
	}
	public function createLog($log)
	{
	    $defaults = Defaults::all();

	    $validate = true;
	    if($log->action == 'create')
	    {
	        if($defaults[0]->allow_create_logs<>'1')
	            $validate = false;
	    }
	    elseif($log->action == 'update')
	    {
	        if($defaults[0]->allow_edit_logs<>'1')
	            $validate = false;
	    }
	    elseif($log->action ==  'delete')
	    {
	        if($defaults[0]->allow_delete_logs<>'1')
	            $validate = false;
	    }
	    
	    if($validate)
	    {
	        $objLog = new Log();
	        $objLog->module_id  =$log->module_id;   
	        $objLog->created_on  =$log->created_on;
	        $objLog->user_id =   $log->user_id;
	        $objLog->action      =$log->action;
	        $objLog->category    =$log->category;
	        $objLog->description =$log->description;
	        $objLog->log_type    =$log->log_type;
	        $objLog->save();
	    }
	}

	public static function sendSMS($mess,$mobilenumbers)
	{   
	    // $user="api";    //your username
	    // $password="NuJqmQn@KAb4XC3"; //your password 
	    // $senderid="ECOFNN"; //Your senderid
	    // $url="http://vnssms.in/quicksms/api/web2sms.php?";
	    // $message = urlencode($mess);

	    // $ch = curl_init();
	    // if (!$ch){die("Couldn't initialize a cURL handle");}
	    // $ret = curl_setopt($ch, CURLOPT_URL,$url);
	    // curl_setopt($ch, CURLOPT_POST, 1);
	    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	    // curl_setopt($ch, CURLOPT_POSTFIELDS,"username=$user&password=$password&to=$mobilenumbers&sender=$senderid&message=$message");
	    // $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1) ;
	    // $curlresponse = curl_exec($ch);// execute

	    // if(curl_errno($ch))
	    //     return 'curl error : '. curl_error($ch);
	    // if (empty($ret)) {
	    //     // some kind of an error happened
	    //     die(curl_error($ch));
	    //     curl_close($ch); // close cURL handler
	    // } else {
	    //     $info = curl_getinfo($ch);
	    //     curl_close($ch); // close cURL handler
	    // }
	}


	public function get_time_ago( $time )
	{
	    $time_difference = time() - $time;

	    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
	    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
	                30 * 24 * 60 * 60       =>  'month',
	                24 * 60 * 60            =>  'day',
	                60 * 60                 =>  'hour',
	                60                      =>  'minute',
	                1                       =>  'second'
	    );

	    foreach( $condition as $secs => $str )
	    {
	        $d = $time_difference / $secs;

	        if( $d >= 1 )
	        {
	            $t = round( $d );
	            return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
	        }
	    }
	}

	public function getWeekdays($days)
	{
	 	$m= date("m");

		$de= date("d");

		$y= date("Y");
	    
	    for($i=0; $i<$days; $i++)
		{
			$Data[] = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y));
		}	
		return $Data;
	 }


	 public function split_name($string) 
	 {
	    $arr = explode(' ', $string);
	    $num = count($arr);
	    $first_name = $middle_name = $last_name = null;
	    
	    if ($num == 2) {
	        list($first_name, $last_name) = $arr;
	    } else {
	        list($first_name, $middle_name, $last_name) = $arr;
	    }

	    return (empty($first_name) || $num > 3) ? false : compact(
	        'first_name', 'middle_name', 'last_name'
	    );
	}

	public function uploadFiles($upload_doc,$type,$folder,$id)
	{
		$new_directory = './'.env('MAIN_FOLDER').'/'.$type;

	    if (!is_dir($new_directory)): mkdir($new_directory, 0777, true); endif;
	    if(strchr($upload_doc,"image")): $file = '.png'; elseif(strchr($upload_doc,"video")): $file =".mp4"; 
	    	elseif(strchr($upload_doc,"octet-stream")):
	    	    $file =".docx";
	    	elseif(strchr($upload_doc,"vnd.openxmlformats-officedocument.wordprocessingml.document")): 
	    		$file =".docx";
	    	elseif(strchr($upload_doc,"msword")): 
	    		$file =".doc";
	        elseif(strchr($upload_doc,"pdf")): 
	    		$file =".pdf";
	    	else: return ""; endif;
	    if($id != 0): 
	    	if(file_exists(getenv('API_URL').$id)): unlink(getenv('API_URL').$id); endif;
    	endif;

    	$upload_doc_path = $new_directory.'/'. uniqid() . $file;
	    $resume_doc_parts = explode(";base64,", $upload_doc);
	    if($file == '.png'):
	    $resume_doc_type_aux = explode("image/", $resume_doc_parts[0]);
	    elseif($file == '.mp4'):
	    $resume_doc_type_aux = explode("video/", $resume_doc_parts[0]);
	    else:
	     $resume_doc_type_aux = explode("application/", $resume_doc_parts[0]);
	    endif;
	    $resume_doc_type = $resume_doc_type_aux[1];
	    $resume_doc_base64 = base64_decode($resume_doc_parts[1]);  
	    file_put_contents($upload_doc_path, $resume_doc_base64);
	    chmod($upload_doc_path,0777);
	    $upload_doc = substr($upload_doc_path, 1);

	    return $upload_doc;
	}


	public function increment($po)
	{
		if(strlen($po) == 1):
	    	return '0000000'.$po;
		elseif(strlen($po) == 2):
	    	return '000000'.$po;
		elseif(strlen($po) == 3):
	    	return '00000'.$po;
	    elseif(strlen($po) == 4):
	    	return '0000'.$po;
	    elseif(strlen($po) == 5):
	    	return '000'.$po;
	    elseif(strlen($po) == 6):
	    	return '00'.$po;
	    elseif(strlen($po) == 7):
	    	return '0'.$po;
	     elseif(strlen($po) == 8):
	    	return $po;
	    else:
	    	return $po;
	   	endif;
	}
}