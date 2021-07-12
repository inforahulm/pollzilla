<?php

namespace App\Contracts;

interface ContactUsContract
{
	
	public function create(array $data);
	
	public function myContactUs(array $data);

}

?>
