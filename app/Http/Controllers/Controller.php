<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Route;



abstract class Controller extends BaseController
{
    use ValidatesRequests;

   public function getTitle($language)
    {
        $method = $this->extractRoute();

        return trans($language . '.' . $method . '.title');
    }
    /**
     * @param $language
     * @return string
     */
    public function getDescription($language)
    {
        $method = $this->extractRoute();

        return trans($language . '.' . $method . '.description');
    }

    /**
     * @return mixed
     */
    protected function extractRoute()
    {
        $route  = Route::current();
        $data   = explode('@', $route->getActionName());
        $method = $data[1];

        return $method;
    }
}
