<?php


namespace cva67\phpmvc;


class Session
{

    protected const FLASH_KEY = "flash_message";

    public function __construct()
    {
        session_start();
    }

    public  function setFlash($key, $message, $type = 'info')
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'message' => $message,
            'type' => $type
        ];
    }

    public  function getFlash($key)
    {
        if (isset($_SESSION[self::FLASH_KEY][$key])) {
            $flash = $_SESSION[self::FLASH_KEY][$key];
            unset($_SESSION[self::FLASH_KEY][$key]);
            return $flash;
        }
        return null;
    }

    public  function displayFlash($key)
    {
        $flash = self::getFlash($key);
        if ($flash) {
            echo "<div class='alert alert-{$flash['type']} alert-dismissible fade show' role='alert'>
                    {$flash['message']}
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
    }


    public function existsFlash($key)
    {
        return isset($_SESSION[self::FLASH_KEY][$key]);
    }

    public  function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public  function getSession($key)
    {
        if (isset($_SESSION[$key])) {
            $session = $_SESSION[$key];
            return $session;
        }
        return null;
    }
    public  function destorySession()
    {
        session_unset();
        session_destroy();
    }
    public function existsSession($key)
    {
        return isset($_SESSION[$key]);
    }
}
