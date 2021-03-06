<?php

function debug($data=NULL, $exit=FALSE)
{
	$trace = debug_backtrace();
	try {
		echo "<pre>";
		// print_r($data);
		if (!empty($trace)) {
			foreach ($trace as $key => $row) {
				$separator = '------';
				for ($i=0; $i < strlen($row['file']); $i++) $separator .= '-';
				
				echo ($key==0?'<h1 style="margin:0;">DEBUGGER</h1>':'').$separator."<br /><b>PATH:</b> ".$row['file'];
				echo "<br /><b>LINE:</b> ".$row['line']."<br />";
				
				if ($key == 0) {
					if (is_bool($data)) {
						echo "<b>DATA TYPE:</b> BOOLEAN<br />";
						if ($data) {
							echo "<b>DATA:</b> TRUE<br />";
						} else {
							echo "<b>DATA:</b> FALSE<br />";
						}
					} else {
						if (is_object($data) OR is_null($data)) echo "<b>DATA TYPE:</b> OBJECT<br />";
						if (is_array($data)) echo "<b>DATA TYPE:</b> ARRAY<br />";
						if (is_numeric($data)) {
							echo "<b>DATA TYPE:</b> NUMBER<br />";
						} elseif (is_string($data)) {
							echo "<b>DATA TYPE:</b> STRING<br />";
						}
						if (empty($data) AND $data != 0) {
							if (is_object($data) OR is_null($data)) echo "<b>DATA:</b> NULL<br />";
							if (is_array($data)) echo "<b>DATA:</b> EMPTY<br />";
							if (is_string($data)) echo "<b>DATA:</b> BLANK<br />";
						} else {
							echo "<b>DATA:</b> ";
							if (is_null($data)) {
								var_dump($data);
							} else if (is_string($data)) {
								echo '<code>';
								print_r($data);
								echo '</code>';
							} else {
								print_r($data);
							}
							echo "<br />";
						}
					}
				}
			}
		} else {
			echo "<b>DATA:</b> NULL<br />";
		}
		echo "</pre>";
	} catch (Exception $e) {
		echo "<pre>";
		foreach ($trace as $key => $row) {
			$separator = '------';
			for ($i=0; $i < strlen($row['file']); $i++) $separator .= '-';
				echo '<h1 style="margin:0;">DEBUGGER</h1>'.$separator."<br /><b>PATH:</b> ".$row['file'];
			echo "<br /><b>LINE:</b> ".$row['line']."<br />";
			echo "<b>DATA:</b> ".$e->getMessage()."<br />";
		}
		echo "</pre>";
	}
	if ($exit) exit();
}

function check_instance($obj=FALSE, $class=NULL)
{
	if (is_array($class)) {
		foreach ($class as $key => $value) {
			if ($obj instanceof $value) {
				return TRUE;
			}
		}
	} else {
		if ($obj instanceof $class) {
			return TRUE;
		}
	}
	return FALSE;
}

function device_id($ip=false)
{
	$ci =& get_instance();
	if ($ip == false) $ip = $_SERVER['REMOTE_ADDR'];
	$ID = GACELABS_SUPER_KEY.$ip;
	/*if (isset($ci->accounts) AND $ci->accounts->has_session) {
		$ID = $ci->accounts->profile['id'].$ci->accounts->profile['email_address'].$ip;
	}*/
	// $DEVICE = substr(md5($ID), 0, 7);
	$DEVICE = substr(md5($ID), 0, 12);
	/*if (get_mac_address()) {
		$DEVICE = substr(md5(get_mac_address()), 0, 7);
	}*/
	// debug($DEVICE, 1);
	$ci->device_id = substr(base64_encode(strtoupper(GACELABS_KEY.$DEVICE)), 0, 9);
	return $ci->device_id;
}

function get_mac_address()
{
	// Turn on output buffering  
	ob_start();  
	// Get the ipconfig details using system commond  
	@system('ipconfig /all');  
	// Capture the output into a variable  
	$mycomsys = ob_get_contents();  
	// Clean (erase) the output buffer  
	ob_clean();  
	$find_mac = "Physical"; // Find the "Physical" & Find the position of Physical text  
	$pmac = strpos($mycomsys, $find_mac);  
	// Get Physical Address  
	$macaddress = substr($mycomsys, ($pmac+36), 17);  
	// Display Mac Address  
	return $macaddress;
}

function time_diff($past=FALSE, $future=FALSE, $diff='minutes', $want='5', $result=false)
{
	if ($past AND $future) {
		$lapse = (strtotime($future) - strtotime($past));
		if ($lapse > 0) {
			switch ($diff) {
				case 'seconds':
					if ($lapse >= $want) {
						if ($result) {
							return $lapse;
						} else {
							return TRUE;
						}
					}
				break;
				case 'minutes':
					if (($lapse / 60) >= $want) {
						if ($result) {
							return $lapse / 60;
						} else {
							return TRUE;
						}
					}
				break;
				case 'hours':
					if (($lapse / 3600) >= $want) {
						if ($result) {
							return $lapse / 3600;
						} else {
							return TRUE;
						}
					}
				break;
				case 'days':
					if (($lapse / 86400) >= $want) {
						if ($result) {
							return $lapse / 86400;
						} else {
							return TRUE;
						}
					}
				break;
			}
		}
	}
	return FALSE;
}

