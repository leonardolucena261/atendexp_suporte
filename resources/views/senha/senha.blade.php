<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atende XP — Central de Servicos</title>
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
            --dourado: #FFAD02; --clarinho: #BFFBAC;
            --laranja: #EF8E26; --escuro: #1E293B; --claro: #F9F9F9; --branco: #FFFFFF;
            --txt-dark: #0F172A; --txt-body: #334155; --txt-muted: #64748B;
            --border: #CBD5E1; --border-light: #E2E8F0;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.06), 0 2px 4px rgba(0,0,0,0.04);
            --shadow-lg: 0 10px 32px rgba(0,0,0,0.08), 0 4px 8px rgba(0,0,0,0.04);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--claro);
            color: var(--txt-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

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

        /* ===== TOPBAR ===== */
        .app-topbar {
            background: rgba(255,255,255,0.85);
            border-bottom: 1px solid var(--border-light);
            padding: 0.625rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
        }
        .topbar-left { display: flex; align-items: center; gap: 0.75rem; }
        .topbar-logo {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, var(--escuro) 0%, #0f172a 100%);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(30,41,59,0.25);
            position: relative; overflow: hidden;
        }
        .topbar-logo::after {
            content: '';
            position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: linear-gradient(135deg, transparent 40%, rgba(139,189,71,0.15) 50%, transparent 60%);
            animation: logoShine 4s ease-in-out infinite;
        }
        @keyframes logoShine {
            0%, 100% { transform: translateX(-100%) rotate(25deg); }
            50% { transform: translateX(100%) rotate(25deg); }
        }
        .topbar-logo i { color: var(--verde); font-size: 1rem; position: relative; z-index: 1; }
        .topbar-title { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 1.025rem; color: var(--txt-dark); }
        .topbar-subtitle { font-size: 0.7rem; color: var(--txt-muted); font-weight: 500; letter-spacing: 0.03em; }
        .topbar-right { display: flex; align-items: center; gap: 0.5rem; }

        .user-chip {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.375rem 0.75rem 0.375rem 0.5rem;
            background: rgba(139,189,71,0.07); border: 1px solid rgba(139,189,71,0.15);
            border-radius: 999px; font-size: 0.8rem; color: var(--txt-dark); font-weight: 500;
            transition: all 0.2s ease;
        }
        .user-chip:hover { background: rgba(139,189,71,0.12); border-color: rgba(139,189,71,0.25); }
        .user-chip-avatar {
            width: 24px; height: 24px; border-radius: 50%;
            background: linear-gradient(135deg, var(--verde), var(--verde-dark));
            display: flex; align-items: center; justify-content: center;
        }
        .user-chip-avatar i { color: white; font-size: 0.625rem; }

        .btn-ghost {
            display: inline-flex; align-items: center; gap: 0.375rem;
            padding: 0.4rem 0.875rem; border-radius: 0.5rem;
            font-size: 0.8rem; font-weight: 600; font-family: 'Space Grotesk', sans-serif;
            color: var(--txt-muted); background: transparent;
            border: 1.5px solid transparent; cursor: pointer;
            text-decoration: none; transition: all 0.25s cubic-bezier(0.22,1,0.36,1);
            min-height: 36px; white-space: nowrap;
        }
        .btn-ghost:hover { color: var(--txt-dark); background: rgba(15,23,42,0.04); border-color: var(--border-light); }
        .btn-logout:hover { color: #dc2626; background: rgba(239,68,68,0.05); border-color: rgba(239,68,68,0.15); }

        .btn-informe {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.4rem 0.875rem; border-radius: 0.5rem;
            font-size: 0.8rem; font-weight: 600; font-family: 'Space Grotesk', sans-serif;
            color: #92400e; background: rgba(239,142,38,0.08);
            border: 1.5px solid rgba(239,142,38,0.18); cursor: pointer;
            text-decoration: none; transition: all 0.25s cubic-bezier(0.22,1,0.36,1);
            min-height: 36px; white-space: nowrap;
            position: relative; overflow: hidden;
        }
        .btn-informe::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
            opacity: 0; transition: opacity 0.25s;
        }
        .btn-informe:hover {
            background: var(--laranja); color: white;
            border-color: var(--laranja);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239,142,38,0.35);
        }
        .btn-informe:hover::before { opacity: 1; }
        .btn-informe:active { transform: translateY(0); }

        .topbar-divider { width: 1px; height: 24px; background: var(--border-light); margin: 0 0.125rem; }

        /* ===== PAINEL GRID ===== */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.25rem;
            position: relative;
            z-index: 1;
            width: 100%;
        }
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
            width: 100%;
            max-width: 860px;
        }
        .cards-grid.grid-single {
            grid-template-columns: 1fr;
            max-width: 440px;
        }
        /* ★ Grid 3 colunas quando há card de relatórios */
        .cards-grid.grid-trio {
            grid-template-columns: repeat(3, 1fr);
            max-width: 1120px;
            gap: 1rem;
        }

        /* ===== CARD BASE ===== */
        .form-card {
            background: white;
            border-radius: 1.25rem;
            padding: 1.75rem 1.5rem 1.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
            position: relative;
            z-index: 1;
            animation: cardIn 0.5s cubic-bezier(0.22,1,0.36,1);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease;
            overflow: hidden;
        }
        .form-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }
        .form-card:nth-child(2) { animation-delay: 0.08s; animation-fill-mode: backwards; }
        .form-card:nth-child(3) { animation-delay: 0.16s; animation-fill-mode: backwards; }
        .form-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            border-radius: 1.25rem 1.25rem 0 0;
            background: linear-gradient(90deg, var(--verde), var(--verde-light), var(--dourado));
            opacity: 0.75;
        }
        /* ★ Barra de topo dourada no card de relatórios */
        .form-card.card-relatorio::before {
            background: linear-gradient(90deg, var(--dourado), #fbbf24, var(--laranja));
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ★ Ícone do card — menor e mais elegante */
        .form-icon {
            width: 48px; height: 48px; border-radius: 0.75rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, rgba(139,189,71,0.12), rgba(255,173,2,0.08));
            border: 1.5px solid rgba(139,189,71,0.15);
            transition: transform 0.3s cubic-bezier(0.22,1,0.36,1);
        }
        .form-card:hover .form-icon { transform: scale(1.06) rotate(-3deg); }

        /* ★ Ícone do card de relatórios com tom dourado */
        .form-card.card-relatorio .form-icon {
            background: linear-gradient(135deg, rgba(255,173,2,0.12), rgba(239,142,38,0.08));
            border-color: rgba(255,173,2,0.2);
        }

        /* ★ Títulos mais compactos */
        .card-title {
            text-align: center;
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: -0.01em;
            margin-bottom: 0.25rem;
            color: var(--txt-dark);
            line-height: 1.25;
        }
        .card-subtitle {
            text-align: center;
            font-size: 0.813rem;
            color: var(--txt-muted);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .field-label { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; }
        .field-label label { font-size: 0.7rem; font-weight: 600; color: var(--txt-muted); text-transform: uppercase; letter-spacing: 0.06em; }
        .required-badge { display: inline-flex; align-items: center; gap: 0.2rem; padding: 0.1rem 0.45rem; border-radius: 999px; font-size: 0.6rem; font-weight: 700; font-family: 'Sora', sans-serif; letter-spacing: 0.03em; background: rgba(239,142,38,0.1); color: #c2410c; border: 1px solid rgba(239,142,38,0.2); }

        /* ★ Inputs com altura mais refinada */
        .turma-input {
            width: 100%; min-height: 46px; padding: 0 1rem 0 2.75rem;
            border: 1.5px solid var(--border); border-radius: 0.625rem;
            font-family: 'Sora', sans-serif; font-size: 0.938rem; font-weight: 600;
            color: var(--txt-dark); background: var(--claro); letter-spacing: 0.04em;
            transition: all 0.25s cubic-bezier(0.22,1,0.36,1);
        }
        .turma-input:hover { border-color: #94a3b8; }
        .turma-input:focus { outline: none; background: white; border-color: var(--verde); box-shadow: 0 0 0 4px rgba(139,189,71,0.12), var(--shadow-sm); }
        .turma-input::placeholder { color: #94a3b8; font-weight: 400; font-size: 0.813rem; letter-spacing: 0; }
        .turma-input.input-alert { border-color: rgba(239,142,38,0.4); background: #fffbeb; }
        .turma-input.input-alert:focus { border-color: var(--laranja); box-shadow: 0 0 0 4px rgba(239,142,38,0.15); }

        .validation-msg { overflow: hidden; max-height: 0; opacity: 0; transition: max-height 0.4s cubic-bezier(0.22,1,0.36,1), opacity 0.3s ease, margin 0.3s ease; margin-top: 0; pointer-events: none; }
        .validation-msg.visible { max-height: 100px; opacity: 1; margin-top: 0.75rem; pointer-events: auto; }
        .validation-inner { display: flex; align-items: flex-start; gap: 0.5rem; padding: 0.625rem 0.875rem; border-radius: 0.625rem; font-size: 0.75rem; line-height: 1.5; background: #fffbeb; border: 1px solid #fde68a; }
        .vi-icon { width: 22px; height: 22px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: rgba(239,142,38,0.1); }
        .vi-title { font-family: 'Sora', sans-serif; font-weight: 600; font-size: 0.75rem; color: #92400e; }
        .vi-text { font-size: 0.688rem; color: var(--txt-muted); margin-top: 0.1rem; }

        /* ★ Botão de submit mais refinado */
        .btn-submit {
            width: 100%; min-height: 46px; padding: 0 1.25rem; border-radius: 0.625rem; border: none;
            font-weight: 700; font-family: 'Sora', sans-serif; font-size: 0.875rem;
            cursor: pointer; transition: all 0.25s cubic-bezier(0.22,1,0.36,1);
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            margin-top: 0.75rem; background: linear-gradient(135deg, var(--verde), var(--verde-dark)); color: white;
            box-shadow: 0 2px 8px rgba(139,189,71,0.3);
            position: relative; overflow: hidden; text-decoration: none;
        }
        .btn-submit::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,0.15));
            opacity: 0; transition: opacity 0.25s;
        }
        .btn-submit:hover { box-shadow: 0 6px 20px rgba(139,189,71,0.4); transform: translateY(-2px); }
        .btn-submit:hover::after { opacity: 1; }
        .btn-submit:active { transform: translateY(0) scale(0.98); }

        /* ★ Botão dourado do card de relatórios */
        .btn-submit.btn-relatorio {
            background: linear-gradient(135deg, var(--dourado), #e6a800);
            box-shadow: 0 2px 8px rgba(255,173,2,0.35);
        }
        .btn-submit.btn-relatorio:hover {
            box-shadow: 0 6px 20px rgba(255,173,2,0.45);
        }

        /* ★ Lista de atalhos dentro do card de relatórios — itens mais compactos */
        .relatorio-links {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
        }
        .relatorio-link-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            border: 1.5px solid var(--border-light);
            background: var(--claro);
            text-decoration: none;
            color: var(--txt-body);
            font-size: 0.813rem;
            font-weight: 500;
            transition: all 0.2s cubic-bezier(0.22,1,0.36,1);
        }
        .relatorio-link-item:hover {
            border-color: rgba(255,173,2,0.35);
            background: rgba(255,173,2,0.04);
            color: var(--txt-dark);
            transform: translateX(3px);
            box-shadow: var(--shadow-sm);
        }
        .relatorio-link-item .rl-icon {
            width: 30px; height: 30px; border-radius: 0.5rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 0.7rem;
            background: rgba(255,173,2,0.1); color: #b45309;
            transition: all 0.2s;
        }
        .relatorio-link-item:hover .rl-icon {
            background: rgba(255,173,2,0.18); color: #92400e;
        }
        .relatorio-link-item .rl-text { flex: 1; min-width: 0; }
        .relatorio-link-item .rl-title {
            font-family: 'Sora', sans-serif; font-weight: 600;
            font-size: 0.75rem; color: var(--txt-dark); line-height: 1.2;
        }
        .relatorio-link-item .rl-desc {
            font-size: 0.65rem; color: var(--txt-muted); margin-top: 0.05rem;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .relatorio-link-item .rl-arrow {
            color: var(--border); font-size: 0.55rem;
            transition: all 0.2s;
        }
        .relatorio-link-item:hover .rl-arrow {
            color: var(--dourado); transform: translateX(2px);
        }

        /* ★ Help text mais discreto */
        .help-text {
            text-align: center;
            font-size: 0.725rem;
            color: var(--txt-muted);
            margin-top: 1rem;
            line-height: 1.5;
        }
        .help-text i { color: rgba(139,189,71,0.6); margin-right: 0.25rem; }

        .app-footer {
            margin-top: auto; padding: 1rem 1.5rem; text-align: center;
            font-size: 0.7rem; color: var(--txt-muted);
            border-top: 1px solid var(--border-light);
            background: rgba(255,255,255,0.5);
            backdrop-filter: blur(8px);
            position: relative; z-index: 1;
        }
        .app-footer span { color: var(--verde); font-weight: 600; }

        :focus-visible { outline: none; box-shadow: 0 0 0 3px white, 0 0 0 5px var(--verde); border-radius: 4px; }

        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; } }

        /* ★ Breakpoints refinados */
        @media (max-width: 1024px) {
            .cards-grid.grid-trio { grid-template-columns: repeat(2, 1fr); max-width: 720px; }
        }
        @media (max-width: 768px) {
            .cards-grid { grid-template-columns: 1fr; max-width: 420px; }
            .cards-grid.grid-trio { grid-template-columns: 1fr; max-width: 420px; }
            .form-panel { padding: 1.5rem 1rem; }
        }
        @media (max-width: 640px) {
            .app-topbar { padding: 0.5rem 0.75rem; }
            .topbar-title { font-size: 0.875rem; }
            .topbar-subtitle { display: none; }
            .user-chip .user-text { display: none; }
            .btn-ghost .btn-text { display: none; }
            .btn-informe .btn-text { display: none; }
            .topbar-divider { display: none; }
            .form-card { padding: 1.5rem 1.25rem 1.25rem; }
            .card-title { font-size: 1.125rem; }
            .app-footer { padding: 0.75rem 1rem; }
        }
    </style>
</head>
<body>

    <header class="app-topbar">
        <div class="topbar-left">
            <div class="topbar-logo" aria-hidden="true"><i class="fa-solid fa-graduation-cap"></i></div>
            <div>
                <h1 class="topbar-title">Atende XP</h1>
                <p class="topbar-subtitle">Central de Servicos</p>
            </div>
        </div>
        <div class="topbar-right">
            <a href="{{ route('aluno.informePrecadastro') }}" class="btn-informe" aria-label="Informe sobre pre-cadastro">
                <i class="fa-solid fa-file-lines text-xs" aria-hidden="true"></i>
                <span class="btn-text">QR Code de Pre-cadastro</span>
            </a>

            <div class="topbar-divider" aria-hidden="true"></div>

            <div class="user-chip" aria-label="Usuario logado">
                <div class="user-chip-avatar"><i class="fa-solid fa-user"></i></div>
                <span class="user-text">{{ session('login')['nome_completo'] }}</span>
            </div>
            <a href="{{ route('login') }}" class="btn-ghost btn-logout" title="Sair do sistema">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="btn-text">Sair</span>
            </a>
        </div>
    </header>

    <main class="form-panel">

        @php
            $perfilUsuario = session('login')['perfil'] ?? '';
            $podeEmitirSenha = in_array(mb_strtoupper(trim($perfilUsuario)), ['ADMINISTRADOR DO SISTEMA', 'GERENCIA']);
        @endphp

        <div class="cards-grid {{ $podeEmitirSenha ? 'grid-trio' : '' }}">

            {{-- ★ CARD DE RELATÓRIOS — agora com 3 opções balanceadas --}}
            <div class="form-card card-relatorio">
                <div class="form-icon" role="img" aria-label="Icone de relatorios">
                    <i class="fa-solid fa-chart-column text-xl" style="color:#b45309;"></i>
                </div>
                <h2 class="card-title">Relatorios</h2>
                <p class="card-subtitle">Dados gerenciais e analiticos</p>

                <div class="relatorio-links">
                    <a href="{{ route('relatorio.matriculas') }}" class="relatorio-link-item" aria-label="Relatorio de matriculas">
                        <div class="rl-icon"><i class="fa-solid fa-users"></i></div>
                        <div class="rl-text">
                            <div class="rl-title">Matriculas</div>
                            <div class="rl-desc">Turmas, vagas e ocupacao</div>
                        </div>
                        <i class="fa-solid fa-chevron-right rl-arrow" aria-hidden="true"></i>
                    </a>
                    
                </div>

                <p class="help-text"><i class="fa-solid fa-circle-info" style="color:rgba(255,173,2,0.5);"></i> Filtros por periodo, coordenacao e mais.</p>
            </div>

            @if($podeEmitirSenha)
            <div class="form-card">
                <div class="form-icon" role="img" aria-label="Icone de geracao de senha">
                    <i class="fa-solid fa-fingerprint text-xl" style="color:var(--verde);"></i>
                </div>
                <h2 class="card-title">Emitir senha</h2>
                <p class="card-subtitle">Informe o codigo da turma para prosseguir</p>

                <form id="formTurma" method="POST" action="{{ route('senha.imprimir') }}" novalidate autocomplete="off">
                    @csrf
                    <div class="field-label">
                        <label for="inputCodTurma">Codigo da turma</label>
                        <span class="required-badge" aria-hidden="true"><i class="fa-solid fa-asterisk" style="font-size:5px;" aria-hidden="true"></i> Obrigatorio</span>
                    </div>
                    <div style="position:relative;">
                        <i class="fa-solid fa-barcode" style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:var(--txt-muted);font-size:0.813rem;pointer-events:none;" aria-hidden="true"></i>
                        <input type="text" id="inputCodTurma" name="cod_turma" class="turma-input" placeholder="Ex: TURM3" maxlength="5" value="{{ old('cod_turma') }}" aria-required="true" aria-invalid="false" aria-describedby="helpTextSenha validationMsg">
                    </div>
                    <div id="validationMsg" class="validation-msg" role="alert" aria-live="assertive"></div>
                    <button type="submit" class="btn-submit" aria-label="Gerar senha">
                        <i class="fa-solid fa-print text-xs" aria-hidden="true"></i>
                        <span>Gerar senha</span>
                    </button>
                </form>
                <p id="helpTextSenha" class="help-text"><i class="fa-solid fa-circle-info"></i> O codigo esta disponivel na carta de convocacao.</p>
            </div>
            @endif

            <div class="form-card">
                <div class="form-icon" role="img" aria-label="Icone de busca de aluno">
                    <i class="fa-solid fa-user-graduate text-xl" style="color:var(--verde);"></i>
                </div>
                <h2 class="card-title">Buscar Aluno</h2>
                <p class="card-subtitle">Localize um aluno para emitir a carteirinha</p>

                <form id="formAluno" method="GET" action="{{ route('aluno.index') }}" novalidate>
                    <div class="field-label">
                        <label for="inputBuscaAluno">Nome, CPF ou RG</label>
                        <span class="required-badge" aria-hidden="true"><i class="fa-solid fa-asterisk" style="font-size:5px;" aria-hidden="true"></i> Obrigatorio</span>
                    </div>
                    <div style="position:relative;">
                        <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:var(--txt-muted);font-size:0.813rem;pointer-events:none;" aria-hidden="true"></i>
                        <input
                            type="text"
                            id="inputBuscaAluno"
                            name="busca"
                            class="turma-input"
                            placeholder="Ex: Joao da Silva"
                            value="{{ request('busca') }}"
                            aria-required="true"
                            aria-invalid="false"
                            aria-describedby="helpTextAluno validationMsgAluno"
                        >
                    </div>
                    <div id="validationMsgAluno" class="validation-msg" role="alert" aria-live="assertive"></div>
                    <button type="submit" class="btn-submit" aria-label="Buscar aluno">
                        <i class="fa-solid fa-magnifying-glass text-xs" aria-hidden="true"></i>
                        <span>Buscar Aluno</span>
                    </button>
                </form>
                <p id="helpTextAluno" class="help-text"><i class="fa-solid fa-circle-info"></i> Informe dados para acessar o historico e carteirinha.</p>
            </div>

            

        </div>
    </main>

    <footer class="app-footer">
        <span>Cidade do Saber</span> — Prefeitura de Camacari · Sistema de Atendimento
    </footer>

    <script>
    class FormValidator {
        #input;
        #msgContainer;

        constructor(input, container) {
            this.#input = input;
            this.#msgContainer = container;
        }

        show(titulo, texto) {
            this.#msgContainer.innerHTML = `
                <div class="validation-inner">
                    <div class="vi-icon" aria-hidden="true">
                        <i class="fa-solid fa-triangle-exclamation text-xs" style="color:var(--laranja);"></i>
                    </div>
                    <div>
                        <p class="vi-title">${titulo}</p>
                        <p class="vi-text">${texto}</p>
                    </div>
                </div>`;

            this.#input.classList.add('input-alert');
            this.#input.setAttribute('aria-invalid', 'true');
            requestAnimationFrame(() => this.#msgContainer.classList.add('visible'));
        }

        clear() {
            this.#msgContainer.classList.remove('visible');
            this.#input.classList.remove('input-alert');
            this.#input.setAttribute('aria-invalid', 'false');
            setTimeout(() => {
                if (!this.#msgContainer.classList.contains('visible')) this.#msgContainer.innerHTML = '';
            }, 400);
        }

        get isVisible() { return this.#msgContainer.classList.contains('visible'); }
    }

    function bindFormEvents(form, input, validator, toUpperCase) {
        form.addEventListener('submit', (e) => {
            if (!input.value.trim()) {
                e.preventDefault();
                validator.show('Campo obrigatorio', 'Preencha este campo para prosseguir com a busca.');
                input.focus();
            }
        });

        input.addEventListener('input', () => {
            if (toUpperCase) input.value = input.value.toUpperCase();
            if (validator.isVisible) validator.clear();
        });

        input.addEventListener('focus', () => {
            if (input.value.trim() === '' && input.classList.contains('input-alert')) {
                validator.clear();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && document.activeElement === input) {
                input.value = '';
                validator.clear();
                input.focus();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {

        const formTurma = document.getElementById('formTurma');
        if (formTurma) {
            const inputTurma = document.getElementById('inputCodTurma');
            const valTurma = new FormValidator(inputTurma, document.getElementById('validationMsg'));
            bindFormEvents(formTurma, inputTurma, valTurma, true);
            window.addEventListener('load', () => setTimeout(() => inputTurma.focus(), 600));
        }

        const formAluno = document.getElementById('formAluno');
        if (formAluno) {
            const inputAluno = document.getElementById('inputBuscaAluno');
            const valAluno = new FormValidator(inputAluno, document.getElementById('validationMsgAluno'));
            bindFormEvents(formAluno, inputAluno, valAluno, false);
            window.addEventListener('load', () => setTimeout(() => inputAluno.focus(), 800));
        }
    });
    </script>
</body>
</html>