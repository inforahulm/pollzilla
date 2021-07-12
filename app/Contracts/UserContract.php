<?php

namespace App\Contracts;

interface UserContract
{
    // public function all();

    public function create(array $data);

    public function createSocial(array $data);

    public function updateSocial(array $data, $id);

    public function login(array $data);

    public function verifiyOTP(array $data);

    public function resendOTP();

    public function update(array $data, $id);

    public function changePassword(array $data);
    
    public function getProfile(array $data);
    
    public function updateDataWhere(array $data);

    public function get(int $id);

    public function getFollowerList(int $id);
    
    public function getFollowingList(int $id);
    
    public function getInterestList(int $id);

    // public function delete($id);

    // public function show($id);
}

?>
