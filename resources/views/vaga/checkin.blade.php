<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmacao de Vaga — Cidade do Saber</title>
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
            --verde: #8BBD47; --dourado: #FFAD02; --clarinho: #BFFBAC;
            --laranja: #EF8E26; --escuro: #1E293B; --claro: #F9F9F9;
            --txt-primary: #F1F5F9; --txt-secondary: #CBD5E1;
            --txt-tertiary: #94A3B8; --txt-muted: #64748B;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--escuro); color: var(--txt-primary);
            overflow-x: hidden; overflow-y: auto;
            min-height: 100vh; min-height: 100dvh; line-height: 1.6;
        }

        /* === CENA 3D === */
        .scene {
            perspective: 1400px; perspective-origin: 50% 50%;
            display: flex; align-items: center; justify-content: center;
            min-height: 100vh; min-height: 100dvh;
            padding: 1.5rem; position: relative;
        }

        .grid-bg {
            position: fixed; inset: 0;
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
        @keyframes gridMove { to { background-position: 60px 60px; } }

        .float-shape {
            position: fixed; border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            filter: blur(1px); opacity: 0.3;
            animation: floatShape 14s ease-in-out infinite;
            transform-style: preserve-3d; pointer-events: none;
        }
        @keyframes floatShape {
            0%, 100% { transform: translateY(0) rotateX(0) rotateY(0); }
            33% { transform: translateY(-25px) rotateX(6deg) rotateY(8deg); }
            66% { transform: translateY(-15px) rotateX(-4deg) rotateY(-5deg); }
        }

        .orb {
            position: fixed; border-radius: 50%; filter: blur(80px);
            pointer-events: none; animation: orbPulse 8s ease-in-out infinite alternate;
            will-change: transform;
        }
        @keyframes orbPulse {
            0% { transform: scale(1); opacity: 0.2; }
            100% { transform: scale(1.3); opacity: 0.45; }
        }

        .card-3d {
            transform-style: preserve-3d; will-change: transform;
            position: relative; z-index: 10; width: 100%; max-width: 520px;
        }
        .card-shine {
            position: absolute; inset: 0; border-radius: inherit;
            pointer-events: none; opacity: 0; transition: opacity 0.4s;
            background: radial-gradient(500px circle at var(--mx,50%) var(--my,50%), rgba(139,189,71,0.08), transparent 50%);
            z-index: 2;
        }
        .card-3d:hover .card-shine { opacity: 1; }

        .border-glow {
            position: absolute; inset: -1.5px; border-radius: inherit; z-index: -1;
            background: conic-gradient(from var(--angle,0deg), var(--verde), var(--dourado), var(--laranja), var(--verde), var(--dourado));
            animation: rotateBorder 5s linear infinite; opacity: 0.4; filter: blur(0.5px);
        }
        @keyframes rotateBorder { to { --angle: 360deg; } }
        @property --angle { syntax: '<angle>'; initial-value: 0deg; inherits: false; }

        .orbit-ring {
            position: fixed; border: 1px dashed rgba(139,189,71,0.08);
            border-radius: 50%; animation: orbitSpin 35s linear infinite; pointer-events: none;
        }
        .orbit-ring:nth-child(2) { animation-duration: 50s; animation-direction: reverse; border-color: rgba(255,173,2,0.06); }
        @keyframes orbitSpin { to { transform: rotate(360deg); } }
        .orbit-dot { position: absolute; width: 5px; height: 5px; border-radius: 50%; top: -2.5px; left: 50%; transform: translateX(-50%); }

        .particle {
            position: fixed; border-radius: 50%; pointer-events: none;
            animation: particleDrift linear infinite;
        }
        @keyframes particleDrift {
            0% { transform: translateY(100vh) rotate(0); opacity: 0; }
            10% { opacity: 0.6; } 90% { opacity: 0.6; }
            100% { transform: translateY(-10vh) rotate(540deg); opacity: 0; }
        }

        /* === ANIMAÇÕES DE ENTRADA === */
        .reveal { animation: reveal 0.8s cubic-bezier(0.22,1,0.36,1) forwards; opacity: 0; transform: translateY(20px); }
        @keyframes reveal { to { opacity: 1; transform: translateY(0); } }
        .reveal-d1 { animation-delay: 0.08s; }
        .reveal-d2 { animation-delay: 0.16s; }
        .reveal-d3 { animation-delay: 0.24s; }
        .reveal-d4 { animation-delay: 0.32s; }
        .reveal-d5 { animation-delay: 0.42s; }
        .reveal-d6 { animation-delay: 0.52s; }
        .reveal-d7 { animation-delay: 0.62s; }
        .reveal-d8 { animation-delay: 0.72s; }

        .accent-line {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--verde), var(--dourado), transparent);
            border-radius: 2px;
            animation: lineExpand 1s cubic-bezier(0.22,1,0.36,1) 0.2s forwards;
            transform: scaleX(0);
        }
        @keyframes lineExpand { to { transform: scaleX(1); } }

        /* === BADGE DE CONFIRMAÇÃO === */
        .confirm-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.5rem 1rem; border-radius: 999px;
            background: rgba(139,189,71,0.12); border: 1.5px solid rgba(139,189,71,0.3);
            animation: badgePop 0.6s cubic-bezier(0.22,1,0.36,1) 0.3s both;
        }
        @keyframes badgePop {
            0% { opacity: 0; transform: scale(0.7); }
            100% { opacity: 1; transform: scale(1); }
        }
        .confirm-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--verde); box-shadow: 0 0 8px var(--verde);
            animation: dotPulse 2s ease-in-out infinite;
        }
        @keyframes dotPulse {
            0%, 100% { box-shadow: 0 0 4px var(--verde); }
            50% { box-shadow: 0 0 12px var(--verde), 0 0 20px rgba(139,189,71,0.3); }
        }

        /* === DETAIL CARDS === */
        .detail-card {
            background: rgba(15,23,42,0.5);
            border: 1px solid rgba(139,189,71,0.08);
            border-radius: 0.875rem; padding: 1rem;
            transition: border-color 0.3s;
        }
        .detail-card:hover { border-color: rgba(139,189,71,0.18); }
        .detail-icon {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 0.875rem;
        }
        .detail-label { font-size: 0.688rem; color: var(--txt-muted); text-transform: uppercase; letter-spacing: 0.06em; font-weight: 500; }
        .detail-value { font-family: 'Sora', sans-serif; font-weight: 600; font-size: 0.938rem; color: var(--txt-primary); line-height: 1.3; }

        /* === DIAS DA SEMANA === */
        .week-day {
            display: flex; flex-direction: column; align-items: center; gap: 0.375rem;
            padding: 0.5rem 0.25rem; border-radius: 0.625rem; min-width: 3rem;
            transition: all 0.3s;
        }
        .week-day.active { background: rgba(139,189,71,0.1); border: 1px solid rgba(139,189,71,0.2); }
        .week-day.inactive { background: rgba(15,23,42,0.3); border: 1px solid rgba(255,255,255,0.04); }
        .week-day .day-initial {
            font-family: 'Sora', sans-serif; font-weight: 700; font-size: 0.875rem;
        }
        .week-day.active .day-initial { color: var(--verde); }
        .week-day.inactive .day-initial { color: var(--txt-muted); opacity: 0.4; }
        .week-day .day-name {
            font-size: 0.563rem; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .week-day.active .day-name { color: var(--txt-tertiary); }
        .week-day.inactive .day-name { color: var(--txt-muted); opacity: 0.3; }
        .week-day .day-dot {
            width: 5px; height: 5px; border-radius: 50%;
        }
        .week-day.active .day-dot { background: var(--verde); box-shadow: 0 0 6px var(--verde); }
        .week-day.inactive .day-dot { background: var(--txt-muted); opacity: 0.2; }

        /* === FAIXA DE HORÁRIO === */
        .time-range {
            display: flex; align-items: center; gap: 0.75rem;
        }
        .time-block {
            font-family: 'Sora', sans-serif; font-weight: 800; font-size: 1.375rem;
            color: var(--txt-primary); line-height: 1; letter-spacing: -0.02em;
        }
        .time-sep {
            display: flex; flex-direction: column; align-items: center; gap: 2px;
            color: var(--verde);
        }
        .time-sep .sep-line { width: 16px; height: 1.5px; background: var(--verde); border-radius: 1px; }
        .time-sep .sep-dur { font-size: 0.563rem; color: var(--txt-muted); white-space: nowrap; }
        .time-label { font-size: 0.75rem; color: var(--txt-tertiary); margin-top: 0.25rem; }

        /* === BARRA DE PROGRESSO DE VAGAS === */
        .vacancy-bar-bg { height: 6px; border-radius: 3px; background: rgba(255,255,255,0.06); overflow: hidden; }
        .vacancy-bar-fill { height: 100%; border-radius: 3px; transition: width 1.2s cubic-bezier(0.22,1,0.36,1); }

        /* === BOTÕES === */
        .btn-primary {
            background: linear-gradient(135deg, var(--verde), #6fa032);
            color: var(--escuro); font-weight: 700;
            transition: all 0.3s cubic-bezier(0.22,1,0.36,1);
            position: relative; overflow: hidden; font-size: 0.875rem; line-height: 1.4;
        }
        .btn-primary::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, var(--dourado), var(--laranja));
            opacity: 0; transition: opacity 0.3s;
        }
        .btn-primary:hover::before { opacity: 1; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(139,189,71,0.3); }
        .btn-primary:active { transform: translateY(0) scale(0.98); }
        .btn-primary span { position: relative; z-index: 1; }

        .btn-ghost {
            background: transparent; border: 1.5px solid rgba(255,255,255,0.1);
            color: var(--txt-secondary); font-weight: 600;
            transition: all 0.3s cubic-bezier(0.22,1,0.36,1);
            font-size: 0.813rem;
        }
        .btn-ghost:hover { border-color: rgba(255,255,255,0.2); color: var(--txt-primary); background: rgba(255,255,255,0.03); }

        /* === TOAST === */
        .toast {
            position: fixed; top: 1rem; right: 1rem; z-index: 1000;
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.22,1,0.36,1);
            width: calc(100% - 2rem); max-width: 360px;
        }
        .toast.show { transform: translateX(0); }

        /* === SKIP LINK === */
        .skip-link {
            position: absolute; top: -100%; left: 1rem; z-index: 9999;
            padding: 0.75rem 1.5rem; background: var(--verde); color: var(--escuro);
            font-weight: 700; font-family: 'Space Grotesk', sans-serif;
            border-radius: 0 0 0.5rem 0.5rem; transition: top 0.2s;
            text-decoration: none; font-size: 0.875rem;
        }
        .skip-link:focus { top: 0; }

        :focus-visible { outline: 3px solid var(--verde); outline-offset: 3px; border-radius: 4px; }
        .btn-primary:focus-visible { outline: 3px solid var(--claro); outline-offset: 3px; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
        }

        @media (max-width: 640px) {
            .scene { padding: 1rem; }
            .card-inner { padding: 2rem 1.5rem !important; }
            .orb { filter: blur(60px); }
            .orbit-ring { display: none; }
            .float-shape { opacity: 0.15; }
            .particle { display: none; }
            .grid-bg { background-size: 40px 40px; mask-image: radial-gradient(ellipse 80% 40% at 50% 60%, black 5%, transparent 60%); -webkit-mask-image: radial-gradient(ellipse 80% 40% at 50% 60%, black 5%, transparent 60%); }
            .time-block { font-size: 1.125rem; }
            .week-day { min-width: 2.5rem; padding: 0.4rem 0.125rem; }
            .week-day .day-initial { font-size: 0.75rem; }
        }

        @media (max-width: 380px) {
            .card-inner { padding: 1.5rem 1.25rem !important; }
        }
    </style>
