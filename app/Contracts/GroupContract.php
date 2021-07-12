<?php

namespace App\Contracts;

interface GroupContract
{
	
	public function create(array $data);

	public function myGroup($id);

	public function groupDetails(array $data);

	public function editGroup(array $data);

	public function DeleteGroup(array $data);

	public function addGroupMembers(array $data);

}

?>