function get_root_path($path='', $is_doc_path=TRUE)
{
	$domain = '/';
	if((bool)strstr($_SERVER['HTTP_HOST'], 'local') == TRUE) {
		$domain = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
	}
	if($is_doc_path) {
		return $_SERVER['DOCUMENT_ROOT'] . $domain . $path;
	} else {
		return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $domain . $path;
	}
}

function save_image($base64_string=FALSE, $dir='', $file=FALSE) {
	if ($base64_string) {
		if ($file == FALSE) {
			$output_file = get_root_path('assets/data/photos/'.random_string().'.jpg');
		} else {
			$output_file = create_dirs($dir).$file;
		}
		// debug($output_file, 1);
		/*open the output file for writing*/
		$ifp = fopen($output_file, 'wb'); 
		/*split the string on commas*/
		/*$data[0] == "data:image/png;base64"*/
		/*$data[1] == <actual base64 string>*/
		$data = explode(',', $base64_string);
		/*we could add validation here with ensuring count($data) > 1*/
		fwrite($ifp, base64_decode($data[1]));
		/*clean up the file resource*/
		fclose($ifp); 
		// return get_root_path($file, FALSE); 
		return 'assets/data/files/'.$dir.'/'.$file; 
	}
	return FALSE;
}

function files_upload($_files=FALSE, $return_path=FALSE, $dir='upload', $this_name=FALSE) {
	if ($_files) {
		// debug($_files, 1);
		$uploaddir = create_dirs($dir);
		// debug($uploaddir, 1);

		$array_index = array_keys($_files);
		$result = FALSE;

		if (isset($array_index[0])) {
			$input = $array_index[0];
			if (is_array($_files[$input]['name'])) {
				$result = [];
				foreach ($_files[$input]['name'] as $key => $name) {
					if (in_str($name, '.accountpicture-ms')) {
						$name = remove_in_str($name, '.accountpicture-ms');
					}
					if ($_files[$input]['error'][$key] == 0) {
						$ext = strtolower(pathinfo(basename($name), PATHINFO_EXTENSION));
						if ($this_name) {
							$pathname = clean_string_name($this_name).'-'.time().'.'.$ext;
						} else {
							$pathname = basename($name);
							$chunks = explode('.'.$ext, $pathname);
							$pathname = $chunks[0].'-'.time().'.'.$ext;
						}
						$uploadfile = $uploaddir . $pathname;
						if (@move_uploaded_file($_files[$input]['tmp_name'][$key], $uploadfile)) {
							// "File is valid, and was successfully uploaded.\n";
							$status = TRUE;
						} else {
							// "Possible file upload attack!\n";
							$status = FALSE;
						}
						$result[] = [
							'file_path' => $uploadfile,
							'url_path' => 'assets/data/files/'.$dir.'/'.$pathname,
							'status' => $status,
							'keyname' => $key
						];
					}
				}
			} else {
				if ($_files[$input]['error'] == 0) {
					$ext = strtolower(pathinfo(basename($_files[$input]['name']), PATHINFO_EXTENSION));
					if ($this_name) {
						$pathname = clean_string_name($this_name).'-'.time().'.'.$ext;
					} else {
						$pathname = basename($_files[$input]['name']);
						$chunks = explode('.'.$ext, $pathname);
						$pathname = $chunks[0].'-'.time().'.'.$ext;
					}
					$uploadfile = $uploaddir . $pathname;
					// debug($ext);
					// debug($uploadfile, 1);
					if (@move_uploaded_file($_files[$input]['tmp_name'], $uploadfile)) {
						// "File is valid, and was successfully uploaded.\n";
						$status = TRUE;
					} else {
						// "Possible file upload attack!\n";
						$status = FALSE;
					}
					$result = [
						'file_path' => $uploadfile,
						'url_path' => 'assets/data/files/'.$dir.'/'.$pathname,
						'status' => $status,
						'keyname' => $input
					];
				}
			}
		}
		// debug($uploaddir, 1);
		// debug(array_keys($result), 1);
		// debug($_files, 1);
		if ($return_path AND isset($input)) {
			$data = '';
			$set = array_keys($result);
			if (isset($set[0]) AND !is_string($set[0])) {
				$data = [];
				foreach ($result as $key => $row) {
					if ($row['status']) {
						$data[] = $row['url_path'];
					}
				}
			} else {
				$data = $result['url_path'];
			}
			return $data;
		} else {
			return $result;
		}
	}
}

