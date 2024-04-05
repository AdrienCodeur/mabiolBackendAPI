<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <table style="width: 100%;">
        <tr>
            <td style="background-color: #f8f9fa; padding: 50px;">
                <table style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 10px; border: 1px solid #e0e0e0;">
                    <tr>
                        <td style="text-align: center;">
                            <h2>Email Verification</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                Bonjour {{ $user->name }},
                            </p>
                            <p>
                                Merci pour votre inscription  en tant que proprietaire. Veuillez cliquer sur le lien ci-dessous pour vérifier votre adresse e-mail :
                            </p>
                            <p style="text-align: center;"> 
                                <a href="/" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Vérifier mon adresse e-mail</a>
                            </p>
                            <p>
                                Si vous n'avez pas créé de compte, vous pouvez ignorer cet e-mail en toute sécurité.
                            </p>
                            <p>
                                Cordialement,<br>
                                Votre équipe {{ config('app.name') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
