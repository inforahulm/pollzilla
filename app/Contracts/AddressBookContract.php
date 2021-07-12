<?php

namespace App\Contracts;

interface AddressBookContract
{
	
	public function create(array $data);

	public function myAddressBook($id);

	public function deleteAddressBook(array $data);
	
	public function searchUser(array $data);

}

?>
