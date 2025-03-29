<?php

namespace MyApp\core\exceptions;

use Exception;
use MyApp\core\App;

class Forbidden extends Exception
{
    protected  $message = "You don't have permission to visit this page.";
    protected  $code = 403;
}
