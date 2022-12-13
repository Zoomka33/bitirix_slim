<?php

namespace App\Exceptions;

use App\View\View;

class NotFoundException extends \Exception
{

    public function view(): void
    {
        echo View::renderHtml('service.500');
    }
}