function create_dirs($dir='')
{
	/*create the dirs*/
	$folder_chunks = explode('/', 'assets/data/files/');
	if (count($folder_chunks)) {
		$uploaddir = get_root_path();
		foreach ($folder_chunks as $key => $folder) {
			$uploaddir .= $folder.'/';
			// debug($uploaddir);
			@mkdir($uploaddir);
		}
	}
	@mkdir(get_root_path('assets/data/files/'));
	$uploaddir = get_root_path('assets/data/files/'.$dir);
	
	if ($dir != '') {
		/*create the dirs*/
		$folder_chunks = explode('/', str_replace(' ', '_', $dir));
		// debug($folder_chunks, 1);
		if (count($folder_chunks)) {
			$uploaddir = get_root_path('assets/data/files/');
			foreach ($folder_chunks as $key => $folder) {
				$uploaddir .= $folder.'/';
				// debug($uploaddir);
				@mkdir($uploaddir);
			}
		}
	}
	@chmod($uploaddir, 0755);

	return $uploaddir;
}

function fix_title($title=FALSE) {
	if ($title) {
		return ucwords(preg_replace('/[-]/', ' ', $title));
	}
	return '';
}

function search_query($query='', $and_clause='')
{
	$ci =& get_instance();
	/*limit words number of characters*/
	$query = substr($query, 0, 200);

	/*Weighing scores*/
	$score_bike_model = 6;
	$score_bike_model_keyword = 5;
	$score_made_by = 5;
	$score_made_by_keyword = 4;
	$score_full_content = 4;
	$score_content_keyword = 3;
	$score_spec_keyword = 2;
	$score_url_keyword = 1;

	/*Remove unnecessary words from the search term and return them as an array*/
	$query = trim(preg_replace("/(\s+)+/", " ", $query));
	$keywords = [];
	/*expand this list with your words.*/
	$list = ["in","it","a","the","of","or","I","you","he","me","us","they","she","to","but","that","this","those","then","by"];
	$c = 0;
	$separated_spaces = explode(" ", $query);
	if (count($separated_spaces) > 0){
		foreach($separated_spaces as $key){
			if (in_array($key, $list)) continue;
			$keywords[] = $key;
			if ($c >= 15) break;
			$c++;
		}
	}
	$escQuery = $ci->db->escape_like_str($query); /*see note above to get db object*/
	$titleSQL = [];
	$sumSQL = [];
	$docSQL = [];
	$categorySQL = [];
	$urlSQL = [];

	/** Matching full occurences **/ 
	$full_content = "CONCAT(REPLACE(b.feat_photo, 'assets/data/files/bikes/images/', ''),' ',b.fields_data,' ',b.price_tag)";
	if (count($keywords) > 1){
		$titleSQL[] = "IF(b.bike_model LIKE '%".$escQuery."%',{$score_bike_model},0)";
		// $sumSQL[] = "IF(b.made_by LIKE '%".$escQuery."%',{$score_made_by},0)";
		$docSQL[] = "IF($full_content LIKE '%".$escQuery."%',{$score_full_content},0)";
	}

	/** Matching Keywords **/
	if (count($keywords) > 0){
		foreach($keywords as $key){
			$titleSQL[] = "IF(b.bike_model LIKE '%".$ci->db->escape_like_str($key)."%',{$score_bike_model_keyword},0)";
			// $sumSQL[] = "IF(b.made_by LIKE '%".$ci->db->escape_like_str($key)."%',{$score_made_by_keyword},0)";
			$docSQL[] = "IF($full_content LIKE '%".$ci->db->escape_like_str($key)."%',{$score_content_keyword},0)";
			$urlSQL[] = "IF(b.external_link LIKE '%".$ci->db->escape_like_str($key)."%',{$score_url_keyword},0)";
			// $categorySQL[] = "IF(b.spec_from LIKE '%".$ci->db->escape_like_str($key)."%',{$score_spec_keyword},0)";
		}
	}

	/*Just incase it's empty, add 0*/
	if (empty($titleSQL)) $titleSQL[] = 0;
	// if (empty($sumSQL)) $sumSQL[] = 0;
	if (empty($docSQL)) $docSQL[] = 0;
	if (empty($urlSQL)) $urlSQL[] = 0;
	if (empty($tagSQL)) $tagSQL[] = 0;
	// if (empty($categorySQL)) $categorySQL[] = 0;

	$sql = "
	SELECT 
			u.store_name, CONCAT(b.id, '-', b.user_id, '/mtb/', REPLACE(LOWER(REPLACE(b.bike_model, ' ', '-')), '\'', ''), '-full-specifications') AS bike_url,
			b.*, ((".implode(' + ', $titleSQL).") + (".implode(' + ', $docSQL).") + (".implode(' + ', $urlSQL).")) as Relevance 
		FROM bike_items b 
		INNER JOIN users u ON u.id = b.user_id
		WHERE 1=1 $and_clause
	GROUP BY b.id 
		HAVING Relevance > 0 
	ORDER BY b.updated DESC";

	/*$sql = "
	SELECT 
			u.store_name, CONCAT(b.id, '-', b.user_id, '/mtb/', REPLACE(LOWER(REPLACE(b.bike_model, ' ', '-')), '\'', ''), '-full-specifications') AS bike_url,
			b.*, ((".implode(' + ', $titleSQL).") + (".implode(' + ', $sumSQL).") + (".implode(' + ', $docSQL).") + (".implode(' + ', $categorySQL).") + (".implode(' + ', $urlSQL).")) as Relevance 
		FROM bike_items b 
		INNER JOIN users u ON u.id = b.user_id
		WHERE 1=1 $and_clause
	GROUP BY b.id 
		HAVING Relevance > 0 
	ORDER BY b.updated DESC";*/

	// debug($sql, 1);
	$data = $ci->db->query($sql);

	if ($data->num_rows() > 0){
		return $data->result_array();
	}
	return [];
}

