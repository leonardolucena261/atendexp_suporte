<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Vagas — Cursos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Sora:wght@200;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        verde: '#8BBD47',
                        dourado: '#FFAD02',
                        clarinho: '#BFFBAC',
                        laranja: '#EF8E26',
                        escuro: '#1E293B',
                        claro: '#F9F9F9',
                    },
                    fontFamily: {
                        display: ['Sora', 'sans-serif'],
                        body: ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --verde: #8BBD47;
            --dourado: #FFAD02;
            --clarinho: #BFFBAC;
            --laranja: #EF8E26;
            --escuro: #1E293B;
            --claro: #F9F9F9;
            /* Tokens de contraste acessível (WCAG AA mínimo 4.5:1) */
            --txt-primary: #F1F5F9;
            --txt-secondary: #CBD5E1;
            --txt-tertiary: #94A3B8;
            --txt-muted: #64748B;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--escuro);
            overflow-x: hidden;
            overflow-y: auto;
            min-height: 100vh;
            min-height: 100dvh;
            color: var(--txt-primary);
            line-height: 1.6;
        }

        /* --- Cena 3D --- */
        .scene {
            perspective: 1400px;
            perspective-origin: 50% 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            min-height: 100dvh;
            padding: 1.5rem;
            position: relative;
        }

        /* --- Grid de fundo --- */
        .grid-bg {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(139,189,71,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(139,189,71,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            transform: rotateX(60deg) scale(2.5);
            animation: gridMove 25s linear infinite;
            mask-image: radial-gradient(ellipse 60% 45% at 50% 55%, black 10%, transparent 65%);
            -webkit-mask-image: radial-gradient(ellipse 60% 45% at 50% 55%, black 10%, transparent 65%);
            pointer-events: none;
        }

        @keyframes gridMove {
            0% { background-position: 0 0; }
            100% { background-position: 60px 60px; }
        }

        /* --- Formas flutuantes --- */
        .float-shape {
            position: fixed;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            filter: blur(1px);
            opacity: 0.3;
            animation: floatShape 14s ease-in-out infinite;
            transform-style: preserve-3d;
            pointer-events: none;
        }

        @keyframes floatShape {
            0%, 100% { transform: translateY(0) rotateX(0deg) rotateY(0deg); }
            33% { transform: translateY(-25px) rotateX(6deg) rotateY(8deg); }
            66% { transform: translateY(-15px) rotateX(-4deg) rotateY(-5deg); }
        }

        /* --- Orbs --- */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            animation: orbPulse 8s ease-in-out infinite alternate;
            will-change: transform;
        }

        @keyframes orbPulse {
            0% { transform: scale(1); opacity: 0.2; }
            100% { transform: scale(1.3); opacity: 0.45; }
        }

        /* --- Cartão 3D --- */
        .card-3d {
            transform-style: preserve-3d;
            will-change: transform;
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 500px;
        }

        .card-shine {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.4s;
            background: radial-gradient(
                500px circle at var(--mx, 50%) var(--my, 50%),
                rgba(139,189,71,0.08),
                transparent 50%
            );
            z-index: 2;
        }

        .card-3d:hover .card-shine { opacity: 1; }

        /* --- Borda rotativa --- */
        .border-glow {
            position: absolute;
            inset: -1.5px;
            border-radius: inherit;
            z-index: -1;
            background: conic-gradient(
                from var(--angle, 0deg),
                var(--verde), var(--dourado), var(--laranja), var(--verde), var(--dourado)
            );
            animation: rotateBorder 5s linear infinite;
            opacity: 0.4;
            filter: blur(0.5px);
        }

        @keyframes rotateBorder { to { --angle: 360deg; } }

        @property --angle {
            syntax: '<angle>';
            initial-value: 0deg;
            inherits: false;
        }

        /* --- Input acessível --- */
        .search-input {
            background: rgba(15,23,42,0.9);
            border: 2px solid rgba(139,189,71,0.25);
            color: var(--txt-primary);
            caret-color: var(--verde);
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            font-size: 1rem;
            line-height: 1.5;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--verde);
            box-shadow:
                0 0 0 4px rgba(139,189,71,0.2),
                0 0 20px rgba(139,189,71,0.06);
        }

        .search-input::placeholder {
            color: var(--txt-muted);
            font-weight: 400;
        }

        /* --- Botão acessível --- */
        .btn-search {
            background: linear-gradient(135deg, var(--verde), #6fa032);
            color: var(--escuro);
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            position: relative;
            overflow: hidden;
            font-size: 0.938rem;
            line-height: 1.4;
        }

        .btn-search::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--dourado), var(--laranja));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-search:hover::before { opacity: 1; }
        .btn-search:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(139,189,71,0.3); }
        .btn-search:active { transform: translateY(0) scale(0.98); }
        .btn-search span { position: relative; z-index: 1; }

        /* --- Focus visible global (teclado) --- */
        :focus-visible {
            outline: 3px solid var(--verde);
            outline-offset: 3px;
            border-radius: 4px;
        }

        .btn-search:focus-visible {
            outline: 3px solid var(--claro);
            outline-offset: 3px;
        }

        .search-input:focus-visible {
            outline: none; /* já tem estilo próprio */
        }

        /* --- Toast --- */
        .toast {
            position: fixed;
            top: 1rem;
            left: 50%;
            z-index: 1000;
            transform: translateX(-50%) translateY(-120%);
            transition: transform 0.5s cubic-bezier(0.22, 1, 0.36, 1);
            width: calc(100% - 2rem);
            max-width: 420px;
        }

        .toast.show { transform: translateX(-50%) translateY(0); }

        /* --- Partículas --- */
        .particle {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            animation: particleDrift linear infinite;
        }

        @keyframes particleDrift {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.6; }
            90% { opacity: 0.6; }
            100% { transform: translateY(-10vh) rotate(540deg); opacity: 0; }
        }

        /* --- Anéis orbitais --- */
        .orbit-ring {
            position: fixed;
            border: 1px dashed rgba(139,189,71,0.08);
            border-radius: 50%;
            animation: orbitSpin 35s linear infinite;
            pointer-events: none;
        }

        .orbit-ring:nth-child(2) {
            animation-duration: 50s;
            animation-direction: reverse;
            border-color: rgba(255,173,2,0.06);
        }

        @keyframes orbitSpin { to { transform: rotate(360deg); } }

        .orbit-dot {
            position: absolute;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            top: -2.5px;
            left: 50%;
            transform: translateX(-50%);
        }

        /* --- Animações de entrada --- */
        .text-reveal {
            animation: textReveal 0.9s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes textReveal {
            to { opacity: 1; transform: translateY(0); }
        }

        .text-reveal-d1 { animation-delay: 0.12s; }
        .text-reveal-d2 { animation-delay: 0.24s; }
        .text-reveal-d3 { animation-delay: 0.4s; }
        .text-reveal-d4 { animation-delay: 0.55s; }

        .accent-line {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--verde), var(--dourado), transparent);
            border-radius: 2px;
            animation: lineExpand 1.2s cubic-bezier(0.22, 1, 0.36, 1) 0.35s forwards;
            transform: scaleX(0);
        }

        @keyframes lineExpand { to { transform: scaleX(1); } }

        .spinner {
            border: 2.5px solid rgba(30,41,59,0.2);
            border-top-color: var(--escuro);
            border-radius: 50%;
            width: 18px;
            height: 18px;
            animation: spin 0.6s linear infinite;
            display: inline-block;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .result-card {
            animation: resultSlide 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            opacity: 0;
            transform: translateY(15px) scale(0.97);
        }

        @keyframes resultSlide {
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            15% { transform: translateX(-6px); }
            30% { transform: translateX(5px); }
            45% { transform: translateX(-4px); }
            60% { transform: translateX(3px); }
            75% { transform: translateX(-1px); }
        }

        /* --- Skip link (acessibilidade) --- */
        .skip-link {
            position: absolute;
            top: -100%;
            left: 1rem;
            z-index: 9999;
            padding: 0.75rem 1.5rem;
            background: var(--verde);
            color: var(--escuro);
            font-weight: 700;
            font-family: 'Space Grotesk', sans-serif;
            border-radius: 0 0 0.5rem 0.5rem;
            transition: top 0.2s;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .skip-link:focus {
            top: 0;
        }

        /* --- Redução de movimento --- */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* --- Mobile --- */
        @media (max-width: 640px) {
            .scene { padding: 1rem; }
            .card-inner { padding: 2rem 1.5rem !important; }
            .orb { filter: blur(60px); }
            .orbit-ring { display: none; }
            .float-shape { opacity: 0.15; }
            .particle { display: none; }
            .grid-bg {
                background-size: 40px 40px;
                mask-image: radial-gradient(ellipse 80% 40% at 50% 60%, black 5%, transparent 60%);
                -webkit-mask-image: radial-gradient(ellipse 80% 40% at 50% 60%, black 5%, transparent 60%);
            }
            .result-grid { grid-template-columns: 1fr !important; gap: 0.5rem !important; }
        }

        @media (max-width: 380px) {
            .card-inner { padding: 1.5rem 1.25rem !important; }
        }
    </style>
</head>
<body class="bg-escuro">

    <!-- Link de acessibilidade: pular para o conteúdo principal -->
    <a href="#formulario-busca" class="skip-link">Pular para o formulario de busca</a>

    <!-- Grade 3D de fundo (decorativa) -->
    <div class="grid-bg" role="presentation" aria-hidden="true"></div>

    <!-- Orbs de luz (decorativos) -->
    <div class="orb" role="presentation" aria-hidden="true" style="width:400px;height:400px;background:rgba(139,189,71,0.12);top:-8%;left:-8%;"></div>
    <div class="orb" role="presentation" aria-hidden="true" style="width:350px;height:350px;background:rgba(255,173,2,0.1);bottom:-5%;right:-5%;animation-delay:3s;"></div>
    <div class="orb" role="presentation" aria-hidden="true" style="width:250px;height:250px;background:rgba(239,142,38,0.08);top:45%;left:55%;animation-delay:5s;"></div>

    <!-- Formas flutuantes (decorativas) -->
    <div class="float-shape" role="presentation" aria-hidden="true" style="width:90px;height:90px;background:rgba(139,189,71,0.1);top:12%;left:8%;animation-delay:0s;"></div>
    <div class="float-shape" role="presentation" aria-hidden="true" style="width:65px;height:65px;background:rgba(255,173,2,0.08);top:65%;right:8%;animation-delay:4s;animation-duration:16s;"></div>
    <div class="float-shape" role="presentation" aria-hidden="true" style="width:50px;height:50px;background:rgba(191,251,172,0.06);top:22%;right:15%;animation-delay:6s;animation-duration:18s;"></div>

    <!-- Anéis orbitais (decorativos) -->
    <div class="orbit-ring" role="presentation" aria-hidden="true" style="width:550px;height:550px;top:50%;left:50%;margin-top:-275px;margin-left:-275px;">
        <div class="orbit-dot" style="background:var(--verde);box-shadow:0 0 8px var(--verde);"></div>
    </div>
    <div class="orbit-ring" role="presentation" aria-hidden="true" style="width:400px;height:400px;top:50%;left:50%;margin-top:-200px;margin-left:-200px;">
        <div class="orbit-dot" style="background:var(--dourado);box-shadow:0 0 8px var(--dourado);"></div>
    </div>

    <!-- Partículas (decorativas) -->
    <div id="particles" role="presentation" aria-hidden="true"></div>

    {{ $slot }}
   
  
</body>
</html>