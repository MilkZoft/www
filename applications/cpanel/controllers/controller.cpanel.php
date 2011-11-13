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
		$this->application = $this->app("cpanel");
		
		$this->config($this->application);
		
		$this->CPanel = $this->classes("CPanel");
		
		$this->isAdmin = $this->CPanel->load();
		
		$this->vars = $this->CPanel->notifications();
		
		$this->CPanel_Model = $this->model("CPanel_Model");
		
		$this->Templates = $this->core("Templates");
		
		$this->Templates->theme(_cpanel);
		
		$this->js("external");
	}
	
	public function index() {
		if($this->isAdmin) {
			$this->home();
		} else {
			$this->login();
		}
	}
	
	private function home() {
		$this->title("Home");
		$this->CSS();
		
		$this->helper("porlets", $this->application);
		
		$this->vars["lastPosts"] = porlet(__("Last posts"), $this->CPanel_Model->home("blog"));
		$this->vars["lastPages"] = porlet(__("Last pages"), $this->CPanel_Model->home("pages"), "list", "right");
		$this->vars["lastLinks"] = porlet(__("Last links"), $this->CPanel_Model->home("links"));
		$this->vars["lastUsers"] = porlet(__("Last users"), $this->CPanel_Model->home("users"), "list", "right");
		$this->vars["view"] 	 = $this->view("home", TRUE);
		
		$this->template("content", $this->vars);
		
		$this->render();
	}
	
	public function login() {
		$this->title("Login");
		$this->CSS("login", "users");
		
		if(POST("connect")) {	
			$this->Users_Controller = $this->controller("Users_Controller");
			
			$this->Users_Controller->login("cpanel");
		} else {
			$this->vars["URL"]  = getURL();
			$this->vars["view"] = $this->view("login", TRUE);
		}
		
		$this->template("include", $this->vars);
		
		$this->render("header", "footer");
	}
	
	public function logout() {
		unsetSessions(_webBase . _sh . _webLang . _sh . _cpanel);
	}
	
}
