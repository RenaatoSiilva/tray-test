<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            color: #555;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
        }

        .footer {
            background-color: #f1f1f1;
            color: #777;
            padding: 15px;
            text-align: center;
            font-size: 12px;
        }

        .button {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 15px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="email-container" style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
        <div class="header" style="background-color: #007bff; color: #ffffff; padding: 10px; text-align: center;">
            <h1 style="margin: 0;">Alerta de Mudança de Senha</h1>
        </div>

        <div class="content" style="background: #ffffff; padding: 20px; margin-top: 10px; border-radius: 5px;">
            <p style="font-size: 16px; color: #333;">
                Olá,<br><br>
                Recebemos um pedido de alteração de senha para o e-mail <strong>{{ $email }}</strong> e a mesma foi alterada para <strong>{{$password}}</strong> , não se esqueça de alterar posteriormente.
            </p>

        </div>

        <div class="footer" style="text-align: center; margin-top: 10px; font-size: 14px; color: #666;">
            <strong>Tray</strong>
            </p>
            <p>© {{ date('Y') }} Tray Test. Todos os Direitos Reservados.</p>
        </div>
    </div>
</body>


</html>