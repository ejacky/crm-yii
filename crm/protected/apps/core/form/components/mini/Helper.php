<?php

class Helper extends MiniBase
{
	
	/**
	 * 
	 * 
	 */
	public function getUserprivilege()
	{
		if(isset($_GET['findings']) && !empty($_GET['findings'])) {
			$condition1 = " id IN (select progress_id  from 2014_progress_schedule where status='".$_GET['findings']."')";
			$val = $_GET['findings'];
		}else{
			$condition1 = " 1=1 ";
		}
	}

}