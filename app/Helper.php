<?php

use App\Models\User;

if ( ! function_exists('uploadFile'))
{
    function uploadFile($file, $dir)
    {
        if ($file) {

            $destinationPath =  storage_path('app/public'). DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR;

            $media_image = $file->hashName();

            $file->move($destinationPath, $media_image);

            return $media_image;
        }
    }
}
if( ! function_exists('encryptString')) 
{
    function encryptString($plaintext) {
        $ciphertext_raw =  openssl_encrypt($plaintext, 'AES-256-CBC', config('app.SERVER_ENCRYPTION_KEY')
            , $options = 0, config('app.SERVER_ENCRYPTION_IV'));
        return base64_encode($ciphertext_raw);
    }
}

if( ! function_exists('decryptString')) 
{

    function decryptString($plaintext) {
        $c = base64_decode($plaintext);
        $original_plaintext = openssl_decrypt($c, 'AES-256-CBC', config('app.SERVER_ENCRYPTION_KEY'), $options = 0, config('app.SERVER_ENCRYPTION_IV'));
        return $original_plaintext;
    }
}

function getUserData($id)
{
    $user = User::find($id);
    if($user)
        return User::select(['id',
            'user_name',
            'email',
            'verify_status',
            'first_name',
            'mobile_number',
            'birthdate',
            'gender',
            'profile_picture',
            'country_id',
            'state_id',
            'city_id',
            'company_name',
            'school_name',
            'facebook_url',
            'twitter_url',
            'interest_sub_category_ids',
            'following_user_ids',
            'follower_user_ids',
            'device_type',
            'device_token',
            'social_types',
            'social_id',
            'status',
            'remember_token',
            'created_at',
            'isguest'])->withCount(['poll','follower','following'])->find($user->id);
    return null;
}

function sendPushNotification($registration_ids,$device_type,$payload) {
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key=' . config('FCM_SERVER_KEY')
    );
    if($registration_ids ==null || $registration_ids =="")
        return true;
    if($device_type=='1') {
        $payload = array(
            'notification'=>array(
                'title'=>isset($payload['title']) ? $payload['title'] : "Pollzilla",
                'body'=>isset($payload['body']) ? $payload['body'] : ""
            ),
            'data'=>array(
                "click_action" =>isset($payload['click_action']) ? $payload['click_action'] : "NOTIFICATION_CLICK",
                'screen'=>isset($payload['screen']) ? $payload['screen'] : "Pollzilla",
                'object'=>isset($payload['object']) ? $payload['object'] : array(),
                'object_data'=>isset($payload['object_data']) ? $payload['object_data'] : array()
            ),
            'priority'=>isset($payload['priority']) ? $payload['priority'] : "high",
            'to'=>$registration_ids
        );
    } else {
        $payload = array(
            'notification'=>array(
                'title'=>isset($payload['title']) ? $payload['title'] : "Pollzilla",
                'body'=>isset($payload['description']) ? $payload['description'] : "Pollzilla"
            ),
            'data'=>array(
                "message" =>isset($payload['title']) ? $payload['title'] : "Pollzilla",
                'data'=>isset($payload['description']) ? $payload['description'] : "Pollzilla",
            ),
            'priority'=>isset($payload['priority']) ? $payload['priority'] : "high",
            'to'=>$registration_ids
        );
    }
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, config('FCM_URL'));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response,true);
    if(isset($response['success']) && $response['success']==1) return true; else return false;
}

if( ! function_exists('getHumanReable')) 
{

    function getHumanReable($minutes) {

        if (!$minutes) return '0 minutes';
        $periods = array('year' => 525600,
            'month' => 43800,
            'week' => 10080,
            'day' => 1440,
            'hour' => 60,
            'minute' => 1);
        $output = array();
        foreach ($periods as $period_name => $period) {
            $num_periods = floor($minutes / $period);
            if ($num_periods > 1) {
                $output[] = "$num_periods {$period_name}s";
            }
            elseif ($num_periods > 0) {
                $output[] = "$num_periods {$period_name}";
            }
            $minutes -= $num_periods * $period;
        }
        return implode(' : ', $output);
    }
}
?>
