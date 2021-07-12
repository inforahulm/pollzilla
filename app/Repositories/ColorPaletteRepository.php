<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\ColorPalette;
use App\Contracts\ColorPaletteContract;

class ColorPaletteRepository implements ColorPaletteContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

	public function get(int $id)
	{
		return ColorPalette::find($id);
	}

	public function list(array $data)
	{
		return ColorPalette::where('status',1)->orderBy('id','DESC')->get();
	}

	public function create(array $data)
	{
		return ColorPalette::create($data);
	}

	public function changeStatus(array $data)
	{
		$cat = ColorPalette::where('id', $data['category_id'])->update(['status' => $data['status']]);

		if($cat) {
			return $data;
		}

	}

	public function update(array $data)
	{
		$category = $this->get($data['id']);

		return $category->update($data);
	}

	public function delete($id)
	{
		return ColorPalette::where('id',$id)->delete();
	}
}

?>
