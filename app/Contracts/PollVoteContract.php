<?php

namespace App\Contracts;

interface PollVoteContract
{

	public function get(array $data);

	public function create(array $data);
}

?>
