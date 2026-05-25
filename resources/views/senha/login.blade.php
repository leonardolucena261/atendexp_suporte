<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Cidade do Saber</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Sora:wght@200;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        verde: '#8BBD47', dourado: '#FFAD02', clarinho: '#BFFBAC',
                        laranja: '#EF8E26', escuro: '#1E293B', claro: '#F9F9F9',
                    },
                    fontFamily: { display: ['Sora','sans-serif'], body: ['Space Grotesk','sans-serif'] }
                }
            }
        }
    </script>
    <style>
        :root {
            --verde: #8BBD47; --dourado: #FFAD02; --clarinho: '#BFFBAC;
            --laranja: #EF8E26; --escuro: #1E293B; --claro: #F9F9F9;
            --txt-dark: #0F172A; --txt-body: #334155; --txt-muted: #64748B;
            --border: #CBD5E1; --border-light: #E2E8F0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--claro);
            color: var(--txt-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* Fundo decorativo suave */
        body::before {
            content: '';
            position: fixed;
            top: -20%; left: -10%;
            width: 50%; height: 50%;
            background: radial-gradient(circle, rgba(139,189,71,0.06) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -15%; right: -10%;
            width: 40%; height: 40%;
            background: radial-gradient(circle, rgba(255,173,2,0.05) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        /* Card Principal (Unificado e Limpo) */
        .login-card {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.04), 0 1px 3px rgba(0,0,0,0.02);
            border: 1px solid var(--border-light);
            position: relative;
            z-index: 1;
            padding: 2.5rem 2rem 2rem;
            animation: cardIn 0.5s cubic-bezier(0.22,1,0.36,1);
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Cabeçalho Interno */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo {
            width: 56px; height: 56px;
            border-radius: 14px;
            background: var(--escuro);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 12px rgba(30,41,59,0.15);
        }
        .login-logo i { color: var(--verde); font-size: 1.5rem; }
        .login-header h1 {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--txt-dark);
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }
        .login-header p {
            font-size: 0.875rem;
            color: var(--txt-muted);
            line-height: 1.4;
        }

        /* Grupos de Input */
        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--txt-muted);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-wrap i.input-icon {
            position: absolute;
            left: 1rem;
            color: var(--txt-muted);
            font-size: 0.9rem;
            pointer-events: none;
            transition: color 0.2s;
        }
        
        /* Input Acessível e Grande */
        .form-input {
            width: 100%;
            min-height: 52px; /* Alcance WCAG AAA para áreas clicáveis */
            padding: 0 1rem 0 2.85rem;
            border: 1.5px solid var(--border);
            border-radius: 0.75rem;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.938rem;
            color: var(--txt-dark);
            background: var(--claro);
            transition: all 0.2s ease;
        }
        .form-input:hover {
            border-color: #94a3b8;
        }
        .form-input:focus {
            outline: none;
            background: white;
            border-color: var(--verde);
            box-shadow: 0 0 0 4px rgba(139,189,71,0.15); /* Anel de foco grosso e visível */
        }
        .form-input:focus + i.input-icon,
        .form-input:focus ~ i.input-icon { color: var(--verde); }
        .form-input::placeholder { color: #94a3b8; font-size: 0.9rem; }
        
        /* Estado de Erro */
        .form-input.input-error { 
            border-color: #ef4444; 
            background: #fef2f2;
        }
        .form-input.input-error:focus { 
            box-shadow: 0 0 0 4px rgba(239,68,68,0.12); 
        }

        /* Botão Toggle Senha */
        .btn-toggle-pass {
            position: absolute;
            right: 0.5rem;
            background: none;
            border: none;
            min-height: 44px; /* Tamanho mínimo touch */
            width: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--txt-muted);
            cursor: pointer;
            font-size: 0.9rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        .btn-toggle-pass:hover { color: var(--txt-dark); background: rgba(0,0,0,0.05); }

        /* Erro de Validação */
        .field-error {
            font-size: 0.813rem;
            color: #dc2626;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-weight: 500;
            animation: fadeIn 0.3s ease;
        }

        /* Alerta Geral */
        .alert-box {
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.625rem;
            margin-bottom: 1.5rem;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            font-weight: 500;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Botão de Submit Robusto */
        .btn-login {
            width: 100%;
            min-height: 52px;
            padding: 0 1.5rem;
            border-radius: 0.75rem;
            border: none;
            background: var(--verde);
            color: white;
            font-weight: 700;
            font-family: 'Sora', sans-serif;
            font-size: 0.938rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            box-shadow: 0 2px 8px rgba(139,189,71,0.3);
        }
        .btn-login:hover { 
            background: #7aa83d; 
            box-shadow: 0 4px 12px rgba(139,189,71,0.4);
            transform: translateY(-1px);
        }
        .btn-login:active { 
            transform: translateY(0) scale(0.98); 
            box-shadow: 0 1px 4px rgba(139,189,71,0.2);
        }
        .btn-login:disabled { 
            opacity: 0.6; 
            cursor: not-allowed; 
            transform: none; 
            box-shadow: none;
        }

        .spinner-sm {
            width: 18px; height: 18px;
            border: 2.5px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: inline-block;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Rodapé */
        .login-card-footer {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-light);
            text-align: center;
        }
        .login-card-footer p {
            font-size: 0.813rem;
            color: var(--txt-muted);
        }
        .login-card-footer a {
            color: var(--txt-dark);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .login-card-footer a:hover { color: var(--verde); }

        /* Foco visível global para acessibilidade via teclado */
        :focus-visible { 
            outline: none; 
            box-shadow: 0 0 0 3px white, 0 0 0 5px var(--verde); 
            border-radius: 4px; 
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        @media (max-width: 480px) {
            body { padding: 1rem; }
            .login-card { padding: 2rem 1.5rem 1.5rem; border-radius: 1.25rem; }
            .login-header h1 { font-size: 1.25rem; }
        }
    </style>
</head>
<body>

    <main class="login-card" role="main">
        
        {{-- Cabeçalho Unificado --}}
        <div class="login-header">
            <div class="login-logo" aria-hidden="true">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h1>Atende XP</h1>
            <p>Experience em atendimento e matriculas</p>
        </div>

        {{-- Formulário --}}
        <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
            @csrf

            {{-- Erro geral (sessão) --}}
            @if(session('error'))
                <div class="alert-box" role="alert" aria-live="assertive">
                    <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Usuário --}}
            <div class="form-group">
                <label for="nome_usuario" class="form-label">Usuario</label>
                <div class="input-wrap">
                    <input
                        type="text"
                        name="nome_usuario"
                        id="nome_usuario"
                        class="form-input {{ $errors->has('nome_usuario') ? 'input-error' : '' }}"
                        placeholder="Digite seu usuario"
                        value="{{ old('nome_usuario') }}"
                        required
                        autofocus
                        autocomplete="username"
                        aria-describedby="{{ $errors->has('nome_usuario') ? 'err-usuario' : '' }}"
                    >
                    <i class="fa-solid fa-user input-icon" aria-hidden="true"></i>
                </div>
                @error('nome_usuario')
                    <div class="field-error" id="err-usuario" role="alert">
                        <i class="fa-solid fa-circle-exclamation" style="font-size:0.75rem;" aria-hidden="true"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            {{-- Senha --}}
            <div class="form-group">
                <label for="senha" class="form-label">Senha</label>
                <div class="input-wrap">
                    <input
                        type="password"
                        name="senha"
                        id="senha"
                        class="form-input {{ $errors->has('nome_usuario') ? 'input-error' : '' }}"
                        placeholder="Digite sua senha"
                        required
                        autocomplete="current-password"
                        aria-describedby="{{ $errors->has('nome_usuario') ? 'err-senha' : '' }}"
                    >
                    <i class="fa-solid fa-lock input-icon" aria-hidden="true"></i>
                    <button
                        type="button"
                        class="btn-toggle-pass"
                        id="btnTogglePass"
                        aria-label="Mostrar senha"
                        tabindex="-1"
                    >
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                @error('nome_usuario')
                    <div class="field-error" id="err-senha" role="alert">
                        <i class="fa-solid fa-circle-exclamation" style="font-size:0.75rem;" aria-hidden="true"></i>
                        <span>Credenciais invalidas ou usuario inativo.</span>
                    </div>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-login" id="btnLogin">
                <span id="btnLoginText">Entrar no sistema</span>
            </button>
        </form>

        {{-- Rodapé --}}
        <footer class="login-card-footer">
            <p>Prefeitura Municipal de Camacari</p>
        </footer>

    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var btnToggle = document.getElementById('btnTogglePass');
        var inputPass = document.getElementById('senha');
        var iconEye   = btnToggle.querySelector('i');

        // Toggle visibilidade da senha
        btnToggle.addEventListener('click', function () {
            var isPassword = inputPass.type === 'password';
            inputPass.type = isPassword ? 'text' : 'password';
            iconEye.className = isPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
            btnToggle.setAttribute('aria-label', isPassword ? 'Ocultar senha' : 'Mostrar senha');
            
            // Mantém o foco no input ao clicar no botão
            inputPass.focus();
        });

        // Feedback visual no submit
        var form     = document.getElementById('loginForm');
        var btnLogin = document.getElementById('btnLogin');
        var btnText  = document.getElementById('btnLoginText');

        form.addEventListener('submit', function () {
            btnLogin.disabled = true;
            btnText.innerHTML = '<span class="spinner-sm"></span> Verificando...';
        });

        // ESC limpa os campos
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                var usuario = document.getElementById('nome_usuario');
                var senha   = document.getElementById('senha');
                if (document.activeElement === usuario || document.activeElement === senha) {
                    usuario.value = '';
                    senha.value   = '';
                    usuario.focus();
                }
            }
        });
    });
    </script>
</body>
</html>
