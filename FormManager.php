<?php
session_start();
require_once 'FormField.php';

class FormManager
{
    private $fields = [];
    private $errors = [];
    private $csrfToken;

    public function __construct()
    {
        $this->generateCsrfToken();
    }

    private function generateCsrfToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $this->csrfToken = $_SESSION['csrf_token'];
    }

    public function validateField($field, $value)
    {
        if (isset($field->constraints['required']) && $field->constraints['required'] && trim($value) === '') {
            $this->errors[$field->name] = 'Ce champ est requis.';
        }

        if (isset($field->constraints['minLength']) && strlen($value) < $field->constraints['minLength']) {
            $this->errors[$field->name] = "Ce champ doit contenir au moins {$field->constraints['minLength']} caractères.";
        }

        if (isset($field->constraints['maxLength']) && strlen($value) > $field->constraints['maxLength']) {
            $this->errors[$field->name] = "Ce champ doit contenir au maximum {$field->constraints['maxLength']} caractères.";
        }

        if ($field->type === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field->name] = "L'adresse email n'est pas valide.";
        }

        if ($field->type === 'date' && DateTime::createFromFormat('Y-m-d', $value) === false) {
            $this->errors[$field->name] = "La date n'est pas valide. Le format attendu est AAAA-MM-JJ.";
        }

        if (in_array($field->type, ['number', 'range']) && !is_numeric($value)) {
            $this->errors[$field->name] = "Ce champ doit être un nombre.";
        }

        if ($field->type === 'password' && !preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*\W).{8,}$/', $value)) {
            $this->errors[$field->name] = "Le mot de passe doit contenir au moins 8 caractères, dont une lettre, un chiffre et un caractère spécial.";
        }
    }


    public function handleSubmission()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $this->csrfToken) {
                $this->errors['form'] = 'Invalid CSRF token.';
                return;
            }
            foreach ($this->fields as $field) {
                if (isset($_POST[$field->name])) {
                    $this->validateField($field, $_POST[$field->name]);
                }
            }
            if (empty($this->errors)) {
                echo "Form Submitted Successfully";
            } else {
                $this->displayErrors();
            }
        }
    }

    public function addField($field)
    {
        $this->fields[] = $field;
    }

    public function render()
    {
        $formHtml = '<form method="post" enctype="multipart/form-data">';
        foreach ($this->fields as $field) {
            $formHtml .= $field->render();
            if (isset($this->errors[$field->name])) {
                $formHtml .= '<span class="error">' . $this->errors[$field->name] . '</span>';
            }
        }
        $formHtml .= '<input type="hidden" name="csrf_token" value="' . $this->csrfToken . '">';
        $formHtml .= '<input type="submit" value="Submit">';
        $formHtml .= '</form>';
        return $formHtml;
    }

    public function displayErrors()
    {
        if (!empty($this->errors)) {
            foreach ($this->errors as $error) {
                echo '<div class="error">' . htmlspecialchars($error, ENT_QUOTES) . '</div>';
            }
        }
    }
}
