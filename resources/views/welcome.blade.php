<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atende XP — Suporte a Matriculas</title>
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
            --verde: #8BBD47; --verde-dark: #6a9a2f; --verde-light: #a8d465;
            --dourado: #FFAD02; --laranja: #EF8E26; --escuro: #1E293B;
            --claro: #F9F9F9; --branco: #FFFFFF;
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
            flex-direction: column;
            overflow-x: hidden;
        }

        /* ===== FUNDO DECORATIVO ===== */
        body::before {
            content: '';
            position: fixed; top: -30%; right: -20%;
            width: 60%; height: 60%;
            background: radial-gradient(circle, rgba(139,189,71,0.08) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none; z-index: 0;
        }
        body::after {
            content: '';
            position: fixed; bottom: -25%; left: -15%;
            width: 50%; height: 50%;
            background: radial-gradient(circle, rgba(255,173,2,0.06) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none; z-index: 0;
        }

        /* ===== ESTRUTURA PRINCIPAL ===== */
        .landing-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 960px;
            margin: 0 auto;
        }

        /* ===== HERO ===== */
        .hero-card {
            background: rgba(255,255,255,0.85);
            border: 1px solid var(--border-light);
            border-radius: 2rem;
            padding: 3.5rem 3rem 3rem;
            text-align: center;
            width: 100%;
            max-width: 580px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            position: relative;
            overflow: hidden;
            animation: heroIn 0.7s cubic-bezier(0.22,1,0.36,1) both;
        }
        
        .hero-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--verde), var(--verde-light), var(--dourado));
        }

        @keyframes heroIn {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .hero-logo {
            width: 80px; height: 80px; border-radius: 1.5rem;
            background: linear-gradient(135deg, var(--escuro) 0%, #0f172a 100%);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 8px 24px rgba(30,41,59,0.25);
            position: relative;
        }
        .hero-logo i { color: var(--verde); font-size: 2rem; position: relative; z-index: 1; }
        .hero-logo::after {
            content: ''; position: absolute; inset: -8px; border-radius: 2rem;
            border: 2px dashed rgba(139,189,71,0.2);
            animation: rotateSlow 25s linear infinite;
        }
        @keyframes rotateSlow { to { transform: rotate(360deg); } }

        .hero-title {
            font-family: 'Sora', sans-serif;
            font-weight: 800; font-size: 2.5rem;
            color: var(--txt-dark); letter-spacing: -0.03em;
            line-height: 1.1; margin-bottom: 0.5rem;
        }
        .hero-subtitle {
            font-family: 'Sora', sans-serif;
            font-weight: 600; font-size: 0.9rem;
            color: var(--verde-dark); letter-spacing: 0.06em;
            text-transform: uppercase; margin-bottom: 1.25rem;
        }
        .hero-desc {
            font-size: 1rem; color: var(--txt-muted); line-height: 1.7;
            max-width: 420px; margin: 0 auto 2.5rem;
        }

        /* ===== BOTÃO PRINCIPAL ===== */
        .btn-login {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.625rem;
            width: 100%; max-width: 320px;
            padding: 1rem 2rem; border-radius: 0.875rem; border: none;
            background: linear-gradient(135deg, var(--verde), var(--verde-dark));
            color: white; font-family: 'Sora', sans-serif;
            font-weight: 700; font-size: 1.05rem;
            cursor: pointer; text-decoration: none;
            box-shadow: 0 4px 14px rgba(139,189,71,0.35);
            transition: all 0.3s cubic-bezier(0.22,1,0.36,1);
            position: relative; overflow: hidden;
        }
        .btn-login::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,0.2));
            opacity: 0; transition: opacity 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(139,189,71,0.45);
        }
        .btn-login:hover::before { opacity: 1; }
        .btn-login:active { transform: translateY(0) scale(0.98); }

        .hero-link {
            display: inline-block; margin-top: 1.25rem;
            font-size: 0.85rem; color: var(--txt-muted);
            text-decoration: none; transition: color 0.2s;
        }
        .hero-link:hover { color: var(--verde-dark); }
        .hero-link i { margin-right: 0.25rem; font-size: 0.75rem; }

        /* ===== CARACTERÍSTICAS ===== */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-top: 2.5rem;
            width: 100%;
            max-width: 700px;
        }
        .feature-card {
            background: rgba(255,255,255,0.7);
            border: 1px solid var(--border-light);
            border-radius: 1.25rem;
            padding: 1.5rem 1.25rem;
            text-align: center;
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.22,1,0.36,1);
        }
        .feature-card:nth-child(1) { animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) 0.2s both; }
        .feature-card:nth-child(2) { animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) 0.3s both; }
        .feature-card:nth-child(3) { animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) 0.4s both; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.07);
            border-color: rgba(139,189,71,0.2);
        }
        .feature-icon {
            width: 48px; height: 48px; border-radius: 0.875rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 0.875rem; font-size: 1.25rem;
        }
        .feature-icon.icon-verde { background: rgba(139,189,71,0.1); color: var(--verde-dark); }
        .feature-icon.icon-laranja { background: rgba(239,142,38,0.1); color: #c2410c; }
        .feature-icon.icon-dourado { background: rgba(255,173,2,0.1); color: #b45309; }
        .feature-title {
            font-family: 'Sora', sans-serif;
            font-weight: 700; font-size: 0.9rem;
            color: var(--txt-dark); margin-bottom: 0.25rem;
        }
        .feature-desc { font-size: 0.8rem; color: var(--txt-muted); line-height: 1.5; }

        /* ===== FOOTER ===== */
        .landing-footer {
            padding: 1.25rem 1.5rem;
            text-align: center; font-size: 0.75rem;
            color: var(--txt-muted);
            background: rgba(255,255,255,0.5);
            border-top: 1px solid var(--border-light);
            backdrop-filter: blur(8px);
            position: relative; z-index: 1;
        }
        .landing-footer strong { color: var(--verde); font-weight: 600; }

        :focus-visible { outline: none; box-shadow: 0 0 0 3px white, 0 0 0 5px var(--verde); border-radius: 4px; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }

        @media (max-width: 768px) {
            .features-grid { grid-template-columns: 1fr; max-width: 360px; }
            .hero-card { padding: 2.5rem 2rem 2rem; }
        }
        @media (max-width: 480px) {
            .landing-container { padding: 1.5rem 1rem; }
            .hero-title { font-size: 2rem; }
            .hero-desc { font-size: 0.9rem; }
            .hero-logo { width: 64px; height: 64px; border-radius: 1.25rem; }
            .hero-logo i { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    <main class="landing-container">
        
        <!-- CARD CENTRAL -->
        <div class="hero-card">
            <div class="hero-logo" aria-hidden="true">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            
            <h1 class="hero-title">Atende XP</h1>
            <p class="hero-subtitle">Sistema de Apoio a Matricula</p>
            <p class="hero-desc">
                Plataforma interna da <strong style="color:var(--txt-dark);">Cidade do Saber</strong> para emissão de senhas, 
                gestão de carteirinhas e suporte ao processo de matrícula presencial.
            </p>

            <a href="{{ route('login') }}" class="btn-login" aria-label="Acessar tela de login">
                <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>
                Fazer Login
            </a>

            <a href="{{ route('precadastro.index') }}" class="hero-link" aria-label="Acesso para candidatos fazerem pre-cadastro">
                <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                Sou candidato e quero me pré-cadastrar
            </a>
        </div>

        <!-- CARACTERÍSTICAS -->
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon icon-verde"><i class="fa-solid fa-fingerprint"></i></div>
                <div class="feature-title">Emissão de Senhas</div>
                <div class="feature-desc">Gere senhas oficiais com QR Code para os candidatos garantirem sua vaga na turma.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon icon-laranja"><i class="fa-solid fa-id-card-clip"></i></div>
                <div class="feature-title">Carteirinhas</div>
                <div class="feature-desc">Consulte alunos e emita carteirinhas de acesso ao aplicativo exclusivo do cursista.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon icon-dourado"><i class="fa-solid fa-clipboard-list"></i></div>
                <div class="feature-title">Pré-cadastro</div>
                <div class="feature-desc">Imprima folders informativos para agilizar o cadastro inicial dos candidatos.</div>
            </div>
        </div>

    </main>

    <footer class="landing-footer">
        <strong>Cidade do Saber</strong> — Prefeitura de Camacari · Todos os direitos reservados
    </footer>

</body>
</html>