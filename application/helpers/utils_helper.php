<?php
if ( ! function_exists('set_active_menu'))
{
	function set_active_menu($breadcrumb, $menu){
		if($breadcrumb['name'] == $menu){
			return 'active';
		}
	}
}