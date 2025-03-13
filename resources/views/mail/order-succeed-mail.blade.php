<?php
// Assuming $invoice is already defined and passed to this script
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Succeeded</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Order Succeeded</h1>
    <p>Hi, <?php echo htmlspecialchars($invoice->reservation->guest->name); ?>!</p>
    <p>Thank you for your order. Here are the details:</p>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Nights</th>
                <th>Subamount</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Room:</strong> <?php echo htmlspecialchars($invoice->reservation->room->room_number); ?></td>
                <td><strong>$<?php echo number_format($invoice->price_per_night, 2); ?></strong></td>
                <td><strong><?php echo htmlspecialchars($invoice->nights); ?></strong></td>
                <td><strong>$<?php echo number_format($invoice->subamount, 2); ?></strong></td>
                <td><strong>$<?php echo number_format($invoice->amount, 2); ?></strong></td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>$<?php echo number_format($invoice->amount, 2); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($invoice->reservation->booking_id); ?></p>

    <p>Thanks,<br>
        <?php echo htmlspecialchars(config('app.name')); ?></p>
</body>

</html>
