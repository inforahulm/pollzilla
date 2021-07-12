<?php

namespace App\Contracts;

interface PollContract
{

	public function get(int $id);

	public function update(array $data);

	public function updatePollGeneral(array $data);

	public function create(array $data);

	public function delete(int $id);
	
	public function list(array $data);
	
	public function getRandomPoll(array $data);
	
	public function getSinglePollDetails(array $data);
	
	public function recentPolls(array $data);

	public function getPollResult(array $data);

	public function updateDataWhere(array $data);
}

?>
