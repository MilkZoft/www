<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Users_Model extends ZP_Model {

	public function __construct() {
		$this->Db = $this->db();
		
		$this->config("email");
		
		$this->Email = $this->core("Email");

		$this->Email->setLibrary(_wEmailLibrary);
		
		$this->Email->fromName  = _webName;
		$this->Email->fromEmail = _webEmailSend;
		
		$this->helpers();

		$this->Data = $this->core("Data");

		$this->table = "users";
	}
	
	public function cpanel($action, $limit = NULL, $order = "Language DESC", $search = NULL, $field = NULL, $trash = FALSE) {
		if($action === "edit" or $action === "save") {
			$validation = $this->editOrSave();
			
			if($validation) {
				return $validation;
			}
		}
		
		if($action === "all") {
			return $this->all($trash, $order, $limit);
		} elseif($action === "edit") {
			return $this->edit();															
		} elseif($action === "save") {
			return $this->save();
		} elseif($action === "search") {
			return $this->search($search, $field);
		}
	}
	
	private function all($trash, $order, $limit) {
		if(!$trash) {
			if(SESSION("ZanUserPrivilege") === _super) {
				$data = $this->Db->findBySQL("Situation != 'Deleted'", $this->table, NULL, $order, $limit);
			} else {
				$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanuserID") ."' AND Situation != 'Deleted'", $this->table, NULL, $order, $limit);
			}	
		} else {
			if(SESSION("ZanUserPrivilege") === _super) {
				$data = $this->Db->findBy("Situation", "Deleted", $this->table, NULL, $order, $limit);
			} else {
				$data = $this->Db->findBySQL("ID_User = '". SESSION("ZanAdminID") ."' AND Situation = 'Deleted'", $this->table, NULL, $order, $limit);
			}
		}
		
		return $data;	
	}
	
	private function editOrSave() {
		$validations = array(
			"username" => "required",
			"email"	   => "email?",
			"pwd"	   => "equals:". POST("pwd")
		);
		
		$data = array(
			"Pwd"		 => encrypt(POST("pwd")),
			"Start_Date" => now(4),
			"Code"		 => code(),
		);

		$this->Data->ignore(array("pwd", "pwd2"));

		$this->data = $this->Data->proccess($data, $validations);
		
	}
	
	private function save() {
		if(strlen($this->pwd2) < 6) {
			return getAlert("Invalid password");
		}
		
		$data = $this->Db->call("setUser('$this->username', '$this->pwd', '$this->email', '$this->date', '$this->code', '$this->Situation', $this->privilege)");
		
		if(isset($data[0]["Email_Exists"])) {
			return getAlert("This user already exists");
		} elseif(isset($data[0]["Username_Exists"])) {
			return getAlert("This user already exists");
		}
		
		return getAlert("The user has been saved correctly", "success");
	}
	
	private function edit() {
		if(strlen($this->pwd2) > 0 and strlen($this->pwd2) < 6) {
			return getAlert("Invalid password");
		}
		
		$data = $this->Db->call("updateUser($this->ID, '$this->username', '$this->pwd', '$this->email', '$this->status', $this->privilege)");
		
		if(isset($data[0]["Email_Exists"])) {
			return getAlert("This user already exists");
		} elseif(isset($data[0]["Username_Exists"])) {
			return getAlert("This user already exists");
		} elseif(isset($data[0]["User_Not_Exists"])) {
			return getAlert("This user not exists");
		}
		
		return getAlert("The user has been edit correctly", "success");
	}
	
	public function activate($code) {
		$this->Db->table($this->table);
		$data = $this->Db->findBySQL("Code = '$code' AND Situation = 'Inactive'");
		
		if($data) {
			$this->Db->values("Situation = 'Active'");
			$this->Db->save($data[0]["ID_User"]);

			return $data;			
		} else {
			$actived = $this->Db->findBySQL("Code = '$code' AND Situation = 'Active'");
			if($actived) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
	
	public function change() {
		if(POST("change")) {
			$tokenID   = POST("tokenID");
			$password1 = POST("password1", "decode-encrypt");
			$password2 = POST("password2", "decode-encrypt");
			
			if(POST("password1") === "" or POST("password2") === "") {
				return getAlert("You need to write the two passwords");
			} elseif(strlen(POST("password1")) < 6 or strlen(POST("password2")) < 6) {
				return getAlert("Your password must contain at least 6 characters");
			} elseif($password1 === $password2) {
				$this->Db->table("tokens");
				
				$data = $this->Db->find($tokenID);

				$this->Db->values("Situation = 'Inactive'");
				$this->Db->save($data[0]["ID_Token"]);
					
				if(!$data) {
					showAlert("Invalid Token");
				} else {		
					$this->Db->table("users");
					
					$this->Db->values("Pwd = '$password1'");
					$this->Db->save($data[0]["ID_User"]);
					
					showAlert("Your password has been changed successfully!", _webBase);
				}
			} else {
				return getAlert("The two passwords do not match");
			}
		} else {
			redirect(_webBase);
		}
	}
	
	public function isAdmin($sessions = FALSE) {
		if($sessions) {		
			$username = SESSION("ZanUser");
			$password = SESSION("ZanUserPwd");	
		} else {			
			$username = POST("username");
			$password = POST("password", "encrypt");
		}
		
		$this->Db->table($this->table);
	
		$data = $this->Db->findBySQL("Username = '$username' AND Pwd = '$password' AND Privilege != 'Member'");
		
		if($data) {
			return TRUE;
		} else {		
			return FALSE;
		}	
	}
	
	public function isMember($sessions = FALSE) {
		if($sessions) {		
			$username = SESSION("ZanUser");
			$password = SESSION("ZanUserPwd");						
		} else {			
			$username = POST("username");
			$password = POST("password", "encrypt");
		}
		
		$this->Db->table($this->table);
		
		$data = $this->Db->findBySQL("Username = '$username' AND Pwd = '$password' AND Situation = 'Active'");
		
		if($data) {
			return TRUE;
		}
		
		return FALSE;
	}
	
	public function getUserData($sessions = FALSE) {		
		if($sessions) {		
			$username = SESSION("ZanUser");
			$password = SESSION("ZanUserPwd");						
		} else {			
			$username = POST("username");
			$password = POST("password", "encrypt");
		}
		
		$this->Db->table($this->table);
		
		$data = $this->Db->findBySQL("Username = '$username' AND Pwd = '$password' AND Situation = 'Active'");	
		
		$user = FALSE;
		
		if($data) {
			$user[0]["ID_User"]  = $data[0]["ID_User"];
			$user[0]["Username"] = $data[0]["Username"];
			$user[0]["Password"] = $data[0]["Pwd"];
			$user[0]["God"]	     = $data[0]["God"];
			
			$this->Db->table("re_privileges_users", "ID_Privilege, ID_User");
			
			$data = $this->Db->findBy("ID_User", $user[0]["ID_User"]);
			 
			if($data) {	
				$this->Db->table("privileges", "ID_Privilege, Privilege");
				
				$data = $this->Db->find($data[0]["ID_Privilege"]);
			
				$user[0]["ID_Privilege"] = $data[0]["ID_Privilege"];
				$user[0]["Privilege"]    = $data[0]["Privilege"];
			} else {
				return FALSE;
			}
		}
			
		return $user;
	}
	
	public function isAllow($permission = "view", $application = NULL) {			
		if(SESSION("ZanUserPrivilegeID") and !SESSION("ZanUserApplication")) {	
			$this->Applications_Model = $this->model("Applications_Model");
			
			if(is_null($application)) {
				$application = whichApplication();		
			}
			
			$privilegeID   = SESSION("ZanUserPrivilegeID");
			$applicationID = $this->Applications_Model->getID($application);
			
			if($this->getPermissions($privilegeID, $applicationID, $permission)) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return TRUE;
		}
	}
	
	public function getPermissions($ID_Privilege, $ID_Application, $permission) {
		$this->Db->table("re_permissions_privileges", "Adding, Deleting, Editing, Viewing");	
		
		$data = $this->Db->findBySQL("ID_Privilege = '$ID_Privilege' AND ID_Application = '$ID_Application'");

		if($permission === "add") { 
			return ($data[0]["Adding"]) ? TRUE : FALSE;
		} elseif($permission === "delete") {
			return ($data[0]["Deleting"]) ? TRUE : FALSE;
		} elseif($permission === "edit") {
			return ($data[0]["Editing"]) ? TRUE : FALSE;
		} elseif($permission === "view") {
			return ($data[0]["Viewing"]) ? TRUE : FALSE;
		}
	}
	
	public function recover() {
		$helpers = array("alerts", "time", "validations");
		
		$this->helper($helpers);		
		
		if(POST("recover")) {
			$username = POST("username");
			$email	  = POST("email");
			
			if($username or isEmail($email)) {
				if($username) {
					$this->Db->table($this->table);
					
					$data = $this->Db->findBy("Username", $username);
				
					if(!$data) {
						return getAlert("This user does not exists in our database");
					} else {
						$userID    = $data[0]["ID_User"];
						$token     = encrypt(code());
						$startDate = now(4);
						$endDate   = $startDate + 86400;
						
						$this->Db->table("tokens");
						
						$data = $this->Db->findBySQL("ID_User = '$userID' AND Action = 'Recover' AND Situation = 'Active'");
						
						if(!$data) {
							$this->Db->table("tokens", "ID_User, Token, Start_Date, End_Date");
							$this->Db->values("'$userID', '$token', '$startDate', '$endDate'");							
							$this->Db->save();
							
							$this->Email->email		= $email;
							$this->Email->subject	= __("Recover Password") . " - " . _webName;
							$this->Email->message	= 	'
														<p>To recover your password, you need to access here.</p>
														<p>You need access to this link: <a href="' . _webBase . '/' . _webLang . '/users/recover/' . $token . '">Recover Password</a></p>
														';
							$this->Email->send();							
						} else {
							return getAlert("You can not apply for two password resets in less than 24 hours");
						}
					}
				} elseif(isEmail($email)) {
					$this->Db->table($this->table);
					
					$data = $this->Db->findBy("Email", $email);
					
					if(!$data) {
						return getAlert("This e-mail does not exists in our database");
					} else {
						$userID    = $data[0]["ID_User"];
						$token     = encrypt(code());
						$startDate = now(4);
						$endDate   = $startDate + 86400;
						
						$this->Db->table("tokens");
						
						$data = $this->Db->findBySQL("ID_User = '$userID' AND Action = 'Recover' AND Situation = 'Active'");
						
						if(!$data) {
							$this->Db->table("tokens", "ID_User, Token, Start_Date, End_Date");
							$this->Db->values("'$userID', '$token', '$startDate', '$endDate'");							
							$this->Db->save();
							
							$this->Email->email		= $email;
							$this->Email->subject	= __("Recover Password") . " - " . _webName;
							$this->Email->message	= 	'
														<p>To recover your password, you need to access here.</p>
														<p>You need access to this link: <a href="' . _webBase . '/' . _webLang . '/users/recover/' . $token . '">Recover Password</a></p>
														';
							$this->Email->send();							
						} else {
							return getAlert("You can not apply for two password resets in less than 24 hours");
						}
					}					
				}
				
				return getAlert("We will send you an e-mail so you can recover your password", "Success");
			} else {
				return getAlert("You must enter a username or e-mail at least");					
			}					
		} else {
			return FALSE;
		}
	}
	
	public function setUser($mode = FALSE) {		
		$helpers = array("alerts", "time", "validations");
		
		$this->helper($helpers);
		
		if(isset($_POST["register"])) {
			$this->Db->table($this->table);
			
			$username = trim(POST("username"));
			$password = (POST("password") != "") ? POST("password", "decode-encrypt") : NULL;
			$email	  = POST("email");

			if(!$username) {
				return getAlert("You need to write a username");
			} elseif(strlen($username) < 5) {
				return getAlert("You need to write a username");
			} elseif(strlen($password) < 6) {
				return getAlert("Invalid password");
			} elseif(!isEmail($email)) {
				return getAlert("Invalid e-mail");
			}
			
			$data = $this->Db->findBy("Username", $username);
		
			if($data) {
				return getAlert("This user already exists");
			}
			
			$data = $this->Db->findBy("Email", $email);
			
			if($data) {
				return getAlert("This e-mail already exists");
			}
			
			$startDate = now(4);
			$code 	   = code();
			$situation = "Inactive";
			
			$values = array(
				"Username"   => $username,
				"Pwd"        => $password,
				"Email"      => $email,
				"Start_Date" => $startDate,
				"Code"       => $code,
				"Situation"  => $situation
			);
			
			$ID_User = $this->Db->insert($this->table, $values);
			
			if($ID_User) {
				$ID_User_Information = $this->Db->insert("users_information", array("ID_User" => $ID_User));

				$this->Db->insert("re_privileges_users", array("ID_Privilege" => "4", "ID_User" => $ID_User));
				
				$this->Email->email   = $email;
				$this->Email->subject = __("Account Activation") . " - " . _webName;
				
				if($mode === "forums") { 
					$this->Email->message	= 	'
						<p>Your account has been created</p>
						<p>You need access to this link: <a href="' . _webBase . '/' . _webLang . '/users/activate/' . $code . '/forums">Activate account</a></p>
					';
				} else {
					$this->Email->message	= 	'
						<p>Your account has been created</p>
						<p>You need access to this link: <a href="' . _webBase . '/' . _webLang . '/users/activate/' . $code . '">Activate account</a></p>
					';
				}
				
				$this->Email->send();

				if($mode === "forums") {
					$result["message"] = __("The account has been created correctly, we will send you an e-mail so you can activate your account");		
					return $result;
				} else {
					return getAlert("The account has been created correctly, we will send you an e-mail so you can activate your account", "success");
				}
			} else {
				return getAlert("Insert error");
			}
		} else {
			return FALSE;
		}
	}
	
	public function last() {
		$this->Db->table($this->table, "ID_User, Username");
		
		$last = $this->Db->findLast();
		
		return ($last) ? $last[0] : NULL;
	}
	
	public function registered() {
		$this->Db->table($this->table);
		
		$registered = $this->Db->countAll();
		
		return $registered;
	}
	
	public function online($all = TRUE) {		
		$this->Db->table("users_online");
		
		$registered = $this->Db->countAll();
		
		$this->Db->table("users_online_anonymous");
		
		$anonymous = $this->Db->countAll();							
		
		$total = $registered + $anonymous;
		
		return ($all === TRUE) ? $total : $anonymous;	
	}	
	
	public function isToken($token = FALSE, $action = NULL) {
		if($token !== FALSE and isset($action)) {
			$this->Db->table("tokens");
			
			$data = $this->Db->findBySQL("Token = '$token' AND Action = '$action' AND Situation = 'Active'");
			
			if(!$data) {
				showAlert("Invalid Token");
			} else {
				return $data[0]["ID_Token"];
			}
		} else {
			showAlert("Invalid Token");
		}
	}
	
	public function getByID($ID) {
		$data = $this->Db->call("getUser($ID)");
		
		return $data;
	}
	
	public function getForProfile($ID) {
		$this->Db->table($this->table);
		$this->Db->encode(TRUE);
		
		$data[0] = $this->Db->find($ID);
		if(!$data[0]) {
			return FALSE;
		}
		
		$this->Db->table("users_information");
		$this->Db->encode(TRUE);
		$data[1] = $this->Db->findBySQL("ID_User = '$ID'");
		if(!$data[1]) {
			return FALSE;
		}
		
		return $data;
	}
	
	public function getPrivileges() {	
		$data = $this->Db->findAll("privileges");
		
		return $data;	
	}
	
	public function editProfile() {
		if(POST("edit")) {
			
			if(POST("website")) {
				if(POST("website") !== "http://") {
					if(!ping(POST("website"))) {
						$alert = getAlert("Invalid URL");
					}
				} else {
					$website = "";
				}
			}
		
			$ID = POST("ID_User");
			if(isset($alert)) {
				$website = "";
			} else {
				if(POST("website") !== "http://") {
					$website = POST("website", "decode", "escape");
				}
			}
			
			$name     = POST("name", "decode", "escape");
			$gender   = POST("gender", "decode", "escape");
			$birthday = POST("birthday", "decode", "escape");
			$company  = POST("company", "decode", "escape");
			$country  = POST("country", "decode", "escape");
			$district = POST("district", "decode", "escape");
			$town     = POST("town", "decode", "escape");
			$twitter  = POST("twitter", "decode", "escape");
			$facebook = POST("facebook", "decode", "escape");
			$linkedin = POST("linkedin", "decode", "escape");
			$google   = POST("google", "decode", "escape");
			$phone    = POST("telephone", "decode", "escape");
			$sign     = POST("sign", "decode", FALSE);
						
			if(!POST("userTwitter")) {
				$this->Db->table($this->table, "Avatar");
				$actualAvatar = $this->Db->find($ID);
			
				if(FILES("file", "name") !== "") {
					$this->Files = $this->core("Files");
					
					$this->Files->filename  = FILES("file", "name");
					$this->Files->fileType  = FILES("file", "type");
					$this->Files->fileSize  = FILES("file", "size");
					$this->Files->fileError = FILES("file", "error");
					$this->Files->fileTmp   = FILES("file", "tmp_name");
					
					$dir = _lib . _sh . _files . _sh . _images . _sh . "users" . _sh;
								
					if(!file_exists($dir)) {
						mkdir($dir, 0777); 				
					}
					
					if($actualAvatar[0]["Avatar"] !== "") {
						@unlink($actualAvatar[0]["Avatar"]);
					}
							
					$upload = $this->Files->upload($dir);
					
					if($upload["upload"] === TRUE) {
						$this->Images   = $this->core("Images");
						$avatar = $this->Images->getResize("mini", $dir, $upload["filename"], _minOriginal, _maxOriginal);
						@unlink($dir . $upload["filename"]);
					} else {
						$alert2 = getAlert($upload["message"]);
					}
				} else {
					$avatar = "";
				}
			
			
				if(isset($alert2)) {
					$avatar = "";
				} 
			} else {
				$avatar = "";
			}
				
			$this->Db->table($this->table);
			
			
			if($avatar === "") {
				$values = "Website = '$website', Sign = '$sign'";
				$this->Db->values($values);
				$update = $this->Db->save($ID);
				if($update) {
					$this->Db->encode(TRUE);
					$data[0] = $this->Db->find($ID);
				} else {
					return FALSE;
				}
			} else {
				$values = "Website = '$website', Sign = '$sign', Avatar = '$avatar'";
				$this->Db->values($values);
				$update = $this->Db->save($ID);
				if($update) {
					$this->Db->encode(TRUE);
					$data[0] = $this->Db->find($ID);
				} else {
					return FALSE;
				}
			}
			
			$this->Db->table("users_information");
			
			
			$userinfo = $this->Db->findBySQL("ID_User = '$ID'");
			$ID2 = $userinfo[0]["ID_User"];
			
			$values = "Name = '$name', Phone = '$phone', Company = '$company', Gender = '$gender', Birthday = '$birthday', Country = '$country', District = '$district', Town = '$town', Facebook = '$facebook', Twitter = '$twitter', Linkedin = '$linkedin', Google = '$google'";
			$this->Db->values($values);
			$update = $this->Db->save($ID2);
			if($update) {
				$this->Db->encode(TRUE);
				$data[1] = $this->Db->find($ID2);
			} else {
				return FALSE;
			}
			
			if($data) {
				$success = TRUE;
				if(isset($alert)) {
					$data[2][] = $alert;
					$success = FALSE;
				}
				
				if(isset($alert2)) {
					$data[2][] = $alert2;
					$success = FALSE;
				}

				if($success === TRUE) {
					$data[2][0] = getAlert("Your profile has been edited correctly", "success");
				}
				return $data;
			} else {
				return FALSE;
			}
			
		} else { 
			return FALSE;
		}
	}
	
	public function setRank($ID_User, $rank = FALSE) {
		$ranks[0] = "Beginner";
		$ranks[1] = "Advanced Beginner";
		$ranks[2] = "Member";
		$ranks[3] = "Full Member";
		$ranks[4] = "Silver Member";
		$ranks[5] = "Gold Member";
		$ranks[6] = "Platinum Member";
		$ranks[7] = "God of the Forum";
		$ranks[8] = "Moderator";
		$ranks[9] = "Administrator";
		$ranks[10] = "Super Administrator";
			
		if(!$rank) {
			$this->Db->table("users");
			$user = $this->Db->find($ID_User);
			
			$normalPoints = $user[0]["Topics"] + $user[0]["Replies"];
			$visitPoints  = $user[0]["Visits"] / 50;
			$points  	  = intval($normalPoints + $visitPoints);
			$actualRank   = $user[0]["Rank"];
			
			if($points === 0) {
				$points = 1;
			}
			
			if($actualRank !== "Super Administrator" and $actualRank !== "Administrator" and $actualRank !== "Moderator") {
				switch($points) {
					case ($points < 50): 
						if($actualRank !== $ranks[0]) {
							$values = "Rank = '$ranks[0]'";
							$this->Db->values($values);
							$this->Db->save($ID_User);
							
						}
					break;
					
					case ($points >= 50 and $points < 100):
						if($actualRank !== $ranks[1]) {
							$values = "Rank = '$ranks[1]'";
							$this->Db->values($values);
							$this->Db->save($ID_User);
						}
					break;
					
					case ($points >= 100 and $points < 200):
						if($actualRank !== $ranks[2]) {
							$values = "Rank = '$ranks[2]'";
							$this->Db->values($values);
							$this->Db->save($ID_User);
						}
					break;
					
					case ($points >= 200 and $points < 350):
						if($actualRank !== $ranks[3]) {
							$values = "Rank = '$ranks[3]'";
							$this->Db->values($values);
							$this->Db->save($ID_User);
						}
					break;
					
					case ($points >= 200 and $points < 350):
						if($actualRank !== $ranks[3]) {
							$values = "Rank = '$ranks[3]'";
							$this->Db->values($values);
							$this->Db->save($ID_User);
						}
					break;
					
					case ($points >= 350 and $points < 550):
						if($actualRank !== $ranks[4]) {
							$values = "Rank = '$ranks[4]'";
							$this->Db->values($values);
							$this->Db->save($ID_User);
						}
					break;
					
					case ($points >= 550 and $points < 800):
						if($actualRank !== $ranks[5]) {
							$values = "Rank = '$ranks[5]'";
							$this->Db->values($values);
							$this->Db->save($ID_User);
						}
					break;
					
					case ($points >= 800 and $points < 1100):
						if($actualRank !== $ranks[6]) {
							$values = "Rank = '$ranks[6]'";
							$this->Db->values($values);
							$this->Db->save($ID_User);
						}
					break;
					
					case ($points > 1100):
						if($actualRank !== $ranks[7]) {
							$values = "Rank = '$ranks[7]'";
							$this->Db->values($values);
							$this->Db->save($ID_User);
						}
					break;
				}
			}
		} else {
			$this->Db->table("users");
			
			$values = "Rank = '$ranks[$rank]'";
			
			$this->Db->values($values);
			$this->Db->save($ID_User);
		}		
	}
}
