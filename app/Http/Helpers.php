<?php

use App\Models\Role;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Menu;
use App\Models\PermissionRole;
use App\Models\Permissions;
use Matthewbdaly\LaravelAzureStorage\AzureBlobStorageAdapter;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use App\Models\BranchUnit;
use App\Models\Application;
use Illuminate\Support\Facades\Cache;

function name_user(){
	$id = Auth::id();
	$user = User::select('name')->where('id',$id)->first();
    $name = '';
	if($user){
        $name = $user->name;
	}
	echo $name;
}
function role_user(){
	$id = Auth::id();
	$role_user_id = UserRole::select('role_id')->where('user_id',$id)->pluck('role_id')->toArray();
	if(!isset($role_user_id[0])){
		return redirect('/');
	}
	$role_id= $role_user_id[0];
	$permissions =Role::select('name')->where('id',$role_id)->pluck('name')->toArray();
	echo $permissions[0];
}
function photo_user(){
	$user = Auth::user();
    $avatar = asset('img/no-avatar.jpg');
	if($user && isset($user->avatar) && $user->avatar!=''){
        $avatar = generateSecureUrl($user->avatar);
	}
	return $avatar;
}

function user_location(){
	$user = Auth::user();
    $branch = null;
	if(isset($user->branch_unit_id)){
        $branch = BranchUnit::find($user->branch_unit_id);
    }
	return $branch ? $branch->name:'';
}


function check_access($feature, $access): bool
{
    $id = Auth::id();
    if (!$id) return false;

    $cacheKey = "access:{$id}:{$feature}:{$access}";

    return Cache::remember($cacheKey, 300, function () use ($id, $feature, $access) {
        return \App\Models\UserRole::where('user_roles.user_id', $id)
            ->join('permission_roles', 'user_roles.role_id', 'permission_roles.role_id')
            ->join('permissions', 'permission_roles.permission_id', 'permissions.id')
            ->where('permissions.feature', $feature)
            ->where('permissions.access', $access)
            ->exists();
    });
}

function pmt($interest, $tenor, $amount, $round_off){
    $pmt = abs($interest * ($amount * (pow((1 + $interest), $tenor) / (1 - pow((1 + $interest), $tenor)))));
    return ceil($pmt/$round_off)*$round_off;
}

function unmaskCurrency($value, $format = 'Rp'){
    $result = str_replace([$format, ' ',',00','.',','],'', $value);
    return $result;
}


function PV($rate, $periods, $payment, $future = 0, $type = 0) {
    $result = abs((((1 - pow(1 + $rate, $periods)) / $rate) * $payment * (1 +$rate * $type) - $future) / pow(1 + $rate, $periods));
    return round($result);
}

function generateSecureUrl($path, $ttl = 1440){
    $path = ltrim($path, '/');
    $url            = env('AZURE_STORAGE_URL');
    $key            = env('AZURE_STORAGE_KEY');
    $storageName    = env('AZURE_STORAGE_NAME');
    $container      = env('AZURE_STORAGE_CONTAINER');

    $client = BlobRestProxy::createBlobService('DefaultEndpointsProtocol=https;AccountName='.$storageName.';AccountKey=' . base64_encode($key));
    $adapter = new AzureBlobStorageAdapter($client, $container, $key, $url, null);
    $scureUrl = $adapter->getTemporaryUrl($path, \Carbon\Carbon::now('+07:00')->addMinutes($ttl));

    return $scureUrl;
}

function formatIDR($number){
    return 'Rp.  '.number_format($number,2,",",".");
}

function numToWords($number){
    $number = str_replace('.', '', $number);

    if (! is_numeric($number)) {
        return '';
    }

    $base = array('nol','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan');
    $number_group = array(1000000000000000, 1000000000000, 1000000000000, 1000000000, 1000000, 1000, 100, 10, 1);
    $unit    = array('kuadriliun', 'triliun', 'biliun', 'milyar', 'juta', 'ribu', 'ratus', 'puluh', '');
    $str     = null;

    $i = 0;

    if ($number == 0){
        $str = 'nol';
    }
    else{
        while ($number != 0){
            $count = (int)($number / $number_group[$i]);

            if ($count >= 10){
                $str .= numToWords($count) . ' ' . $unit[$i] . ' ';
            }
            elseif ($count > 0 && $count < 10){
                $str .= $base[$count] . ' ' . $unit[$i] . ' ';
            }

            $number -= $number_group[$i] * $count;
            $i++;
        }

        $str = preg_replace('/satu puluh (\w+)/i', '\1 belas', $str);
        $str = preg_replace('/satu (ribu|ratus|puluh|belas)/', 'se\1', $str);
        $str = preg_replace('/\s{2,}/', ' ', trim($str));
    }

    return $str;
}

function acronym($string){
    $result = $string;
    if(preg_match_all('/\b(\w)/',strtoupper($string),$m)) {
        $result = implode('',$m[1]);
    }
    return $result;
}

function applicationDocumentType($type){
    $name = [
        'slik'=>'Slik',
        'application'=>'Pengajuan',
        'interview_video'=>'Video Wawancara',
        'insurance_video'=>'Video Asuransi',
        'credit-analysis'=>'MAUK',
    ];

    $result = isset($name[$type]) ? $name[$type] : $type;
    return $result;
}

function hexColor(){
    $color = [
        '#FF0000',
        '#800000',
        '#FFFF00',
        '#808000',
        '#00FF00',
        '#008000',
        '#00FFFF',
        '#008080',
        '#0000FF',
        '#000080',
        '#FF00FF',
        '#800080',
    ];
    return $color;
}

function getNotificationData(){
    return Application::getNotificationData();
}

function user_role($user_id = null)
{
    if (is_null($user_id)) {
        $user_id = Auth::id();
    }
    if (!$user_id) return null;

    return Cache::remember("user_role:{$user_id}", 300, function () use ($user_id) {
        $userRole = \App\Models\UserRole::select('role_id')->where('user_id', $user_id)->first();
        if (!$userRole) return null;
        return \App\Models\Role::with('permissions')->find($userRole->role_id);
    });
}

?>
