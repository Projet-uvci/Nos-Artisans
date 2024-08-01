<?php
require '../../../App/Config/database.php';
require '../../../vendor/autoload.php';
require_once '../../../config.php';
session_start();

$identifiant = "Somme à payer pour une réservation";
$prixReservation = 2000; // 2000 FCFA
$currency = "XOF";

// Stocker les informations de paiement dans la session pour les récupérer dans payment_init.php
$_SESSION['identifiant'] = $identifiant;
$_SESSION['prixReservation'] = $prixReservation;
$_SESSION['currency'] = $currency;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="/Public/images/log75.jpeg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://js.stripe.com/v3/"></script>
    <title>Réservation d'une prestation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="cart">
        <div id="paymentResponse" class="hidden"></div>
        <form id="commandeForm" method="post">
            <a name="anchor"></a>
            <div class="row cart-table-row cart-table-row-head">
                <div class="col-xs-8">
                    <h1 class="text-right-center"><?php echo $identifiant; ?></h1>
                </div>
            </div>
            <br>
            <br>
            <br>
            <p>Somme: <b><?php echo $prixReservation . ' ' . strtoupper($currency); ?></b></p>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <button class="stripe-button btn btn-default" id="payButton">
                        <div class="spinner hidden" id="spinner"></div>
                        <span id="buttonText">Réserver maintenant</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');
    const payBtn = document.querySelector("#payButton");

    payBtn.addEventListener("click", function (evt) {
        setLoading(true);
        createCheckoutSession().then(function (data) {
            if (data.sessionId) {
                stripe.redirectToCheckout({
                    sessionId: data.sessionId,
                }).then(handleResult);
            } else {
                handleResult(data);
            }
        });
    });

    const createCheckoutSession = function () {
        return fetch("payment_init.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                createCheckoutSession: 1,
            }),
        }).then(function (result) {
            return result.json();
        });
    };

    const handleResult = function (result) {
        if (result.error) {
            showMessage(result.error.message);
        }
        setLoading(false);
    };

    function setLoading(isLoading) {
        if (isLoading) {
            payBtn.disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#buttonText").classList.add("hidden");
        } else {
            payBtn.disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#buttonText").classList.remove("hidden");
        }
    }

    function showMessage(messageText) {
        const messageContainer = document.querySelector("#paymentResponse");
        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;
        setTimeout(() => {
            messageContainer.classList.add("hidden");
            messageContainer.textContent = "";
        }, 5000);
    }
</script>

</body>
</html>

