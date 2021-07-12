<?php

namespace App\Contracts;

interface PollCommentContract
{

	public function get(array $data);

	public function create(array $data);
	
	public function list(array $data);
}

?>
