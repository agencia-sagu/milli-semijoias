<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lisy Modas - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e3b2ff67; 
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 48px 40px;
            border-radius: 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            background: #4f46e5;
            border-radius: 20px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
        }

        .header h1 {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            font-style: italic;
        }

        .header p {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 4px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-left: 4px;
        }

        .input-field {
            position: relative;
        }

        .input-field input {
            width: 100%;
            padding: 14px 16px;
            background: #f1f5f9;
            border: 2px solid transparent;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 500;
            color: #1e293b;
            transition: all 0.2s ease;
        }

        .input-field input::placeholder {
            color: #94a3b8;
        }

        .input-field input:focus {
            outline: none;
            background: #ffffff;
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            padding: 0 4px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
            cursor: pointer;
        }

        .remember input {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            accent-color: #4f46e5;
            cursor: pointer;
        }

        button {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 18px;
            background: #0f172a;
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button:hover {
            background: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        button:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fef2f2;
            color: #dc2626;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #fee2e2;
        }

        .field-error {
            font-size: 12px;
            color: #dc2626;
            font-weight: 600;
            margin-top: 6px;
            margin-left: 4px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 40px 24px;
                border-radius: 24px;
            }
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="header">
            <div class="brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
            </div>
            <h1>Lisy Modas</h1>
            <p>Acesso ao Painel</p>
        </div>

        @if (session('status'))
        <div class="error-message">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <label>E-mail</label>
                <div class="input-field">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nome@lisymodas.com" required>
                </div>
                @error('email')
                <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label>Senha de Acesso</label>
                <div class="input-field">
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                @error('password')
                <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="options">
                <label class="remember">
                    <input type="checkbox" name="remember">
                    Manter conectado
                </label>
            </div>

            <button type="submit">
                Entrar no Sistema
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                    <polyline points="10 17 15 12 10 7"></polyline>
                    <line x1="15" y1="12" x2="3" y2="12"></line>
                </svg>
            </button>
        </form>
    </div>

</body>

</html>