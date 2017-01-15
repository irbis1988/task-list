<?php

class Actions extends MainApp{
	
	public $view = '';
	public $title='';
	public $data='';
	public $message='';
	public $cfg;
	public $nav = [
		['view'=>'index','url'=>'','caption'=>'Список задач','auth'=>0],
		['view'=>'add','url'=>'add-task','caption'=>'Нова задача','auth'=>0],
		['view'=>'login','url'=>'sign-in','caption'=>'Авторизоваться','auth'=>-1],
		['view'=>'logout','url'=>'sign-out','caption'=>'Выйти','auth'=>1],
	];

	public function __construct() {
		$this->cfg = parent::config();
	}

	public function actionSignIn(){
		
		$auth = $_POST['auth'];
		if($auth['enter']){
			$login = htmlspecialchars(strip_tags(trim($auth['login'])));
			$pass = htmlspecialchars(strip_tags($auth['pass']));
			if($login == $this->cfg['admin-login'] && $pass == $this->cfg['admin-pass']){
				$_SESSION['auth'] = $this->hashToken();
				header("Location: http://".$_SERVER['HTTP_HOST']);
			}else{
				$this->data['login'] = $auth['login'];
				$this->data['error'] = 'Неверное имя пользователя или пароль';
			}
		}
		
		$this->view = 'login';
		$this->title = 'Авторизация';
		
	}
	
	public function actionSignOut(){
		
		unset($_SESSION['auth']);
		setcookie('auth', '', time()-1, '/');
		header("Location: http://".$_SERVER['HTTP_HOST']."/");
	
	}
	
	public function actionAddTask(){
		
		$add = $_POST['add'];
		if($add['send']){
			
			if(!preg_match('/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/', $add['email'])){
				$error['email'] = 'E-mail введён с ошибками';
			}else{
				$task = new Task();
				$task->email = $add['email'];
			}
			
			if(!count($error) && $_FILES['add']['name']['image']){
				
				if(!in_array($_FILES['add']['type']['image'], ['image/gif','image/jpeg','image/png'])){
					
					$error['image'] = 'Допустимые форматы изображения: jpeg, png, gif';
					
				}elseif($_FILES['add']['size']['image'] > $this->cfg['max-file-size']){
					
					$maxSize = round($this->cfg['max-file-size']/1024);
					$error['image'] = "Максимальный размер загружаемого файла {$maxSize} KB";
					
				}else{
					
					@mkdir(UPL_PATH, 0777);
					$tmp = explode('.',$_FILES['add']['name']['image']);
					$ext = $tmp[sizeof($tmp)-1];
					$uploadfile = UPL_PATH . ($fname = md5($_FILES['add']['name']['image'].time()).'.'.$ext);
				
					if (!empty($add['altImage'])) {
						
						$image_data = str_replace(" ", "+", $add['altImage']);
						$image_data = substr($image_data, strpos($image_data, ","));
						file_put_contents($uploadfile, base64_decode($image_data));
						$task->image = $fname;
					
					}else{
					
						if(move_uploaded_file($_FILES['add']['tmp_name']['image'], $uploadfile)){
							$task->image = $fname;
						} else {
							$error['image'] = 'Ошибка при загрузке изображения';
						}
					}
				}
			}
			
			if(count($error)){
				$this->data=$add;
				$this->data['error']=$error;
			}else{	
				$task->username = htmlspecialchars(strip_tags(trim($add['username'])));
				$task->text = htmlspecialchars(strip_tags(trim($add['text'])));
				$task->addNew();
				$this->message = 'Ваша задача добавлена';
			}
		}
		$this->title = 'Новая задача';
		$this->view = 'add';
		
	}
	
	public function actionPage404(){
		
		http_response_code(404);
		$this->title = 'Ошибка 404. Страница не найдена';
		$this->view = '404';
	
	}
	
	public function actionIndex(){
		
		if($this->isAuth() && ($upd = $_POST['upd'])){ 
			if($upd['send']){
				$task = new Task();
				$task->id = (int)$upd['send'];
				$task->getTask();
				$task->text = htmlspecialchars(strip_tags(trim($upd['text'])));
				$task->status = (int)$upd['status'];
				if($task->update()){
					$this->message = 'Задача изменена';	
				}	
			}
		}
		$order = htmlspecialchars(strip_tags(trim($_GET['o'])));
		$desc = (int)htmlspecialchars(strip_tags(trim($_GET['d'])));
		if( !in_array($order, ['username', 'email', 'status'])){
			$orderQuery = 'username';
		}elseif(isset($desc) && $desc===1){
			$orderQuery ="{$order} DESC";
		}else{
			$orderQuery = $order;
		}
		$task = new Task();
		$this->data['tasks'] = $task->getAllTasks($orderQuery);
		$this->data['o'] = $order;
		$this->data['d'] = $desc;
		$this->title = "Список задач";
		$this->view = 'index';
		
	}
	
	private function hashToken(){
		return md5(md5($this->cfg['admin-login']).md5($this->cfg['admin-pass']));
	}
	
	public function isAuth(){
		
		$auth = $_SESSION['auth'];
		if(!$auth || $auth!==self::hashToken()){
			return false;
		}
		return true;
		
	}
	
}
