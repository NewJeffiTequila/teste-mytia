<!DOCTYPE html>
<html>
<head>
    <title>Redefinição de Senha</title>
</head>
<body>
    <h2>Olá,</h2>
    <p>Recebemos uma solicitação para redefinir sua senha.</p>
    <p>Clique no link abaixo para criar uma nova senha:</p>
    <a href="{{ url('/reset-password?token=' . $token) }}">Redefinir Senha</a>
    <p>Se você não solicitou isso, ignore este e-mail.</p>
</body>
</html>
