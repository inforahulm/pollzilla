<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\InterestCategory;
use App\Models\SubInterestCategory;
use App\Contracts\InterestCategoryContract;

class InterestCategoryRepository implements InterestCategoryContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function get(int $id){
        return InterestCategory::find($id);
    }

    public function list(array $data){
        return InterestCategory::With('subcategories')->where('status',1)->orderBy('id','DESC')->get();
    }

    public function create(array $data)
    {
        $res = InterestCategory::create($data);
        SubInterestCategory::create([
            'interest_category_id'=>$res->id,
            'interest_sub_category_name'=>$data['interest_category_name'],
            'status'=>1
        ]);
        return $res;
    }

    public function changeStatus(array $data)
    {
        $cat = InterestCategory::where('id', $data['category_id'])->update(['status' => $data['status']]);

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
        return InterestCategory::where('id',$id)->delete();
    }
}

?>
