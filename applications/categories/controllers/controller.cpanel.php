<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class CPanel_Controller extends ZP_Controller {
	
	private $vars = array();
	
	public function __construct() {		
		$this->app("cpanel");
		
		$this->application = whichApplication();
		
		$this->CPanel = $this->classes("CPanel");
		
		$this->isAdmin = $this->CPanel->load();
		
		$this->vars = $this->CPanel->notifications();
		
		$this->helper("applications", "applications");
		
		$this->CPanel_Model     = $this->model("CPanel_Model");
		$this->Categories_Model = $this->model("Categories_Model");
		
		$this->Templates = $this->core("Templates");
		
		$this->Templates->theme(_cpanel);
	}
	
	public function index() {
		if($this->isAdmin) {
			$this->home();
		} else {
			$this->login();
		}
	}
	
	public function add() {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		$this->title("Add");
		
		//$this->js("tiny-mce");
		$this->js("insert-html");
		$this->js("show-element");	
		
		$this->CSS("forms", _cpanel);
		$this->CSS("categories", $this->application);
		
		$this->Library = $this->classes("Library", _cpanel);
		
		$this->vars["ID"]          	= 0;
		$this->vars["ID_URL"]      	= isset($save["error"]) ? recoverPOST("ID_URL") 	: NULL;
		$this->vars["title"]       	= isset($save["error"]) ? recoverPOST("title")		: NULL;
		$this->vars["content"]     	= isset($save["error"]) ? recoverPOST("content")	: NULL;
		$this->vars["situation"]	= isset($save["error"]) ? recoverPOST("situation")	: NULL;
		$this->vars["comments"]    	= isset($save["error"]) ? recoverPOST("comments")	: NULL;	
		$this->vars["language"]    	= isset($save["error"]) ? recoverPOST("language")	: NULL;
		$this->vars["pwd"]   		= isset($save["error"]) ? recoverPOST("pwd")		: NULL;
		$this->vars["edit"]        	= FALSE;
		$this->vars["action"]		= "save";
		$this->vars["href"] 		= _webPath . $this->application . _sh . _cpanel . _sh . "add" . _sh;
		
		$this->vars["apps"] 		  = getApplicationsArray(array(3,9,18));
		$this->vars["appsCategories"] = $this->Categories_Model->getSomecategories(NULL, 'Spanish');
	
		$Model = ucfirst($this->application) . "_Model";
		
		$this->$Model = $this->model($Model);
		
		if(POST("save")) {
			$this->vars["alert"] = $this->$Model->cpanel("save");
		} elseif(POST("cancel")) {
			redirect(_webBase . _sh . _webLang . _sh . _cpanel);
		}
		
		$this->vars["view"] = $this->view("add", TRUE, $this->application);
		
		$this->template("content", $this->vars);
		
		$this->render();
	}
	
	public function delete($ID = 0) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if($this->CPanel_Model->delete($ID)) {
			redirect(_webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _results . _sh . _trash);
		} else {
			redirect(_webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _results);
		}	
	}
	
	public function edit($ID = 0) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if((int) $ID === 0) { 
			redirect(_webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _results);
		}

		$this->title("Edit");
		
		$this->CSS("forms", _cpanel);
		$this->CSS("misc", _cpanel);
		$this->CSS("categories", "categories");
		
		$this->js("tiny-mce");
		$this->js("insert-html");
		$this->js("show-element");	
		
		$Model = ucfirst($this->application) . "_Model";
		
		$this->$Model = $this->model($Model);
		
		if(POST("edit")) {
			$this->vars["alert"] = $this->$Model->cpanel("edit");
		} elseif(POST("cancel")) {
			redirect(_webBase . _sh . _webLang . _sh . _cpanel);
		} 
		
		$data = $this->$Model->getByID($ID);
		
		if($data) {
			$this->Library 	  = $this->classes("Library", _cpanel);
			$this->Categories = $this->classes("Categories", "categories");
			
			$this->vars["data"]			= $data;
			#$this->vars["application"] = $this->CPanel->getApplicationID($this->application);
		
			$this->vars["view"] = $this->view("add", TRUE, $this->application);
			
			$this->template("content", $this->vars);
			
			$this->render();
		} else {
			redirect(_webBase. _sh. _webLang. _sh. $this->application. _sh. _cpanel . _sh . _results);
		}
	}
	
	public function login() {
		$this->title("Login");
		$this->CSS("login", "users");
		
		if(POST("connect")) {	
			$this->Users_Controller = $this->controller("Users_Controller");
			
			$this->Users_Controller->login("cpanel");
		} else {
			$this->vars["URL"]  = getURL();
			$this->vars["view"] = $this->view("login", TRUE, _cpanel);
		}
		
		$this->template("include", $this->vars);
		
		$this->render("header", "footer");
		
		exit;
	}
	
	public function restore($ID = 0) { 
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if($this->CPanel_Model->restore($ID)) {
			redirect(_webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _results . _sh . _trash);
		} else {
			redirect(_webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _results);
		}
	}
	
	public function results() {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		$this->title("Manage ". $this->application);
		$this->CSS("results", _cpanel);
		$this->CSS("pagination");
		$this->js("checkbox");
		
		$this->helper("inflect");		
		
		if(isLang()) {
			if(segment(4) === "trash") {
				$trash = TRUE;
			} else {
				$trash = FALSE;
			}
		} else {
			if(segment(3) === "trash") {
				$trash = TRUE;
			} else {
				$trash = FALSE;
			}
		}
		
		$singular = "post";
		$plural   = "posts";
		
		$total 		= $this->CPanel_Model->total($trash, $singular, $plural);
		$thead 		= $this->CPanel_Model->thead("checkbox, ". getFields($this->application) .", Action", FALSE);
		$pagination = $this->CPanel_Model->getPagination($trash);
		$tFoot 		= getTFoot($trash);
		
		$this->vars["message"]    = (!$tFoot) ? "Error" : NULL;
		$this->vars["pagination"] = $pagination;
		$this->vars["trash"]  	  = $trash;	
		$this->vars["search"] 	  = getSearch(); 
		$this->vars["table"]      = getTable(__("Manage " . ucfirst($this->application)), $thead, $tFoot, $total);					
		$this->vars["view"]       = $this->view("results", TRUE, _cpanel);
		
		$this->template("content", $this->vars);
		
		$this->render();
	}
	
	public function trash($ID = 0) {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		if($this->CPanel_Model->trash($ID)) {
			redirect(_webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _results);
		} else {
			redirect(_webBase . _sh . _webLang . _sh . $this->application . _sh . _cpanel . _sh . _add);
		}
	}
	
	public function upload() {
		if(!$this->isAdmin) {
			$this->login();
		}
		
		$this->Library = $this->classes("Library", _cpanel);	
			
		$this->Library->upload();
	}
	
}
