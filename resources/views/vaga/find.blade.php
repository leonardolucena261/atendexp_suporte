<x-layoutvaga>
    <!-- Conteúdo principal -->
    <main class="scene" id="scene" role="main">
        <div class="card-3d" id="card3d">
            <!-- Borda rotativa (decorativa) -->
            <div class="border-glow rounded-3xl" role="presentation" aria-hidden="true"></div>

            <!-- Cartão -->
            <div class="card-inner relative rounded-3xl overflow-hidden"
                 style="background: linear-gradient(165deg, rgba(30,41,59,0.97) 0%, rgba(30,41,59,0.99) 50%, rgba(30,41,59,0.93) 100%);
                        backdrop-filter: blur(40px);
                        border: 1px solid rgba(139,189,71,0.1);
                        padding: 3rem 2.5rem;">

                <!-- Brilho interativo (decorativo) -->
                <div class="card-shine rounded-3xl" id="cardShine" role="presentation" aria-hidden="true"></div>

                <!-- Conteúdo do cartão -->
                <div class="relative z-10">

                    <!-- Ilustração do ícone com alt descritivo -->
                    <div class="text-reveal mb-5 flex justify-center" role="img" aria-label="Icone de um capelo academico, simbolizando cursos e graduacao">
                        <img
                            src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64' fill='none'%3E%3Crect width='64' height='64' rx='16' fill='url(%23g1)'/%3E%3Cdefs%3E%3ClinearGradient id='g1' x1='0' y1='0' x2='64' y2='64'%3E%3Cstop stop-color='%238BBD47' stop-opacity='0.18'/%3E%3Cstop offset='1' stop-color='%23FFAD02' stop-opacity='0.12'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M32 14L10 26l22 12 22-12L32 14z' fill='%238BBD47'/%3E%3Cpath d='M14 29v14c0 0 8 8 18 8s18-8 18-8V29L32 39 14 29z' fill='%238BBD47' opacity='0.5'/%3E%3Cpath d='M50 22v20' stroke='%23FFAD02' stroke-width='2.5' stroke-linecap='round'/%3E%3Ccircle cx='50' cy='44' r='3' fill='%23FFAD02'/%3E%3C/svg%3E"
                            alt="Icone de um capelo academico representando cursos e graduacao"
                            width="56"
                            height="56"
                            class="sm:w-16 sm:h-16 rounded-2xl"
                            style="border: 1px solid rgba(139,189,71,0.15);"
                        >
                    </div>

                    <!-- Título principal -->
                    <h1 class="text-reveal text-reveal-d1 font-display text-center font-800 text-2xl sm:text-3xl md:text-4xl tracking-tight mb-2"
                        style="color: var(--txt-primary); line-height: 1.2;">
                        Encontre sua vaga
                    </h1>

                    <!-- Subtítulo com contraste acessível -->
                    <p class="text-reveal text-reveal-d2 text-center font-body font-400 text-sm sm:text-base mb-5"
                       style="color: var(--txt-secondary); line-height: 1.6;">
                        Digite o token da vaga do curso para continuar com a sua matrícula.
                    </p>

                    <!-- Linha decorativa -->
                    <div class="accent-line mx-auto mb-7" style="max-width:160px;" role="presentation" aria-hidden="true"></div>

                    @if (session('error'))
                        <div class="mb-5 rounded-xl border px-4 py-3 text-sm font-body text-center"
                             style="border-color: rgba(239,68,68,0.35); background: rgba(239,68,68,0.08); color: var(--txt-secondary);"
                             role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Formulário -->
                    <form id="formulario-busca" class="text-reveal text-reveal-d3" autocomplete="off" aria-label="Buscar vaga pelo token">
                        <div class="relative">
                            <!-- Ícone do campo -->
                            <div class="absolute left-3.5 sm:left-4 top-1/2 -translate-y-1/2" aria-hidden="true"
                                 style="color: var(--txt-muted);">
                                <i class="fa-solid fa-hashtag text-sm"></i>
                            </div>

                            <!-- Campo de texto -->
                            <label for="codeInput" class="sr-only">Token de acesso</label>
                            <input
                                type="text"
                                id="codeInput"
                                name="codigo-curso"
                                class="search-input w-full pl-10 sm:pl-11 pr-4 sm:pr-36 py-3.5 sm:py-4 rounded-xl font-body tracking-wider"
                                placeholder="Token: Abc123XY"
                                maxlength="120"
                                autocapitalize="none"
                                autocorrect="off"
                                spellcheck="false"
                                aria-describedby="help-text"
                                required
                            >

                            <!-- Botão desktop -->
                            <button type="submit" id="searchBtn"
                                    class="btn-search hidden sm:flex absolute right-2 top-1/2 -translate-y-1/2 px-5 py-2.5 rounded-lg font-display items-center gap-2"
                                    aria-label="Buscar vaga pelo codigo digitado">
                                <span id="btnContentDesktop">
                                    <i class="fa-solid fa-magnifying-glass text-xs" aria-hidden="true"></i>
                                    Buscar
                                </span>
                            </button>
                        </div>

                        <!-- Botão mobile -->
                        <button type="submit" id="searchBtnMobile"
                                class="btn-search sm:hidden w-full mt-3 py-3.5 rounded-xl font-display flex items-center justify-center gap-2"
                                aria-label="Buscar vaga pelo codigo digitado">
                            <span id="btnContentMobile">
                                <i class="fa-solid fa-magnifying-glass text-xs" aria-hidden="true"></i>
                                Buscar vaga
                            </span>
                        </button>

                        <!-- Texto de ajuda (vinculado ao input via aria-describedby) -->
                        <p id="help-text" class="mt-3.5 text-center text-xs sm:text-sm font-body" style="color: var(--txt-tertiary); line-height: 1.5;">
                            <i class="fa-solid fa-circle-info mr-1" aria-hidden="true"></i>
                            Insira o token da carta de convocacao (maiúsculas ou minúsculas)
                        </p>
                    </form>

                    <!-- Área de resultado (live region para leitores de tela) -->
                    <div id="resultArea" class="mt-5 hidden" role="region" aria-live="polite" aria-atomic="true" aria-label="Resultado da busca"></div>

                    <!-- Rodapé social proof -->
                    <div class="text-reveal text-reveal-d4 mt-7 flex items-center justify-center gap-2.5">
                        <div class="flex -space-x-1.5" role="img" aria-label="Tres usuarios representando a comunidade de inscritos" aria-hidden="true">
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full border-2 flex items-center justify-center text-[10px] sm:text-xs font-600"
                                 style="background: var(--verde); color: var(--escuro); border-color: var(--escuro);">A</div>
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full border-2 flex items-center justify-center text-[10px] sm:text-xs font-600"
                                 style="background: var(--dourado); color: var(--escuro); border-color: var(--escuro);">M</div>
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full border-2 flex items-center justify-center text-[10px] sm:text-xs font-600"
                                 style="background: var(--laranja); color: var(--escuro); border-color: var(--escuro);">R</div>
                        </div>
                        <span class="text-xs sm:text-sm font-body" style="color: var(--txt-tertiary);">
                            Mais de 2.400 vagas abertas agora
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Toast de notificação -->
    <div class="toast" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl shadow-2xl"
             style="background: rgba(30,41,59,0.97); backdrop-filter: blur(20px); border: 1px solid rgba(139,189,71,0.15);">
            <div id="toastIcon" class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                 style="background: rgba(139,189,71,0.12);" aria-hidden="true">
                <i class="fa-solid fa-check text-sm" style="color: var(--verde);"></i>
            </div>
            <div class="min-w-0">
                <p id="toastTitle" class="text-sm font-display font-600" style="color: var(--txt-primary);">Sucesso</p>
                <p id="toastMsg" class="text-sm font-body" style="color: var(--txt-secondary);">Mensagem</p>
            </div>
        </div>
    </div>

    <!-- Classe utilitária sr-only para screen readers -->
    <style>.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;}</style>

    <script>
        const VAGA_BASE_URL = @json(rtrim(url('/vaga'), '/'));

        // =============================================
        // Elementos DOM
        // =============================================
        const card3d = document.getElementById('card3d');
        const cardShine = document.getElementById('cardShine');
        const searchForm = document.getElementById('formulario-busca');
        const codeInput = document.getElementById('codeInput');
        const searchBtn = document.getElementById('searchBtn');
        const searchBtnMobile = document.getElementById('searchBtnMobile');
        const btnContentDesktop = document.getElementById('btnContentDesktop');
        const btnContentMobile = document.getElementById('btnContentMobile');
        const resultArea = document.getElementById('resultArea');
        const toast = document.getElementById('toast');
        const toastIcon = document.getElementById('toastIcon');
        const toastTitle = document.getElementById('toastTitle');
        const toastMsg = document.getElementById('toastMsg');

        const isTouchDevice = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);

        // =============================================
        // Efeito 3D sutil
        // =============================================
        let targetRotX = 0, targetRotY = 0;
        let currentRotX = 0, currentRotY = 0;
        const LERP = isTouchDevice ? 0.02 : 0.04;
        const MAX_ROT_X = isTouchDevice ? 1.5 : 4;
        const MAX_ROT_Y = isTouchDevice ? 2 : 5;

        // Respeitar preferência de redução de movimento
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (!isTouchDevice && !prefersReducedMotion) {
            document.addEventListener('mousemove', (e) => {
                const rect = card3d.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const mx = (e.clientX - cx) / (rect.width / 2);
                const my = (e.clientY - cy) / (rect.height / 2);
                targetRotY = mx * MAX_ROT_Y;
                targetRotX = -my * MAX_ROT_X;
                const sx = ((e.clientX - rect.left) / rect.width) * 100;
                const sy = ((e.clientY - rect.top) / rect.height) * 100;
                cardShine.style.setProperty('--mx', sx + '%');
                cardShine.style.setProperty('--my', sy + '%');
            });
            document.addEventListener('mouseleave', () => { targetRotX = 0; targetRotY = 0; });
        } else if (isTouchDevice && !prefersReducedMotion) {
            window.addEventListener('deviceorientation', (e) => {
                if (e.gamma !== null && e.beta !== null) {
                    targetRotY = Math.max(-MAX_ROT_Y, Math.min(MAX_ROT_Y, e.gamma * 0.15));
                    targetRotX = Math.max(-MAX_ROT_X, Math.min(MAX_ROT_X, (e.beta - 45) * 0.1));
                }
            });
        }

        if (!prefersReducedMotion) {
            (function animateCard() {
                currentRotX += (targetRotX - currentRotX) * LERP;
                currentRotY += (targetRotY - currentRotY) * LERP;
                card3d.style.transform = `rotateX(${currentRotX.toFixed(3)}deg) rotateY(${currentRotY.toFixed(3)}deg)`;
                requestAnimationFrame(animateCard);
            })();
        }

        // =============================================
        // Partículas (somente desktop, sem reduced-motion)
        // =============================================
        if (!isTouchDevice && !prefersReducedMotion) {
            (function createParticles() {
                const container = document.getElementById('particles');
                const colors = ['#8BBD47', '#FFAD02', '#BFFBAC', '#EF8E26'];
                for (let i = 0; i < 28; i++) {
                    const p = document.createElement('div');
                    p.className = 'particle';
                    const size = Math.random() * 3 + 1.5;
                    const color = colors[Math.floor(Math.random() * colors.length)];
                    p.style.cssText = `width:${size}px;height:${size}px;background:${color};left:${Math.random()*100}%;animation-duration:${Math.random()*14+12}s;animation-delay:${Math.random()*14}s;opacity:0;box-shadow:0 0 ${size*2.5}px ${color};`;
                    container.appendChild(p);
                }
            })();
        }

        // =============================================
        // Parallax dos orbs (só desktop)
        // =============================================
        if (!isTouchDevice && !prefersReducedMotion) {
            const orbs = document.querySelectorAll('.orb');
            document.addEventListener('mousemove', (e) => {
                const cx = (e.clientX / window.innerWidth - 0.5) * 2;
                const cy = (e.clientY / window.innerHeight - 0.5) * 2;
                orbs.forEach((orb, i) => {
                    const f = (i + 1) * 10;
                    orb.style.transform = `translate(${cx * f}px, ${cy * f}px)`;
                });
            });
        }

        // =============================================
        // Toast
        // =============================================
        let toastTimer = null;
        function showToast(type, title, msg) {
            clearTimeout(toastTimer);
            const cfg = {
                sucesso: { icon: 'fa-check', bg: 'rgba(139,189,71,0.12)', color: '#8BBD47' },
                erro:    { icon: 'fa-xmark', bg: 'rgba(239,68,68,0.12)', color: '#ef4444' },
                aviso:   { icon: 'fa-triangle-exclamation', bg: 'rgba(255,173,2,0.12)', color: '#FFAD02' }
            };
            const c = cfg[type] || cfg.sucesso;
            toastIcon.style.background = c.bg;
            toastIcon.innerHTML = `<i class="fa-solid ${c.icon} text-sm" style="color:${c.color}"></i>`;
            toastTitle.textContent = title;
            toastMsg.textContent = msg;
            toast.classList.add('show');
            toastTimer = setTimeout(() => toast.classList.remove('show'), 4500);
        }

        // =============================================
        // Loading states
        // =============================================
        const loadingHTML = '<div class="spinner" aria-hidden="true"></div><span>Buscando...</span>';
        const idleHTMLDesktop = '<i class="fa-solid fa-magnifying-glass text-xs" aria-hidden="true"></i> Buscar';
        const idleHTMLMobile = '<i class="fa-solid fa-magnifying-glass text-xs" aria-hidden="true"></i> Buscar vaga';

        function setLoading(on) {
            btnContentDesktop.innerHTML = on ? loadingHTML : idleHTMLDesktop;
            btnContentMobile.innerHTML = on ? loadingHTML : idleHTMLMobile;
            searchBtn.disabled = on;
            searchBtnMobile.disabled = on;
            if (on) {
                searchBtn.setAttribute('aria-busy', 'true');
                searchBtnMobile.setAttribute('aria-busy', 'true');
            } else {
                searchBtn.removeAttribute('aria-busy');
                searchBtnMobile.removeAttribute('aria-busy');
            }
        }

        // Mensagem nativa de obrigatoriedade: sem limpar no input, o campo fica invalido para sempre apos o primeiro erro
        codeInput.addEventListener('input', () => codeInput.setCustomValidity(''));
        codeInput.addEventListener('invalid', (ev) => {
            ev.target.setCustomValidity('Por favor, preencha este campo obrigatório!');
        });

        // Voltar do historico (bfcache): botoes podem ter ficado desabilitados no "Buscando..."
        window.addEventListener('pageshow', (ev) => {
            if (ev.persisted) {
                setLoading(false);
            }
        });

        // =============================================
        // Busca → rota getVaga (/vaga/{token})
        // =============================================
        function handleSearch(e) {
            e.preventDefault();
            codeInput.setCustomValidity('');
            const token = codeInput.value.trim();

            if (!token) {
                showToast('aviso', 'Campo vazio', 'Por favor, insira o token.');
                codeInput.focus();
                return;
            }

            setLoading(true);
            const destino = VAGA_BASE_URL + '/' + encodeURIComponent(token);
            window.location.assign(destino);
        }

        searchForm.addEventListener('submit', handleSearch);

        window.addEventListener('load', () => {
            setTimeout(() => codeInput.focus(), 800);
        });

        // =============================================
        // Escape para limpar
        // =============================================
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                codeInput.value = '';
                resultArea.classList.add('hidden');
                resultArea.innerHTML = '';
                codeInput.focus();
            }
        });
    </script>
</x-layoutvaga>