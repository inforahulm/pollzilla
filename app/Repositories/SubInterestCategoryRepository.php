<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubInterestCategory;
use App\Contracts\SubInterestCategoryContract;

class SubInterestCategoryRepository implements SubInterestCategoryContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function get(int $id){
        return SubInterestCategory::find($id);
    }

    public function list(array $data){
        $subInterestCategory=new SubInterestCategory();
        if(isset($data['interest_category_id']) && !empty($data['interest_category_id'])){
            $subInterestCategory=$subInterestCategory->where('interest_category_id',$data['interest_category_id']);
        }
        if(isset($data['id']) && !empty($data['id'])){
            $subInterestCategory=$subInterestCategory->where('id',$data['id']);
        }
        if(isset($data['status']) && !empty($data['status'])){
            $subInterestCategory=$subInterestCategory->where('status',$data['status']);
        }
        $subInterestCategory=$subInterestCategory->orderBy('id','DESC')->get();

        return $subInterestCategory;

    }

    public function create(array $data)
    {
        return SubInterestCategory::create($data);
    }

    public function changeStatus(array $data)
    {
        $cat = SubInterestCategory::where('id', $data['category_id'])->update(['status' => $data['status']]);

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
        return SubInterestCategory::where('id',$id)->delete();
    }
}

?>
