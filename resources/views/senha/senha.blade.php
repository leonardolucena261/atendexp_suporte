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

        .app-topbar {
            background: rgba(255,255,255,0.9);
            border-bottom: 1px solid var(--border-light);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(8px);
        }
        .topbar-left { display: flex; align-items: center; gap: 0.75rem; }
        .topbar-logo { width: 36px; height: 36px; border-radius: 10px; background: var(--escuro); display: flex; align-items: center; justify-content: center; }
        .topbar-logo i { color: var(--verde); font-size: 1rem; }
        .topbar-title { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 1rem; color: var(--txt-dark); }
        .topbar-subtitle { font-size: 0.75rem; color: var(--txt-muted); }
        .topbar-right { display: flex; align-items: center; gap: 0.75rem; }
        
        .user-chip { display: flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0.75rem 0.4rem 0.5rem; background: rgba(139,189,71,0.08); border: 1px solid rgba(139,189,71,0.2); border-radius: 999px; font-size: 0.813rem; color: var(--txt-dark); font-weight: 500; }
        .user-chip i { color: var(--verde); font-size: 0.875rem; }
        
        .btn-logout { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.4rem 0.875rem; border-radius: 0.5rem; font-size: 0.813rem; font-weight: 600; font-family: 'Space Grotesk', sans-serif; color: var(--txt-muted); background: transparent; border: 1px solid transparent; cursor: pointer; text-decoration: none; transition: all 0.2s ease; min-height: 36px; }
        .btn-logout:hover { color: #dc2626; background: rgba(239,68,68,0.05); border-color: rgba(239,68,68,0.15); }

        /* ===== PAINEL GRID ===== */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 960px; 
            margin: 0 auto;
        }
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            width: 100%;
        }

        /* ALTERAÇÃO: Quando tem apenas 1 card (sem permissão), centraliza bonito */
        .cards-grid.grid-single {
            grid-template-columns: 1fr;
            max-width: 480px;
        }

        /* ===== CARD BASE ===== */
        .form-card {
            background: white;
            border-radius: 1.5rem;
            padding: 2.5rem 2rem 2rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.04), 0 1px 3px rgba(0,0,0,0.02);
            border: 1px solid var(--border-light);
            position: relative;
            z-index: 1;
            animation: cardIn 0.5s cubic-bezier(0.22,1,0.36,1);
        }
        .form-card:nth-child(2) { animation-delay: 0.1s; animation-fill-mode: backwards; }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .form-icon {
            width: 64px; height: 64px; border-radius: 1rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
            background: linear-gradient(135deg, rgba(139,189,71,0.12), rgba(255,173,2,0.08));
            border: 1.5px solid rgba(139,189,71,0.15);
        }

        .field-label { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; }
        .field-label label { font-size: 0.75rem; font-weight: 600; color: var(--txt-muted); text-transform: uppercase; letter-spacing: 0.06em; }
        .required-badge { display: inline-flex; align-items: center; gap: 0.2rem; padding: 0.1rem 0.45rem; border-radius: 999px; font-size: 0.625rem; font-weight: 700; font-family: 'Sora', sans-serif; letter-spacing: 0.03em; background: rgba(239,142,38,0.1); color: #c2410c; border: 1px solid rgba(239,142,38,0.2); }

        .turma-input {
            width: 100%; min-height: 52px; padding: 0 1rem 0 2.85rem;
            border: 1.5px solid var(--border); border-radius: 0.75rem;
            font-family: 'Sora', sans-serif; font-size: 1rem; font-weight: 600;
            color: var(--txt-dark); background: var(--claro); letter-spacing: 0.04em;
            transition: all 0.2s ease;
        }
        .turma-input:hover { border-color: #94a3b8; }
        .turma-input:focus { outline: none; background: white; border-color: var(--verde); box-shadow: 0 0 0 4px rgba(139,189,71,0.15); }
        .turma-input::placeholder { color: #94a3b8; font-weight: 400; font-size: 0.875rem; letter-spacing: 0; }
        .turma-input.input-alert { border-color: rgba(239,142,38,0.4); background: #fffbeb; }
        .turma-input.input-alert:focus { border-color: var(--laranja); box-shadow: 0 0 0 4px rgba(239,142,38,0.15); }

        .validation-msg { overflow: hidden; max-height: 0; opacity: 0; transition: max-height 0.4s cubic-bezier(0.22,1,0.36,1), opacity 0.3s ease, margin 0.3s ease; margin-top: 0; pointer-events: none; }
        .validation-msg.visible { max-height: 100px; opacity: 1; margin-top: 0.75rem; pointer-events: auto; }
        .validation-inner { display: flex; align-items: flex-start; gap: 0.5rem; padding: 0.75rem 1rem; border-radius: 0.75rem; font-size: 0.813rem; line-height: 1.5; background: #fffbeb; border: 1px solid #fde68a; }
        .vi-icon { width: 24px; height: 24px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: rgba(239,142,38,0.1); }
        .vi-title { font-family: 'Sora', sans-serif; font-weight: 600; font-size: 0.813rem; color: #92400e; }
        .vi-text { font-size: 0.75rem; color: var(--txt-muted); margin-top: 0.125rem; }

        .btn-submit {
            width: 100%; min-height: 52px; padding: 0 1.5rem; border-radius: 0.75rem; border: none;
            font-weight: 700; font-family: 'Sora', sans-serif; font-size: 0.938rem;
            cursor: pointer; transition: all 0.2s ease;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            margin-top: 0.5rem; background: var(--verde); color: white;
            box-shadow: 0 2px 8px rgba(139,189,71,0.3);
        }
        .btn-submit:hover { background: #7aa83d; box-shadow: 0 4px 12px rgba(139,189,71,0.4); transform: translateY(-1px); }
        .btn-submit:active { transform: translateY(0) scale(0.98); }

        .help-text { text-align: center; font-size: 0.813rem; color: var(--txt-muted); margin-top: 1.5rem; line-height: 1.6; }
        .help-text i { color: rgba(139,189,71,0.6); margin-right: 0.25rem; }

        .toast { position: fixed; top: 1rem; left: 50%; z-index: 1000; transform: translateX(-50%) translateY(-120%); transition: transform 0.5s cubic-bezier(0.22,1,0.36,1); width: calc(100% - 2rem); max-width: 380px; }
        .toast.show { transform: translateX(-50%) translateY(0); }

        :focus-visible { outline: none; box-shadow: 0 0 0 3px white, 0 0 0 5px var(--verde); border-radius: 4px; }

        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; } }

        @media (max-width: 768px) { .cards-grid { grid-template-columns: 1fr; max-width: 420px; } }
        @media (max-width: 640px) {
            .app-topbar { padding: 0.5rem 1rem; }
            .topbar-title { font-size: 0.875rem; }
            .user-chip span { display: none; }
            .form-panel { padding: 1rem 0.75rem; }
            .form-card { padding: 2rem 1.5rem 1.5rem; }
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
            <div class="user-chip" aria-label="Usuario logado">
                <i class="fa-solid fa-user"></i>
                <span>{{ session('login')['nome_completo'] }}</span>
            </div>
            <a href="{{ route('login') }}" class="btn-logout" title="Sair do sistema"><i class="fa-solid fa-right-from-bracket"></i><span>Sair</span></a>
        </div>
    </header>

    <main class="form-panel">
        
        <!-- ALTERAÇÃO INICIADA: Verificação de Perfil e Classe CSS dinâmica -->
        @php
            $perfilUsuario = session('login')['perfil'] ?? '';
            $podeEmitirSenha = in_array(mb_strtoupper(trim($perfilUsuario)), ['ADMINISTRADOR DO SISTEMA', 'GERENCIA']);
        @endphp

        <div class="cards-grid {{ !$podeEmitirSenha ? 'grid-single' : '' }}">
        <!-- ALTERAÇÃO FINALIZADA -->

            
            <!-- CARD 1: GERAR SENHA (AGORA CONDICIONAL) -->
            @if($podeEmitirSenha)
            <div class="form-card">
                <div class="form-icon" role="img" aria-label="Icone de geracao de senha">
                    <i class="fa-solid fa-fingerprint text-2xl" style="color:var(--verde);"></i>
                </div>
                <h2 class="text-center font-display font-800 text-xl sm:text-2xl tracking-tight mb-1" style="color:var(--txt-dark);line-height:1.2;">Emitir senha</h2>
                <p class="text-center text-sm mb-8" style="color:var(--txt-muted);">Informe o codigo da turma para prosseguir</p>

                <form id="formTurma" method="POST" action="{{ route('senha.imprimir') }}" novalidate autocomplete="off">
                    @csrf
                    <div class="field-label">
                        <label for="inputCodTurma">Codigo da turma</label>
                        <span class="required-badge" aria-hidden="true"><i class="fa-solid fa-asterisk" style="font-size:6px;" aria-hidden="true"></i> Obrigatorio</span>
                    </div>
                    <div style="position:relative;">
                        <i class="fa-solid fa-barcode" style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:var(--txt-muted);font-size:0.875rem;pointer-events:none;" aria-hidden="true"></i>
                        <input type="text" id="inputCodTurma" name="cod_turma" class="turma-input" placeholder="Ex: TURM3" maxlength="5" value="{{ old('cod_turma') }}" aria-required="true" aria-invalid="false" aria-describedby="helpTextSenha validationMsg">
                    </div>
                    <div id="validationMsg" class="validation-msg" role="alert" aria-live="assertive"></div>
                    <button type="submit" class="btn-submit mt-3" aria-label="Gerar senha">
                        <i class="fa-solid fa-print text-sm" aria-hidden="true"></i>
                        <span>Gerar senha</span>
                    </button>
                </form>
                <p id="helpTextSenha" class="help-text"><i class="fa-solid fa-circle-info"></i> O codigo da turma esta disponivel na sua carta de convocacao.</p>
            </div>
            @endif

            <!-- CARD 2: BUSCAR ALUNO -->
            <div class="form-card">
                <div class="form-icon" role="img" aria-label="Icone de busca de aluno">
                    <i class="fa-solid fa-user-graduate text-2xl" style="color:var(--verde);"></i>
                </div>
                <h2 class="text-center font-display font-800 text-xl sm:text-2xl tracking-tight mb-1" style="color:var(--txt-dark);line-height:1.2;">Buscar Aluno</h2>
                <p class="text-center text-sm mb-8" style="color:var(--txt-muted);">Localize um aluno para emitir a carteirinha</p>

                <form id="formAluno" method="GET" action="{{ route('aluno.index') }}" novalidate>
                    <div class="field-label">
                        <label for="inputBuscaAluno">Nome, CPF ou RG</label>
                        <span class="required-badge" aria-hidden="true"><i class="fa-solid fa-asterisk" style="font-size:6px;" aria-hidden="true"></i> Obrigatorio</span>
                    </div>
                    <div style="position:relative;">
                        <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:var(--txt-muted);font-size:0.875rem;pointer-events:none;" aria-hidden="true"></i>
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
                    <button type="submit" class="btn-submit mt-3" aria-label="Buscar aluno">
                        <i class="fa-solid fa-magnifying-glass text-sm" aria-hidden="true"></i>
                        <span>Buscar Aluno</span>
                    </button>
                </form>
                <p id="helpTextAluno" class="help-text"><i class="fa-solid fa-circle-info"></i> Informe dados do aluno para acessar seu historico e carteirinha.</p>
            </div>

        </div>
    </main>

    <!-- ===== TOAST ===== -->
    <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div style="display:flex;align-items:center;gap:0.625rem;padding:0.75rem 1rem;border-radius:0.75rem;background:white;box-shadow:0 4px 20px rgba(0,0,0,0.12);border:1px solid var(--border-light);">
            <div id="toastIcon" style="width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:rgba(239,142,38,0.1);" aria-hidden="true">
                <i class="fa-solid fa-triangle-exclamation text-xs" style="color:var(--laranja);"></i>
            </div>
            <div style="min-width:0;">
                <p id="toastTitle" style="font-size:0.813rem;font-family:'Sora',sans-serif;font-weight:600;color:var(--txt-dark);"></p>
                <p id="toastMsg" style="font-size:0.75rem;color:var(--txt-muted);"></p>
            </div>
        </div>
    </div>

    <script>
    // =============================================================
    // CLASSE DE VALIDAÇÃO REUTILIZÁVEL
    // =============================================================
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

    // =============================================================
    // FUNÇÃO GENÉRICA PARA LIGAR EVENTOS A QUALQUER FORMULÁRIO
    // =============================================================
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

    // =============================================================
    // INICIALIZAÇÃO SEGURA
    // =============================================================
    document.addEventListener('DOMContentLoaded', () => {
        
        // 1. Configuração do Formulário de Senha (Só existe na página se o cara tiver permissão)
        const formTurma = document.getElementById('formTurma');
        if (formTurma) {
            const inputTurma = document.getElementById('inputCodTurma');
            const valTurma = new FormValidator(inputTurma, document.getElementById('validationMsg'));
            bindFormEvents(formTurma, inputTurma, valTurma, true);
            window.addEventListener('load', () => setTimeout(() => inputTurma.focus(), 600));
        }

        // 2. Configuração do Formulário de Aluno
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