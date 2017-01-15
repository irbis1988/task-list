<?php 

class Task extends MainApp{
	
	protected $cfg;
	protected $link;
	
	public $id;
	public $username;
	public $email;
	public $text;
	public $image;
	public $status;
	
	public function __construct(){
		
		$this->cfg = parent::config();
		$this->link = mysqli_connect($this->cfg['db-host'], 
			$this->cfg['db-user'], $this->cfg['db-pass'], $this->cfg['database']) or die('Error '. mysqli_error($this->link));
		
	}
	
	public function addNew(){
		
		$query = "INSERT INTO task (username,email,text,image) VALUES ('{$this->username}','{$this->email}','{$this->text}','{$this->image}')";
		
		return mysqli_query($this->link, $query) 
			or die('Error '. mysqli_error($this->link)); 
		
	}
	
	public function update(){
		
		$query = "UPDATE task SET text='{$this->text}', status={$this->status} WHERE id='{$this->id}'";
		
		return mysqli_query($this->link, $query) 
			or die('Error '. mysqli_error($this->link)); 
		
	}
	
	public function getTask(){
		
		if(!isset($this->id)){
			return false;
		}
		
		$query = "SELECT * FROM task WHERE id='{$this->id}'";
		
		if(($result = mysqli_query($this->link, $query) 
			or die('Error '. mysqli_error($this->link)))){ 
			if(mysqli_num_rows($result) > 0){ 
				$row =  mysqli_fetch_assoc($result);
				foreach($row as $field => $value){
					$this->{$field} = $value;
				}
				return true;
			}
			return false;
		}
		
	}
	
	public function getAllTasks($order='username'){
		
		$query = "SELECT * FROM task ORDER BY {$order}";
		
		if(($result = mysqli_query($this->link, $query) 
			or die('Error '. mysqli_error($this->link)))){ 
			if(mysqli_num_rows($result) > 0){ 
				$i=0;$res=[];
				while($row =  mysqli_fetch_assoc($result)){
					$i++;
					$res[$i] = new Task();
					foreach($row as $field => $value){
						$res[$i]->{$field} = $value;
					}
				}
				return $res;
			}
			return false;
		}
		
	}
	
}
