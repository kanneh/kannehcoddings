<?php
/**
 * users processes
 */
class User
{
	private $registry;

        
        
	function __construct($registry){
		$this->registry=$registry;
	}
	
	public function getUser()
	{
		$usr=$this->registry->get('session')->get('user');
		return $usr['id'];

	}
        public function getUserUsername()
	{
		$usr=$this->registry->get('session')->get('user');
		return $usr['username'];

	}
	public function logout()
	{
		$this->session->unset("user");
		$this->request->redirect($this->url->link("account/login"));
	}
	public function log($username,$password)
	{
		$this->registry->get('db')->query("DELETE FROM ".DB_PREFIX."login WHERE date_added < '".date("y-m-d H:i:s",strtotime('-1 hours'))."'");
		$attemptquer=$this->registry->get('db')->query("SELECT atp FROM ".DB_PREFIX."login WHERE username='$username'");
		if (isset($attemptquer->row['atp']) && $attemptquer->row['atp']>=5) {
			$this->registry->get('session')->set('error','Too many attempts please wait for one hour and try again');
			return false;
		}
		$mquery=$this->registry->get('db')->query("SELECT username,id,first_name,last_name,permission,account_status FROM ".DB_PREFIX."users WHERE username='$username' AND password='".md5(md5(sha1(md5(sha1($password))."@H#")."@@HH##")."@@@HHH###")."'");
		if ($mquery->num_rows) {
			if ($mquery->row['account_status']=="Active") {
				$this->registry->get('session')->set("user",$mquery->row);
				return true;
			}else{
				$this->registry->get('session')->set('error','Your account has been suspended. Please consult admin for help.');
				return false;
			}
			
		}else{
			$this->registry->get('session')->set('error','Invalid Username/Password.');
			if ($attemptquer->num_rows) {
				$this->registry->get('db')->query("UPDATE ".DB_PREFIX."login SET atp = atp+1 WHERE username='$username'");
			}else{
				$this->registry->get('db')->query("INSERT INTO ".DB_PREFIX."login SET atp = 1, username='$username', ip='".$_SERVER['REMOTE_ADDR']."', date_added=NOW()");
			}
			return false;
		}
	}

	
	public function isLog()
	{
		if(null != $this->registry->get('session')->get('user')){
			if(!$this->isActive()){
				$this->registry->get('session')->unset('user');
			}
		}
		return null !== $this->registry->get('session')->get('user');
	}

	public function isActive()
	{
		$query=$this->registry->get('db')->query("SELECT account_status FROM ".DB_PREFIX."users WHERE id='".$this->getUser()."'");
		if ($query->row['account_status']=='Active') {
			return true;
		}
		return false;
	}

	public function hasPermission($key,$value)
	{
		# code...
		$idquery=$this->registry->get('session')->get("user");
		$permQuery=json_decode($idquery['permission']);
		$permission= isset($permQuery->$key)?$permQuery->$key:array();
		return in_array($value, $permission);

	}
	public function addPermission($key='access',$value)
	{
		# code...
		$idquery=$this->registry->get('session')->get("user");
		$permQuery=json_decode($idquery['permission']);
		$permission=isset($permQuery->$key)?$permQuery->$key:array();
		if (!in_array($value, $permission)) {
			# code...
			$permission[]=$value;
			$permQuery->$key=$permission;
			$id=$idquery['id'];
			$this->registry->get('db')->query("UPDATE ".DB_PREFIX."users SET permission='".json_encode($permQuery)."' WHERE id='$id'");
			$query=$this->registry->get('db')->query("SELECT id,first_name,last_name,permission FROM ".DB_PREFIX."users WHERE id='$id'");
			$this->registry->get('session')->set("user",$query->row);
		}
		$idquery=$this->registry->get('session')->get("user");
		$permQuery=json_decode($idquery['permission']);
		$permission=$permQuery->$key;
	}
	public function removePermission($key,$value='')
	{
		# code...
		$idquery=$this->registry->get('session')->get("user");
		$permQuery=json_decode($idquery['permission']);
		if ($value !=='') {
			# code...
			$permission=isset($permQuery->$key)?$permQuery->$key:array();
			if (in_array($value,$permission)) {
				# code...
				$nperm=array();
				for ($i=0; $i < count($permission); $i++) { 
					# code...
					if ($permission[$i] !== $value) {
						# code...
						$nperm[]=$permission[$i];
					}
				}
				$permission=$nperm;
				$permQuery->$key=$permission;
			}
		}else{
			$nperm=new stdClass();
			foreach ($permQuery as $mkey => $mvalue) {
				# code...
				if ($key !==$mkey) {
					# code...
					$nperm->$mkey=$mvalue;
				}
			}
			$permQuery=$nperm;
		}
		$id=$idquery['id'];
		$this->registry->get('db')->query("UPDATE ".DB_PREFIX."users SET permission='".json_encode($permQuery)."' WHERE id='$id'");
		$query=$this->registry->get('db')->query("SELECT id,first_name,last_name,permission FROM ".DB_PREFIX."users WHERE id='$id'");
		$this->registry->get('session')->set("user",$query->row);

		$idquery=$this->registry->get('session')->get("user");
		$permQuery=json_decode($idquery['permission']);
		$permission=$permQuery;
	}
        public function __get($name) {
            $this->registry->get($name);
        }
        public function __set($name, $value) {
            $this->registry->set($name,$value);
        }
}