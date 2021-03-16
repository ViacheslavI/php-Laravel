<?php

namespace App\Http\Controllers\Blog\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Blog\BaseController as GuestBaseController;

/** базовыйконтроллер  длявсех контроллеров управления  блогом в панели администрирования. Дэолжен быть родителем всех контроллеров управления блогом */
abstract class BaseController extends GuestBaseController
{
    public function __construct()
    {
        // инициализация общих  моментов для админки
    }

}
