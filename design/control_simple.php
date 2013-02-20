<?php
// Copyright AI Software Ltd Bucharest, Romania 2001-2006
require_once("design/control_design.php");

class simple_design extends control_design
{
	function renderTop()
	{
		?>
		<?php if($this->title!=''){?><FIELDSET><legend><?php  echo $this->title;?></legend><?php }?>
		<table width=100% style="border:none;" <?php if($this->name!="") echo 'id="'.$this->name.'"';?>>
		<?php if($this->error!=''){?><tr><td align=center class=error <?php if($this->menus_no>0){?>colspan=2<?php }?>><?php  echo $this->error;?></td></tr><?php }?>
		<?php if($this->info!=''){?><tr><td align=center class=info <?php if($this->menus_no>0){?>colspan=2<?php }?>><?php  echo $this->info;?></td></tr><?php }?>
		<?php if($this->menus_no>0){?><tr><td align=center valign=top><ul>
			<?php
			for ( $i = 0; $i < $this->menus_no; $i++ )
			{
				if($this->selected!=$this->menusa[$i])
				{
					?>
					<li>
					<a class=menu href="<?php echo $this->menusl[$i];?>"><?php echo $this->menust[$i];?></a></li>
					<?php
				}
				else
				{
					?>
					<li><a class=selmenu href="<?php echo $this->menusl[$i];?>"><?php echo $this->menust[$i];?></a></li>
					<?php

				}
			}
			?>
			</ul>
			</td><?php }
			else
			{
				?><tr><?php
			}?>
		<td width=80% align=center valign=top>
		<?php
	}

	function renderBottom()
	{
		?>
		</td></tr>
		</table>
		<?php if($this->title!=''){?></FIELDSET><?php }?>
		<?php
	}
}
?>