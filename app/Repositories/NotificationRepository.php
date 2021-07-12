<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\NotifictionAdmins;
use App\Models\User;
use App\Models\Notifications;
use App\Contracts\NotificationContract;

class NotificationRepository implements NotificationContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function get($id)
    {
        return NotifictionAdmins::find($id);
    }
    public function create(array $data)
    {
        return NotifictionAdmins::create($data);
    }


    public function update(array $data)
    {
        $record = $this->get($data['id']);

        return $record->update($data);
    }


    public function delete($id)
    {
        return NotifictionAdmins::where('id',$id)->delete();
    }


    public function sendPush($id)
    {
        $notification = $this->get($id);
        $notification->sended_at = date('Y-m-d H:i:s');
        $notification->save();
        $users = User::where('isguest',0)->get();
        if(!empty($users)){
            foreach ($users as $key => $value) {
                Notifications::create([
                    'notification_title'=>$notification->title,
                    'notification_description'=>$notification->description,
                    'user_id'=>$value->id,
                    'notification_type'=>0,
                    'sender_user_id'=>0,
                    'poll_id'=>0,
                    'status'=>1
                ]);
                if(!empty($value->device_token)){
                    $payload =[
                        'title'=>$notification->title,
                        'description'=>$notification->description
                    ];
                    sendPushNotification($value->device_token,$value->device_type,$payload);
                }
            }
        }
        return $notification;
    }



}

?>