function clean_string_name($string=FALSE, $replaced=FALSE, $delimiter='')
{
	if ($string) {
		if ($replaced) {
			$string = preg_replace('/'.$delimiter.'/', $replaced, $string);
		} else {
			/*now replace space and underscores with the delimiter*/
			$string = preg_replace('/\s/', $delimiter, $string);
			$string = preg_replace('/_/', $delimiter, $string);
			/*clean all unnecessary symbols and characters*/
			$string = preg_replace('/[^a-z0-9\.-]/', '', strtolower($string));
			$string = preg_replace('/[()]/', '', strtolower($string));
			$string = preg_replace('/[+]/', '', strtolower($string));
		}
	}
	return $string;
}

function get_like_count($where=FALSE, $table='bike_items')
{
	$ci =& get_instance();
	if ($where) {
		$ci->load->model('custom_model');
		$data = $ci->custom_model->get($table, $where, 'like_count', 'row');
		return $data['like_count'];
	}
	return 0;
}

function curl_get_shares($url)
{
	$access_token = FBTOKEN;
	$api_url = 'https://graph.facebook.com/v6.0/?id=' . urlencode($url) . '&fields=engagement&access_token=' . $access_token;
	$fb_connect = curl_init(); // initializing
	curl_setopt($fb_connect, CURLOPT_URL, $api_url);
	curl_setopt($fb_connect, CURLOPT_RETURNTRANSFER, 1); // return the result, do not print
	curl_setopt($fb_connect, CURLOPT_TIMEOUT, 20);
	$json_return = curl_exec($fb_connect); // connect and get json data
	curl_close($fb_connect); // close connection
	
	return json_decode($json_return, TRUE);
}

function in_str($string='', $search='')
{
	return (bool)strstr($string, $search);
}

function current_full_url()
{
	$CI =& get_instance();
	$url = $CI->config->site_url($CI->uri->uri_string());
	// debug($url); debug($_SERVER); exit();
	if ($_SERVER['QUERY_STRING']) {
		$url .= $url.'?'.$_SERVER['QUERY_STRING'];
	}
	return $url;
}

function remove_in_str($string=FALSE, $remove='')
{
	if ($string) {
		return preg_replace('/'.$remove.'/', '', $string);
	}
}

function tinymce_upload($dir='', $filename='upload')
{
	/***************************************************
	* Only these origins are allowed to upload images *
	***************************************************/
	$accepted_origins = ["http://localhost", "http://local.mtbarena", "https://mtbarena.com"];
	/*********************************************
	* Change this line to set the upload folder *
	*********************************************/
	$imageFolderMain = "assets/data/files";
	$imageFolder = create_dirs($dir);
	// debug($imageFolder, 1);

	reset($_FILES);
	$temp = current($_FILES);
	if (is_uploaded_file($temp['tmp_name'])){
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			/*same-origin requests won't set an origin. If the origin is set, it must be valid.*/
			if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
				header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
			} else {
				header("HTTP/1.1 403 Origin Denied");
				return;
			}
		}

		/*
		If your script needs to receive cookies, set images_upload_credentials : true in
		the configuration and enable the following two headers.
		*/
		/*header('Access-Control-Allow-Credentials: true');*/
		/*header('P3P: CP="There is no P3P policy."');*/

		/*Sanitize input*/
		if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
			header("HTTP/1.1 400 Invalid file name.");
			return;
		}

		/*Verify extension*/
		if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), ["gif", "jpg", "png"])) {
			header("HTTP/1.1 400 Invalid extension.");
			return;
		}
		// $ext = strtolower(pathinfo(basename($temp['name']), PATHINFO_EXTENSION));

		/*Accept upload if there was no origin, or if it is an accepted origin*/
		$filetowrite = $imageFolder . $temp['name'];
		// $filetowrite = $imageFolder . $filename.'.'.$ext;
		@move_uploaded_file($temp['tmp_name'], $filetowrite);

		/*Respond to the successful upload with JSON.*/
		/*Use a location key to specify the path to the saved image resource.*/
		/*{ location : '/your/uploaded/image/file'}*/
		return json_encode(['location' => base_url($imageFolderMain.'/'.$dir.'/'.$temp['name'])]);
		// return json_encode(['location' => base_url($imageFolderMain.'/'.$dir.'/'.$filename.'.'.$ext)]);
	} else {
		/*Notify editor that the upload failed*/
		header("HTTP/1.1 500 Server Error");
	}
}

