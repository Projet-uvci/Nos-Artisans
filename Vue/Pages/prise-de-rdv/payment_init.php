<?php
require '../../../vendor/autoload.php';
require_once '../../../config.php';

session_start();

$identifiant = $_SESSION['identifiant'];
$prixReservation = $_SESSION['prixReservation'];
$currency = $_SESSION['currency'];

$stripe = new \Stripe\StripeClient(STRIPE_API_KEY);

$response = array('status' => 0, 'error' => array('message' => 'Invalid Request'));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents('php://input');
    $request = json_decode($input);

    if (json_last_error() === JSON_ERROR_NONE && !empty($request->createCheckoutSession)) {
        $stripeAmount = round($prixReservation); // Amount in cents

        try {
            $checkout_session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => $currency,
                        'product_data' => [
                            'name' => $identifiant,
                        ],
                        'unit_amount' => $stripeAmount,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => STRIPE_SUCCESS_URL . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => STRIPE_CANCEL_URL,
            ]);

            $response = array(
                'status' => 1,
                'message' => 'Checkout Session created successfully',
                'sessionId' => $checkout_session->id
            );
        } catch (Exception $e) {
            $response['error']['message'] = 'Checkout Session creation failed! ' . $e->getMessage();
        }
    }
}
echo json_encode($response);
?>