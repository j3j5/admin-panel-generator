<?php namespace VivifyIdeas\AdminPanelGenerator\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

    use DispatchesCommands, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(packageConfig('authMiddleware'));
    }

    public function prepareFilterValue($sql, $value)
    {
        return ($sql == 'LIKE')? '%' . $value . '%' : $value;
    }

}
