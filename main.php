<?php
	error_reporting(E_ALL);

	set_error_handler("errorfunction");
	ini_set("display_errors",'1');

	require_once 'myfunctions.php';

	$classfiles=scandir(DIR_CLASS,1);

	for ($i=0; $i < count($classfiles); $i++) { 
		# code...
		if (is_file(DIR_CLASS.$classfiles[$i])) {
			# code...
			require_once DIR_CLASS.$classfiles[$i];
		}
		
	}

	$dbfiles=scandir(DIR_DB,1);

	for ($i=0; $i < count($dbfiles); $i++) { 
		# code...
		if (is_file(DIR_DB.$dbfiles[$i])) {
			# code...
			require_once DIR_DB.$dbfiles[$i];
		}
		
	}

	$registry=new Registry();

	$system=new System();
	$registry->set("sys",$system);

	$log=new Log(DIR_STORAGE."logfiles.txt",DIR_STORAGE."accessfiles.txt");
	$registry->set("log",$log);

	$loader=new Loader($registry);
	$registry->set("load",$loader);

	$event=new Events($registry);
	$registry->set("event",$event);

	$request=new Request();
	$registry->set("request",$request);

	$response=new Response();
	$registry->set("response",$response);

	if (!isset($request->get['route'])) {
		# code...
		$request->get['route']="common/home";
	}
	$action=new Action($request->get['route']);
	$registry->set("action",$action);

	$document=new Document();
	$registry->set("document",$document);

	$db=new DB();
	$registry->set("db",$db);

	$config=new Config($db);
	$registry->set("config",$config);

	$language=new Language();
	$registry->set("language",$language);

	$url=new URL();
	$registry->set("url",$url);

	$user=new User($registry);
	$registry->set('user',$user);

	$session=new Session();
	$registry->set("session",$session);
	$session->start();
	

	$loader->Controller($request->get['route']);
	$log->writeAccess(date('Y/m/d H:i:s')."\t".$request->server['REQUEST_METHOD']."\t".$request->server['REQUEST_URI']."\t".$request->server['REMOTE_ADDR']."\t".$request->server['HTTP_USER_AGENT']."\tport: ".$request->server['REMOTE_PORT']."\n");
	$registry->get("response")->Output();

    
 function errorfunction($errno,$errstr,$errfile,$errline)
	{
		global $log,$registry;
		switch ($errno) {
			case E_USER_ERROR:
			case E_ERROR:
				# code...
				$massage="   ";
				$massage.=date("Y-m-d H:i:s");
				$massage.=" Error: ";
				$massage.="   $errstr";
				$massage.="  in ".$errfile;
				$massage.=" on line  ".$errline;
				$massage.=" php ".PHP_VERSION;
				$massage.="(".PHP_OS.")\n";
				$log->write($massage);
				echo "<h2>";
				print_r(date("Y-m-d H:i:s"));
				print_r(" Error: ".$errstr." in ".$errfile." on line ".$errline);
				echo "</h2>";
                $registry->set("error",$errstr);
				exit();
				break;
			case E_USER_WARNING:
			case E_WARNING:
				# code...
				$massage="   ";
				$massage.=date("Y-m-d H:i:s");
				$massage.=" Warning: ";
				$massage.="   $errstr";
				$massage.="  in ".$errfile;
				$massage.=" on line  ".$errline;
				$massage.=" php ".PHP_VERSION;
				$massage.="(".PHP_OS.")\n";
				$log->write($massage);
				/*echo "<h2>";
				print_r(date("Y-m-d H:i:s"));
				print_r(" Warning: ".$errstr." in ".$errfile." on line ".$errline);
				echo "</h2>";*/
                $registry->set("error",$errstr);
				break;
			case E_USER_NOTICE:
			case E_NOTICE:
				# code...
				$massage="   ";
				$massage.=date("Y-m-d H:i:s");
				$massage.=" Notice: ";
				$massage.="   $errstr";
				$massage.="  in ".$errfile;
				$massage.=" on line  ".$errline;
				$massage.=" php ".PHP_VERSION;
				$massage.="(".PHP_OS.")\n";
				$log->write($massage);
				/*echo "<h2>";
				print_r(date("Y-m-d H:i:s"));
				print_r(" Notice: ".$errstr." in ".$errfile." on line ".$errline);
				echo "</h2>";*/
                $registry->set("error",$errstr);
				break;
			default:
				# code...
				$massage="   ";
				$massage.=date("Y-m-d H:i:s");
				$massage.=" Unknown Error: [$errno] ";
				$massage.="   $errstr";
				$massage.="  in ".$errfile;
				$massage.=" on line  ".$errline;
				$massage.=" php ".PHP_VERSION;
				$massage.="(".PHP_OS.")\n";
				$log->write($massage);
				/*echo "<h2>";
				print_r(date("Y-m-d H:i:s"));
				print_r(" Unknown Error: ".$errstr." in ".$errfile." on line ".$errline);
				echo "</h2>";*/
                $registry->set("error",$errstr);
				break;
		}
		
	}