function calculate($data=FALSE, $mode=FALSE)
{
	$result = FALSE;
	if ($data AND $mode) {
		$data = (object)$data;
		switch (strtolower($mode)) {
			case 'frequency':
				$now = date('Y-m-d H:i:s');
				$added = $data->added;
				$version = $data->version;
				$timediff = strtotime($now) - strtotime($added);
				// Check how many revisions have been made over the lifetime of the Page for a rough estimate of it's changing frequency.
				$period = $timediff / ($version + 1);
				if ($period > 60 * 60 * 24 * 365) {
					$result = 'yearly';
				} elseif ($period > 60 * 60 * 24 * 30) {
					$result = 'monthly';
				} elseif ($period > 60 * 60 * 24 * 7) {
					$result = 'weekly';
				} elseif ($period > 60 * 60 * 24) {
					$result = 'daily';
				} elseif ($period > 60 * 60) {
					$result = 'hourly';
				} else {
					$result = 'always';
				}
				break;
			
			default: /**/
				# code...
				break;
		}
	}
	return $result;
}

function csv_to_array($filename='', $delimiter=',')
{
	if(!file_exists(get_root_path($filename)) OR !is_readable(get_root_path($filename))) {
		return FALSE;
	}
	$header = NULL;
	$data = array();
	if (($handle = fopen($filename, 'r')) !== FALSE) {
		while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
			if(!$header) {
				$header = $row;
			} else {
				$data[] = array_combine($header, $row);
			}
		}
		fclose($handle);
	}
	return $data;
}

function cookies($name=false, $method='get', $value=false, $expire=604800) /*for a week*/
{
	// https://codeigniter.com/user_guide/helpers/cookie_helper.html
	if ($name) {
		switch (strtolower($method)) {
			case 'set':
				if ($value) {
					set_cookie($name, $value, $expire);
					return true;
				}
				break;
			
			case 'delete':
				delete_cookie($name);
				return true;
				break;
			
			default:
				$cookie = get_cookie($name);
				if (!is_null($cookie)) {
					return $cookie;
				}
				break;
		}
	}
	return false;
}

function get_fullname($profile=false)
{
	$ci =& get_instance();
	if ($profile == false) $ci->profile;
	if ($profile) {
		if (isset($profile['user'])) {
			if (isset($profile['user']['last_name'])) {
				return $profile['user']['first_name'].' '.$profile['user']['last_name'];
			}
			return $profile['user']['first_name'];
		}
	}
	return false;
}

function is_farmer($profile=false)
{
	$ci =& get_instance();
	if ($profile == false) $ci->profile;
	if ($profile) {
		if (isset($profile['user'])) {
			if (isset($profile['user']['farmer']) AND (bool)$profile['user']['farmer']) {
				return true;
			}
		}
	}
	return false;
}

function is_url_var($name='', $value='')
{
	$set = ['', $value];
	if (isset($_GET[$name])) {
		if (!in_array($_GET[$name], $set)) {
			return false;
		}
	}
	return true;
}

function get_url_var($name='')
{
	if (isset($_GET[$name])) {
		return $_GET[$name];
	}
	return '';
}

function calculate_distance($distance=false)
{
	if ($distance) {
		return round(((float) $distance * 1.8) * 60, 1);
	}
	return 0;
}

function actual_estimate($secs=0)
{
	$estimated = '';
	if ($secs) {
		$gmdate = gmdate('H:i:s', $secs);
		$exploded = explode(':', $gmdate);
		
		$hours = $exploded[0] == '00' ? false : (int)$exploded[0];
		$minutes = $exploded[1] == '00' ? false : (int)$exploded[1];
		$seconds = $exploded[2] == '00' ? false : (int)$exploded[2];

		if ($hours) $estimated .= $hours . ' hr' . ($hours > 1 ? 's. ' : '. ');
		if ($minutes) $estimated .= $minutes . ' min' . ($minutes > 1 ? 's. ' : '. ');
		if ($seconds) $estimated .= $seconds . ' sec' . ($seconds > 1 ? 's. ' : '. ');

		if ($minutes < 4 AND $hours == false) $estimated = '5 mins';
	}
	return $estimated;
}

function has_get($name='')
{
	return isset($_GET[$name]);
}

function has_post($name='')
{
	return isset($_POST[$name]);
}

function get_form_data()
{
	$ci =& get_instance();
	return $ci->input->post() ? $ci->input->post() : ($ci->input->get() ? $ci->input->get() : FALSE);
}

