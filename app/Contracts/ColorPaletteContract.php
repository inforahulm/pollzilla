<?php

namespace App\Contracts;

interface ColorPaletteContract
{
	public function get(int $id);

	public function list(array $data);

	public function create(array $data);

	public function update(array $data);

	public function delete(int $id);

	public function changeStatus(array $data);

}

?>
