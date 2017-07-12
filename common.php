<?php
session_start();
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

if(!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}

function translate($string) {
    $de_phrases = array("Home page" => "Startseite",
                      "Manage your products" => "Verwalten Sie Ihre Produkte",
                      "Image" => "Bild",
                      "Product name" => "Produktname",
                      "Price" => "Preis",
                      "Description" => "Beschreibung",
                      "See cart" => "Warenkorb",
                      "All the products are already in the cart!" => "Alle Produkte sind bereits im Warenkorb!",
                      "Go to homepage" => "Startseite",
                      "Remove from cart" => "Aus dem Warenkorb entfernen",
                      "Order now!" => "Jetzt bestellen!",
                       "Name" => "Name",
                       "email" => "email",
                       "Other details..." => "Andere Details...",
                       "Add to cart" => "In den Warenkorb legen");
    $ro_phrases = array("Home page" => "Acasa",
                      "Manage your products" => "Administreaza-ti produsele",
                      "Image" => "Imagine",
                      "Product name" => "Denumirea produsului",
                      "Price" => "Pret",
                      "Description" => "Descriere",
                      "See cart" => "Cosul tau",
                      "All the products are already in the cart!" => "Toate produsele au fost adaugate in cos",
                      "Go to homepage" => "Acasa",
                      "Remove from cart" => "Sterge",
                      "Order now!" => "Comanda acum!",
                       "Name" => "Nume",
                       "email" => "email",
                       "Other details..." => "Alte detalii referitoare la comanda",
                       "Add to cart" => "Adauga in cos");
    if($_SESSION["lang"] == "de") {
        if($de_phrases[$string]) {
            return $de_phrases[$string];
        } else {
            return $string;
        }
    } else if ($_SESSION["lang"] == "ro") {
        if($ro_phrases[$string]) {
            return $ro_phrases[$string];
        } else {
            return $string;
        }
    } else {
        return $string;
    }
}

?>