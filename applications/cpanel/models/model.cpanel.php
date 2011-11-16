<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class CPanel_Model extends ZP_Model {
	
	private $route;
	private $table;
	private $primaryKey;
	
	public function __construct() {
		$this->Db = $this->db();
		$this->Users_Model = $this->model("Users_Model");

		$this->Email = $this->core("Email");
		
		$this->Email->setLibrary("PHPMailer");
		
		$this->Email->fromName  = _webName;
		$this->Email->fromEmail = _webEmailSend;
		
		$this->config("applications");
		
		$this->helper("router");
		
		$this->application = whichApplication();
	}
	
	public function action($trash = FALSE, $ID, $delete = TRUE, $edit = TRUE, $comments = FALSE) {
		$delete = $this->Users_Model->isAllow("delete");
		$edit 	= $this->Users_Model->isAllow("edit");
		
		if($this->application === "comments") {
			if($delete and $edit) {				
				$URL1     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _validate . _sh . $ID;
				$URL2     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _trash    . _sh . $ID;
				$title1   = __("Validate comment");
				$title2   = __("Send to trash");
				$onClick1 = "return confirm('". __("Do you want to validate the comment?") ."')";
				$onClick2 = "return confirm('". __("Do you want to send to the trash the record?") ."')";			
					
				if($comments) {					
					$action = a(span("tiny-image tiny-ok", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL1, FALSE, array("title" => $title1, "onclick" => $onClick1)) . 
							  a(span("tiny-image tiny-trash", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL2, FALSE, array("title" => $title2, "onclick" => $onClick2));
				} else {
					$action = a(span("tiny-image tiny-trash", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL2, FALSE, array("title" => $title2, "onclick" => $onClick2));
				}
			} elseif($delete and $edit) {
				$URL1	  = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _read  . _sh . $ID;
				$URL2 	  = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _trash . _sh . $ID;	
				$title1   = __("Read Comment");
				$title2   = __("Send to Trash");				
				$onClick2 = "return confirm('".__("Do you want to send to the trash the record?")."')";	
					
				$action = a(span("tiny-image tiny-mail-off", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL1, FALSE, array("title" => $title1, "onclick" => $onClick1)) . 
						  a(span("tiny-image tiny-trash", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL2, FALSE, array("title" => $title2, "onclick" => $onClick2));												
			}
		} elseif($this->application === "feedback") {
			if($delete and $edit) {
				$URL1     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _read  . _sh . $ID;
				$URL2     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _trash . _sh . $ID;
				$title1   = __("Read Message");
				$title2   = __("Send to Trash");				
				$onClick2 = "return confirm('".__("Do you want to send to the trash the record?")."')";	
					
				$action = a(span("tiny-image tiny-mail", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"), $URL1, FALSE, array("title" => $title1)) . 
						  a(span("tiny-image tiny-trash", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"), $URL2, FALSE, array("title" => $title2, "onclick" => $onClick2));										
			} elseif($delete and !$edit) {
				$URL1     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _read  . _sh . $ID;
				$URL2     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _trash . _sh . $ID;
				$title1   = __("Read Message");
				$title2   = __("Send to Trash");				
				$onClick2 = "return confirm('".__("Do you want to send to the trash the record?")."')";	
					
				$action = a(span("tiny-image tiny-mail-off", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL1, FALSE, array("title" => $title1, "onclick" => $onClick1)) . 
						  a(span("tiny-image tiny-trash", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL2, FALSE, array("title" => $title2, "onclick" => $onClick2));				
			}
		
		} elseif($comments) {
				$URL1     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _validate . _sh . $ID;
				$URL2     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _trash    . _sh . $ID;
				$title1   = __("Validate Comment");
				$title2   = __("Send to Trash");
				$onClick1 = "return confirm('". __("Do you want to validate the comment?") ."')";
				$onClick2 = "return confirm('". __("Do you want to send to the trash the record?") ."')";	
							
				$action = a(span("tiny-image tiny-ok", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL1, FALSE, array("title" => $title1, "onclick" => $onClick1)) . 
				  		  a(span("tiny-image tiny-trash", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL2, FALSE, array("title" => $title2, "onclick" => $onClick2));						 
		} elseif(!$trash) {
			if($delete and $edit) {
				$URL1     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _edit  . _sh . $ID;
				$URL2     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _trash . _sh . $ID;
				$title1   = __("Edit");
				$title2   = __("Send to trash");
				$onClick1 = "return confirm('".__("Do you want to edit the record?")."')";
				$onClick2 = "return confirm('".__("Do you want to send to the trash the record?")."')";
				
				$action = a(span("tiny-image tiny-edit", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL1, FALSE, array("title" => $title1, "onclick" => $onClick1)) . 
						  a(span("tiny-image tiny-trash", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"), $URL2, FALSE, array("title" => $title2, "onclick" => $onClick2));	
			} elseif($delete and !$edit) {  				
				$URL2     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _trash . _sh . $ID;				
				$title2   = __("Send to trash");				
				$onClick2 = "return confirm('".__("Do you want to send to the trash the record?")."')";
				
				$action = a(span("tiny-image tiny-trash", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL2, FALSE, array("title" => $title2, "onclick" => $onClick2));				
			} elseif(!$delete and !$edit) {
				$action = span("tiny-image tiny-edit-off", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;") . 
				   		  span("tiny-image tiny-trash-off", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
			}
		} else {
			$URL1     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _restore . _sh . $ID;
			$URL2     = _webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _delete  . _sh . $ID;
			$title1   = __("Restore");
			$title2   = __("Delete");
			$onClick1 = "return confirm('".__("Do you want to restore the record?")."')";
			$onClick2 = "return confirm('".__("Do you want to delete the record permanently?")."')";
			
			$action = a(span("tiny-image tiny-restore", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"), $URL1, FALSE, array("title" => $title1, "onclick" => $onClick1)) . 
			  		  a(span("tiny-image tiny-delete", "&nbsp;&nbsp;&nbsp;&nbsp;"), $URL2, FALSE, array("title" => $title2, "onclick" => $onClick2));	
		}
		
		return $action;
	}
	
	public function delete($ID, $comments = FALSE) {
		if($comments) {
			$this->Db->table("comments");
			
			if(!is_array($ID)) {
				$this->Db->deleteBy("ID_Comment", $ID);
				
				return TRUE;
			} else {
				for($i = 0; $i <= count($ID) - 1; $i++) {
					$this->Db->deleteBy("ID_Comment", $ID[$i]);
				}
				
				return TRUE;	
			}
		} else { 
			$this->Db->table($this->application);
			
			if(!is_array($ID)) {						
				$this->Db->delete($ID);
				
				$count = $this->Db->countBySQL("Situation = 'Deleted'");
				
				if($count > 0) {
					return TRUE;
				}
				
				return FALSE;
			} else {
				for($i = 0; $i <= count($ID) - 1; $i++) {
					$this->Db->delete($ID[$i]);
				}
				
				$count = $this->Db->countBySQL("Situation = 'Deleted'");
				
				if($count > 0) {
					return TRUE;
				}
				
				return FALSE;			
			}
		}
	}

	public function deletedRecords($table) {
		$this->Db->table($table);
		
		if(SESSION("ZanUserPrivilege") === _super) {
			return $this->Db->countBySQL("Situation = 'Deleted'");
		} else {
			return	$this->Db->countBySQL("ID_User = '" . SESSION("ZanUserID") . "' AND Situation = 'Deleted'");	
		}
	}
	
	public function home($type) {
		if($type === "pages") {						
			$data = $this->Db->findAll("pages", NULL, "ID_Page DESC", _maxLimit, TRUE);
			
			if($data) {
				$i = 1;	
							
				foreach($data as $page) {
					$list[] = li(a(getLanguage($page["Language"], TRUE) ." $i. ". cut($page["Title"], 4), _webBase . _sh . getXMLang($page["Language"]) . _sh . _pages . _sh . $page["Slug"], $page["Title"], TRUE));					
					
					$i++;
				}
				
			} else {
				$list = __("There are no new pages");
			}
			
			return $list;		
		} elseif($type === "blog") {						
			$data = $this->Db->findAll("blog", NULL, "ID_Post DESC", _maxLimit);							
		
			if($data) {
				$i = 1;		
						
				foreach($data as $post) { 	
					$URL = _webBase . _sh . _webLang . _sh . _blog . _sh . $post["Year"] . _sh . $post["Month"] . _sh . $post["Day"] . _sh . $post["Slug"];

					$list[] = li(a(getLanguage($post["Language"], TRUE) .' '. $i .'. '. cut($post["Title"], 4), $URL , $post["Title"], TRUE));					
					
					$i++;					
				}
				
			} else {
				$list = __("There are no new posts");			
			}
			
			return $list;			
		} elseif($type === "links") {						
			$data = $this->Db->findAll("links", NULL, "ID_Link DESC", _maxLimit);
			
			if($data) {
				$i = 1;
				
				foreach($data as $link) {
					$list[] = li(a($i .". ". $link["Title"], $link["URL"], $link["Description"], TRUE));					
					
					$i++;
				}
			} else {
				$list = __("There are no new links");			
			}
			
			return $list;
		} elseif($type === "users") {			
			$data = $this->Db->findAll("users", NULL, "ID_User DESC", _maxLimit);
			
			if($data) {
				$i = 1;
				
				foreach($data as $user) {																											
					$list[] = li(a($i .". ". $user["Username"], _webBase . _sh . _webLang . _sh . _users . _sh .  "profile" . _sh . $user["ID_User"], $user["Username"], TRUE));					
					
					$i++;
				}
			
			} else {
				$list = __("There are no new users");			
			}
			
			return $list;							
		}
	}
	
	public function getPagination($trash = FALSE) {
		$primaryKey = $this->Db->table($this->application);	
		
		$application = whichApplication();

		$start = 0;
		
		if($trash) {	
			if(isLang()) {
				if(segment(5) === _page and segment(6) > 0) {
					$start = (segment(6) * _maxLimit) - _maxLimit;
				}
			} else {
				if(segment(4) === _page and segment(5) > 0) {
					$start = (segment(5) * _maxLimit) - _maxLimit;
				}
			}
			
			$limit = $start .", ". _maxLimit;
		} else {
			if(isLang()) {
				if(segment(4) === _page and segment(5) > 0) {
					$start = (segment(5) * _maxLimit) - _maxLimit;
				}	
			} else {
				if(segment(3) === _page and segment(4) > 0) {
					$start = (segment(4) * _maxLimit) - _maxLimit;
				}
			}
			
			$limit = $start .", ". _maxLimit;				
		}				
		
		if(POST("seek")) {
			if(POST("field") === "ID") {
				if(SESSION("ZanUserPrivilege") === _super) {
					$count = $this->Db->countBySQL("$primaryKey = '". POST("search") ."' AND Situation != 'Deleted'");
				} else {
					$count = $this->Db->countBySQL("ID_User = '". SESSION("ZanUserID")."' AND $primaryKey = '". POST("search") ."' AND Situation != 'Deleted'");
				}
			} else {
				if(SESSION("ZanUserPrivilege") === _super) {
					$count = $this->Db->countBySQL("". POST("field") ." LIKE '%". POST("search") ."%' AND Situation != 'Deleted'");
				} else {
					$count = $this->Db->countBySQL("ID_User = '". SESSION("ZanUserID") ."' AND ". POST("field") ." LIKE '%". POST("search") ."%' AND Situation != 'Deleted'");						
				}
			}
		} elseif(!$trash) {
			if(SESSION("ZanUserPrivilege") === _super) {
				$count = $this->Db->countBySQL("Situation != 'Deleted'");
			} else {
				$count = $this->Db->countBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Situation != 'Deleted'");
			}
			
			$URL = _webBase . _sh . _webLang . _sh . $application . _sh . _cpanel . _sh . _results . _sh . _page . _sh;
		} else {
			if(SESSION("ZanUserPrivilege") === _super) {
				$count = $this->Db->countBySQL("Situation = 'Deleted'");
			} else {
				$count = $this->Db->countBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Situation = 'Deleted'");
			}
			
			$URL = _webBase . _sh . _webLang . _sh . $application . _sh . _cpanel . _sh . _results . _sh . _trash . _sh . _page . _sh;
		}
		
		if(!POST("seek")) {
			$this->Pagination = $this->core("Pagination");
			
			if($count > _maxLimit) {
				$pagination = $this->pagination = $this->Pagination->paginate($count, _maxLimit, $start, $URL);
			} else {
				$pagination = NULL;
			}			
		} else {
			$pagination = NULL;	
		}
		
		return $pagination;		
	}
	
	public function getTFoot($a = 0, $position, $value, $array, $text = NULL) {
		$array[$a][$position] = $value;
		
		if($text !== "") {
			$array[$a]["TitleComment"] = $text;
		}
		
		return $array;
	}
	
	public function records($trash = FALSE, $order = NULL) {
		if(isLang()) {
			$Model = ucfirst(segment(1)) . "_Model";
		} else {
			$Model = ucfirst(segment(0)) . "_Model";
		}
		
		$this->$Model = $this->model($Model);
		
		if(isset($this->$Model)) {
			if(POST("seek")) {
				$data = $this->$Model->cpanel("search", NULL, POST("field") ." ". POST("order"), POST("search"), POST("field"));
				
				if(!$data) {
					showAlert("Results not found", _webBase . _sh . _webLang . _sh . whichApplication() . _sh . _cpanel . _sh . _results);
				}
			} else {
				$start = 0;
				
				if($trash) {	
					if(isLang()) {
						if(segment(5) === _page and segment(6) > 0) {
							$start = (segment(6) * _maxLimit) - _maxLimit;
						}
					} else {
						if(segment(4) === _page and segment(5) > 0) {
							$start = (segment(5) * _maxLimit) - _maxLimit;
						}
					}
					
					$limit = $start .", ". _maxLimit;
				} else {
					if(isLang()) {
						if(segment(4) === _page and segment(5) > 0) {
							$start = (segment(5) * _maxLimit) - _maxLimit;
						}	
					} else {
						if(segment(3) === _page and segment(4) > 0) {
							$start = (segment(4) * _maxLimit) - _maxLimit;
						}
					}
					
					$limit = $start .", ". _maxLimit;				
				}			
				
				if(segment(3) === "order") {				
					if(segment(4)) {
						$i = 3; 
						$j = 4;
					} else {
						$i = 4;
						$j = 5;
					}
					
					if(segment($i) === "id") {
						$field = "ID";
					} elseif(segment($i) === "end-date") {
						$field = "End_Date";
					} elseif(segment($i) === "start-date") {
						$field = "Start_Date";
					} elseif(segment($i) === "text-date") {
						$field = "Text_Date";
					} else {
						$field = ucfirst(segment($i));
					}
					
					if(segment($j) === "asc") {		
						$data = $this->$Model->cpanel("all", $limit, "$field ASC", NULL, NULL, $trash);
					} elseif(segment($j) === "desc") {
						$data = $this->$Model->cpanel("all", $limit, "$field DESC", NULL, NULL, $trash);
					}
				} else {
					if(!$trash) {
						$data = $this->$Model->cpanel("all", $limit, $order, NULL, NULL);
					} else {
						$data = $this->$Model->cpanel("all", $limit, $order, NULL, NULL, $trash);			
					}
				}
			}
			
			return $data;
		}
		
		return FALSE;
	}
	
	public function restore($ID) {
		$this->Db->table($this->application);
		$this->Db->values("Situation = 'Active'");
		
		if(!is_array($ID)) {
			$this->Db->save($ID);
			
			$count = $this->Db->countBySQL("Situation = 'Deleted'");
			
			if($count > 0) {
				return TRUE;
			}
			
			return FALSE;
		} else {
			for($i = 0; $i <= count($ID) - 1; $i++) {
				$this->Db->save($ID[$i]);
			}	
					
			$count = $this->Db->countBySQL("Situation = 'Deleted'");
			
			if($count > 0) {
				return TRUE;
			}
			
			return FALSE;			
		}
	}
	
	public function thead($positions, $trash = FALSE) {
		$positions = str_replace(", ", ",", $positions);
		$parts     = explode(",", $positions);
		
		if(count($parts) > 0) {
			for($i = 0; $i <= count($parts) - 1; $i++) {
				if($parts[$i] != "checkbox") {					
					if($parts[$i] === "Action") {
						$thead[$i] = __($parts[$i]);
					} else {
						$thead[$i] = __($parts[$i]);
					}
				} else {
					$thead[$i] = "";	
				}
			}
		} else {
			$thead[0] = __($positions);	
		}
		
		$return = $thead;
		
		unset($thead);
		
		return $return;
	}
	
	public function total($trash = FALSE, $singular = "record", $plural = "records", $comments = FALSE) {
		$primaryKey = $this->Db->table($this->application);
		
		if(POST("seek")) {
			if(POST("field") === "ID") {
				if(SESSION("ZanUserPrivilege") === _super) {
					$total = $this->Db->countBySQL("$primaryKey = '". POST("search") ."'", $this->application);
				} else {
					$total = $this->Db->countBySQL("ID_User = '". SESSION("ZanUserID") ."' AND $primaryKey = '". POST("search") ."'", $this->application);
				}
			} else {
				if(SESSION("ZanUserPrivilege") === _super) {
					$total = $this->Db->countBySQL("". POST("field") ." LIKE '%". POST("search") ."%'", $this->application);
				} else {
					$total = $this->Db->countBySQL("ID_User = '". SESSION("ZanUserID") ."' AND ". POST("field") ." LIKE '%". POST("search") ."%'", $this->application);						
				}
			}
			
			if($total === 0) {
				$total = "0 " . __("Records founded");
			} elseif($total === 1) {
				$total = "1 " . __("Record found");
			} else {
				$total = $total . " " .__("Records founded");	
			}
			
			return $total;
		} elseif(!$trash) { 
			if(SESSION("ZanUserPrivilege") === _super) {
				$total = $this->Db->countBySQL("Situation != 'Deleted'", $this->application);
			} else {
				$total = $this->Db->countBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Situation != 'Deleted'", $this->application);
			}
		} else {
			if(SESSION("ZanUserPrivilege") === _super) {
				$total = $this->Db->countBySQL("Situation = 'Deleted'", $this->application);
			} else {
				$total = $this->Db->countBySQL("ID_User = '". SESSION("ZanUserID") ."' AND Situation = 'Deleted'", $this->application);
			}
		}
		 
		if($comments) {
			if(whichApplication === "blog") {
				$total = $this->Db->countBySQL("ID_Application = '3'", "comments");
			}
		}
		
		if($total === 0) {
			$total = "0 " . __($plural);
		} elseif((int) $total === 1) { 
			$total = "1 " . __($singular);
		} else { 
			$total = $total . " " . __($plural);
		}
		
		return $total;
	}
	
	public function trash($ID) {
		$this->Db->table($this->application);
		$this->Db->values("Situation = 'Deleted'");	
		
		if(!is_array($ID)) {
			$a = $this->Db->save($ID);
			
			$count = $this->Db->countBySQL("Situation = 'Active'");
			
			if($count > 0) {
				return TRUE;
			}
			
			return FALSE;
		} else {
			for($i = 0; $i <= count($ID) - 1; $i++) {
				$this->Db->save($ID[$i]);	
			}
			
			$count = $this->Db->countBySQL("Situation = 'Active'");
			
			if($count > 0) {
				return TRUE;
			}
			
			return FALSE;			
		}
	}
	
	public function validate($ID) {
		$this->Db->table("comments");
		
		$values = "Situation = 'Active'";
		
		if(!is_array($ID)) {
			$this->Db->values($values);
			$this->Db->update($ID);
			
			$count = $this->Db->countBySQL("Situation = 'Inactive'");
			
			if($count > 0) {
				return TRUE;
			}
			
			return FALSE;
		} else {
			for($i = 0; $i <= count($ID) -1; $i++) {
				$this->Db->setValues($values);
				$this->Db->doUpdate($ID[$i]);
			}
			
			$count = $this->Db->countBySQL("Situation = 'Inactive'");
			
			if($count > 0) {
				return TRUE;
			}
			
			return FALSE;
		}
	}
}
