<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Contracts\CategoryContract;

class CategoryRepository implements CategoryContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function create(array $data)
    {
        if($data['image']) {    
                            #helper function             #folder name
            $data['image'] = uploadFile($data['image'], 'Category');
        }
        return $this->model->create($data);
    }

    public function changeStatus(array $data)
    {
        $cat = Category::where('id', $data['category_id'])->update(['is_active' => $data['status']]);

        if($cat) {
            return $data;
        }
        
    }

    public function update(array $data, $id)
    {
        $record = $this->findData($id);
        
        if(isset($data['image']) && $data['image']) {    
            #helper function             #folder name
            $data['image'] = uploadFile($data['image'], 'Category');
        }

        return $record->update($data);
    }
    
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}

?>
