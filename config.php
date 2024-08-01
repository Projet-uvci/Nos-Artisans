<?php
require_once 'App/Config/database.php';
require 'vendor/autoload.php';



define('STRIPE_API_KEY', 'sk_test_51PfOXDG9oHcuFD19Z0LLy58SgKIoSnKJ5k3afWhS4A4EuOmAh0mym9LvivWSCBEKzTHCwzCGEtIt06kf1CurB8nx00oC8rfoDL');
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51PfOXDG9oHcuFD19SWWdmzqVo2PjlKXsMJ2EnEuqDzPKOUgHaBha89uXh3miszElAZZaf8KZj88FfTGaOVQ83J0j00JVgEIkX7');
define('STRIPE_SUCCESS_URL', 'http://localhost:8000/Vue/Pages/prise-de-rdv/payement-success.php');
define('STRIPE_CANCEL_URL', 'http://localhost:8000/Vue/Pages/prise-de-rdv/payement-cancel.php');
?>