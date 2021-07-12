<?php
namespace App\Repositories;

use App\Models\Faq;

class FaqRepository 
{
    # Note : extends BaseRepository for basic functionality
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function changeStatus(array $data)
    {
        $cat = Faq::where('id', $data['faq_id'])->update(['is_active' => $data['status']]);

        if($cat) {
            return $data;
        } else {
            return false;
        }

    }
}

?>
