<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2006

class control_design
{
	var $menust;
	var $menusa;
	var $menusl;
	var $menus_no;
	var $selected;
	var $info;
	var $title;
	var $error;
	var $slot;
	var $name;

	function control_design()
	{
		$this->menust=array();
		$this->menusa=array();
		$this->menusl=array();
		$this->menus_no=0;
		$this->selected="";
		$this->info="";
		$this->title="";
		$this->error="";
		$this->slot="";
		$this->name="";
	}

	function addMenu($newmenu,$link,$action)
	{
		$this->menusl[$this->menus_no]=$link;
		$this->menusa[$this->menus_no]=$action;
		$this->menust[$this->menus_no]=$newmenu;
		$this->menus_no++;
	}
	function setSelected($sel)
	{
		$this->selected=$sel;
	}
	function setSlot($sel)
	{
		$this->slot=$sel;
	}
	function setID($sel)
	{
		$this->name=$sel;
	}

	function setTexts($title,$info,$error)
	{
		$this->info=$info;
		$this->title=$title;
		$this->error=$error;
	}
	function setInfo($info)
	{
		$this->info=$info;
	}
	function renderTop()
	{
	}

	function renderBottom()
	{
	}

	function resetMenus()
	{
		$this->menus_no=0;
	}
}
?>