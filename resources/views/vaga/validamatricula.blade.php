<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Matricula por Token — Cidade do Saber</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Sora:wght@200;400;600;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { verde: '#8BBD47', dourado: '#FFAD02', clarinho: '#BFFBAC', laranja: '#EF8E26', escuro: '#1E293B', claro: '#F9F9F9' },
                    fontFamily: { display: ['Sora', 'sans-serif'], body: ['Space Grotesk', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        :root {
            --verde: #8BBD47;
            --dourado: #FFAD02;
            --laranja: #EF8E26;
            --escuro: #1E293B;
            --txt-primary: #F1F5F9;
            --txt-secondary: #CBD5E1;
            --txt-muted: #64748B;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--escuro);
            color: var(--txt-primary);
            overflow-x: hidden;
            min-height: 100vh;
            min-height: 100dvh;
        }

        /* === FUNDO 3D === */
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

        .grid-bg {
            position: fixed;
            inset: 0;
            background-image: linear-gradient(rgba(139, 189, 71, 0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(139, 189, 71, 0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            transform: rotateX(60deg) scale(2.5);
            animation: gridMove 25s linear infinite;
            mask-image: radial-gradient(ellipse 60% 45% at 50% 55%, black 10%, transparent 65%);
            pointer-events: none;
        }

        @keyframes gridMove {
            to {
                background-position: 60px 60px;
            }
        }

        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            animation: orbPulse 8s ease-in-out infinite alternate;
            will-change: transform;
        }

        @keyframes orbPulse {
            0% {
                transform: scale(1);
                opacity: 0.2;
            }

            100% {
                transform: scale(1.3);
                opacity: 0.45;
            }
        }

        .particle {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            animation: particleDrift linear infinite;
        }

        @keyframes particleDrift {
            0% {
                transform: translateY(100vh) rotate(0);
                opacity: 0;
            }

            10% {
                opacity: 0.6;
            }

            90% {
                opacity: 0.6;
            }

            100% {
                transform: translateY(-10vh) rotate(540deg);
                opacity: 0;
            }
        }

        /* === CARD === */
        .card-3d {
            transform-style: preserve-3d;
            will-change: transform;
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
        }

        .card-shine {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.4s;
            background: radial-gradient(500px circle at var(--mx, 50%) var(--my, 50%), rgba(139, 189, 71, 0.08), transparent 50%);
            z-index: 2;
        }

        .card-3d:hover .card-shine {
            opacity: 1;
        }

        .border-glow {
            position: absolute;
            inset: -1.5px;
            border-radius: inherit;
            z-index: -1;
            background: conic-gradient(from var(--angle, 0deg), var(--verde), var(--dourado), var(--laranja), var(--verde));
            animation: rotateBorder 5s linear infinite;
            opacity: 0.4;
            filter: blur(0.5px);
        }

        @keyframes rotateBorder {
            to {
                --angle: 360deg;
            }
        }

        @property --angle {
            syntax: '<angle>';
            initial-value: 0deg;
            inherits: false;
        }

        /* === ELEMENTOS UI === */
        .step-card {
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 0.875rem;
            padding: 0.875rem;
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            transition: all 0.3s;
        }

        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .token-input {
            width: 100%;
            padding: 1.25rem 1rem;
            text-align: center;
            background: rgba(15, 23, 42, 0.8);
            border: 2px solid rgba(139, 189, 71, 0.2);
            color: var(--verde);
            caret-color: var(--verde);
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 2.25rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            border-radius: 1rem;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .token-input:focus {
            outline: none;
            border-color: var(--verde);
            box-shadow: 0 0 0 4px rgba(139, 189, 71, 0.15), 0 0 25px rgba(139, 189, 71, 0.15);
        }

        .token-input::placeholder {
            color: var(--txt-muted);
            font-weight: 400;
            font-size: 1rem;
            letter-spacing: 0.1em;
            text-transform: none;
        }

        .token-input.input-error {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--verde), #6fa032);
            color: var(--escuro);
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--dourado), var(--laranja));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-primary:hover:not(:disabled)::before {
            opacity: 1;
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(139, 189, 71, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-primary span {
            position: relative;
            z-index: 1;
        }

        /* === ANIMAÇÕES === */
        .reveal {
            animation: reveal 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            opacity: 0;
            transform: translateY(16px);
        }

        @keyframes reveal {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .rd1 {
            animation-delay: 0.1s;
        }

        .rd2 {
            animation-delay: 0.2s;
        }

        .rd3 {
            animation-delay: 0.3s;
        }

        .rd4 {
            animation-delay: 0.4s;
        }

        @keyframes popIn {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .pop-in {
            animation: popIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        /* === MODAL === */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(6px);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            padding: 1rem;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            transform: scale(0.95) translateY(10px);
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .modal-overlay.active .modal-content {
            transform: scale(1) translateY(0);
        }

        /* === TOAST === */
        .toast {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 200;
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            width: calc(100% - 2rem);
            max-width: 360px;
        }

        .toast.show {
            transform: translateX(0);
        }

        :focus-visible {
            outline: 3px solid var(--verde);
            outline-offset: 3px;
            border-radius: 4px;
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        @media (max-width: 640px) {
            .scene {
                padding: 1rem;
            }

            .token-input {
                font-size: 1.875rem;
            }

            .particle {
                display: none;
            }

            .grid-bg {
                background-size: 40px 40px;
                mask-image: radial-gradient(ellipse 80% 40% at 50% 60%, black 5%, transparent 60%);
            }
        }

        /* === FLASH DE COLAR === */
        .token-input.input-paste-success {
            border-color: var(--verde) !important;
            box-shadow: 0 0 25px rgba(139, 189, 71, 0.35) !important;
            transition: all 0.1s;
        }
    </style>
</head>

<body class="bg-escuro">

    <div class="grid-bg" role="presentation" aria-hidden="true"></div>
    <div class="orb" role="presentation" aria-hidden="true"
        style="width:400px;height:400px;background:rgba(139,189,71,0.12);top:-10%;left:-10%;"></div>
    <div class="orb" role="presentation" aria-hidden="true"
        style="width:350px;height:350px;background:rgba(255,173,2,0.1);bottom:-10%;right:-10%;animation-delay:3s;">
    </div>
    <div id="particles" role="presentation" aria-hidden="true"></div>

    <main class="scene" id="scene" role="main">
        <div class="card-3d" id="card3d">
            <div class="border-glow rounded-3xl" role="presentation" aria-hidden="true"></div>
            <div class="card-inner relative rounded-3xl overflow-hidden"
                style="background:linear-gradient(165deg,rgba(30,41,59,0.97),rgba(30,41,59,0.99) 50%,rgba(30,41,59,0.93));backdrop-filter:blur(40px);border:1px solid rgba(139,189,71,0.1);padding:2rem 1.75rem;">
                <div class="card-shine rounded-3xl" id="cardShine" role="presentation" aria-hidden="true"></div>

                <!-- Container dinâmico -->
                <div class="relative z-10" id="appContent">
                    <!-- O JavaScript vai injetar o conteúdo aqui -->
                </div>
            </div>
        </div>
    </main>

    <!-- Modal "Não tenho carteirinha" -->
    <div class="modal-overlay" id="semCarteirinhaModal" role="dialog" aria-modal="true">
        <div class="modal-content w-full max-w-sm rounded-3xl p-6 text-center"
            style="background: rgba(30,41,59,0.98); border: 1px solid rgba(255,255,255,0.1);">
            <div class="mb-4">
                <i class="fa-solid fa-id-card text-3xl" style="color: var(--txt-muted);"></i>
            </div>
            <h3 class="font-display font-700 text-lg mb-2" style="color:var(--txt-primary);">Nao tenho a carteirinha
            </h3>
            <p class="text-sm mb-6" style="color:var(--txt-tertiary); line-height: 1.6;">
                Para garantir a seguranca dos seus dados, a matricula online so e permitida com o token da carteirinha
                digital.
            </p>
            <div
                style="background: rgba(15,23,42,0.5); border: 1px solid rgba(139,189,71,0.08); border-radius: 0.875rem; padding: 1rem; text-align: left; margin-bottom: 1.5rem;">
                <p class="text-xs font-600 mb-2" style="color:var(--dourado);"><i
                        class="fa-solid fa-location-dot mr-1"></i> Como conseguir:</p>
                <p class="text-xs" style="color:var(--txt-muted); line-height: 1.5;">
                    Dirija-se a <strong style="color:var(--txt-secondary);">Coordenacao de Cursos</strong> com um
                    documento de identificacao oficial (RG ou CPF). Solicite a emissao da sua Carteirinha Digital Cidade
                    do Saber.
                </p>
            </div>
            <button onclick="fecharModal()" class="btn-primary w-full py-3 rounded-xl font-display">
                <span>Entendi</span>
            </button>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast" class="toast" role="alert" aria-live="assertive">
        <div
            style="display:flex;align-items:center;gap:0.625rem;padding:0.75rem 1rem;border-radius:0.75rem;background:rgba(30,41,59,0.97);backdrop-filter:blur(20px);border:1px solid rgba(139,189,71,0.15);box-shadow:0 4px 20px rgba(0,0,0,0.2);">
            <div id="toastIcon"
                style="width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:rgba(139,189,71,0.12);">
            </div>
            <p id="toastMsg"
                style="font-size:0.813rem;font-family:'Sora',sans-serif;font-weight:600;color:var(--txt-primary);"></p>
        </div>
    </div>

    <script>
        // Rota do Controller de Matrícula que criamos
        window.ROUTES = {
            matricular: @json(url('/matricular/'))
        };

        // =============================================================
        // TOAST
        // =============================================================
        class Toast {
            #el; #icon; #msg; #timer;
            #cfg = {
                sucesso: { icon: 'fa-check', bg: 'rgba(139,189,71,0.12)', color: '#8BBD47' },
                erro: { icon: 'fa-xmark', bg: 'rgba(239,68,68,0.12)', color: '#ef4444' },
                aviso: { icon: 'fa-triangle-exclamation', bg: 'rgba(255,173,2,0.12)', color: '#FFAD02' }
            };
            show(tipo, mensagem) {
                clearTimeout(this.#timer);
                this.#el = document.getElementById('toast'); this.#icon = document.getElementById('toastIcon'); this.#msg = document.getElementById('toastMsg');
                const c = this.#cfg[tipo] || this.#cfg.sucesso;
                this.#icon.style.background = c.bg;
                this.#icon.innerHTML = `<i class="fa-solid ${c.icon} text-sm" style="color:${c.color}"></i>`;
                this.#msg.textContent = mensagem;
                this.#el.classList.add('show');
                this.#timer = setTimeout(() => this.#el.classList.remove('show'), 4500);
            }
        }
        const toast = new Toast();

        // =============================================================
        // MODAL
        // =============================================================
        document.getElementById('semCarteirinhaModal').addEventListener('click', (e) => {
            if (e.target.id === 'semCarteirinhaModal') fecharModal();
        });
        function abrirModal() { document.getElementById('semCarteirinhaModal').classList.add('active'); document.body.style.overflow = 'hidden'; }
        function fecharModal() { document.getElementById('semCarteirinhaModal').classList.remove('active'); document.body.style.overflow = 'auto'; }

        // =============================================================
        // APLICAÇÃO PRINCIPAL
        // =============================================================
        class TokenMatriculaApp {
            constructor() {
                this.renderForm();
                this.initEffects();
            }

            // =============================================================
            // SISTEMA DE ERROS INTELIGENTE
            // =============================================================
            clearError() {
                const container = document.getElementById('errorContainer');
                // 1. Recolhe o card suavemente (some a altura e opacidade)
                container.style.maxHeight = '0';
                container.style.opacity = '0';

                // 2. Remove a borda vermelha do input
                document.getElementById('tokenInput').classList.remove('input-error');

                // 3. NÃO apague o HTML. O erro ficará guardado na memória, apenas invisível.
            }

            renderError(message) {
                console.table(message);

                const container = document.getElementById('errorContainer');

                // 1. Define estilos padrão (Vermelho para erros bloqueantes)
                let iconClass = 'fa-circle-xmark';
                let iconColor = '#ef4444';
                let bgColor = 'rgba(239, 68, 68, 0.06)';
                let borderColor = 'rgba(239, 68, 68, 0.15)';
                let title = 'Matrícula Negada';
                let titleColor = '#ef4444';

                // 2. Parser Inteligente: Muda para Amarelo se for um erro de Sessão/Token Expirado
                const msgLower = message.toLowerCase();
                if (msgLower.includes('expirou') || msgLower.includes('sessão')) {
                    iconClass = 'fa-clock-rotate-left';
                    iconColor = '#FFAD02'; // Cor dourada
                    bgColor = 'rgba(255, 0, 173, 2, 0.06)';
                    borderColor = 'rgba(255, 173, 2, 0.2)';
                    title = 'Ação Necessária';
                    titleColor = '#FFAD02';
                }
                // Parser: Destaca erros de regra de negócio específicos
                // Use .includes('inadequada') que cobre "inadequada" (sem acento) e "inadequada" (com acento)
                else if (msgLower.includes('inadequada')) {
                    iconClass = 'fa-user-slash';
                    title = 'Idade Incompatível';
                } else if (msgLower.includes('possui uma matrícula') || msgLower.includes('coordenação')) {
                    iconClass = 'fa-layer-group';
                    title = 'Conflito de Matrícula';
                } else if (msgLower.includes('nascimento nao cadastrada')) { // Adicionado 'nao' para bater com o Controller
                    iconClass = 'fa-id-card';
                    title = 'Cadastro Incompleto';
                } else if (msgLower.includes('invalidada')) { // Adicionado 'invalidada' para bater com o Controller
                    iconClass = 'fa-ban';
                    title = 'Documento Inválido';
                } else if (msgLower.includes('no query results') || msgLower.includes('model')) { // Adicionado para erros do Eloquent
                    iconClass = 'fa-magnifying-glass';
                    title = 'Token Inexistente';
                }

                // 3. Renderiza o Card de Alerta
                container.innerHTML = `
                <div class="pop-in p-4 rounded-xl" style="background: ${bgColor}; border: 1px solid ${borderColor}; text-align: left;">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-content-center flex-shrink-0 mt-0.5" style="background: ${bgColor}; border: 1px solid ${borderColor};">
                            <i class="fa-solid ${iconClass}" style="color: ${iconColor};"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-display font-700 text-sm mb-1" style="color: ${titleColor};">${title}</h3>
                            <p class="text-xs leading-relaxed" style="color: var(--txt-tertiary);">${message}</p>
                        </div>
                    </div>
                </div>
                `;

                // 4. Anima a entrada do card (expande e aparece)
                container.style.maxHeight = '300px';
                container.style.opacity = '1';
            }

            renderForm() {
                const container = document.getElementById('appContent');
                container.innerHTML = `
                <div class="reveal text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-3" style="background: rgba(139,189,71,0.1); border: 1px solid rgba(139,189,71,0.15);">
                        <i class="fa-solid fa-key text-2xl" style="color: var(--verde);"></i>
                    </div>
                    <h1 class="font-display font-800 text-2xl tracking-tight mb-1">Matricula Segura</h1>
                    <p class="text-sm" style="color: var(--txt-muted);">Insira o token de acesso para vincular esta vaga ao seu cadastro.</p>
                </div>

                <!-- PASSO A PASSO EDUCATIVO -->
                <div class="reveal rd1 flex items-start gap-3 mb-3 p-3 rounded-xl" style="background: rgba(15,23,42,0.4); border: 1px dashed rgba(139,189,71,0.15);">
                    <div class="flex flex-col items-center gap-1">
                        <div class="step-number" style="background:var(--verde); color:var(--escuro);">1</div>
                        <div class="w-px h-full" style="background: rgba(139,189,71,0.2);"></div>
                    </div>
                    <div class="pb-4">
                        <p class="text-xs font-600 mb-0.5" style="color: var(--txt-secondary);">Pegue sua carteirinha</p>
                        <p class="text-xs" style="color: var(--txt-muted);">Utilize a carteirinha impressa fornecida pela Coordenacao de Cursos.</p>
                    </div>
                </div>

                <div class="reveal rd2 flex items-start gap-3 mb-3 p-3 rounded-xl" style="background: rgba(15,23,42,0.4); border: 1px dashed rgba(139,189,71,0.15);">
                    <div class="flex flex-col items-center gap-1">
                        <div class="step-number" style="background:var(--dourado); color:var(--escuro);">2</div>
                        <div class="w-px h-full" style="background: rgba(139,189,71,0.2);"></div>
                    </div>
                    <div class="pb-4">
                        <p class="text-xs font-600 mb-0.5" style="color: var(--txt-secondary);">Escaneie o QR Code</p>
                        <p class="text-xs" style="color: var(--txt-muted);">Aponte a camera do celular para abrir o seu App da Carteirinha.</p>
                    </div>
                </div>

                <div class="reveal rd3 flex items-start gap-3 mb-6 p-3 rounded-xl" style="background: rgba(15,23,42,0.4); border: 1px dashed rgba(139,189,71,0.15);">
                    <div class="flex flex-col items-center gap-1">
                        <div class="step-number" style="background:var(--laranja); color:var(--escuro);">3</div>
                    </div>
                    <div>
                        <p class="text-xs font-600 mb-0.5" style="color: var(--txt-secondary);">Gere e copie o Token</p>
                        <p class="text-xs" style="color: var(--txt-muted);">No app, toque em <strong style="color:var(--verde);">"Gerar Token"</strong> e copie o codigo de 6 letras.</p>
                    </div>
                </div>

                <!-- INPUT DO TOKEN COM BOTÃO COLAR -->
                <div class="reveal rd4 mb-1 relative">
                    <label for="tokenInput" class="sr-only">Codigo de acesso de 6 letras</label>
                    <input 
                        type="text" 
                        id="tokenInput" 
                        class="token-input" 
                        placeholder="Ex: TM9 - W4K" 
                        maxlength="9" 
                        autocomplete="off" 
                        accept="none" 
                        inputmode="text" 
                        style="padding-right: 2.5rem;">
                    
                    <!-- Botão de Colar -->
                    <button id="btnColar" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl flex items-center justify-center transition-all active:scale-90"
                            style="background: rgba(139,189,71,0.1); color: var(--verde);"
                            title="Colar Token" 
                            aria-label="Colar token da área de transferência">
                        <i class="fa-solid fa-paste text-lg"></i>
                    </button>
                </div>
                
                <!-- CONTAINER DE ERRO DINÂMICO -->
                <div id="errorContainer" class="mb-4" style="max-height: 0; overflow: hidden; transition: max-height 0.4s cubic-bezier(0.22,1,0.36,1), opacity 0.3s; opacity: 0;">
                    <!-- O JavaScript vai injetar o card de erro aqui -->
                </div>

                <!-- BOTÃO MATRICULAR -->
                <button id="btnMatricular" class="reveal rd5 btn-primary w-full py-4 rounded-xl font-display flex items-center justify-center gap-2 text-base" disabled>
                    <span><i class="fa-solid fa-shield-halved mr-2 text-sm"></i>Vincular e Matricular</span>
                </button>

                <!-- LINK FALLBACK -->
                <button onclick="abrirModal()" class="reveal rd6 w-full py-3 mt-3 text-xs font-500 text-center rounded-lg" style="color: var(--txt-muted); background: transparent; border: none; cursor: pointer; text-decoration: underline; text-underline-offset: 2px;">
                    Nao tenho carteirinha digital
                </button>
            `;

                this.bindEvents();
            }


            bindEvents() {
                const input = document.getElementById('tokenInput');
                const btn = document.getElementById('btnMatricular');
                const btnColar = document.getElementById('btnColar');

                setTimeout(() => input.focus(), 600);

                input.addEventListener('input', (e) => {
                    let val = e.target.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
                    val = val.substring(0, 6);

                    if (val.length > 3) {
                        e.target.value = val.substring(0, 3) + ' - ' + val.substring(3);
                    } else {
                        e.target.value = val;
                    }

                    const rawToken = val.replace(/\s|-/g, '');
                    btn.disabled = rawToken.length !== 6;

                    this.clearError();
                });

                input.addEventListener('focus', (e) => e.target.select());

                // BOTÃO DE COLAR MELHORADO (Com fallback para iOS/Safari)
                btnColar.addEventListener('click', async () => {
                    // Fallback para navegadores que bloqueiam a API de leitura de área de transferência
                    if (!navigator.clipboard || !navigator.clipboard.readText) {
                        toast.show('aviso', 'Use o botão colar do seu teclado', 'Segure e clique no campo de texto para colar o token.');
                        input.focus();
                        return;
                    }

                    try {
                        const textoColado = await navigator.clipboard.readText();
                        let tokenLimpo = textoColado.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 6);

                        if (tokenLimpo.length === 6) {
                            input.value = tokenLimpo.substring(0, 3) + ' - ' + tokenLimpo.substring(3);
                            input.classList.add('input-paste-success');
                            setTimeout(() => input.classList.remove('input-paste-success'), 800);
                            btn.disabled = false;

                            this.clearError();
                            this.submeter();

                        } else {
                            input.value = tokenLimpo;
                            input.classList.add('input-error');
                            this.renderError('O texto colado não parece ser um token válido de 6 letras.');
                            btn.disabled = true;
                        }
                    } catch (err) {
                        // Se o iOS/Safari bloquear a leitura
                        if (err.name === 'NotAllowedError') {
                            toast.show('aviso', 'Permissão Negada', 'Segure e clique no campo, depois toque em "Colar" no seu teclado.');
                        } else {
                            toast.show('erro', 'Erro ao colar', 'Não foi possível ler a área de transferência.');
                        }
                        input.focus();
                    }
                });

                btn.addEventListener('click', () => this.submeter());
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' && !btn.disabled) this.submeter();
                });
            }

            getRawToken() {
                return document.getElementById('tokenInput').value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
            }

            async submeter() {
                const token = this.getRawToken();
                if (token.length !== 6) return;

                const btn = document.getElementById('btnMatricular');
                const input = document.getElementById('tokenInput');

                // Estado de Loading
                btn.disabled = true;
                btn.innerHTML = '<span><i class="fa-solid fa-spinner fa-spin mr-2 text-sm"></i>Verificando dados...</span>';
                input.disabled = true;
                this.clearError();

                try {
                    const response = await fetch(`${window.ROUTES.matricular}/${token}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    // SOLUÇÃO DO ERRO DE JSON: Verifica se o Laravel realmente retornou um JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('O servidor retornou uma resposta inesperada. A página pode ter expirado ou a rota está bloqueada. Recarregue a página e tente novamente.');
                    }
                    

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Erro ao realizar matrícula.');
                    }

                    this.renderSucesso(data);

                } catch (error) {
                    input.classList.add('input-error');
                    this.renderError(error.message);
                    toast.show('erro', 'Falha na matrícula', 'Verifique o detalhe do erro abaixo.');
                } finally {
                    // O "FINALLY" GARANTE QUE O LOOPING INFINITO ACABE.
                    // Não importa se deu erro de JSON ou de Rede, o botão VOLTA ao normal.
                    btn.disabled = false;
                    btn.innerHTML = '<span><i class="fa-solid fa-shield-halved mr-2 text-sm"></i>Vincular e Matricular</span>';
                    input.disabled = false;
                }
            }


            renderSucesso(data) {
                const container = document.getElementById('appContent');
                container.innerHTML = `
                <div class="pop-in flex flex-col items-center text-center py-6">
                    <div style="width:80px;height:80px;border-radius:50%;background:rgba(139,189,71,0.12);border:2px solid rgba(139,189,71,0.3);display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem; box-shadow: 0 0 30px rgba(139,189,71,0.2);">
                        <i class="fa-solid fa-check text-4xl" style="color:var(--verde);"></i>
                    </div>
                    <h2 class="font-display font-800 text-2xl mb-2" style="color:var(--txt-primary);">Matricula Realizada!</h2>
                    <p class="text-sm mb-6" style="color:var(--txt-tertiary); max-width: 300px;">
                        Sua vaga foi reservada com sucesso. Você pode acompanhar os detalhes pelo seu aplicativo de carteirinha.
                    </p>
                    
                    ${data.autenticacao ? `
                    <div style="background: rgba(15,23,42,0.5); border: 1px solid rgba(139,189,71,0.08); border-radius: 0.875rem; padding: 1rem; width: 100%; margin-bottom: 1.5rem; text-align: left;">
                        <p class="text-xs mb-1" style="color: var(--txt-muted);">Código de Autenticação</p>
                        <p class="font-display font-800 text-xl tracking-widest" style="color: var(--dourado);">${data.autenticacao}</p>
                        <p class="text-xs mt-1" style="color: var(--txt-muted);">Guarde este comprovante</p>
                    </div>
                    ` : ''}

                    <a href="${data.redirect_url || '/'}" class="btn-primary w-full py-3 rounded-xl font-display flex items-center justify-center gap-2 no-underline">
                        <span><i class="fa-solid fa-id-card mr-2 text-sm"></i>Ir para minha Carteirinha</span>
                    </a>
                </div>
            `;
                toast.show('sucesso', 'Sucesso!', 'Sua matrícula foi registrada no sistema.');
            }

            // Efeitos visuais (Otimizados)
            initEffects() {
                const isTouch = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);
                const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const card = document.getElementById('card3d');
                const shine = document.getElementById('cardShine');

                if (!reduceMotion) {
                    if (!isTouch) {
                        document.addEventListener('mousemove', (e) => {
                            const r = card.getBoundingClientRect();
                            const mx = (e.clientX - r.left - r.width / 2) / (r.width / 2);
                            const my = (e.clientY - r.top - r.height / 2) / (r.height / 2);
                            card.style.transform = `rotateX(${-my * 4}deg) rotateY(${mx * 5}deg)`;
                            shine.style.setProperty('--mx', ((e.clientX - r.left) / r.width * 100) + '%');
                            shine.style.setProperty('--my', ((e.clientY - r.top) / r.height * 100) + '%');
                        });
                    } else {
                        window.addEventListener('deviceorientation', (e) => {
                            if (e.gamma == null || e.beta == null) return;
                            const rY = Math.max(-2, Math.min(2, e.gamma * 0.15));
                            const rX = Math.max(-1.5, Math.min(1.5, (e.beta - 45) * 0.1));
                            card.style.transform = `rotateX(${rX}deg) rotateY(${rY}deg)`;
                        });
                    }

                    // Partículas (Menos quantity para não pesar)
                    const pC = document.getElementById('particles');
                    const frag = document.createDocumentFragment();
                    const cols = ['#8BBD47', '#FFAD02', '#EF8E26'];
                    for (let i = 0; i < 15; i++) {
                        const p = document.createElement('div'); p.className = 'particle';
                        const s = Math.random() * 3 + 1.5, c = cols[Math.floor(Math.random() * cols.length)];
                        p.style.cssText = `width:${s}px;height:${s}px;background:${c};left:${Math.random() * 100}%;animation-duration:${Math.random() * 14 + 12}s;animation-delay:${Math.random() * 14}s;opacity:0;box-shadow:0 0 ${s * 2.5}px ${c};`;
                        frag.appendChild(p);
                    }
                    pC.appendChild(frag);
                }
            }
        }

        // Inicialização segura
        document.addEventListener("DOMContentLoaded", () => {
            new TokenMatriculaApp();
        });
    </script>
</body>

</html>