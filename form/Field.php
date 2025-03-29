<?php

namespace MyApp\core\form;

use MyApp\app\BaseModel;

class Field
{

    public const TEXT_INPUT = 'text';
    public const EMAIL_INPUT = 'email';
    public const PASSWORD_INPUT = 'password';
    public const NUMBER_INPUT = 'number';
    public const RADIO_INPUT = 'radio';
    public const CHECK_INPUT = 'check';

    private string $input = "<div class='mb-3'>
        <label for='name' class='form-label'>%s</label>
        <input type='%s' class='form-control %s'  name='%s' value='%s'/>
        <div class='form-text %s'>%s</div>
    </div>";

    private BaseModel $baseModel;
    private string $attribute;
    private string $label;
    private string $type;

    public function __construct($model, $attribute, $label, $type)
    {
        $this->baseModel = $model;
        $this->attribute = $attribute;
        $this->label = $label;
        $this->type = $type;
    }

    public  function __toString()
    {
        $message = sprintf(
            $this->input,
            $this->label,
            $this->type,
            $this->baseModel->hasError($this->attribute) ? "is-invalid" : "",
            $this->attribute,
            $this->baseModel->{$this->attribute} ?? '',
            $this->baseModel->hasError($this->attribute) ? "text-danger" : "d-none",
            $this->baseModel->hasError($this->attribute),

        );

        return $message;
    }
}