function redirect_prev_url()
{
	$ci =& get_instance();
	if ($ci->session->userdata('prev_url')) {
		redirect($ci->session->userdata('prev_url'));
	}
	return false;
}

function getsave_prev_cart()
{
	$ci =& get_instance();
	$ci->cart->destroy();
	$check = ['device_id' => $ci->device_id];
	if ($ci->accounts->has_session) {
		$user = $ci->accounts->profile['user'];
		$check = ['user_id' => $user['id'], 'device_id' => $ci->device_id];
	}
	$carts = $ci->custom->get('cart', $check);
	// debug($carts AND empty($ci->cart->contents()), 1);
	if ($carts) {
		foreach ($carts as $key => $cart) {
			$data = unserialize($cart['data']);
			$ci->cart->insert($data);
		}
	}
	return $ci->cart->contents();
}

function construct($data=false, $type='', $selected=false, $field='id')
{
	$result = false;
	if ($data) {
		switch (strtolower($type)) {
			case 'dd':
				$set = [];
				foreach ($data as $key => $row) {
					$set[$row[$field]] = $row['label'];
				}
				$result = [
					'selected' => $selected,
					'select' => $set
				];
				break;

			case 'avdd':
				$result = [];
				// debug($data, 1);
				foreach ($data as $key => $row) {
					$result[$row[$field]] = [
						'name' => $row['name'],
						'label' => $row['label'],
						'type' => $row['type'],
						'value' => $row['value']
					];
				}
				break;

			case 'ddloc':
				$set = [];
				foreach ($data as $key => $row) {
					$set[$row[$field]] = $row['address'];
				}
				$result = [
					'selected' => $selected,
					'select' => $set
				];
				break;
		}
	}
	// debug($result, 1);
	return $result;
}

function active_menu($nums=0, $current='', $treeview=false)
{
	$ci =& get_instance();
	$is_active = false;
	if (is_array($nums)) {
		$current_links = explode('/', $current);
		foreach ($nums as $num) {
			if (in_array($ci->uri->segment($num), $current_links)) {
				$is_active = true;
			} else {
				$is_active = false;
			}
		}
	} else {
		$is_active = ($ci->uri->segment($nums) == $current);
	}
	if ($is_active) {
		if ($treeview) {
			echo 'menu-open';
		} else {
			echo 'active';
		}
	}
	echo '';
}

function check_app_settings($field='password', $post=false)
{
	$ci =& get_instance();
	$data = false;
	if ($post == false) {
		$post = $ci->input->post();
	}
	if ($post) {
		$post = array_merge($post, ['name' => $field, 'user_id' => $ci->accounts->profile['user']['id']]);
		$data = $ci->custom->get('user_app_settings', $post, 'value', 'row');
	}
	// debug($data, 1);
	return $data;
}

function get_data_and_construct($table=false, $field='id', $type='dd', $selected=false)
{
	$ci =& get_instance();
	if ($table) {
		$data = $ci->custom->get($table);
		if ($data) {
			return construct($data, $type, $selected, $field);
		}
	}
	return false;
}

function check_file_and_render($file=false, $replace=false)
{
	$exists = false;
	if ($file) {
		$doc = get_root_path($file);
		$exists = file_exists($doc);
		// debug($exists, 1);
	}
	if ($exists == false) {
		if ($replace) {
			echo 'http://placehold.it/'.$replace;
		} else {
			echo 'http://placehold.it/800X600?text=Image';
		}
	} else {
		echo $file;
	}
}

function get_geolocation($latlng_only=true) {
	$data = unserialize(@file_get_contents('http://www.geoplugin.net/php.gp'));
	// debug($data, 1);
	if ($data) {
		if ($latlng_only) {
			return [
				'lat' => $data['geoplugin_latitude'],
				'lng' => $data['geoplugin_longitude'],
			];
		} else {
			return [
				'ip' => $data['geoplugin_request'],
				'lat' => $data['geoplugin_latitude'],
				'lng' => $data['geoplugin_longitude'],
				'tz' => $data['geoplugin_timezone'],
				'unit' => $data['geoplugin_currencySymbol'],
				'date' => date('Y-m-d'),
			];
		}
	}
	return false;
}

