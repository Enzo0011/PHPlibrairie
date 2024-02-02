<?php
class FormField
{
    public $name;
    public $type;
    public $label;
    public $options;
    public $constraints;

    public function __construct($name, $type, $label = '', $options = [], $constraints = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->label = $label;
        $this->options = $options;
        $this->constraints = $constraints;
    }

    private function renderAttributes()
    {
        $attributes = '';
        foreach ($this->options as $key => $value) {
            $attributes .= " {$key}='" . htmlspecialchars($value, ENT_QUOTES) . "'";
        }
        foreach ($this->constraints as $key => $value) {
            $attributes .= " {$key}='" . htmlspecialchars($value, ENT_QUOTES) . "'";
        }
        return $attributes;
    }

    public function render()
    {
        $attributes = $this->renderAttributes();
        $html = '';

        if ($this->type === 'textarea') {
            $html .= "<label for='{$this->name}'>{$this->label}</label><textarea name='{$this->name}'{$attributes}></textarea>";
        } elseif ($this->type === 'radio' || $this->type === 'checkbox') {
            $html .= "<input type='{$this->type}' id='{$this->name}' name='{$this->name}'{$attributes}><label for='{$this->name}'> {$this->label}</label>";
        } else {
            $html .= "<label for='{$this->name}'>{$this->label}</label><input type='{$this->type}' id='{$this->name}' name='{$this->name}'{$attributes}>";
        }
        return $html;
    }
}
