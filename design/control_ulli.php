<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2006

require_once("design/control_design.php");

class ulli_design extends control_design
{
	function renderTop()
	{
		if($this->name!="") echo '<div id="'.$this->name.'">';
		if($this->title!=''){?><h1><?php echo $this->title;?></h1><?php }
		if($this->error!=''){?><h3 class="error"><?php echo $this->error;?></h3><?php }
		if($this->info!=''){?><h3 class="info"><?php echo $this->info;?></h3><?php }
		if($this->menus_no>0){?><ul class="controlmenu">
			<?php
			for ( $i = 0; $i < $this->menus_no; $i++ )
			{
				if($this->selected!=$this->menusa[$i])
				{
					?>
					<li><a class=menu href="<?php echo $this->menusl[$i];?>"><?php echo $this->menust[$i];?></a></li>
					<?php
				}
				else
				{
					?>
					<li><a class=selmenu href="<?php echo $this->menusl[$i];?>"><?php echo $this->menust[$i];?></a></li>
					<?php

				}
			}?></ul><?php
		}
	}

	function renderBottom()
	{
		if($this->name!="") echo '</div>';
	}
}
?>