function nearest_locations($data=false, $limit=false, $distance=100, $unit='km')
{
	if ($data AND isset($data['latlng'])) {
		$ci =& get_instance();
		$position = $data['latlng'];

		$and_clause = "";
		if ($ci->accounts->has_session AND $ci->accounts->profile['user']['farmer']) {
			// $and_clause = " AND user.id != '".$ci->accounts->profile['user']['id']."'";
		}

		if ($unit == 'km') {
			$sql = "SELECT * FROM (
				SELECT user_location.*, 
					(
						(
							(
								acos(
									sin(( ".$position['lat']." * pi() / 180))
									*
									sin(( user_location.lat * pi() / 180)) + cos(( ".$position['lat']." * pi() /180 ))
									*
									cos(( user_location.lat * pi() / 180)) * cos((( ".$position['lng']." - user_location.lng) * pi()/180)))
							) * 180/pi()
						) * 60 * 1.1515 * 1.609344
					) AS distance, 'km' AS unit 
				 FROM `user_location`
				INNER JOIN user ON user_location.user_id = user.id
				WHERE user.farmer = 1 ".$and_clause."
			) user_location";
		} else {
			$sql = "SELECT * FROM (
				SELECT user_location.*, 
					(
						(
							(
								acos(
									sin(( ".$position['lat']." * pi() / 180))
									*
									sin(( user_location.lat * pi() / 180)) + cos(( ".$position['lat']." * pi() /180 ))
									*
									cos(( user_location.lat * pi() / 180)) * cos((( ".$position['lng']." - user_location.lng) * pi()/180)))
							) * 180/pi()
						) * 60 * 1.1515
					) AS distance, 'mi' AS unit 
				 FROM `user_location`
				INNER JOIN user ON user_location.user_id = user.id
				WHERE user.farmer = 1 ".$and_clause."
			) user_location";
		}

		$extends = $sql." WHERE distance <= ".$distance." ORDER BY user_location.id";

		if ($limit) {
			$extends .= " LIMIT $limit";
		}
		// debug($extends, 1);
		$record = $ci->db->query($extends);
		if ($record->num_rows()) {
			$record = $record->result_array();
			// debug($record);
			if ($ci->input->is_ajax_request()) {
				echo json_encode($record); exit();
			} else {
				return $record;
			}
		}
	}
	return false;
}

function cart_session($function=false, $params=false)
{
	$ci =& get_instance();
	if ($function) {
		if ($function == 'count') {
			return count($ci->cart->contents($params));
		} else {
			if ($params) {
				return $ci->cart->{$function}($params);
			} else {
				return $ci->cart->{$function}();
			}
		}
	}
	return $ci->cart->contents($params);
}

function construct_paypal($data=FALSE, $paypal_api=FALSE, $user=FALSE)
{
	if ($data AND $paypal_api AND $user) {
		$user = (array)$user;
		$post = array( 
			'method' => 'SinglePayment',
			'data' => array(
				'payment_method' => 'paypal', // credit_card or paypal by default
				'items' => [
					[
						'sku' => $data['sku'], // 'Customed-1000',
						'name' => $data['name'], // 'Customed Service | 1K Metered Payload for Php 1000',
						'price' => $data['price'], // 1000,
						'quantity' => $data['quantity'], // 1
					]
				],
				/*if there are other details you want to set like shipping_fee, tax or subtotal*/
				'details' => [
					'shipping_fee' => 0,
					'tax' => 0,
					'subtotal' => 0 // pre computed by default
				],
				'currency' => $data['currency'], // 'PHP',
				'payment_description' => 'Realtime data transmission Service',
				'invoice_number' => $data['invoice_number'],
				'return_url' => base_url('accounts/payment_url?success=true&id='.$user['id'].'&number='.$data['invoice_number']),
				'cancel_url' => base_url('accounts/payment_url?success=false&id='.$user['id'].'&number='.$data['invoice_number'])
			)
		);
		if (isset($data['urls'])) {
			$post['data']['return_url'] = $data['urls']['return'];
			$post['data']['cancel_url'] = $data['urls']['cancel'];
		}
		// debug($post); exit();
		$paypal_api->submit($post);
		// debug($paypal_api->fetch()); exit();
		$result = $paypal_api->fetch();
		if ($result->output->errors['success']) {
			return $result;
		}
	}

	return FALSE;
}

function generate_invoice($user=FALSE)
{
	$ci =& get_instance();
	if ($user) {
		$user = (array)$user;
	} else {
		if ($ci->accounts->has_session) {
			$user = $ci->accounts->profile['user'];
		} else {
			$user = ['id'=>GACELABS_SUPER_KEY, 'email_address'=>GACELABS_KEY];
		}
	}

	$number = INVOICE_PREFIX.'-'.strtoupper(substr(md5($user['id'].$user['email_address'].'|'.time()), 0, 5).'-'.str_pad(rand(1, 10), 2, '0', STR_PAD_LEFT));
	$data = $ci->db->get_where('invoices', ['number' => $number]);
	// debug($data->num_rows(), 1);
	if ($data->num_rows() == 0) {
		$ci->custom->create('invoices', ['number'=>$number, 'email'=>$user['email_address']]);
		return $number;
	} else {
		return generate_invoice($user);
	}
}

function driving_time_distance($lat1, $lat2, $long1, $long2)
{
	$url = "https://maps.googleapis.com/maps/api/distancematrix/json?key=AIzaSyBbNbxnm4HQLyFO4FkUOpam3Im14wWY0MA&origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=en-EN";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);
	curl_close($ch);
	
	$response_a = json_decode($response, true);
	$dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
	$time = $response_a['rows'][0]['elements'][0]['duration']['text'];

	return array('distance' => $dist, 'time' => $time);
}

