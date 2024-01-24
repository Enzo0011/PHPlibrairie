<?php
require_once 'FormField.php';

class FormManager {
    private $fields = [];

    public function addField($field) {
        $this->fields[] = $field;
    }

    public function render() {
        $formHtml = '<form method="post">';
        foreach ($this->fields as $field) {
            $formHtml .= $field->render();
        }
        $formHtml .= '<input type="submit" value="Submit">';
        $formHtml .= '</form>';
        return $formHtml;
    }

    public function handleSubmission() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "y";
        }
    }
}
?>