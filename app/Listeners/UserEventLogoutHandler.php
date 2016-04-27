<?php
/**
 * Created by PhpStorm.
 * User: Saša
 * Date: 21.4.2016.
 * Time: 8:26
 */

namespace app\Listeners;


class UserEventLogoutHandler
{
    public function handle($event) {
        dd('logout');
    }
}