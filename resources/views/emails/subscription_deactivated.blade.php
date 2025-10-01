<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Assinatura Desativada</title>
</head>

<body
    style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f9fafb; margin:0; padding:0;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <tr>
            <td style="padding: 24px; text-align: center; border-bottom: 1px solid #eaeaea;">
                <h1 style="margin: 0; font-weight: 700; font-size: 24px; color: #111827;">Assinatura Desativada</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 24px; color: #374151; font-size: 16px; line-height: 1.5;">
                <p>Olá <strong>{{ $user->name }}</strong> 👋,</p>
                <p>Sua assinatura referente ao plano <strong>{{ $subscription->plan->name ?? 'desconhecido' }}</strong>
                    foi desativada em <strong>{{ $subscription->expires_at->format('d/m/Y') }}</strong>.</p>
                <p>Se quiser continuar aproveitando nossos serviços, basta renovar sua assinatura clicando no botão
                    abaixo:</p>
                <p style="text-align: center; margin: 32px 0;">
                    <a href="{{ url('/plans') }}"
                        style="background-color: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; font-weight: 600; border-radius: 6px; display: inline-block;">Renovar
                        Assinatura</a>
                </p>
                <p style="color: #6b7280; font-size: 14px;">Se você já renovou, desconsidere este email.</p>
                <p>Obrigado por estar conosco!</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 16px; text-align: center; font-size: 12px; color: #9ca3af;">
                &copy; {{ date('Y') }} ClubStep. Todos os direitos reservados.
            </td>
        </tr>
    </table>
</body>

</html>