function products_by_location($products=false, $location=false, $data=false)
{
	if ($products AND $location) {
		$ci =& get_instance();
		$user_location = $ci->custom->get('user_location', ['id'=>$location['id']], false, 'row');
		unset($user_location['created']); unset($user_location['last_updated']);

		foreach ($products as $key => $row) {
			$product = $ci->custom->get('product', ['id'=>$row['product_id']], false, 'row');
			if ($product) {
				unset($product['created']); unset($product['last_updated']);
				unset($product['location_id']);

				$product['farm_name'] = $user_location['farm_name'];
				$product['address'] = $user_location['address'];
				$product['distance'] = $location['distance'];
				$product['unit'] = $location['unit'];
				$product['lat'] = $location['lat'];
				$product['lng'] = $location['lng'];

				$category = $ci->custom->get('product_category', ['id'=>$product['category_id']], false, 'row');
				unset($category['created']); unset($category['last_updated']);
				$product['category'] = $category['label'];
				unset($product['category_id']);

				$activity = $ci->custom->get('activity', ['id'=>$product['activity_id']], false, 'row');
				unset($activity['created']); unset($activity['last_updated']);
				$product['activity'] = $activity['label'];
				unset($product['activity_id']);

				$product_photo = $ci->custom->get('product_photo', ['product_id'=>$product['id'], 'is_main'=>1], false, 'row');
				unset($product_photo['created']); unset($product_photo['last_updated']);
				$product['photo'] = $product_photo['path'];

				$product_photos = $ci->custom->get('product_photo', ['product_id'=>$product['id'], 'is_main'=>0]);
				unset($product_photos['created']); unset($product_photos['last_updated']);
				// debug($product_photos, 1);
				$product['photos'] = [];
				if ($product_photos) {
					foreach ($product_photos as $key => $photo) {
						$product['photos'][] = $photo['path'];
					}
				}

				$data[] = $product;
			}
		}
		// debug($data, 1);
	}
	return $data;
}

function get_update_marketplace($latlng=false)
{
	$veggies_position = $farmers_position = false;
	if ($latlng) {
		$ci =& get_instance();
		$data = nearest_locations(['latlng' => $latlng], 10);
		// debug($data, 1);
		if ($data) {
			$veggies_position = $farmers_position = $distances = [];
			foreach ($data as $loc) $distances[$loc['user_id']][] = $loc['distance'];
			foreach ($data as $key => $loc) {
				unset($loc['created']); unset($loc['last_updated']);
				/*veggies*/
				$products = $ci->custom->get('product_location', ['location_id'=>$loc['id']]);
				$veggies_position = products_by_location($products, $loc, $veggies_position);
				/*farmers*/
				$users = $ci->db->join('user_location', 'user_location.user_id = user.id', 'left')
					->select('user.*, "'.$loc['distance'].'" AS distance, "'.$loc['unit'].'" AS unit, user_location.farm_name, user_location.address')
					->get_where('user', ['user_location.user_id'=>$loc['user_id'], 'user_location.id'=>$loc['id']]);
				if ($users->num_rows()) {
					// debug($users->result_array(), 1);
					foreach ($users->result_array() as $key => $user) {
						$farmers_position[] = $user;
					}
				}
				/*orders*/
				/*$orders = $ci->db->join('product_location', 'product_location.user_id = user.id', 'left')
					->select('order.*, "'.$loc['distance'].'" AS distance, "'.$loc['unit'].'" AS unit, product_location.farm_name, product_location.address')
					->get_where('order', ['order.user_id'=>$loc['user_id'], 'product_location.id'=>$loc['id']]);*/
			}
		}
	}
	$ci->session->set_userdata('near_veggies', $veggies_position);
	// debug($veggies_position, 1);
	$ci->session->set_userdata('near_farmers', $farmers_position);
	// debug($farmers_position, 1);
	return [
		'veggies_position' => $veggies_position,
		'farmers_position' => $farmers_position
	];
}

function format_date($date=false)
{
	if ($date) {
		return date('F j, Y | g:i:s a', strtotime($date));
	}
	return false;
}

function get_categories()
{
	$ci =& get_instance();
	$categories = $ci->custom->get('product_category');
	return $categories;
}

function get_data_table($table=false, $field='id', $value=false, $row='row')
{
	$ci =& get_instance();
	if ($table) {
		if ($value) {
			$data = $ci->custom->get($table, [$field => $value], false, $row);
		} else {
			$data = $ci->custom->get($table);
		}
		return $data;
	}
	return false;
}

function write_data_file($content='', $dir='prints')
{
	create_dirs($dir);
	// Write the contents back to the file
	@file_put_contents('assets/data/files/prints/print.html', $content);
	return 'assets/data/files/prints/print.html';
}