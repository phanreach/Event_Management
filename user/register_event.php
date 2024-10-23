<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webinar Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #e95c20;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="email"], input[type="tel"] {
            width: calc(50% - 10px);
            padding: 10px;
            margin-right: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        input[type="text"].full-width, input[type="email"].full-width, input[type="tel"].full-width {
            width: 100%;
            margin-right: 0;
        }
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #e95c20;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #d94b16;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Webinar Registration Form</h1>
        <form action="submit_registration.php" method="post">
            <label for="firstName">Name</label>
            <input type="text" id="firstName" name="first_name" placeholder="First Name" required>
            <input type="text" id="lastName" name="last_name" placeholder="Last Name" required>

            <label for="email">E-Mail</label>
            <input type="email" id="email" name="email" class="full-width" placeholder="example@example.com" required>
            
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" class="full-width" placeholder="(000) 000-0000" required>

            <label for="company">Company</label>
            <input type="text" id="company" name="company" class="full-width" placeholder="Company Name" required>

            <input type="submit" value="Register">

        </form>
    </div>
</body>
</html>