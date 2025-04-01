<!DOCTYPE html>
<html>
<head>
    <title>Convite</title>
</head>
<body>
    <h1>Olá, {{ $details['name'] }}!</h1>
    <p>Você foi convidado para um evento especial.</p>
    <p>Detalhes: {{ $details['message'] }}</p>
    <p>Data: {{ $details['date'] }}</p>
    <p>Atenciosamente,</p>
    <p>Sua Equipe</p>
</body>
</html>
