<?php
class My_Functions
{
	
	static function getLienTitle($titre = "")
	{
		$p[0] = "/(éèê)/";
		$p[1] = "/(à)/";
		$p[2] = "/(ç)/";
		$p[3] = "/[^a-zA-Z]/";
		$p[4] = "/(-)+/";
		
		$r[0] = "e";
		$r[1] = "a";
		$r[2] = "c";
		$r[3] = "-";
		$r[4] = "-";
		
		$titre = preg_replace($p ,$r , $titre);
		
		return $titre;
	}

	static function countImg($link, array $imgs)
	{
		$c = 0;
		foreach($imgs as $k=>$v):
			$imgs[$k] = self::getImg($link, $v['nom_image']);
			if(strpos( $imgs[$k] ,'defaut') === false):
				$c++;
			endif;
		endforeach;
		return $c;
	}
	
	static function getImg($link = '', $img = '')
	{
		$link = substr($link,1);
		return is_file($link.$img) ? '/'.$link.$img :  '/'.$link.'defaut.png';
	}

	static function saveUrl($params=array())
	{
		$url = new Zend_Session_Namespace('url');
		$url->params = $params;
	}

	static function getSavedUrl()
	{
		$url = new Zend_Session_Namespace('url');
		return $url->params;
	}

	static function clearSavedUrl()
	{
		$url = new Zend_Session_Namespace('url');
		unset($url->params);
	}

	static function renameUploads(&$names, $dist="", $slug="")
	{		
		$names = is_string($names) ? array($names) : $names;
		$i = 0;
		foreach($names as $k => $values):			
			$i++;			
			$newName = $slug . $i . strrchr($values,'.');
			$names[$k] = $newName;
			@rename('tmp/' . $values, $dist . $newName);
		endforeach;
		
	}
	
	static function renameImages(&$names, $dist="", $slug="")
	{
		$names = is_string($names) ? array($names) : $names;
		$i=1;
		foreach($names as $k=>$values):
		
			do{
				$newName = $slug . $i . strrchr($values,'.');
				$i++;
			}while(file_exists($dist . $newName));
			
			$names[$k] = $newName;
			@rename('tmp/' . $values, $dist . $newName);
		endforeach;
		
	}
	
	static function getPostedOptions($params)
	{
		$op = array();
		if(is_array($params)):
			
			foreach($params as $k=>$v):
				if(preg_match('/option([0-9]+)/',$k, $out)):
					if( isset($out[1]) and  $v == 1) $op[] = $out[1];
				endif;
			endforeach;
		endif;
		return $op;
	} 
}