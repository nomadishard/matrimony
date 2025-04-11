<!DOCTYPE html>
<html>

<head>
    <title>PhonePe Payment</title>
</head>

<body>
    <form action="process_payment.php" method="POST">
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Pay with PhonePe</button>
    </form>
</body>

</html>