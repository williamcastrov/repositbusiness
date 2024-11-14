<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mail</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #727272;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 1000px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            margin: 0 auto;
        }
        .container img {
            max-width: 500px;
            display: block;
            margin: 0 auto;
        }
        .header, .footer {
            background-color: #f5f5f5;
            color: #ffffff;
            text-align: center;
            font-size: 24px;
        }
        .content {
            padding: 5px;
        }
        .content h2 {
            color: #2D2E83;
            text-align: center;
            font-size: 20px;
        }
        .content p {
            color: #2D2E83;
            text-align: center;
            font-size: 15px;
        }
        .footer {
            padding: 5px;
			background-color: #faac04;
            font-size: 14px;
        }
        .noti {
            text-align: center;
            padding: 5px;
            font-size: 12px;
            background-color: #f4f4f4;
        }
        .orange-section {
            background-color: #faac04;
            padding: 20px;
        }
        .orange-section h1 {
            color: #ffffff;
            text-align: center;
            font-size: 20px;
        }
    </style>
</head>
<body>
<table align="center" width="70%">
  <tr>
    <td>
    <div class="container">
    <div class="header">
        <div class="content">
            <img src="https://gimcloud.com.co/files/mercadorepuesto/redes/logmrazulclaro.png" alt="Mercado Repuesto" height="150" >
        </div>
    </div>    
    <div class="orange-section">
        <h1>{!! $asunto !!}</h1>
    </div>
    <div class="content">
        <h2>{!! $contenido_html['title'] !!}</h2>
        <h2>{!! $contenido_html['subtitle'] !!}</h2>
        <p>{!! $contenido_html['body'] !!}</p>
    </div>
        <div class="footer">
            <p>¿NECESITAS AYUDA? <span style="text-decoration: underline;">CONTÁCTANOS</span></p>
            <p>© 2021 Mercado Repuesto SAS. Todos los derechos reservados.</p>
        </div>
    </div>
    </td>
  </tr>
</table>
</body>
</html>