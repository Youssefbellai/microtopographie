<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $typeDevis = $_POST['type-devis'];
    $vousEtes = $_POST['vous-etes'];
    $descriptionBesoin = $_POST['description-besoin'];

    // Common fields
    $subject = 'Demande de devis';
    $to = 'youssefotaku03@gmail.com'; // Replace with your email address

    // Additional fields based on whether it's a company or individual
    if ($vousEtes === 'societe') {
        $nomSociete = $_POST['nom-societe'];
        $siege = $_POST['siege'];
        $ice = $_POST['ice'];
        $nomDemandeur = $_POST['nom-demandeur'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];

        // Compose message for company
        $message = "Type de devis: $typeDevis\n\n";
        $message .= "Vous êtes: Société\n\n";
        $message .= "Nom Sté: $nomSociete\n";
        $message .= "Siège: $siege\n";
        $message .= "ICE: $ice\n";
        $message .= "Nom du demandeur: $nomDemandeur\n";
        $message .= "Téléphone: $telephone\n";
        $message .= "E-mail: $email\n\n";
        $message .= "Description du besoin:\n$descriptionBesoin";
    } elseif ($vousEtes === 'personne-physique') {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $cin = $_POST['CIN'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];

        // Compose message for individual
        $message = "Type de devis: $typeDevis\n\n";
        $message .= "Vous êtes: Personne physique\n\n";
        $message .= "Nom: $nom\n";
        $message .= "Prénom: $prenom\n";
        $message .= "CIN: $cin\n";
        $message .= "Téléphone: $telephone\n";
        $message .= "E-mail: $email\n\n";
        $message .= "Description du besoin:\n$descriptionBesoin";
    }

    // Headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-type: text/plain; charset=utf-8\r\n";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo 'Votre demande a été envoyée avec succès.';
    } else {
        echo 'Erreur lors de l\'envoi de votre demande.';
    }
} else {
    // Redirect back to the form if accessed directly
    header('Location: Services.html');
    exit();
}
?>
