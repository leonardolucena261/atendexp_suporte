<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Minha Carteirinha — Cidade do Saber</title>

    <!-- PWA Tags -->
    <meta name="theme-color" content="#1E293B">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- CSRF Token Necessário para o AJAX funcionar no Laravel -->
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
            --clarinho: #BFFBAC;
            --laranja: #EF8E26;
            --escuro: #1E293B;
            --claro: #F9F9F9;
            --txt-primary: #F1F5F9;
            --txt-secondary: #CBD5E1;
            --txt-tertiary: #94A3B8;
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
            padding-bottom: 2rem;
        }

        .scene {
            perspective: 1400px;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem 1rem;
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

        .float-shape {
            position: fixed;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            filter: blur(1px);
            opacity: 0.3;
            animation: floatShape 14s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes floatShape {

            0%,
            100% {
                transform: translateY(0) rotateX(0) rotateY(0);
            }

            50% {
                transform: translateY(-25px) rotateX(6deg) rotateY(8deg);
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

        .card-3d {
            transform-style: preserve-3d;
            will-change: transform;
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 520px;
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
            background: conic-gradient(from var(--angle, 0deg), var(--verde), var(--dourado), var(--laranja), var(--verde), var(--dourado));
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

        .detail-card {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(139, 189, 71, 0.08);
            border-radius: 0.875rem;
            padding: 1rem;
            transition: border-color 0.3s;
        }

        .detail-card:hover {
            border-color: rgba(139, 189, 71, 0.18);
        }

        .detail-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.875rem;
        }

        .detail-label {
            font-size: 0.688rem;
            color: var(--txt-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 500;
        }

        .detail-value {
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            font-size: 0.938rem;
            color: var(--txt-primary);
            line-height: 1.3;
        }

        .btn-neon {
            background: linear-gradient(135deg, rgba(139, 189, 71, 0.1), rgba(139, 189, 71, 0.05));
            border: 1.5px solid rgba(139, 189, 71, 0.5);
            color: var(--verde);
            font-weight: 700;
            text-shadow: 0 0 10px rgba(139, 189, 71, 0.4);
            box-shadow: 0 0 15px rgba(139, 189, 71, 0.15);
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-neon:hover {
            background: linear-gradient(135deg, rgba(139, 189, 71, 0.2), rgba(139, 189, 71, 0.1));
            box-shadow: 0 0 25px rgba(139, 189, 71, 0.4);
            transform: translateY(-2px);
            border-color: var(--verde);
        }

        .btn-neon:active {
            transform: translateY(0) scale(0.98);
        }

        .btn-neon:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-ghost {
            background: transparent;
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            color: var(--txt-secondary);
            font-weight: 600;
            transition: all 0.3s;
            font-size: 0.813rem;
        }

        .btn-ghost:hover {
            border-color: var(--verde);
            color: var(--verde);
            background: rgba(139, 189, 71, 0.05);
        }

        .reveal {
            animation: reveal 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes reveal {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reveal-d1 {
            animation-delay: 0.1s;
        }

        .reveal-d2 {
            animation-delay: 0.2s;
        }

        .reveal-d3 {
            animation-delay: 0.3s;
        }

        .reveal-d4 {
            animation-delay: 0.4s;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
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
            transform: scale(0.9) translateY(20px);
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .modal-overlay.active .modal-content {
            transform: scale(1) translateY(0);
        }

        .token-display {
            font-family: 'Sora', sans-serif;
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: 0.15em;
            color: var(--verde);
            text-shadow: 0 0 20px rgba(139, 189, 71, 0.6), 0 0 40px rgba(139, 189, 71, 0.3);
            line-height: 1;
        }

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

        @media (max-width: 640px) {
            .scene {
                padding: 1rem 0.75rem;
            }

            .token-display {
                font-size: 2.8rem;
            }

            .particle,
            .float-shape,
            .orbit-ring {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-escuro">

    <div class="grid-bg" role="presentation" aria-hidden="true"></div>
    <div class="orb" role="presentation" aria-hidden="true"
        style="width:400px;height:400px;background:rgba(139,189,71,0.12);top:-8%;left:-8%;"></div>
    <div class="orb" role="presentation" aria-hidden="true"
        style="width:350px;height:350px;background:rgba(255,173,2,0.1);bottom:-5%;right:-5%;animation-delay:3s;"></div>
    <div id="particles" role="presentation" aria-hidden="true"></div>

    <main class="scene" id="scene">
        <div class="card-3d" id="card3d">
            <div class="border-glow rounded-3xl" role="presentation" aria-hidden="true"></div>
            <div class="card-inner relative rounded-3xl overflow-hidden"
                style="background:linear-gradient(165deg,rgba(30,41,59,0.97) 0%,rgba(30,41,59,0.99) 50%,rgba(30,41,59,0.93) 100%);backdrop-filter:blur(40px);border:1px solid rgba(139,189,71,0.1);padding:2rem 1.5rem;">
                <div class="card-shine rounded-3xl" id="cardShine" role="presentation" aria-hidden="true"></div>

                <div class="relative z-10" id="appContent">
                    <!-- O JavaScript vai injetar o conteúdo aqui -->
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Token -->
    <div class="modal-overlay" id="tokenModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-content w-full max-w-sm rounded-3xl p-8 text-center"
            style="background: rgba(15,23,42,0.98); border: 1px solid rgba(139,189,71,0.3); box-shadow: 0 0 60px rgba(139,189,71,0.15);">
            <div class="mb-2">
                <i class="fa-solid fa-shield-halved text-2xl"
                    style="color: var(--verde); filter: drop-shadow(0 0 8px rgba(139,189,71,0.5));"></i>
            </div>
            <h3 id="modalTitle" class="font-display text-lg font-700 mb-1" style="color: var(--txt-primary);">Token de
                Acesso</h3>
            <p class="text-xs mb-6" style="color: var(--txt-muted);">Forneça este código para realizar sua matrícula.
            </p>


            <div class="mb-8 py-4 border-y border-dashed" style="border-color: rgba(139,189,71,0.2);">
                <span class="token-display" id="tokenValue">--- ---</span>
                <!-- Adicionado o id="tokenExpiracao" aqui -->
                <p class="text-xs mt-2" id="tokenExpiracao" style="color: var(--txt-tertiary);">Calculando validade...
                </p>
            </div>

            <button id="btnCopiar" onclick="copiarToken()"
                class="btn-neon w-full py-3 rounded-xl font-display flex items-center justify-center gap-2">
                <i class="fa-regular fa-copy"></i>
                <span>Copiar Código</span>
            </button>
            <button onclick="fecharModal()" class="mt-3 w-full py-2 text-xs font-600 rounded-lg"
                style="color: var(--txt-muted); background: transparent;">Fechar</button>
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
        // =============================================================
        // INJEÇÃO DE DADOS DO LARAVEL VIA BLADE
        // =============================================================
        window.APP_DATA = @json($aluno);
        window.HISTORICO_DATA = @json($historico);
        window.CARTEIRINHA_UUID = @json($carteirinha->uuid);

        // Rota que vai chamar o método renovarTokenSeVencido() do Model
        window.ROUTES = {
            gerarToken: @json(route('carteirinha.gerarToken', $carteirinha->uuid))
        };

        let currentTokenRaw = '';

        // =============================================================
        // UTILITÁRIOS
        // =============================================================
        function formatarData(dataBanco) {
            if (!dataBanco) return '—';
            const partes = dataBanco.split('-');
            if (partes.length !== 3) return dataBanco; // Se já vier formatado, retorna como está
            return `${partes[2]}/${partes[1]}/${partes[0]}`;
        }

        // =============================================================
        // RENDERIZAÇÃO DO APP
        // =============================================================
        function renderApp() {
            const container = document.getElementById('appContent');
            const a = window.APP_DATA;
            const h = window.HISTORICO_DATA;
            const uuid = window.CARTEIRINHA_UUID;

            container.innerHTML = `
            <div class="reveal flex items-center gap-3 mb-6">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-xl font-display font-800" style="background: linear-gradient(135deg, var(--verde), var(--dourado)); color: var(--escuro);">
                    ${a.nome_aluno.split(' ').map(n => n[0]).slice(0, 2).join('')}
                </div>
                <div>
                    <h1 class="font-display font-800 text-xl tracking-tight" style="color: var(--txt-primary);">${a.nome_aluno}</h1>
                    <p class="text-xs font-500" style="color: var(--verde);">Aluno Ativo</p>
                </div>
            </div>

            <div class="reveal reveal-d1 mb-6">
                <h2 class="detail-label mb-3 pl-1" style="font-size: 0.75rem;">Dados Pessoais</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    <div class="detail-card col-span-2 sm:col-span-1">
                        <div class="flex items-center gap-2.5 mb-1">
                            <div class="detail-icon" style="background:rgba(139,189,71,0.1);"><i class="fa-solid fa-id-card" style="color:var(--verde);"></i></div>
                            <span class="detail-label">CPF</span>
                        </div>
                        <p class="detail-value">${a.cpf}</p>
                    </div>
                    <div class="detail-card col-span-2 sm:col-span-1">
                        <div class="flex items-center gap-2.5 mb-1">
                            <div class="detail-icon" style="background:rgba(255,173,2,0.1);"><i class="fa-solid fa-cake-candles" style="color:var(--dourado);"></i></div>
                            <span class="detail-label">Nascimento</span>
                        </div>
                        <p class="detail-value">${formatarData(a.data_nascimento)}</p>
                    </div>
                    <div class="detail-card col-span-2 sm:col-span-1">
                        <div class="flex items-center gap-2.5 mb-1">
                            <div class="detail-icon" style="background:rgba(239,142,38,0.1);"><i class="fa-solid fa-mobile-screen" style="color:var(--laranja);"></i></div>
                            <span class="detail-label">Celular</span>
                        </div>
                        <p class="detail-value">${a.telefone_celular}</p>
                    </div>
                    <div class="detail-card col-span-2 sm:col-span-1">
                        <div class="flex items-center gap-2.5 mb-1">
                            <div class="detail-icon" style="background:rgba(191,251,172,0.08);"><i class="fa-solid fa-envelope" style="color:var(--clarinho);"></i></div>
                            <span class="detail-label">E-mail</span>
                        </div>
                        <p class="detail-value text-sm">${a.email}</p>
                    </div>
                </div>
            </div>

            <div class="reveal reveal-d3 mb-6">
                <button id="btnGerarToken" onclick="handleGerarToken()" class="btn-neon w-full py-4 rounded-2xl font-display text-base flex items-center justify-center gap-3">
                    <i class="fa-solid fa-key"></i>
                    <span>Gerar Token de Atualização</span>
                </button>
            </div>

            <div class="reveal reveal-d4">
                <h2 class="detail-label mb-3 pl-1" style="font-size: 0.75rem;">Histórico de Matrícula</h2>
                <div class="flex flex-col gap-2.5">
                    ${h.length === 0 ? '<p class="text-sm text-center py-4" style="color: var(--txt-muted);">Nenhuma matrícula encontrada.</p>' : ''}
                    
                    ${h.map((item, index) => {
                // O index 0 é a matrícula mais recente (pois ordenamos DESC no Controller)
                const isRecent = index === 0;

                // Estilo de destaque sutil para a matrícula atual
                const destaqueStyle = isRecent
                    ? 'border-color: rgba(139,189,71,0.35); background: rgba(15,23,42,0.8);'
                    : '';

                return `
                            <div class="detail-card flex flex-col gap-2" style="padding: 1.25rem; ${destaqueStyle}">
                                <div class="flex items-start justify-between gap-3 flex-wrap">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                                            <span class="font-display font-800 text-xs px-2 py-0.5 rounded" style="background:rgba(139,189,71,0.1); color:var(--verde);">
                                                ${item.nome_periodo_letivo}
                                            </span>
                                            <span class="text-xs" style="color:var(--txt-muted);">${item.situacao_matricula}</span>
                                            
                                            ${isRecent ? '<span class="text-xs font-700 px-1.5 py-0.5 rounded" style="background:rgba(255,173,2,0.15); color:var(--dourado);">ATUAL</span>' : ''}
                                        </div>
                                        <p class="detail-value">${item.nome_curso}</p>
                                        
                                        <p class="text-xs mt-1.5 flex items-center gap-1.5" style="color:var(--txt-tertiary);">
                                            <i class="fa-solid fa-building-user" style="font-size: 0.6rem; color: var(--laranja);"></i>
                                            ${item.nome_coordenacao}
                                        </p>
                                    </div>
                                    
                                    <a href="/app/${uuid}/matricula/${item.cod_turma_aluno}/comprovante" 
                                       class="btn-ghost px-3 py-2 rounded-lg text-xs flex items-center gap-1.5 no-underline flex-shrink-0 mt-1">
                                        <i class="fa-solid fa-file-lines"></i> Comprovante
                                    </a>
                                </div>
                            </div>
                        `;
            }).join('')}
                </div>
            </div>
        `;
        }


        // =============================================================
        // LÓGICA DO TOKEN (INTEGRAÇÃO REAL COM LARAVEL)
        // =============================================================
        async function handleGerarToken() {
            const btn = document.getElementById('btnGerarToken');
            const originalHTML = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Verificando token...`;

            try {
                const response = await fetch(window.ROUTES.gerarToken, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Erro ao gerar token.');
                }

                currentTokenRaw = data.token_acesso;

                // Passa a data de expiração para o modal calcular o texto dinâmico
                abrirModal(currentTokenRaw, data.token_expiracao);

                if (data.status === 'novo') {
                    showToast('sucesso', 'Novo token gerado com sucesso!');
                } else if (data.status === 'atual') {
                    showToast('aviso', data.message);
                }

            } catch (error) {
                showToast('erro', error.message);
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalHTML;
            }
        }

        // =============================================================
        // MODAL E CLIPBOARD
        // =============================================================
        function abrirModal(token, dataExpiracao) {
            const formatted = `${token.substring(0, 3)}-${token.substring(3, 6)}`;
            document.getElementById('tokenValue').innerText = formatted;

            const btnCopiar = document.getElementById('btnCopiar');
            btnCopiar.innerHTML = `<i class="fa-regular fa-copy"></i><span>Copiar Código</span>`;
            btnCopiar.style.borderColor = ''; btnCopiar.style.color = ''; btnCopiar.disabled = false;

            document.getElementById('tokenModal').classList.add('active');
            document.body.style.overflow = 'hidden';

            // LÓGICA DINÂMICA DE EXPIRAÇÃO
            calcularTextoExpiracao(dataExpiracao);
        }

        function calcularTextoExpiracao(dataExpiracaoISO) {
            const el = document.getElementById('tokenExpiracao');
            if (!dataExpiracaoISO) {
                el.innerText = "Sem data de expiração definida.";
                return;
            }

            const agora = new Date();
            const expira = new Date(dataExpiracaoISO.replace(' ', 'T')); // Ajuste para formato ISO do JS
            const diffMs = expira - agora;

            if (diffMs <= 0) {
                el.innerText = "Expirado";
                el.style.color = '#ef4444'; // Fica vermelho se expirou
                return;
            }

            el.style.color = 'var(--txt-tertiary)'; // Volta para a cor padrão

            const diffMinutos = Math.floor(diffMs / 60000);
            const diffHoras = Math.floor(diffMinutos / 60);
            const diffDias = Math.floor(diffHoras / 24);

            let texto = "";
            if (diffDias >= 1) {
                texto = `Expira em ${diffDias} dia${diffDias > 1 ? 's' : ''}`;
            } else if (diffHoras >= 1) {
                texto = `Expira em ${diffHoras} hora${diffHoras > 1 ? 's' : ''}`;
            } else {
                texto = `Expira em ${diffMinutos} minuto${diffMinutos > 1 ? 's' : ''}`;
            }

            el.innerText = texto;
        }

        function fecharModal() {
            document.getElementById('tokenModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('tokenModal').addEventListener('click', (e) => {
            if (e.target.id === 'tokenModal') fecharModal();
        });

        async function copiarToken() {
            const btn = document.getElementById('btnCopiar');
            if (!currentTokenRaw) return;
            try {
                await navigator.clipboard.writeText(currentTokenRaw);
                btn.innerHTML = `<i class="fa-solid fa-check"></i><span>Copiado!</span>`;
                btn.style.borderColor = 'var(--dourado)'; btn.style.color = 'var(--dourado)'; btn.disabled = true;
                setTimeout(() => abrirModal(currentTokenRaw), 2500);
            } catch (err) {
                showToast('erro', 'Falha ao copiar. Copie manualmente: ' + currentTokenRaw);
            }
        }

        // =============================================================
        // TOAST (Adicionado suporte ao tipo 'aviso')
        // =============================================================
        function showToast(tipo, msg) {
            const toast = document.getElementById('toast');
            const icon = document.getElementById('toastIcon');
            const msgEl = document.getElementById('toastMsg');

            // Adicionado o tipo 'aviso' com cor dourada/amarela
            const cores = {
                sucesso: { i: 'fa-check', c: '#8BBD47', bg: 'rgba(139,189,71,0.12)' },
                erro: { i: 'fa-xmark', c: '#ef4444', bg: 'rgba(239,68,68,0.12)' },
                aviso: { i: 'fa-clock', c: '#FFAD02', bg: 'rgba(255,173,2,0.12)' }
            };

            const cfg = cores[tipo] || cores.sucesso;
            icon.style.background = cfg.bg;
            icon.innerHTML = `<i class="fa-solid ${cfg.i} text-sm" style="color:${cfg.c}"></i>`;
            msgEl.textContent = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 4500);
        }



        // =============================================================
        // INIT E EFEITOS VISUAIS
        // =============================================================
        document.addEventListener("DOMContentLoaded", () => {
            renderApp();

            if ('ontouchstart' in window) {
                window.addEventListener('deviceorientation', (e) => {
                    const card = document.getElementById('card3d');
                    if (e.gamma == null || e.beta == null) return;
                    card.style.transform = `rotateX(${Math.max(-1.5, Math.min(1.5, (e.beta - 45) * 0.1))}deg) rotateY(${Math.max(-2, Math.min(2, e.gamma * 0.15))}deg)`;
                });
            } else {
                document.addEventListener('mousemove', (e) => {
                    const card = document.getElementById('card3d');
                    const r = card.getBoundingClientRect();
                    const mx = (e.clientX - r.left - r.width / 2) / (r.width / 2);
                    const my = (e.clientY - r.top - r.height / 2) / (r.height / 2);
                    card.style.transform = `rotateX(${-my * 4}deg) rotateY(${mx * 5}deg)`;
                    const shine = document.getElementById('cardShine');
                    shine.style.setProperty('--mx', ((e.clientX - r.left) / r.width * 100) + '%');
                    shine.style.setProperty('--my', ((e.clientY - r.top) / r.height * 100) + '%');
                });
            }

            const pContainer = document.getElementById('particles');
            const frag = document.createDocumentFragment();
            const cores = ['#8BBD47', '#FFAD02', '#BFFBAC', '#EF8E26'];
            for (let i = 0; i < 20; i++) {
                const p = document.createElement('div'); p.className = 'particle';
                const s = Math.random() * 3 + 1.5; const c = cores[Math.floor(Math.random() * cores.length)];
                p.style.cssText = `width:${s}px;height:${s}px;background:${c};left:${Math.random() * 100}%;animation-duration:${Math.random() * 14 + 12}s;animation-delay:${Math.random() * 14}s;opacity:0;box-shadow:0 0 ${s * 2.5}px ${c};`;
                frag.appendChild(p);
            }
            pContainer.appendChild(frag);

            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('{{ asset("sw.js") }}');
            }
        });
    </script>
</body>

</html>