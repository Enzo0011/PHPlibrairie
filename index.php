<?php
require_once 'FormManager.php';

$form = new FormManager();

// Ajouter des champs avec des labels
$form->addField(new FormField("username", "text", "Nom d'utilisateur", ["placeholder" => "Entrez votre nom d'utilisateur", "class" => "form-control"], ["required" => true, "maxLength" => 20]));
$form->addField(new FormField("email", "email", "Email", ["placeholder" => "Entrez votre email", "class" => "form-control"], ["required" => true]));
$form->addField(new FormField("password", "password", "Mot de passe", ["class" => "form-control"], ["required" => true]));
$form->addField(new FormField("bio", "textarea", "Biographie", ["rows" => "4", "class" => "form-control"], []));
$form->addField(new FormField("gender", "radio", "Homme", ["value" => "male", "class" => "form-control"], []));
$form->addField(new FormField("gender", "radio", "Femme", ["value" => "female", "class" => "form-control"], []));


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form->handleSubmission();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de Profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        textarea,
        .form-control {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #ff00ff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php echo $form->render(); ?>
</body>
</html>