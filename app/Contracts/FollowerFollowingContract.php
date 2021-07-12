<?php

namespace App\Contracts;

interface FollowerFollowingContract
{
	public function followUnfollow(array $data);
	
	public function followerList(array $data);

	public function followingList(array $data);
}

?>