</head>
<body class="bg-escuro">

    <a href="#conteudo-curso" class="skip-link">Pular para detalhes do curso</a>

    <div class="grid-bg" role="presentation" aria-hidden="true"></div>
    <div class="orb" role="presentation" aria-hidden="true" style="width:400px;height:400px;background:rgba(139,189,71,0.12);top:-8%;left:-8%;"></div>
    <div class="orb" role="presentation" aria-hidden="true" style="width:350px;height:350px;background:rgba(255,173,2,0.1);bottom:-5%;right:-5%;animation-delay:3s;"></div>
    <div class="orb" role="presentation" aria-hidden="true" style="width:250px;height:250px;background:rgba(239,142,38,0.08);top:45%;left:55%;animation-delay:5s;"></div>
    <div class="float-shape" role="presentation" aria-hidden="true" style="width:90px;height:90px;background:rgba(139,189,71,0.1);top:12%;left:8%;animation-delay:0s;"></div>
    <div class="float-shape" role="presentation" aria-hidden="true" style="width:65px;height:65px;background:rgba(255,173,2,0.08);top:65%;right:8%;animation-delay:4s;animation-duration:16s;"></div>
    <div class="float-shape" role="presentation" aria-hidden="true" style="width:50px;height:50px;background:rgba(191,251,172,0.06);top:22%;right:15%;animation-delay:6s;animation-duration:18s;"></div>
    <div class="orbit-ring" role="presentation" aria-hidden="true" style="width:550px;height:550px;top:50%;left:50%;margin-top:-275px;margin-left:-275px;">
        <div class="orbit-dot" style="background:var(--verde);box-shadow:0 0 8px var(--verde);"></div>
    </div>
    <div class="orbit-ring" role="presentation" aria-hidden="true" style="width:400px;height:400px;top:50%;left:50%;margin-top:-200px;margin-left:-200px;">
        <div class="orbit-dot" style="background:var(--dourado);box-shadow:0 0 8px var(--dourado);"></div>
    </div>
    <div id="particles" role="presentation" aria-hidden="true"></div>

    <main class="scene" id="scene" role="main">
        <div class="card-3d" id="card3d">
            <div class="border-glow rounded-3xl" role="presentation" aria-hidden="true"></div>
            <div class="card-inner relative rounded-3xl overflow-hidden"
                 style="background:linear-gradient(165deg,rgba(30,41,59,0.97) 0%,rgba(30,41,59,0.99) 50%,rgba(30,41,59,0.93) 100%);backdrop-filter:blur(40px);border:1px solid rgba(139,189,71,0.1);padding:2.5rem 2rem;"
                 id="conteudo-curso">

                <div class="card-shine rounded-3xl" id="cardShine" role="presentation" aria-hidden="true"></div>

                <div class="relative z-10" id="courseContent">
                    <!-- Conteúdo será renderizado via JS -->
                </div>
            </div>
        </div>
    </main>

    <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div style="display:flex;align-items:center;gap:0.625rem;padding:0.75rem 1rem;border-radius:0.75rem;background:rgba(30,41,59,0.97);backdrop-filter:blur(20px);border:1px solid rgba(139,189,71,0.15);box-shadow:0 4px 20px rgba(0,0,0,0.2);">
            <div id="toastIcon" style="width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:rgba(139,189,71,0.12);" aria-hidden="true"></div>
            <div style="min-width:0;">
                <p id="toastTitle" style="font-size:0.813rem;font-family:'Sora',sans-serif;font-weight:600;color:var(--txt-primary);"></p>
                <p id="toastMsg" style="font-size:0.75rem;color:var(--txt-secondary);"></p>
            </div>
        </div>
    </div>

    <style>.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;}</style>

    <script>
    window.CHECKIN_URLS = {
        voltar: @json(route('vaga.find')),
        matricula: @json(route('vaga.validamatricula')),
        senhas: @json(url('/senha')),
    };
    </script>
    @isset($cursoCheckin)
    <script type="application/json" id="curso-checkin-json">@json($cursoCheckin)</script>
    @endisset

    <script>
    // =============================================================
    // MAPA COMPLETO DE DIAS DA SEMANA
    // =============================================================
    const DIAS_SEMANA = [
        { key: 'dom', label: 'Dom', full: 'Domingo' },
        { key: 'seg', label: 'Seg', full: 'Segunda-feira' },
        { key: 'ter', label: 'Ter', full: 'Terca-feira' },
        { key: 'qua', label: 'Qua', full: 'Quarta-feira' },
        { key: 'qui', label: 'Qui', full: 'Quinta-feira' },
        { key: 'sex', label: 'Sex', full: 'Sexta-feira' },
        { key: 'sab', label: 'Sab', full: 'Sabado' }
    ];

    // =============================================================
    // REPOSITÓRIO DE CURSOS (dados enriquecidos)
    // =============================================================
    class CursoRepository {
        #cursos;
        constructor(dados) { this.#cursos = dados.map(d => ({ ...d })); }
        findByCodigo(codigo) { return this.#cursos.find(c => c.codigo === codigo.toUpperCase()) || null; }
    }

    // =============================================================
    // TOAST
    // =============================================================
    class Toast {
        #el; #icon; #title; #msg; #timer;
        #cfg = {
            sucesso: { icon: 'fa-check', bg: 'rgba(139,189,71,0.12)', color: '#8BBD47' },
            erro:    { icon: 'fa-xmark', bg: 'rgba(239,68,68,0.12)', color: '#ef4444' },
            aviso:   { icon: 'fa-triangle-exclamation', bg: 'rgba(255,173,2,0.12)', color: '#FFAD02' }
        };
        constructor() {
            this.#el = document.getElementById('toast');
            this.#icon = document.getElementById('toastIcon');
            this.#title = document.getElementById('toastTitle');
            this.#msg = document.getElementById('toastMsg');
        }
        show(tipo, titulo, mensagem) {
            clearTimeout(this.#timer);
            const c = this.#cfg[tipo] || this.#cfg.sucesso;
            this.#icon.style.background = c.bg;
            this.#icon.innerHTML = `<i class="fa-solid ${c.icon} text-sm" style="color:${c.color}"></i>`;
            this.#title.textContent = titulo;
            this.#msg.textContent = mensagem;
            this.#el.classList.add('show');
            this.#timer = setTimeout(() => this.#el.classList.remove('show'), 4500);
        }
    }

    // =============================================================
    // EFEITO 3D
    // =============================================================
    class Card3DEffect {
        #card; #shine; #lerp; #maxRotX; #maxRotY;
        #targetRotX = 0; #targetRotY = 0;
        #currentRotX = 0; #currentRotY = 0; #rafId = null;

        constructor(card, shine, { isTouch, reduceMotion }) {
            this.#card = card; this.#shine = shine;
            this.#lerp = isTouch ? 0.02 : 0.04;
            this.#maxRotX = isTouch ? 1.5 : 4;
            this.#maxRotY = isTouch ? 2 : 5;
            if (reduceMotion) return;
            if (!isTouch) this.#bindMouse(); else this.#bindGyro();
            this.#animate();
        }
        #bindMouse() {
            document.addEventListener('mousemove', (e) => {
                const r = this.#card.getBoundingClientRect();
                const mx = (e.clientX - r.left - r.width/2) / (r.width/2);
                const my = (e.clientY - r.top - r.height/2) / (r.height/2);
                this.#targetRotY = mx * this.#maxRotY;
                this.#targetRotX = -my * this.#maxRotX;
                this.#shine.style.setProperty('--mx', ((e.clientX - r.left)/r.width*100) + '%');
                this.#shine.style.setProperty('--my', ((e.clientY - r.top)/r.height*100) + '%');
            });
            document.addEventListener('mouseleave', () => { this.#targetRotX = 0; this.#targetRotY = 0; });
        }
        #bindGyro() {
            window.addEventListener('deviceorientation', (e) => {
                if (e.gamma == null || e.beta == null) return;
                this.#targetRotY = Math.max(-this.#maxRotY, Math.min(this.#maxRotY, e.gamma * 0.15));
                this.#targetRotX = Math.max(-this.#maxRotX, Math.min(this.#maxRotX, (e.beta - 45) * 0.1));
            });
        }
        #animate() {
            this.#currentRotX += (this.#targetRotX - this.#currentRotX) * this.#lerp;
            this.#currentRotY += (this.#targetRotY - this.#currentRotY) * this.#lerp;
            this.#card.style.transform = `rotateX(${this.#currentRotX.toFixed(3)}deg) rotateY(${this.#currentRotY.toFixed(3)}deg)`;
            this.#rafId = requestAnimationFrame(() => this.#animate());
        }
    }

    // =============================================================
    // PARTÍCULAS
    // =============================================================
    class ParticleSystem {
        constructor(container, { ativo }) {
            if (!ativo) return;
            const frag = document.createDocumentFragment();
            const cores = ['#8BBD47','#FFAD02','#BFFBAC','#EF8E26'];
            for (let i = 0; i < 28; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                const s = Math.random()*3+1.5;
                const c = cores[Math.floor(Math.random()*cores.length)];
                p.style.cssText = `width:${s}px;height:${s}px;background:${c};left:${Math.random()*100}%;animation-duration:${Math.random()*14+12}s;animation-delay:${Math.random()*14}s;opacity:0;box-shadow:0 0 ${s*2.5}px ${c};`;
                frag.appendChild(p);
            }
            container.appendChild(frag);
        }
    }

    // =============================================================
    // PARALLAX DOS ORBS
    // =============================================================
    class OrbParallax {
        constructor(orbs, { ativo }) {
            if (!ativo) return;
            document.addEventListener('mousemove', (e) => {
                const cx = (e.clientX/window.innerWidth - 0.5)*2;
                const cy = (e.clientY/window.innerHeight - 0.5)*2;
                orbs.forEach((orb, i) => { const f = (i+1)*10; orb.style.transform = `translate(${cx*f}px,${cy*f}px)`; });
            });
        }
    }

    // =============================================================
    // RENDERIZADOR DO CURSO — Monta todo o HTML da tela
    // =============================================================
    class CourseDetailRenderer {
        #container;

        constructor(container) { this.#container = container; }

        /**
         * @param {Object} curso
         */
        render(curso) {
            const situacao = (curso.situacaoSenha || 'DISPONIVEL').toString().toUpperCase();
            const tokenUtilizado = situacao === 'UTILIZADA';
            const tokenDisponivel = situacao === 'DISPONIVEL';
            const bloqueadoMatricula = tokenUtilizado || !tokenDisponivel;

            let badgeLabel, badgeAccent;
            if (tokenUtilizado) {
                badgeLabel = 'TOKEN UTILIZADO';
                badgeAccent = '#ef4444';
            } else if (!tokenDisponivel) {
                badgeLabel = 'TOKEN INDISPONIVEL';
                badgeAccent = '#ef4444';
            } else {
                badgeLabel = 'TOKEN DISPONIVEL';
                badgeAccent = 'var(--verde)';
            }

            const podeContinuar = tokenDisponivel && !tokenUtilizado;
            const vagasTotal = 1;
            const vagasRestantes = podeContinuar ? 1 : 0;
            const pctOcupada = Math.round(((vagasTotal - vagasRestantes) / vagasTotal) * 100);
            const duracaoAula = this.#calcularDuracao(curso.horarioInicio, curso.horarioFim);
            const diasAtivos = Array.isArray(curso.diasSemana) ? curso.diasSemana : [];
            const faixaEtaria = (curso.faixaEtaria != null && curso.faixaEtaria !== '') ? curso.faixaEtaria : (curso.local || '—');

            this.#container.innerHTML = `
                <!-- Badge de confirmação -->
                <div class="reveal flex justify-center mb-4">
                    <div class="confirm-badge" role="status">
                        <div class="confirm-dot" aria-hidden="true" style="background:${bloqueadoMatricula ? '#ef4444' : 'var(--verde)'};box-shadow:0 0 10px ${bloqueadoMatricula ? 'rgba(239,68,68,0.5)' : 'rgba(139,189,71,0.45)'};"></div>
                        <span style="font-family:'Sora',sans-serif;font-weight:700;font-size:0.75rem;color:${badgeAccent};letter-spacing:0.04em;">
                            ${badgeLabel}
                        </span>
                    </div>
                </div>

                <!-- Título -->
                <h1 class="reveal reveal-d1 font-display text-center font-800 text-2xl sm:text-3xl tracking-tight mb-1"
                    style="color:var(--txt-primary);line-height:1.15;">
                    ${curso.nome}
                </h1>
                <p class="reveal reveal-d2 text-center font-body text-sm mb-4" style="color:var(--txt-tertiary);">
                    ${curso.modulo}
                </p>
                ${tokenUtilizado ? `
                <p class="reveal reveal-d2 text-center font-body text-xs mb-4 px-2 rounded-lg py-2" style="color:var(--txt-secondary);background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);">
                    Este token ja foi utilizado: a vaga foi confirmada e nao esta mais disponivel com este codigo.
                </p>` : ''}

                <!-- Linha -->
                <div class="accent-line mx-auto mb-5" style="max-width:140px;" aria-hidden="true"></div>

                <!-- Disponibilidade do token (1 vaga por token) -->
                <div class="reveal reveal-d3 detail-card mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="detail-label">Vaga deste token</span>
                        <span class="font-display font-700 text-sm" style="color:${bloqueadoMatricula ? '#ef4444' : 'var(--verde)'};">
                            ${vagasRestantes} de ${vagasTotal}
                        </span>
                    </div>
                    <div class="vacancy-bar-bg" role="progressbar"
                         aria-valuenow="${vagasTotal - vagasRestantes}" aria-valuemin="0" aria-valuemax="${vagasTotal}"
                         aria-label="Ocupacao da vaga ligada a este token: ${vagasTotal - vagasRestantes} de ${vagasTotal}">
                        <div class="vacancy-bar-fill" id="vacancyBar"
                             style="width:0%;${bloqueadoMatricula ? 'background:linear-gradient(90deg,#ef4444,#f87171)' : 'background:linear-gradient(90deg,var(--verde),var(--dourado))'};">
                        </div>
                    </div>
                </div>

                <!-- Grade de detalhes -->
                <div class="reveal reveal-d4 grid grid-cols-2 gap-2.5 mb-4">
                    <!-- Turno -->
                    <div class="detail-card">
                        <div class="flex items-center gap-2.5 mb-1.5">
                            <div class="detail-icon" style="background:rgba(255,173,2,0.1);">
                                <i class="fa-solid fa-sun" style="color:var(--dourado);" aria-hidden="true"></i>
                            </div>
                            <span class="detail-label">Turno</span>
                        </div>
                        <p class="detail-value">${curso.turno}</p>
                    </div>
                    <!-- Início -->
                    <div class="detail-card">
                        <div class="flex items-center gap-2.5 mb-1.5">
                            <div class="detail-icon" style="background:rgba(139,189,71,0.1);">
                                <i class="fa-solid fa-calendar-check" style="color:var(--verde);" aria-hidden="true"></i>
                            </div>
                            <span class="detail-label">Inicio</span>
                        </div>
                        <p class="detail-value">${curso.inicio}</p>
                    </div>
                </div>

                <!-- Horário de aula (destaque) -->
                <div class="reveal reveal-d5 detail-card mb-4" style="border-color:rgba(139,189,71,0.15);background:rgba(139,189,71,0.04);">
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="detail-icon" style="background:rgba(139,189,71,0.12);">
                            <i class="fa-regular fa-clock" style="color:var(--verde);" aria-hidden="true"></i>
                        </div>
                        <span class="detail-label">Horario de aula</span>
                    </div>
                    <div class="time-range">
                        <div class="text-center">
                            <div class="time-block">${curso.horarioInicio}</div>
                            <div class="time-label">Entrada</div>
                        </div>
                        <div class="time-sep" aria-hidden="true">
                            <div class="sep-line"></div>
                            <span class="sep-dur">${duracaoAula}h</span>
                            <div class="sep-line"></div>
                        </div>
                        <div class="text-center">
                            <div class="time-block">${curso.horarioFim}</div>
                            <div class="time-label">Saida</div>
                        </div>
                    </div>
                </div>

                <!-- Dias da semana (visual) -->
                <div class="reveal reveal-d6 detail-card mb-4">
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="detail-icon" style="background:rgba(239,142,38,0.1);">
                            <i class="fa-solid fa-calendar-week" style="color:var(--laranja);" aria-hidden="true"></i>
                        </div>
                        <span class="detail-label">Dias de aula</span>
                    </div>
                    <div class="flex justify-between gap-1" role="list" aria-label="Dias da semana com aula">
                        ${DIAS_SEMANA.map(dia => {
                            const ativo = diasAtivos.includes(dia.key);
                            return `
                                <div class="week-day ${ativo ? 'active' : 'inactive'}" role="listitem"
                                     aria-label="${dia.full} — ${ativo ? 'tem aula' : 'sem aula'}">
                                    <span class="day-initial">${dia.label}</span>
                                    <div class="day-dot" aria-hidden="true"></div>
                                    <span class="day-name">${dia.full.substring(0, 3)}</span>
                                </div>`;
                        }).join('')}
                    </div>
                    <p class="text-center text-xs mt-2.5 font-body" style="color:var(--txt-muted);">
                        ${diasAtivos.length ? diasAtivos.map(d => DIAS_SEMANA.find(x => x.key === d)?.full).filter(Boolean).join(', ') : '—'}
                    </p>
                </div>

                <!-- Faixa etaria -->
                <div class="reveal reveal-d7 detail-card mb-5">
                    <div class="flex items-center gap-2.5 mb-1.5">
                        <div class="detail-icon" style="background:rgba(191,251,172,0.08);">
                            <i class="fa-solid fa-users" style="color:var(--clarinho);" aria-hidden="true"></i>
                        </div>
                        <span class="detail-label">Faixa etaria</span>
                    </div>
                    <p class="detail-value">${faixaEtaria}</p>
                </div>

                <!-- Ações -->
                <div class="reveal reveal-d8 flex flex-col sm:flex-row gap-2.5">
                    <a href="${(window.CHECKIN_URLS && window.CHECKIN_URLS.voltar) || 'busca.html'}" class="btn-ghost flex-1 py-3 rounded-xl font-display flex items-center justify-center gap-2 text-center no-underline"
                       aria-label="Voltar para busca de vagas">
                        <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                        <span>Voltar</span>
                    </a>
                    ${podeContinuar ? `
                    <a href="${(window.CHECKIN_URLS && window.CHECKIN_URLS.matricula) || 'validamatricula.html'}"
                       class="btn-primary flex-1 py-3 rounded-xl font-display flex items-center justify-center gap-2 text-center no-underline"
                       aria-label="Continuar matricula para ${curso.nome}">
                        <span><i class="fa-solid fa-arrow-right-to-bracket mr-1.5 text-xs" aria-hidden="true"></i>Continuar matricula</span>
                    </a>` : `
                    <div class="flex-1 py-3 rounded-xl font-display font-600 text-center text-sm"
                         style="background:rgba(239,68,68,0.06);border:1.5px solid rgba(239,68,68,0.15);color:rgba(239,68,68,0.75);">
                        <i class="fa-solid fa-ban mr-1.5 text-xs" aria-hidden="true"></i>${
                            tokenUtilizado ? 'Token ja utilizado — matricula nao disponivel' :
                            'Token indisponivel para matricula'
                        }
                    </div>`}
                </div>
            `;

            // Animar barra de vagas após render
            requestAnimationFrame(() => {
                setTimeout(() => {
                    const bar = document.getElementById('vacancyBar');
                    if (bar) bar.style.width = pctOcupada + '%';
                }, 400);
            });
        }

        /** Calcula duração entre dois horários "HH:MM" */
        #calcularDuracao(inicio, fim) {
            const [ih, im] = inicio.split(':').map(Number);
            const [fh, fm] = fim.split(':').map(Number);
            let diff = (fh * 60 + fm) - (ih * 60 + im);
            if (diff < 0) diff += 24 * 60; // cruza meia-noite
            const h = Math.floor(diff / 60);
            const m = diff % 60;
            return m > 0 ? `${h}h${m.toString().padStart(2,'0')}` : `${h}h`;
        }

        /** Mostra estado de curso não encontrado */
        renderNotFound(codigo) {
            this.#container.innerHTML = `
                <div class="reveal flex flex-col items-center text-center py-8">
                    <div style="width:64px;height:64px;border-radius:1rem;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.15);display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;">
                        <i class="fa-solid fa-magnifying-glass text-xl" style="color:#ef4444;" aria-hidden="true"></i>
                    </div>
                    <h1 class="font-display font-800 text-xl mb-2" style="color:var(--txt-primary);">Curso nao encontrado</h1>
                    <p class="text-sm mb-6" style="color:var(--txt-tertiary);max-width:280px;">
                        Nenhuma vaga foi localizada para o codigo <strong style="color:var(--txt-secondary);">${codigo}</strong>.
                    </p>
                    <a href="${(window.CHECKIN_URLS && window.CHECKIN_URLS.voltar) || 'busca.html'}" class="btn-ghost py-2.5 px-6 rounded-xl font-display flex items-center gap-2 no-underline"
                       aria-label="Voltar para busca">
                        <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                        <span>Voltar para busca</span>
                    </a>
                </div>
            `;
        }
    }

    // =============================================================
    // APLICAÇÃO PRINCIPAL
    // =============================================================
    class CourseDetailApp {
        #repository;
        #renderer;
        #toast;

        constructor() {
            const isTouch = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            this.#repository = new CursoRepository([
                { codigo: 'CURS2025', nome: 'Tecnologia da Informacao', modulo: 'Desenvolvimento Full Stack', vagas: 1, total: 1, turno: 'Noturno', faixaEtaria: '18 a 29 anos', situacaoSenha: 'DISPONIVEL', inicio: '15/02/2025', horarioInicio: '19:00', horarioFim: '22:30', diasSemana: ['seg','qua','sex'] },
                { codigo: 'ADM2025',  nome: 'Administracao',         modulo: 'Gestao Empresarial',      vagas: 1, total: 1, turno: 'Vespertino', faixaEtaria: '30 a 45 anos', situacaoSenha: 'DISPONIVEL', inicio: '01/03/2025', horarioInicio: '13:30', horarioFim: '17:30', diasSemana: ['ter','qui'] },
                { codigo: 'ENF2025',  nome: 'Enfermagem',            modulo: 'Saude Coletiva',          vagas: 0, total: 1, turno: 'Integral',   faixaEtaria: '18 a 35 anos', situacaoSenha: 'UTILIZADA', inicio: '10/02/2025', horarioInicio: '08:00', horarioFim: '17:00', diasSemana: ['seg','ter','qua','qui','sex'] },
                { codigo: 'ENG2025',  nome: 'Engenharia Civil',      modulo: 'Estruturas e Construcao', vagas: 1, total: 1, turno: 'Diurno',     faixaEtaria: '16 a 21 anos', situacaoSenha: 'DISPONIVEL', inicio: '20/02/2025', horarioInicio: '08:00', horarioFim: '12:00', diasSemana: ['seg','ter','qua','qui','sex'] },
                { codigo: 'DES2025',  nome: 'Design Grafico',        modulo: 'Identidade Visual e UX',  vagas: 1, total: 1, turno: 'Noturno',   faixaEtaria: '14 a 17 anos', situacaoSenha: 'DISPONIVEL', inicio: '05/03/2025', horarioInicio: '19:00', horarioFim: '22:00', diasSemana: ['ter','qua'] },
                { codigo: 'DIR2025',  nome: 'Direito',               modulo: 'Direito Constitucional',   vagas: 1, total: 1, turno: 'Noturno',   faixaEtaria: '18 a 40 anos', situacaoSenha: 'DISPONIVEL', inicio: '12/03/2025', horarioInicio: '19:30', horarioFim: '22:30', diasSemana: ['seg','qua','sex'] }
            ]);

            this.#toast = new Toast();
            this.#renderer = new CourseDetailRenderer(document.getElementById('courseContent'));

            // Efeitos visuais
            new Card3DEffect(document.getElementById('card3d'), document.getElementById('cardShine'), { isTouch, reduceMotion });
            new ParticleSystem(document.getElementById('particles'), { ativo: !isTouch && !reduceMotion });
            new OrbParallax(document.querySelectorAll('.orb'), { ativo: !isTouch && !reduceMotion });

            this.#carregarCurso();
        }

        #carregarCurso() {
            const embeddedEl = document.getElementById('curso-checkin-json');
            if (embeddedEl) {
                try {
                    const curso = JSON.parse(embeddedEl.textContent);
                    const sit = (curso.situacaoSenha || 'DISPONIVEL').toString().toUpperCase();
                    this.#renderer.render(curso);
                    if (sit === 'UTILIZADA') {
                        this.#toast.show('aviso', 'Token utilizado', 'Este codigo ja foi utilizado. A vaga nao esta mais disponivel para matricula.');
                    } else if (sit !== 'DISPONIVEL') {
                        this.#toast.show('aviso', 'Token indisponivel', 'A situacao deste token nao permite avancar com a matricula.');
                    } else {
                        this.#toast.show('sucesso', 'Token disponivel', `Voce pode continuar a matricula em "${curso.nome}".`);
                    }
                } catch (e) {
                    console.error(e);
                    this.#renderer.renderNotFound('(dados)');
                    this.#toast.show('erro', 'Erro', 'Nao foi possivel carregar os dados da vaga.');
                }
                return;
            }

            const params = new URLSearchParams(window.location.search);
            const codigo = (params.get('codigo') || '').trim().toUpperCase();

            if (!codigo) {
                this.#renderer.renderNotFound('(vazio)');
                return;
            }

            const curso = this.#repository.findByCodigo(codigo);
            if (!curso) {
                this.#renderer.renderNotFound(codigo);
                this.#toast.show('erro', 'Nao encontrado', `Codigo "${codigo}" nao localizado.`);
                return;
            }

            this.#renderer.render(curso);

            const sit = (curso.situacaoSenha || 'DISPONIVEL').toString().toUpperCase();
            if (sit === 'UTILIZADA') {
                this.#toast.show('aviso', 'Token utilizado', 'Este token ja foi utilizado.');
            } else if (sit !== 'DISPONIVEL') {
                this.#toast.show('aviso', 'Token indisponivel', 'Este token nao esta disponivel para matricula.');
            } else {
                this.#toast.show('sucesso', 'Curso localizado', `"${curso.nome}" — token disponivel.`);
            }
        }
    }

    // =============================================================
    // INICIALIZAÇÃO
    // =============================================================
    const app = new CourseDetailApp();
    </script>
</body>
</html>