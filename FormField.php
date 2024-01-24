<?php
class FormField {
    public $name;
    public $type;
    public $label;
    public $options;
    public $constraints;

    public function __construct($name, $type, $label = '', $options = [], $constraints = []) {
        $this->name = $name;
        $this->type = $type;
        $this->label = $label;
        $this->options = $options;
        $this->constraints = $constraints;
    }

    private function renderAttributes() {
        $attributes = '';
        foreach ($this->options as $key => $value) {
            $attributes .= " {$key}='{$value}'";
        }
        foreach ($this->constraints as $key => $value) {
            $attributes .= " {$key}='{$value}'";
        }
        return $attributes;
    }

    public function render() {
        $attributes = $this->renderAttributes();
        
        // Pour les textarea
        if ($this->type === 'textarea') {
            return "<label for='{$this->name}'>{$this->label}</label><textarea name='{$this->name}'{$attributes}></textarea>";
        }
        
        // Pour les radio et checkbox, le label est après l'input
        if ($this->type === 'radio' || $this->type === 'checkbox') {
            return "<input type='{$this->type}' id='{$this->name}' name='{$this->name}'{$attributes}><label for='{$this->name}'> {$this->label}</label>";
        }

        // Pour les autres types d'input
        return "<label for='{$this->name}'>{$this->label}</label><input type='{$this->type}' name='{$this->name}'{$attributes}>";
    }

    
}
?>