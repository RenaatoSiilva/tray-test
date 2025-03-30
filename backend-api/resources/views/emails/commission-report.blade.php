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
            <h1 style="margin: 0;">Comissões de Vendas</h1>
        </div>

        @if(!$sales->isEmpty())
        <div class="content" style="background: #ffffff; padding: 20px; margin-top: 10px; border-radius: 5px;">
            <p style="font-size: 16px; color: #333;">
                Olá,<br><br>
                Segue abaixo uma tabela com as suas vendas e comissões referente a data de <strong>{{$date}}</strong>.
            </p>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="background-color: #007bff; color: #000;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Valor</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Comissão</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr style="background-color: #f9f9f9; text-align: center;">
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $sale->amount }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $sale->commission_value }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #e9ecef; font-weight: bold; text-align: center;">
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">Quantidade de Vendas:</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $sales->count() }}</td>
                </tr>

                <tr style="background-color: #e9ecef; font-weight: bold; text-align: center;">
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">Total de Vendas:</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $sales->sum('amount') }}</td>
                </tr>

                <tr style="background-color: #e9ecef; font-weight: bold; text-align: center;">
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">Total de Comissões:</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $sales->sum('commission_value') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @else

    <div class="content" style="background: #ffffff; padding: 20px; margin-top: 10px; border-radius: 5px;">
        <p style="font-size: 16px; color: #333;">
            Olá,<br><br>
            Parece que você não efetuou nenhuma venda na data <strong>{{$date}}</strong>, então você não tem comissões para receber.
        </p>
    </div>

    @endif

    <div class="footer" style="text-align: center; margin-top: 10px; font-size: 14px; color: #666;">
        <strong>Tray</strong>
        </p>
        <p>© {{ date('Y') }} Tray Test. Todos os Direitos Reservados.</p>
    </div>
    </div>
</body>


</html>