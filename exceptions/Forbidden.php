<?php

namespace cva67\phpmvc\core\exceptions;

use Exception;
use cva67\phpmvc\core\App;

class Forbidden extends Exception
{
    protected  $message = "You don't have permission to visit this page.";
    protected  $code = 403;
}
