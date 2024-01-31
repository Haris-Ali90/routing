<?php

function backend_view($file) {
    return call_user_func_array( 'view', ['backend/' . $file] + func_get_args() );
}

function backend_path($uri='') {
    return public_path( 'backend/' . $uri );
}

function backend_asset($uri='') {
    return asset( 'backend/' . ltrim($uri,'/') );
}

/*public assets */
function app_asset($uri='') {
    return asset( '/' . ltrim($uri,'/') );
}

function backend_url($uri='/') {
    return call_user_func_array( 'url', ['backend/' . ltrim($uri,'/')] + func_get_args() );
}

function constants($key) {
    return config( 'constants.' . $key );
}

function institute_view($file) {
    return call_user_func_array( 'view', ['institute/' . $file] + func_get_args() );
}

function institute_path($uri='') {
    return public_path( 'institute/' . $uri );
}

function institute_asset($uri='') {
    return asset( 'backend/' . ltrim($uri,'/') );
}

function institute_url($uri='/') {
    return call_user_func_array( 'url', ['institute/' . ltrim($uri,'/')] + func_get_args() );
}

// function  to convert datetime  string to other  time zons
function ConvertTimeZone($dataTimeString,$CurrentTimeZone = 'UTC' ,$ConvertTimeZone = 'UTC',$format = 'Y-m-d H:i:s')
{
    return Carbon\Carbon::parse($dataTimeString, $CurrentTimeZone)->setTimezone($ConvertTimeZone)->format($format);
}