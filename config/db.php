<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2011
if(!function_exists("writeDbSaveState"))
{
function writeDbSaveState($table,$id,$op)
{
	if(getUserConfig("dbobjversions")!="")
	{
		$alltable=explode(",",getUserConfig("dbobjversions"));
		if(in_array($table,$alltable))
		{
			//save state
			$del=create_db_connection();
			$del->addnew("junk_items");
			$del->setvalue("fromtable",$table);
			$del->setvalue("opid",$id);
			$del->setvalue("operation",$op);
			$newid=$del->update();
			$del->execute("delete from junk_items where fromtable='".$table."' and opid=0".$id." and operation=0".$op." and id<0".$newid);
		}
	}
}
function writeDbDeleteCheck($sql)
{
	if(getUserConfig('dbsynchron')!="")
	{
		//check for delete items to play on sync
		if(substr($sql,0,12)=="delete from ")
		{
			$table=trim(strtok(substr($sql,12)," "));
			if($table!="junk_items")
			{
				$where=strtok(" ");
				$where=strtok("");

				$del=create_db_connection();
				$del->openselect("select id from ".$table." where ".$where);
				$delids="";
				while(!$del->eof())
				{
					if($delids!="") $delids.=",";
					$delids.=$del->getvalue("id");
					$del->movenext();
				}
				$del=create_db_connection();
				$del->addnew("junk_items");
				$del->setvalue("fromtable",$table);
				$del->setvalue("delid",$delids);
				$del->setvalue("operation",3);
				$del->update();
			}
		}
	}
}

function writeDbLogSql($sql,$type='s')
{
	if(getUserConfig("dblog")!="")
	{
		if($type=='s')
		{
			if(substr($sql,0,24)=="insert into pdfarchiving") return;
		}
		$f=fopen(getUserConfig("dblog"),"a");
		if($f)
		{
			fwrite($f,$type.":".serialize($sql)."\r\n");
			fclose($f);
		}
		else
		{
			session_addvalue("error","unable to write db log");
		}
	}
}
}

if(file_exists("config/db_dummy.php")) require_once("config/db_dummy.php");

?>
