<?php

namespace App\Contracts;

interface CommonContract
{
    public function countryList();
    
    public function stateList(array $data);
    
    public function cityList(array $data);
    
    public function uploadFile($data);
}

?>
