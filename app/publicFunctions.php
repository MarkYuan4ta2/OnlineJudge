<?php
/**
 * Created by PhpStorm.
 * User: 4ta2
 * Date: 2016/4/16
 * Time: 17:22
 * Usage: some public functions written by me
 */
if (! function_exists('checkUserPriority')) {
    /**
     * @param $checkedPriority : the number which is going to be checked
     * @return boolean
     */
    function checkUserPriority($checkedPriority){
        if(Auth::user()->is_admin == 2){
            return true;
        }else if(Auth::user()->id == $checkedPriority){
            return true;
        }

        return false;
    }
}