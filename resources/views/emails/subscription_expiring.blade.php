<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Assinatura Próxima do Vencimento</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Olá, {{ $user->name }}! 👋</h2>
    <p>Sua assinatura está prestes a expirar em <strong>{{ $daysLeft }} dias</strong>.</p>
    
    <p>Para continuar aproveitando nossos serviços, por favor, renove sua assinatura antes do vencimento.</p>
    <a href="{{ $renewUrl }}" style="padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 4px;">
    Renovar Assinatura
</a>


    <p>Se precisar de ajuda, estamos à disposição!</p>

    <p>Obrigado por estar conosco! 🎉</p>
    <hr>
    <p style="font-size: 0.9em; color: #777;">Este é um aviso automático, não responda este email.</p>
</body>
</html>