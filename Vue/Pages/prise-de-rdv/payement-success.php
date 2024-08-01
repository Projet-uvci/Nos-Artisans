<?php
require '../../../App/Config/database.php';
require_once '../../../config.php';
require '../../../vendor/autoload.php';

$payment_id = $statusMsg = '';
$status = 'error';
$produitId = "1234FTK";
$identifiant = "Somme à payer pour une réservation";
$prixReservation = 2000;
$currency = "XOF";

if (!empty($_GET['session_id'])) {
    $session_id = $_GET['session_id'];

    $sqlQ = "SELECT * FROM transactions WHERE stripe_checkout_session_id = ?";
    $stmt = $connexion->prepare($sqlQ);
    $stmt->bindParam(1, $session_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $payment_id = $result['id'];
        $transactionID = $result['txn_id'];
        $paidAmount = $result['paid_amount'];
        $paidCurrency = $result['paid_amount_currency'];
        $payment_status = $result['payment_status'];
        $datePaiment = $result['updated_at'];
        $nom_client = $result['nom_client'];
        $email_client = $result['email_client'];

        $status = 'success';
        $statusMsg = 'Votre paiement a été effectué avec succès';
    } else {
        $stripe = new \Stripe\StripeClient(STRIPE_API_KEY);
        try {
            $checkout_session = $stripe->checkout->sessions->retrieve($session_id);
        } catch (Exception $e) {
            $api_error = $e->getMessage();
        }

        if (empty($api_error) && $checkout_session) {
            $customer_details = $checkout_session->customer_details;
            try {
                $paymentIntent = $stripe->paymentIntents->retrieve($checkout_session->payment_intent);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $api_error = $e->getMessage();
            }

            if (empty($api_error) && $paymentIntent) {
                if ($paymentIntent->status == 'succeeded') {
                    $transactionID = $paymentIntent->id;
                    $paidAmount = $prixReservation;
                    $paidCurrency = strtoupper($currency);
                    $payment_status = $paymentIntent->status;
                    $datePaiment = date('Y-m-d H:i:s', $paymentIntent->created);

                    $nom_client = !empty($customer_details->name) ? $customer_details->name : '';
                    $email_client = !empty($customer_details->email) ? $customer_details->email : '';

                    $sqlQ = "INSERT INTO transactions (nom_client, email_client, item_name, item_number, item_price, item_price_currency, paid_amount, paid_amount_currency, txn_id, payment_status, stripe_checkout_session_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
                    $stmt = $connexion->prepare($sqlQ);
                    $stmt->execute([$nom_client, $email_client, $identifiant, $produitId, $prixReservation, $currency, $paidAmount, $paidCurrency, $transactionID, $payment_status, $session_id]);

                    $payment_id = $connexion->lastInsertId();
                    $status = 'success';
                    $statusMsg = 'Votre paiement a été effectué avec succès';
                } else {
                    $statusMsg = 'Transaction échouée!';
                }
            } else {
                $statusMsg = "Impossible de récupérer les détails de la transaction! $api_error";
            }
        } else {
            $statusMsg = "Transaction invalide! $api_error";
        }
    }
} else {
    $statusMsg = 'Requête invalide';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="/Public/images/log75.jpeg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation d'une prestation</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(rgba(213, 164, 164, 0.5), rgba(64, 55, 55, 0.5)),
            url('/Public/images/log75.jpeg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .status {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 80%;
            max-width: 1000px;
        }
        .status.success {
            color: green;
        }
        h1.success {
            color: green;
        }
        .status.error {
            color: red;
        }
        #download {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #download:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="status" id="receipt">
        <?php if (!empty($payment_id)) { ?>
            <h1 class="success"><?php echo $statusMsg; ?></h1>
            <h1>Information du paiement</h1>
            <p><b>Reference:</b> <?php echo $payment_id; ?></p>
            <p><b>Nom:</b> <?php echo $nom_client; ?></p>
            <p><b>Email:</b> <?php echo $email_client; ?></p>
            <p><b>ID de la transaction:</b> <?php echo $transactionID; ?></p>
            <p><b>Montant du paiement:</b> <?php echo $prixReservation . ' ' . strtoupper($currency); ?></p>
            <p><b>Statut paiement:</b> <?php echo $payment_status; ?></p>
            <p><b>Date du paiement:</b> <?php echo $datePaiment; ?></p>
            <p>Merci d'avoir effectué le paiement de la réservation. Pour trouver un artisan, cliquez sur ce lien : <a href="./rendez-vous.php">Faire sa réservation chap</a> pour finaliser votre prise de rendez-vous. L'entreprise 75 vous remercie pour votre confiance.</p>
            <button id="download">Télécharger le reçu</button>
        <?php } else { ?>
            <h1>Votre paiement a échoué</h1>
            <p><?php echo $statusMsg; ?></p>
        <?php } ?>
    </div>
</div>
<script>
    document.getElementById('download').addEventListener('click', function () {
        var element = document.getElementById('receipt');
        var opt = {
            margin:       1,
            filename:     'Recu_Paiement.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().from(element).set(opt).save();
    });
</script>
</body>
</html>


