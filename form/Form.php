<?php

namespace MyApp\core\form;

use MyApp\app\BaseModel;

class Form
{

    public static function begin(string $action, string $method, string $name = '')
    {
        echo sprintf("<form  action='%s' method='%s' name='%s'>", $action, $method, $name);
    }

    public static function end()
    {
        echo "</form>";
    }

    public static function submit()
    {
        echo " <button type='submit' class='btn btn-primary'>Submit</button>";
    }

    public static function field(BaseModel $model, string $attribute, string $label = '')
    {
        return new Field($model, $attribute, $label ? $label : $attribute, Field::TEXT_INPUT);
    }
    public static function passwordField(BaseModel $model, string $attribute, string $label = '')
    {
        return new Field($model, $attribute, $label ? $label : $attribute, Field::PASSWORD_INPUT);
    }
    public static function emailField(BaseModel $model, string $attribute, string $label = '')
    {
        return new Field($model, $attribute, $label ? $label : $attribute, Field::EMAIL_INPUT);
    }
    public static function numberlField(BaseModel $model, string $attribute, string $label = '')
    {
        return new Field($model, $attribute, $label ? $label : $attribute, Field::NUMBER_INPUT);
    }
    public static function checkField(BaseModel $model, string $attribute, string $label = '')
    {
        return new Field($model, $attribute, $label ? $label : $attribute, Field::CHECK_INPUT);
    }
    public static function radioField(BaseModel $model, string $attribute, string $label = '')
    {
        return new Field($model, $attribute, $label ? $label : $attribute, Field::RADIO_INPUT);
    }
}
