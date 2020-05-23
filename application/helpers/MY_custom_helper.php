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

function files_upload($_files=FALSE, $return_path=FALSE, $dir='', $this_name=FALSE) {
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
					if ($_files[$input]['error'][$key] == 0) {
						$ext = strtolower(pathinfo(basename($name), PATHINFO_EXTENSION));
						if ($this_name) {
							$pathname = clean_string_name($this_name).'.'.$ext;
						} else {
							$pathname = basename($name);
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
							'status' => $status
						];
					}
				}
			} else {
				if ($_files[$input]['error'] == 0) {
					$ext = strtolower(pathinfo(basename($_files[$input]['name']), PATHINFO_EXTENSION));
					if ($this_name) {
						$pathname = clean_string_name($this_name).'.'.$ext;
					} else {
						$pathname = basename($_files[$input]['name']);
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
						'status' => $status
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
		// debug($folder_chunks);
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

function construct_where($id_post_id=FALSE, $table_or_alias='') {
	// debug($id_post_id);
	if ($id_post_id) {
		$data = explode('-', $id_post_id);
		// debug($data, 1);
		if (count($data) == 2) {
			return $table_or_alias.'id = '.$data[0].' AND '.$table_or_alias.'user_id = '.$data[1];
		} elseif (count($data) == 1) {
			return $table_or_alias.'id = '.$data[0];
		}
	}
	return FALSE;
}

function fix_title($title=FALSE) {
	if ($title) {
		return ucwords(preg_replace('/[-]/', ' ', $title));
	}
	return '';
}

function bike_search($query='', $and_clause='')
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

function clean_string_name($string=FALSE, $replaced=FALSE, $delimiter='-')
{
	if ($string) {
		/*now replace space and underscores with the delimiter*/
		$string = preg_replace('/\s/', $delimiter, $string);
		$string = preg_replace('/_/', $delimiter, $string);
		/*clean all unnecessary symbols and characters*/
		$string = preg_replace('/[^a-z0-9\.-]/', '', strtolower($string));
		$string = preg_replace('/[()]/', '', strtolower($string));
		$string = preg_replace('/[+]/', '', strtolower($string));
		if ($replaced) {
			$string = preg_replace('/'.$delimiter.'/', $replaced, $string);
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

function is_url_parsable()
{
	return (in_str(current_full_url(), '_') OR in_str(current_full_url(), '~')) AND in_str(current_full_url(), ':');
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

function parse_mtb_query($uri=FALSE)
{
	$parsed = [];
	if ($uri) {
		$separate = explode(':', $uri);
		foreach ($separate as $key => $string) {
			$col_val = explode('_', $string);
			$num = $col_val[0][strlen($col_val[0])-1];
			$column = is_numeric($num) ? remove_in_str($col_val[0], $num).'_'.$num : $col_val[0];
			$value = $col_val[1];
			if (!isset($parsed[$column])) {
				$parsed[$column] = get_col_val($value);
			} else {
				if (is_array($parsed[$column])) {
					$parsed[$column][] = get_col_val($value);
				} else {
					$parsed[$column] = [$parsed[$column]];
					$parsed[$column][] = get_col_val($value);
				}
			}
		}
		// debug($parsed, 1);
	}
	return $parsed;
}

function remove_in_str($string=FALSE, $remove='')
{
	if ($string) {
		return preg_replace('/'.$remove.'/', '', $string);
	}
}

function get_col_val($string=FALSE, $delimiter='~')
{
	$parsed = $string;
	if ($string AND in_str($string, $delimiter)) {
		$parsed = [];
		$col_val = explode($delimiter, $string);
		// debug($col_val, 1);
		$column = $col_val[0];
		$value = $col_val[1];
		if (!isset($parsed[$column])) {
			$parsed[$column] = $value;
		} else {
			if (is_array($parsed[$column])) {
				$parsed[$column][] = $value;
			} else {
				$parsed[$column] = [$parsed[$column]];
				$parsed[$column][] = $value;
			}
		}
	}
	return $parsed;
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

function manipulate_bike_display_data($items_data=FALSE, $id=FALSE, $table=FALSE)
{
	if ($items_data) {
		$ci =& get_instance();
		$ci->load->model('custom_model');
		// debug($items_data, 1);

		$bike_items = [];
		foreach ($items_data as $key => $bike) {
			foreach ($bike as $field => $data) {
				if (in_array($field, ['id','user_id','bike_model','feat_photo','view_count','share_count','like_count','added','updated','version','store_name','bike_url'])) {
					if (in_array($field, ['id','view_count','share_count','like_count'])) {
						if ($field == 'id') {
							$bike_items['other']['id'] = $id;
							$bike_items['other']['table'] = $table;
							$bike_items['other']['bike_ids'][] = $data;
							$bike_items['info'][$key]['id'] = $data;
						} else {
							if ($id) {
								$data = $ci->custom_model->get($table, ['id'=>$id], $field, 'row');
								$data = $data[$field];
							}
							$bike_items['other'][$field] = $data;
						}
					} else {
						$bike_items['info'][$key][$field] = $data;
					}
				} else {
					if ($field == 'fields_data') {
						if (!is_array($data)) $data = json_decode($data, TRUE);
						// debug($data, 1);
						if ($data) {
							foreach ($data as $base => $row) {
								foreach ($row as $column => $json) {
									$mapped = [];
									$parsed = $json;
									if (!is_array($json)) $parsed = json_decode($json, TRUE);
									if ($parsed) {
										foreach ($parsed as $idx => $tags) $mapped[] = $tags['value'];
									}
									$bike_items['fields'][$base][$column][$key] = count($mapped) ? implode(', ', $mapped) : 'Unspecified';
								}
							}
						}
					} else {
						$bike_items['fields'][str_replace('_', ' ', $field)][$key] = $data;
					}
				}
			}
		}
		// debug($bike_items, 1);
		$bike_items['table'] = $table;
		return $bike_items;
	}
	return FALSE;
}

function check_and_save_matchup($items_data=FALSE)
{
	if ($items_data) {
		$ci =& get_instance();
		$today = date('Y-m-d');
		$ci->load->model('custom_model');
		$ids = [];
		foreach ($items_data as $key => $row) {
			$ids[] = $row['id'];
		}
		// debug($ids, 1);
		// $data = $ci->custom_model->get('match_ups', ['bike_data' => $json, 'today' => $today], FALSE, 'row');
		if (isset($ids[1])) {
			$bike_data_1 = json_encode(['id'=>[$ids[0], $ids[1]]]);
			$bike_data_2 = json_encode(['id'=>[$ids[1], $ids[0]]]);
			$data = $ci->custom_model->get('match_ups', "(bike_data = '$bike_data_1' OR bike_data = '$bike_data_2')", FALSE, 'row');
			$json = $bike_data_1;
		} else {
			$bike_data = json_encode(['id'=>[$ids[0]]]);
			$data = $ci->custom_model->get('match_ups', "bike_data = '$bike_data'", FALSE, 'row');
			$json = $bike_data;
		}

		if ($data == FALSE) {
			$id = $ci->custom_model->new('match_ups', ['bike_data' => $json, 'today' => $today]);
			return ['id' => $id, 'table' => 'match_ups'];
		} else {
			$data = $ci->custom_model->get('match_ups', "today = '".$today."'", FALSE, 'row');
			// debug($data == FALSE, 1);
			if ($data == FALSE) {
				/*get random compares*/
				$ci->db->order_by('id', 'RANDOM');
				$ci->db->limit(1);
				$query = $ci->db->get('compares');
				$data = $query->row_array();
				if ($query->num_rows()) {
					$items_data = $ci->custom_model->compared_bikes(['id'=>$data['id']]);
					return check_and_save_matchup($items_data);
				}
			}
			return ['id' => $data['id'], 'table' => 'match_ups'];
		}
	}
}

function assemble_fields_data($data=FALSE)
{
	if ($data) {
		// debug($data, 1);
		$result = [];
		$ci =& get_instance();
		$ci->load->model('custom_model');

		foreach ($data as $base => $fields) {
			$field_data = $ci->custom_model->get('fields_data', ['base' => $base], FALSE, 'row');
			// debug($fields, 1);
			$field_data['values'] = json_decode($field_data['values'], TRUE);
			// debug($field_data);
			if (is_array($field_data['values'])) {
				foreach ($fields as $column => $values) {
				// debug(array_values($values));
					foreach ($field_data['values'] as $key => $row) {
						if ($row['column'] === $column AND is_array($values)) {
							$column_values = strlen(trim($row['data'])) ? explode(',', $row['data']) : [];
							foreach ($values as $index => $input) {
								if (!in_array($input['value'], $column_values)) {
									$column_values[] = $input['value'];
								}
							}
							$field_data['values'][$key]['data'] = implode(',', $column_values);
						}
					}
				}
				if (!isset($field_data['path'])) {
					$field_data['path'] = "assets/data/jsons/spec_template/".clean_string_name($base).".json";
				}
				unset($field_data['added']);
				unset($field_data['updated']);
				$result[] = $field_data;
			}
			// debug($field_data, 1);
		}
		// debug(['fields_data' => $result], 1);
		return ['fields_data' => $result];
	}
	return FALSE;
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

function get_shortcode_values($data=FALSE)
{
	if ($data) {
		preg_match_all('/\[(.*?)\]/', $data, $matches);
		if (isset($matches[1])) {
			$ci =& get_instance();
			$ci->load->model('custom_model');

			$values = $matches[1];
			$tags = $methods = $queries = [];
			foreach ($values as $key => $value) {
				$tags[$key] = explode('|', $value);
			}
			foreach ($tags as $key => $tag) {
				foreach ($tag as $index => $row) {
					$conditions = explode('=', $row);
					$methods[$key][$conditions[0]] = str_replace('"', '', $conditions[1]);
				}
			}
			// debug($methods);
			foreach ($methods as $key => $method) {
				if (isset($method['data'])) {
					switch (strtolower($method['data'])) {
						case 'compare': case 'bike':
							$queries[$key]['field'] = 'bike_model';
							$queries[$key]['table'] = 'bike_items';
							break;
						case 'profile':
							$queries[$key]['field'] = 'store_name';
							$queries[$key]['table'] = 'users';
							break;
					}
					if (isset($method['search'])) {
						switch (strtolower($method['data'])) {
							case 'compare':
								$ci->db->like('bike_model', $method['search']);
								$items = $ci->db->get('bike_items');
								if ($items->num_rows()) {
									$bike_items = $items->result_array();
									$queries[$key]['where'] = '';
									$ids = [];
									foreach ($bike_items as $bike) $ids[] = $bike['id'];
									$queries[$key]['where'] .= "id IN (".implode(',', $ids).")";
								}
								break;
							case 'bike':
								$queries[$key]['where'] = "bike_model = '".$method['search']."'";
								break;
							case 'profile':
								$queries[$key]['where'] = "store_name LIKE '%".$method['search']."%'";
								break;
						}
					}
					if (isset($method['limit']) AND (is_numeric($method['limit']) AND $method['limit'])) {
						$queries[$key]['limit'] = ' LIMIT '.$method['limit'];
					}
					if (isset($method['style']) AND strlen(trim($method['style']))) {
						$queries[$key]['class'] = trim($method['style']);
					}
				}
			}
			// debug($queries);
			$statements = [];
			foreach ($queries as $key => $query) {
				if (isset($query['where'])) {
					$string = "SELECT ".$query['field']." FROM ".$query['table']." WHERE ".$query['where'];
				} else {
					$string = "SELECT ".$query['field']." FROM ".$query['table'];
				}
				if (isset($query['limit'])) {
					$string .= $query['limit'];
				}
				$code_data = $ci->custom_model->query($string);
				// debug($code_data);
				if ($code_data) {
					$statements[$key] = '';
					foreach ($code_data as $index => $code) {
						if (isset($query['class'])) {
							$statements[$key] .= '<span class="sc-'.$query['class'].'">'.$code[$query['field']].'</span>&nbsp;';
						} else {
							$statements[$key] .= '<span class="sc-default">'.$code[$query['field']].'</span>&nbsp;';
						}
					}
				}
			}
			// debug($matches[0]);
			foreach ($matches[0] as $key => $value) {
				$data = str_replace($value, $statements[$key], $data);
			}
			// debug($data);
			// debug($statements, 1);
		}
	}
	return $data;
}

function whats_the_day($in='tomorrow')
{
	$datetime = new DateTime($in);
	return $datetime->format('Y-m-d');
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

function has_get($name='')
{
	return isset($_GET[$name]);
}

function has_post($name='')
{
	return isset($_POST[$name]);
}

function construct($data=false, $type='', $selected=false)
{
	$result = false;
	if ($data) {
		switch (strtolower($type)) {
			case 'dd':
				$set = [];
				foreach ($data as $key => $row) {
					$set[$row['id']] = $row['label'];
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
					$result[$row['id']] = [
						'name' => $row['name'],
						'label' => $row['label'],
						'checkbox' => $row['is_toggler'],
						'value' => $row['value']
					];
				}
				break;
		}
	}
	return $result;
}