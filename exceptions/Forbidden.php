<?php

namespace cva67\phpmvc\exceptions;

use Exception;


class Forbidden extends Exception
{
    protected  $message = "You don't have permission to visit this page.";
    protected  $code = 403;
}
