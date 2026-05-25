<x-layoutvaga>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <main class="scene" id="scene" role="main">
        <div class="card-3d" id="card3d">
            <div class="border-glow rounded-3xl" role="presentation" aria-hidden="true"></div>

            <div class="card-inner relative rounded-3xl overflow-hidden" style="background: linear-gradient(165deg, rgba(30,41,59,0.97) 0%, rgba(30,41,59,0.99) 50%, rgba(30,41,59,0.93) 100%);
                        backdrop-filter: blur(40px);
                        border: 1px solid rgba(139,189,71,0.1);
                        padding: 2.5rem 2rem 2rem;">

                <div class="card-shine rounded-3xl" id="cardShine" role="presentation" aria-hidden="true"></div>

                <div class="relative z-10">

                    <!-- ETAPA 1: VERIFICAÇÃO HUMANA -->
                    <div id="verifyArea" @if($jaVerificado) style="display:none;" @endif>
                        <div class="text-reveal mb-4 flex justify-center" role="img"
                            aria-label="Icone de verificacao de seguranca">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='16' fill='rgba(139,189,71,0.15)'/%3E%3Cpath d='M32 12L12 22v12c0 10 8.5 19.5 20 22 11.5-2.5 20-12 20-22V22L32 12z' fill='rgba(139,189,71,0.12)' stroke='%238BBD47' stroke-width='1.5'/%3E%3Cpath d='M26 33l4 4 8-8' stroke='%238BBD47' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"
                                alt="Escudo com check" width="56" height="56" class="sm:w-14 sm:h-14 rounded-2xl"
                                style="border:1px solid rgba(139,189,71,0.15);">
                        </div>
                        <h1 class="text-reveal text-reveal-d1 font-display text-center font-800 text-2xl sm:text-3xl tracking-tight mb-1.5"
                            style="color:var(--txt-primary); line-height:1.2;">Verificação de segurança</h1>
                        <p class="text-reveal text-reveal-d2 text-center font-body font-400 text-sm sm:text-base mb-6"
                            style="color:var(--txt-secondary); line-height:1.6;">Não sou um robô <br> Confirme que você
                            é humano antes de continuar.</p>
                        <div class="accent-line mx-auto mb-8" style="max-width:120px;" role="presentation"
                            aria-hidden="true"></div>

                        <div class="text-reveal text-reveal-d3 flex flex-col items-center">
                            <div id="holdBtn" class="hold-btn" role="button" tabindex="0"
                                aria-label="Pressione e segure por 3 segundos para verificar que voce e humano">
                                <svg class="hold-ring" viewBox="0 0 80 80" aria-hidden="true">
                                    <circle class="ring-bg" cx="40" cy="40" r="34" />
                                    <circle class="ring-progress" id="ringProgress" cx="40" cy="40" r="34" />
                                </svg>
                                <div class="hold-icon" id="holdIcon"><i class="fa-solid fa-shield-halved"></i></div>
                            </div>
                            <p class="hold-text" id="holdText">Pressione e segure</p>
                            <p class="hold-subtext" id="holdSubtext">Segure por 3 segundos para verificar</p>
                        </div>
                        <div class="text-reveal text-reveal-d4 mt-8 text-center">
                            <p class="text-xs font-body" style="color:var(--txt-tertiary); line-height:1.5;"><i
                                    class="fa-solid fa-lock mr-1" aria-hidden="true"></i> Proteção contra cadastros
                                automatizados</p>
                        </div>
                    </div>

                    <!-- ETAPA 2: FORMULÁRIO DE PRÉ-CADASTRO -->
                    <div id="formArea" @if(!$jaVerificado) style="display:none;" @endif>
                        <div class="mb-4 flex justify-center" role="img" aria-label="Icone de cadastro de aluno">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='16' fill='rgba(139,189,71,0.15)'/%3E%3Ccircle cx='24' cy='20' r='7' fill='%238BBD47'/%3E%3Cpath d='M14 42c0-7 4.5-12 10-12s10 5 10 12' fill='%238BBD47' opacity='0.5'/%3E%3Crect x='36' y='16' width='18' height='24' rx='3' fill='rgba(255,173,2,0.2)' stroke='%23FFAD02' stroke-width='1.5'/%3E%3Cline x1='40' y1='22' x2='50' y2='22' stroke='%23FFAD02' stroke-width='1.5' stroke-linecap='round'/%3E%3Cline x1='40' y1='27' x2='50' y2='27' stroke='%23FFAD02' stroke-width='1.5' stroke-linecap='round'/%3E%3Cline x1='40' y1='32' x2='46' y2='32' stroke='%23FFAD02' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E"
                                alt="Icone cadastro" width="56" height="56" class="sm:w-14 sm:h-14 rounded-2xl"
                                style="border:1px solid rgba(139,189,71,0.15);">
                        </div>
                        <h1 class="font-display text-center font-800 text-2xl sm:text-3xl tracking-tight mb-1.5"
                            style="color:var(--txt-primary); line-height:1.2;">Pré-cadastro de Candidato</h1>
                        <p class="text-center font-body font-400 text-sm sm:text-base mb-4"
                            style="color:var(--txt-secondary); line-height:1.6;">Preencha seus dados básicos para
                            iniciar o processo.</p>
                        <div class="accent-line mx-auto mb-6" style="max-width:140px;" role="presentation"
                            aria-hidden="true"></div>

                        <form id="formPreCadastro" autocomplete="off" novalidate
                            aria-label="Formulario de pre-cadastro de candidato">
                            @csrf
                            <div style="position:absolute;left:-9999px;top:-9999px;opacity:0;height:0;overflow:hidden;"
                                aria-hidden="true" tabindex="-1">
                                <label for="website_url">Não preencha</label>
                                <input type="text" id="website_url" name="website_url" autocomplete="off" tabindex="-1">
                            </div>

                            <!-- Nome completo -->
                            <div class="mb-4">
                                <label for="nome_aluno" class="form-label">Nome completo <span
                                        style="color:var(--verde);">*</span></label>
                                <div class="relative">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                        aria-hidden="true" style="color:var(--txt-muted);"><i
                                            class="fa-solid fa-user text-xs"></i></div>
                                    <input type="text" id="nome_aluno" name="nome_aluno" class="form-input pl-11"
                                        placeholder="Seu nome completo" maxlength="50" required>
                                </div>
                                <p class="field-error" id="erro-nome_aluno"></p>
                            </div>

                            <!-- CPF + Data de nascimento -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="cpf" class="form-label">CPF <span
                                            style="color:var(--verde);">*</span></label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                            aria-hidden="true" style="color:var(--txt-muted);"><i
                                                class="fa-solid fa-id-card text-xs"></i></div>
                                        <input type="text" id="cpf" name="cpf" class="form-input pl-11"
                                            placeholder="000.000.000-00" maxlength="14" required>
                                    </div>
                                    <p class="field-error" id="erro-cpf"></p>
                                </div>
                                <div>
                                    <label for="data_nascimento" class="form-label">Nascimento <span
                                            style="color:var(--verde);">*</span></label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                            aria-hidden="true" style="color:var(--txt-muted);"><i
                                                class="fa-solid fa-calendar text-xs"></i></div>
                                        <input type="date" id="data_nascimento" name="data_nascimento"
                                            class="form-input pl-11" required>
                                    </div>
                                    <p class="field-error" id="erro-data_nascimento"></p>
                                </div>
                            </div>

                            <!-- Sexo + Telefone celular -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="sexo" class="form-label">Sexo <span
                                            style="color:var(--verde);">*</span></label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                            aria-hidden="true" style="color:var(--txt-muted);"><i
                                                class="fa-solid fa-venus-mars text-xs"></i></div>
                                        <select id="sexo" name="sexo" class="form-select pl-11 pr-9 appearance-none"
                                            required>
                                            <option value="" disabled selected>Selecione</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Feminino">Feminino</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                            aria-hidden="true" style="color:var(--txt-muted);"><i
                                                class="fa-solid fa-chevron-down text-xs"></i></div>
                                    </div>
                                    <p class="field-error" id="erro-sexo"></p>
                                </div>
                                <div>
                                    <label for="telefone_celular" class="form-label">Celular <span
                                            style="color:var(--verde);">*</span></label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                            aria-hidden="true" style="color:var(--txt-muted);"><i
                                                class="fa-solid fa-mobile-screen text-xs"></i></div>
                                        <input type="text" id="telefone_celular" name="telefone_celular"
                                            class="form-input pl-11" placeholder="(00) 00000-0000" maxlength="15"
                                            required>
                                    </div>
                                    <p class="field-error" id="erro-telefone_celular"></p>
                                </div>
                            </div>

                             <!-- Nome da Mãe (Obrigatório para Todos) -->
                             <div class="mb-4">
                                <label for="nome_mae" class="form-label">
                                    Nome completo da Mãe <span style="color:var(--verde);">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" aria-hidden="true" style="color:var(--txt-muted);"><i class="fa-solid fa-person-dress text-xs"></i></div>
                                    <input type="text" id="nome_mae" name="nome_mae" class="form-input pl-11" placeholder="Nome completo da mãe do candidato" maxlength="50" required>
                                </div>
                                <p class="field-error" id="erro-nome_mae"></p>
                            </div>

                            <!-- E-mail -->
                            <div class="mb-5">
                                <label for="email" class="form-label">E-mail <span class="text-xs font-400"
                                        style="color:var(--txt-tertiary);">(opcional)</span></label>
                                <div class="relative">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                        aria-hidden="true" style="color:var(--txt-muted);"><i
                                            class="fa-solid fa-envelope text-xs"></i></div>
                                    <input type="email" id="email" name="email" class="form-input pl-11"
                                        placeholder="seuemail@exemplo.com" maxlength="50">
                                </div>
                                <p class="field-error" id="erro-email"></p>
                            </div>

                            <!-- ============================================ -->
                            <!-- SEÇÃO DO RESPONSÁVEL (APARECE SE MENOR)      -->
                            <!-- ============================================ -->
                            <div id="guardianArea" style="display: none;">
                                <div class="pt-5 mb-5" style="border-top: 1px solid rgba(255,255,255,0.06);">
                                    <h3 class="font-display font-600 text-sm mb-4 flex items-center gap-2"
                                        style="color: var(--dourado, #FFAD02);">
                                        <i class="fa-solid fa-user-tie text-xs"></i>
                                        Dados do Responsável Legal
                                        <span class="text-xs font-body font-400"
                                            style="color: var(--txt-tertiary);">(Menor de 18 anos)</span>
                                    </h3>

                                    <!-- Nome do Responsável -->
                                    <div class="mb-4">
                                        <label for="nome_responsavel" class="form-label">Nome do Responsável <span
                                                style="color:var(--verde);">*</span></label>
                                        <div class="relative">
                                            <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                                aria-hidden="true" style="color:var(--txt-muted);"><i
                                                    class="fa-solid fa-user-shield text-xs"></i></div>
                                            <input type="text" id="nome_responsavel" name="nome_responsavel"
                                                class="form-input pl-11"
                                                placeholder="Nome completo do pai, mãe ou tutor" maxlength="50">
                                        </div>
                                        <p class="field-error" id="erro-nome_responsavel"></p>
                                    </div>

                                    <!-- CPF + Parentesco -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="cpf_responsavel" class="form-label">CPF do Responsável <span
                                                    style="color:var(--verde);">*</span></label>
                                            <div class="relative">
                                                <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                                    aria-hidden="true" style="color:var(--txt-muted);"><i
                                                        class="fa-solid fa-id-card text-xs"></i></div>
                                                <input type="text" id="cpf_responsavel" name="cpf_responsavel"
                                                    class="form-input pl-11" placeholder="000.000.000-00"
                                                    maxlength="14">
                                            </div>
                                            <p class="field-error" id="erro-cpf_responsavel"></p>
                                        </div>
                                        <div>
                                            <label for="grau_parentesco" class="form-label">Grau de Parentesco <span
                                                    style="color:var(--verde);">*</span></label>
                                            <div class="relative">
                                                <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                                    aria-hidden="true" style="color:var(--txt-muted);"><i
                                                        class="fa-solid fa-people-arrows text-xs"></i></div>
                                                <select id="grau_parentesco" name="grau_parentesco"
                                                    class="form-select pl-11 pr-9 appearance-none">
                                                    <option value="" disabled selected>Selecione</option>
                                                    <option value="Mãe">Mãe</option>
                                                    <option value="Pai">Pai</option>
                                                    <option value="Tutor(a) Legal">Tutor(a) Legal</option>
                                                    <option value="Avó(o)">Avó(o)</option>
                                                    <option value="Outro">Outro</option>
                                                </select>
                                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"
                                                    aria-hidden="true" style="color:var(--txt-muted);"><i
                                                        class="fa-solid fa-chevron-down text-xs"></i></div>
                                            </div>
                                            <p class="field-error" id="erro-grau_parentesco"></p>
                                        </div>
                                    </div>

                                    <!-- Checkbox LGPD / ECA -->
                                    <div class="flex items-start gap-3 p-3.5 rounded-xl"
                                        style="background: rgba(255,173,2,0.04); border: 1px solid rgba(255,173,2,0.12);">
                                        <input type="checkbox" id="termo_responsavel" name="termo_responsavel"
                                            class="mt-0.5 w-4 h-4 rounded flex-shrink-0 cursor-pointer accent-[#8BBD47]"
                                            style="box-shadow: none;">
                                        <label for="termo_responsavel"
                                            class="text-xs font-body cursor-pointer leading-relaxed"
                                            style="color: var(--txt-secondary);">
                                            Declaro que sou o responsável legal pelo candidato acima e <strong
                                                style="color: var(--txt-primary);">autorizo a coleta dos seus
                                                dados</strong> para fins de pré-matrícula, ciente de que devo apresentar
                                            documentação original presencialmente (Conforme LGPD e ECA Digital).
                                        </label>
                                    </div>
                                    <p class="field-error" id="erro-termo_responsavel"
                                        style="margin-top: 0.25rem; margin-bottom: 0.5rem;"></p>
                                </div>
                            </div>

                            <!-- Botões -->
                            <button type="submit" id="btnSubmit"
                                class="btn-search hidden sm:flex w-full justify-center py-3.5 rounded-xl font-display items-center gap-2">
                                <span id="btnContentDesktop"><i class="fa-solid fa-arrow-right-to-bracket text-xs"
                                        aria-hidden="true"></i> Realizar pré-cadastro</span>
                            </button>
                            <button type="submit" id="btnSubmitMobile"
                                class="btn-search sm:hidden w-full py-3.5 rounded-xl font-display flex items-center justify-center gap-2">
                                <span id="btnContentMobile"><i class="fa-solid fa-arrow-right-to-bracket text-xs"
                                        aria-hidden="true"></i> Realizar pré-cadastro</span>
                            </button>

                            <p class="mt-3 text-center text-xs font-body"
                                style="color:var(--txt-tertiary); line-height:1.5;">
                                <i class="fa-solid fa-shield-halved mr-1" aria-hidden="true"></i>
                                Seus dados são protegidos e utilizados apenas para o processo de matrícula.
                            </p>
                        </form>
                    </div>

                    <!-- ETAPA 3: SUCESSO -->
                    <div id="successArea" style="display:none;">
                        <div class="animate-in text-center">
                            <div class="mb-4 flex justify-center">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='16' fill='rgba(139,189,71,0.2)'/%3E%3Ccircle cx='32' cy='32' r='16' fill='rgba(139,189,71,0.12)' stroke='%238BBD47' stroke-width='2'/%3E%3Cpath d='M23 32l6 6 12-12' stroke='%238BBD47' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"
                                    alt="Sucesso" width="64" height="64" class="rounded-2xl"
                                    style="border:1px solid rgba(139,189,71,0.2);">
                            </div>
                            <h2 class="font-display font-800 text-2xl sm:text-3xl tracking-tight mb-2"
                                style="color:var(--txt-primary); line-height:1.2;">Pré-cadastro realizado!</h2>
                            <p class="font-body font-400 text-sm sm:text-base mb-6"
                                style="color:var(--txt-secondary); line-height:1.6;">Seus dados foram registrados com
                                sucesso em nosso sistema.</p>

                            <div class="rounded-xl p-4 mb-6 text-left"
                                style="background:rgba(255,173,2,0.06); border:1px solid rgba(255,173,2,0.2);"
                                role="alert">
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"
                                        style="background:rgba(255,173,2,0.12);" aria-hidden="true"><i
                                            class="fa-solid fa-location-dot text-sm" style="color:#FFAD02;"></i></div>
                                    <div>
                                        <p class="font-display font-600 text-sm mb-1" style="color:#FFAD02;">Compareça
                                            presencialmente</p>
                                        <p class="font-body font-400 text-sm"
                                            style="color:var(--txt-secondary); line-height:1.6;">
                                            Dirija-se a <strong style="color:var(--txt-primary);">Coordenação de Cursos</strong> <strong style="color:var(--txt-primary);">o
                                                mais breve possível</strong>. Lembre-se de
                                            portar documento de identificação com foto e comprovante de residência.
                                            Solicite a sua carteirinha de acesso ao aplicativo. Ela é o seu passaporte para o nosso <strong style="color:var(--txt-primary);">aplicativo exclusivo</strong>, onde você poderá realizar e acompanhar todas as suas matrículas de forma prática.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-xl p-4 mb-6 text-left"
                                style="background:rgba(139,189,71,0.04); border:1px solid rgba(139,189,71,0.1);">
                                <p class="font-display font-600 text-xs uppercase tracking-wider mb-2.5"
                                    style="color:var(--txt-tertiary);">Dados registrados</p>
                                <div class="space-y-1.5 text-sm font-body" style="color:var(--txt-secondary);">
                                    <p><span style="color:var(--txt-tertiary);">Nome:</span> <span id="resumoNome"
                                            class="font-500" style="color:var(--txt-primary);"></span></p>
                                    <p><span style="color:var(--txt-tertiary);">CPF:</span> <span id="resumoCPF"
                                            class="font-500" style="color:var(--txt-primary);"></span></p>
                                </div>
                            </div>

                            <button type="button" id="btnNovoCadastro"
                                class="w-full py-3.5 rounded-xl font-display flex items-center justify-center gap-2 btn-acao-local"
                                style="background: var(--verde, #8BBD47); color: var(--escuro, #0f172a); border: 1px solid transparent; cursor: pointer; transition: all 0.2s;">
                                <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i> Novo pré-cadastro
                            </button>
                        </div>
                    </div>

                    <!-- ETAPA 4: JÁ CADASTRADO (Duplicata) -->
                    <div id="duplicadoArea" style="display:none;">
                        <div class="animate-in text-center">
                            <!-- Ícone de Usuário Já Existente -->
                            <div class="mb-4 flex justify-center">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='16' fill='rgba(255,173,2,0.15)'/%3E%3Ccircle cx='32' cy='24' r='9' fill='%23FFAD02' opacity='0.8'/%3E%3Cpath d='M18 50c0-7.7 6.3-14 14-14s14 6.3 14 14' fill='%23FFAD02' opacity='0.4'/%3E%3Crect x='38' y='36' width='20' height='20' rx='4' fill='rgba(255,173,2,0.2)' stroke='%23FFAD02' stroke-width='1.5'/%3E%3Cpath d='M44 46l4 4 6-6' stroke='%23FFAD02' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"
                                    alt="Icone de usuario ja cadastrado" width="64" height="64"
                                    class="rounded-2xl" style="border:1px solid rgba(255,173,2,0.2);">
                            </div>

                            <h2 class="font-display font-800 text-2xl sm:text-3xl tracking-tight mb-2"
                                style="color:var(--txt-primary); line-height:1.2;">
                                Você já faz parte da nossa base!
                            </h2>
                            <p class="font-body font-400 text-sm sm:text-base mb-6"
                                style="color:var(--txt-secondary); line-height:1.6;">
                                Localizamos o seu registro em nosso sistema. Não é necessário realizar um novo cadastro.
                            </p>

                            <!-- Box de Orientação da Carteirinha/App -->
                            <div class="rounded-xl p-4 mb-6 text-left"
                                style="background:rgba(255,173,2,0.06); border:1px solid rgba(255,173,2,0.2);"
                                role="alert">
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"
                                        style="background:rgba(255,173,2,0.12);" aria-hidden="true">
                                        <i class="fa-solid fa-id-card-clip text-sm" style="color:#FFAD02;"></i>
                                    </div>
                                    <div>
                                        <p class="font-display font-600 text-sm mb-1" style="color:#FFAD02;">
                                            Solicite sua Carteirinha
                                        </p>
                                        <p class="font-body font-400 text-sm"
                                            style="color:var(--txt-secondary); line-height:1.6;">
                                            Dirija-se à <strong style="color:var(--txt-primary);">Coordenação de Cursos</strong> para solicitar a sua carteirinha de acesso ao aplicativo. Ela é o seu passaporte para o nosso <strong style="color:var(--txt-primary);">aplicativo exclusivo</strong>, onde você poderá realizar e acompanhar todas as suas matrículas de forma prática.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Dados localizados -->
                            <div class="rounded-xl p-4 mb-6 text-left"
                                style="background:rgba(139,189,71,0.04); border:1px solid rgba(139,189,71,0.1);">
                                <p class="font-display font-600 text-xs uppercase tracking-wider mb-2.5"
                                    style="color:var(--txt-tertiary);">Dados localizados</p>
                                <div class="space-y-1.5 text-sm font-body" style="color:var(--txt-secondary);">
                                    <p><span style="color:var(--txt-tertiary);">Nome:</span> <span id="resumoNomeDup" class="font-500" style="color:var(--txt-primary);"></span></p>
                                    <p><span style="color:var(--txt-tertiary);">CPF:</span> <span id="resumoCPFDup" class="font-500" style="color:var(--txt-primary);"></span></p>
                                </div>
                            </div>

                            <!-- Botão para tentar outro cadastro -->
                            <button type="button" id="btnNovoCadastroDup"
                                class="w-full py-3.5 rounded-xl font-display flex items-center justify-center gap-2 btn-acao-local"
                                style="background: var(--verde, #8BBD47); color: var(--escuro, #0f172a); border: 1px solid transparent; cursor: pointer; transition: all 0.2s;">
                                <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i> Realizar outro pré-cadastro
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Toast -->
    <div class="toast" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl shadow-2xl"
            style="background:rgba(30,41,59,0.97); backdrop-filter:blur(20px); border:1px solid rgba(139,189,71,0.15);">
            <div id="toastIcon" class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                style="background:rgba(139,189,71,0.12);" aria-hidden="true"><i class="fa-solid fa-check text-sm"
                    style="color:var(--verde);"></i></div>
            <div class="min-w-0">
                <p id="toastTitle" class="text-sm font-display font-600" style="color:var(--txt-primary);">Sucesso</p>
                <p id="toastMsg" class="text-sm font-body" style="color:var(--txt-secondary);">Mensagem</p>
            </div>
        </div>
    </div>

    <style>
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .hold-btn {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            position: relative;
            cursor: pointer;
            user-select: none;
            -webkit-user-select: none;
            -webkit-tap-highlight-color: transparent;
            touch-action: none;
            margin: 0 auto;
            outline: none;
        }

        .hold-btn:focus-visible {
            box-shadow: 0 0 0 3px rgba(139, 189, 71, 0.35);
        }

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(139, 189, 71, 0), 0 0 20px 0 rgba(139, 189, 71, 0);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(139, 189, 71, 0.06), 0 0 30px 4px rgba(139, 189, 71, 0.12);
            }
        }

        @keyframes pulseIcon {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        @keyframes pulseText {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .hold-btn:not(.active):not(.done):not(.fail) {
            animation: pulseGlow 2.4s ease-in-out infinite;
        }

        .hold-btn:not(.active):not(.done):not(.fail) .hold-icon {
            animation: pulseIcon 2.4s ease-in-out infinite;
        }

        .hold-btn:not(.active):not(.done):not(.fail)~.hold-text {
            animation: pulseText 2.4s ease-in-out infinite;
        }

        @media(prefers-reduced-motion:reduce) {

            .hold-btn,
            .hold-btn .hold-icon,
            .hold-btn~.hold-text {
                animation: none !important;
            }
        }

        .hold-ring {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .ring-bg {
            fill: none;
            stroke: rgba(255, 255, 255, 0.06);
            stroke-width: 3;
        }

        .ring-progress {
            fill: none;
            stroke: var(--verde, #8BBD47);
            stroke-width: 3;
            stroke-linecap: round;
            stroke-dasharray: 213.63;
            stroke-dashoffset: 213.63;
            transition: stroke-dashoffset 0.06s linear;
        }

        .hold-icon {
            position: absolute;
            inset: 8px;
            border-radius: 50%;
            background: rgba(139, 189, 71, 0.08);
            border: 1px solid rgba(139, 189, 71, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--verde, #8BBD47);
            font-size: 1.5rem;
            transition: background 0.3s, transform 0.15s, border-color 0.3s;
        }

        .hold-btn.active {
            animation: none;
            box-shadow: none;
        }

        .hold-btn.active .hold-icon {
            animation: none;
            background: rgba(139, 189, 71, 0.15);
            transform: scale(0.94);
            border-color: rgba(139, 189, 71, 0.3);
        }

        .hold-btn.done .hold-icon {
            animation: none;
            background: rgba(139, 189, 71, 0.22);
            border-color: rgba(139, 189, 71, 0.4);
        }

        .hold-btn.fail {
            animation: none;
            box-shadow: none;
        }

        .hold-btn.fail .ring-progress {
            stroke: #ef4444;
            transition: stroke-dashoffset 0.4s ease;
        }

        .hold-btn.fail .hold-icon {
            animation: none;
            background: rgba(239, 68, 68, 0.12);
            border-color: rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        .hold-text {
            text-align: center;
            font-family: var(--font-display, sans-serif);
            font-weight: 600;
            font-size: 0.9375rem;
            color: var(--txt-primary, #f1f5f9);
            margin-top: 1.25rem;
            transition: color 0.3s;
        }

        .hold-subtext {
            text-align: center;
            font-family: var(--font-body, sans-serif);
            font-weight: 400;
            font-size: 0.8125rem;
            color: var(--txt-tertiary, rgba(148, 163, 184, 0.6));
            margin-top: 0.25rem;
            transition: color 0.3s;
        }

        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--txt-secondary, #94a3b8);
            margin-bottom: 0.375rem;
            font-family: var(--font-body, sans-serif);
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 0.7rem 0.875rem 0.7rem 2.75rem;
            border-radius: 0.75rem;
            font-family: var(--font-body, sans-serif);
            font-size: 0.875rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--txt-primary, #f1f5f9);
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            box-sizing: border-box;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: rgba(139, 189, 71, 0.5);
            box-shadow: 0 0 0 3px rgba(139, 189, 71, 0.1);
        }

        .form-input::placeholder {
            color: var(--txt-tertiary, rgba(148, 163, 184, 0.55));
        }

        .form-select option {
            background: #1e293b;
            color: #f1f5f9;
        }

        .form-input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.7);
            cursor: pointer;
        }

        .form-input[type="date"]::-moz-calendar-picker-indicator {
            filter: invert(0.7);
            cursor: pointer;
        }

        .form-input.error,
        .form-select.error {
            border-color: rgba(239, 68, 68, 0.5);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.08);
        }

        .field-error {
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 0.25rem;
            font-family: var(--font-body, sans-serif);
            display: none;
            line-height: 1.4;
        }

        .field-error.visible {
            display: block;
        }

        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeSlideIn 0.45s ease forwards;
        }

        #verifyArea,
        #formArea {
            transition: opacity 0.35s ease, transform 0.35s ease;
        }

        /* ── Correção de contraste no hover dos botões de ação ── */
        #btnNovoCadastro.btn-search,
        #btnNovoCadastroDup.btn-search {
            color: var(--txt-primary, #f1f5f9) !important;
            transition: color 0.2s, background 0.2s;
        }
        
        #btnNovoCadastro.btn-search:hover,
        #btnNovoCadastroDup.btn-search:hover,
        #btnNovoCadastro.btn-search:focus-visible,
        #btnNovoCadastroDup.btn-search:focus-visible {
            color: var(--escuro, #0f172a) !important;
        }
        
        #btnNovoCadastro.btn-search i,
        #btnNovoCadastroDup.btn-search i {
            color: inherit !important;
            transition: color 0.2s;
        }

        /* ── Botões de ação local (sem conflito com .btn-search global) ── */
        .btn-acao-local:hover {
            background: var(--dourado, #FFAD02) !important;
            color: var(--escuro, #0f172a) !important;
            border-color: var(--dourado, #FFAD02) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 173, 2, 0.25);
        }
        .btn-acao-local:active {
            transform: translateY(0);
        }
    </style>

    <script>
        const CIRCUMFERENCE = 2 * Math.PI * 34;
        const HOLD_DURATION = 3000;
        const PRE_CADASTRO_URL = @json(url('/precadastro'));
        const VERIFICAR_URL = @json(url('/precadastro/verificar'));
        const VERIFY_TOKEN = @json($tokenVerificacao);

        const card3d = document.getElementById('card3d');
        const cardShine = document.getElementById('cardShine');
        const verifyArea = document.getElementById('verifyArea');
        const formArea = document.getElementById('formArea');
        const successArea = document.getElementById('successArea');
        const form = document.getElementById('formPreCadastro');
        const holdBtn = document.getElementById('holdBtn');
        const ringProgress = document.getElementById('ringProgress');
        const holdIcon = document.getElementById('holdIcon');
        const holdText = document.getElementById('holdText');
        const holdSubtext = document.getElementById('holdSubtext');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnSubmitMobile = document.getElementById('btnSubmitMobile');
        const btnContentDesk = document.getElementById('btnContentDesktop');
        const btnContentMob = document.getElementById('btnContentMobile');
        const btnNovoCadastro = document.getElementById('btnNovoCadastro');
        const toast = document.getElementById('toast');
        const toastIcon = document.getElementById('toastIcon');
        const toastTitle = document.getElementById('toastTitle');
        const toastMsg = document.getElementById('toastMsg');
        const btnNovoCadastroDup = document.getElementById('btnNovoCadastroDup');
        const duplicadoArea = document.getElementById('duplicadoArea');

        const campos = {
            nome_aluno: document.getElementById('nome_aluno'),
            cpf: document.getElementById('cpf'),
            data_nascimento: document.getElementById('data_nascimento'),
            sexo: document.getElementById('sexo'),
            telefone_celular: document.getElementById('telefone_celular'),
            nome_mae: document.getElementById('nome_mae'), // NOVO
            email: document.getElementById('email'),
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value;
        const isTouchDevice = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // --- EFEITO 3D ---
        let targetRotX = 0, targetRotY = 0, currentRotX = 0, currentRotY = 0;
        const LERP = isTouchDevice ? 0.02 : 0.04, MAX_ROT_X = isTouchDevice ? 1.5 : 4, MAX_ROT_Y = isTouchDevice ? 2 : 5;
        if (!isTouchDevice && !prefersReducedMotion) {
            document.addEventListener('mousemove', (e) => { const r = card3d.getBoundingClientRect(); targetRotY = ((e.clientX - r.left - r.width / 2) / (r.width / 2)) * MAX_ROT_Y; targetRotX = -((e.clientY - r.top - r.height / 2) / (r.height / 2)) * MAX_ROT_X; cardShine.style.setProperty('--mx', ((e.clientX - r.left) / r.width * 100) + '%'); cardShine.style.setProperty('--my', ((e.clientY - r.top) / r.height * 100) + '%'); });
            document.addEventListener('mouseleave', () => { targetRotX = 0; targetRotY = 0; });
        }
        if (!prefersReducedMotion) { (function anim() { currentRotX += (targetRotX - currentRotX) * LERP; currentRotY += (targetRotY - currentRotY) * LERP; card3d.style.transform = `rotateX(${currentRotX.toFixed(3)}deg) rotateY(${currentRotY.toFixed(3)}deg)`; requestAnimationFrame(anim); })(); }
        if (!isTouchDevice && !prefersReducedMotion) { (function () { const c = document.getElementById('particles'); if (!c) return; const cores = ['#8BBD47', '#FFAD02', '#BFFBAC', '#EF8E26']; for (let i = 0; i < 28; i++) { const p = document.createElement('div'); p.className = 'particle'; const s = Math.random() * 3 + 1.5, cor = cores[Math.floor(Math.random() * cores.length)]; p.style.cssText = `width:${s}px;height:${s}px;background:${cor};left:${Math.random() * 100}%;animation-duration:${Math.random() * 14 + 12}s;animation-delay:${Math.random() * 14}s;opacity:0;box-shadow:0 0 ${s * 2.5}px ${cor};`; c.appendChild(p); } })(); const orbs = document.querySelectorAll('.orb'); document.addEventListener('mousemove', (e) => { const cx = (e.clientX / window.innerWidth - 0.5) * 2, cy = (e.clientY / window.innerHeight - 0.5) * 2; orbs.forEach((o, i) => { const f = (i + 1) * 10; o.style.transform = `translate(${cx * f}px,${cy * f}px)`; }); }); }

        // --- TOAST ---
        let toastTimer = null;
        function showToast(type, title, msg) { clearTimeout(toastTimer); const cfg = { sucesso: { icon: 'fa-check', bg: 'rgba(139,189,71,0.12)', color: '#8BBD47' }, erro: { icon: 'fa-xmark', bg: 'rgba(239,68,68,0.12)', color: '#ef4444' }, aviso: { icon: 'fa-triangle-exclamation', bg: 'rgba(255,173,2,0.12)', color: '#FFAD02' } }; const c = cfg[type] || cfg.sucesso; toastIcon.style.background = c.bg; toastIcon.innerHTML = `<i class="fa-solid ${c.icon} text-sm" style="color:${c.color}"></i>`; toastTitle.textContent = title; toastMsg.textContent = msg; toast.classList.add('show'); toastTimer = setTimeout(() => toast.classList.remove('show'), 4500); }

        // --- VALIDAÇÃO DE CPF ---
        function validarCPF(str) { const cpf = str.replace(/\D/g, ''); if (cpf.length !== 11) return false; if (/^(\d)\1{10}$/.test(cpf)) return false; for (let t = 9; t < 11; t++) { let soma = 0; for (let i = 0; i < t; i++) { soma += parseInt(cpf.charAt(i)) * ((t + 1) - i); } let resto = (soma * 10) % 11; if (resto === 10) resto = 0; if (resto !== parseInt(cpf.charAt(t))) return false; } return true; }

        // --- BOTÃO DE SEGURAR ---
        let holdStartTime = null, holdRAF = null, holdCompleted = false;
        function startHold(e) { e.preventDefault(); if (holdCompleted) return; holdStartTime = performance.now(); holdBtn.classList.add('active'); holdBtn.classList.remove('done', 'fail'); holdText.textContent = 'Verificando...'; holdText.style.color = ''; holdSubtext.textContent = 'Continue segurando'; function tick(now) { if (!holdStartTime) return; const elapsed = now - holdStartTime; const progress = Math.min(elapsed / HOLD_DURATION, 1); ringProgress.style.strokeDashoffset = CIRCUMFERENCE * (1 - progress); if (progress >= 1) { completeHold(elapsed); } else { holdRAF = requestAnimationFrame(tick); } } holdRAF = requestAnimationFrame(tick); }
        function endHold(e) { e.preventDefault(); if (holdCompleted || !holdStartTime) return; cancelAnimationFrame(holdRAF); holdBtn.classList.remove('active'); if (holdStartTime) { const elapsed = performance.now() - holdStartTime; if (elapsed > 300) { holdBtn.classList.add('fail'); holdText.textContent = 'Interrompido'; holdText.style.color = '#ef4444'; holdSubtext.textContent = 'Segure até o fim para verificar'; setTimeout(resetHold, 1200); holdStartTime = null; return; } } resetHold(); }
        function completeHold(duracao) { cancelAnimationFrame(holdRAF); holdCompleted = true; holdBtn.classList.remove('active'); holdBtn.classList.add('done'); holdText.textContent = 'Verificado'; holdText.style.color = 'var(--verde, #8BBD47)'; holdSubtext.textContent = 'Carregando formulário...'; holdBtn.style.pointerEvents = 'none'; holdIcon.innerHTML = '<i class="fa-solid fa-check"></i>'; enviarVerificacao(Math.round(duracao)); }
        function resetHold() { holdCompleted = false; holdStartTime = null; holdBtn.classList.remove('active', 'done', 'fail'); holdBtn.style.pointerEvents = ''; holdIcon.innerHTML = '<i class="fa-solid fa-shield-halved"></i>'; holdText.textContent = 'Pressione e segure'; holdText.style.color = ''; holdSubtext.textContent = 'Segure por 3 segundos para verificar'; ringProgress.style.strokeDashoffset = CIRCUMFERENCE; ringProgress.style.stroke = ''; }
        async function enviarVerificacao(duracao) { try { const resp = await fetch(VERIFICAR_URL, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify({ token: VERIFY_TOKEN, duracao: duracao }), }); const data = await resp.json(); if (data.sucesso) { transitarPara('form'); } else { resetHold(); showToast('erro', 'Falha na verificação', data.mensagem || 'Tente novamente.'); } } catch (err) { resetHold(); showToast('erro', 'Erro de conexão', 'Verifique sua internet.'); } }
        holdBtn.addEventListener('mousedown', startHold); holdBtn.addEventListener('mouseup', endHold); holdBtn.addEventListener('mouseleave', endHold); holdBtn.addEventListener('touchstart', startHold, { passive: false }); holdBtn.addEventListener('touchend', endHold, { passive: false }); holdBtn.addEventListener('touchcancel', endHold, { passive: false });
        let keyHeld = false;
        holdBtn.addEventListener('keydown', (e) => { if ((e.key === ' ' || e.key === 'Enter') && !keyHeld) { e.preventDefault(); keyHeld = true; startHold(e); } });
        holdBtn.addEventListener('keyup', (e) => { if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); keyHeld = false; endHold(e); } });

        // --- TRANSIÇÃO ---
        function transitarPara(destino) { const saida = destino === 'form' ? verifyArea : formArea; const entrada = destino === 'form' ? formArea : successArea; saida.style.opacity = '0'; saida.style.transform = 'translateY(-10px)'; setTimeout(() => { saida.style.display = 'none'; if (destino === 'form') saida.closest('.card-inner').style.padding = '2.5rem 2rem 2rem'; entrada.style.display = 'block'; entrada.style.opacity = '0'; entrada.style.transform = 'translateY(12px)'; requestAnimationFrame(() => { entrada.style.opacity = '1'; entrada.style.transform = 'translateY(0)'; }); if (destino === 'form') setTimeout(() => campos.nome_aluno.focus(), 400); }, 350); }

        // --- MÁSCARAS ---
        function mascaraCPF(v) { v = v.replace(/\D/g, '').slice(0, 11); v = v.replace(/(\d{3})(\d)/, '$1.$2'); v = v.replace(/(\d{3})(\d)/, '$1.$2'); v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); return v; }
        function mascaraTel(v) { v = v.replace(/\D/g, '').slice(0, 11); if (v.length > 6) v = v.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3'); else if (v.length > 2) v = v.replace(/^(\d{2})(\d{0,5})/, '($1) $2'); return v; }
        campos.cpf.addEventListener('input', (e) => { e.target.value = mascaraCPF(e.target.value); limparErro('cpf'); });
        campos.telefone_celular.addEventListener('input', (e) => { e.target.value = mascaraTel(e.target.value); limparErro('telefone_celular'); });
        Object.keys(campos).forEach(n => { if (n !== 'cpf' && n !== 'telefone_celular') campos[n].addEventListener('input', () => limparErro(n)); if (campos[n].tagName === 'SELECT') campos[n].addEventListener('change', () => limparErro(n)); });
        campos.nome_mae.addEventListener('input', () => limparErro('nome_mae'));

        // --- ERROS INLINE ---
        function mostrarErro(nome, msg) { campos[nome]?.classList.add('error'); const el = document.getElementById('erro-' + nome); if (el) { el.textContent = msg; el.classList.add('visible'); } }
        function limparErro(nome) { campos[nome]?.classList.remove('error'); const el = document.getElementById('erro-' + nome); if (el) { el.textContent = ''; el.classList.remove('visible'); } }
        function limparTodosErros() { Object.keys(campos).forEach(limparErro); }

        // --- LOADING ---
        const loadingHTML = '<div class="spinner" aria-hidden="true"></div><span>Enviando...</span>';
        const idleDesk = '<i class="fa-solid fa-arrow-right-to-bracket text-xs" aria-hidden="true"></i> Realizar pré-cadastro';
        const idleMob = '<i class="fa-solid fa-arrow-right-to-bracket text-xs" aria-hidden="true"></i> Realizar pré-cadastro';
        function setLoading(on) { btnContentDesk.innerHTML = on ? loadingHTML : idleDesk; btnContentMob.innerHTML = on ? loadingHTML : idleMob; btnSubmit.disabled = btnSubmitMobile.disabled = on; btnSubmit.setAttribute('aria-busy', on); btnSubmitMobile.setAttribute('aria-busy', on); }
        window.addEventListener('pageshow', (e) => { if (e.persisted) setLoading(false); });

        // =============================================
        // LÓGICA DE IDADE (LGPD / ECA)
        // =============================================
        function calcularIdade(dataNasc) {
            const hoje = new Date();
            const nascimento = new Date(dataNasc + 'T00:00:00');
            let idade = hoje.getFullYear() - nascimento.getFullYear();
            const m = hoje.getMonth() - nascimento.getMonth();
            if (m < 0 || (m === 0 && hoje.getDate() < nascimento.getDate())) idade--;
            return idade;
        }

        // Variável de controle para saber se os campos do responsável estão visíveis
        let guardianEventosAtrelados = false;

        campos.data_nascimento.addEventListener('change', function () {
            const val = this.value;
            if (!val) {
                toggleGuardian(false);
                return;
            }
            const idade = calcularIdade(val);
            toggleGuardian(idade < 18);
        });

        function toggleGuardian(show) {
            const area = document.getElementById('guardianArea');

            // Registra os campos no objeto de validação e atrela eventos (apenas uma vez)
            if (!guardianEventosAtrelados) {
                campos.nome_responsavel = document.getElementById('nome_responsavel');
                campos.cpf_responsavel = document.getElementById('cpf_responsavel');
                campos.grau_parentesco = document.getElementById('grau_parentesco');
                campos.termo_responsavel = document.getElementById('termo_responsavel');

                campos.cpf_responsavel.addEventListener('input', (e) => { e.target.value = mascaraCPF(e.target.value); limparErro('cpf_responsavel'); });
                campos.nome_responsavel.addEventListener('input', () => limparErro('nome_responsavel'));
                campos.grau_parentesco.addEventListener('change', () => limparErro('grau_parentesco'));
                campos.termo_responsavel.addEventListener('change', () => limparErro('termo_responsavel'));
                guardianEventosAtrelados = true;
            }

            if (show) {
                area.style.display = 'block';
                area.style.opacity = '0';
                area.style.transform = 'translateY(10px)';
                requestAnimationFrame(() => {
                    area.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
                    area.style.opacity = '1';
                    area.style.transform = 'translateY(0)';
                });
            } else {
                area.style.display = 'none';
                // Limpa os campos ao esconder
                campos.nome_responsavel.value = '';
                campos.cpf_responsavel.value = '';
                campos.grau_parentesco.value = '';
                campos.termo_responsavel.checked = false;
                limparErro('nome_responsavel');
                limparErro('cpf_responsavel');
                limparErro('grau_parentesco');
                limparErro('termo_responsavel');
            }
        }

        // --- VALIDAÇÃO CLIENT-SIDE ---
        function validarForm() {
            let ok = true;
            limparTodosErros();

            if (!campos.nome_aluno.value.trim()) { mostrarErro('nome_aluno', 'O nome é obrigatório.'); ok = false; }
            if (!campos.nome_mae.value.trim()) { mostrarErro('nome_mae', 'O nome da mãe é obrigatório.'); ok = false; } // NOVO
            const cpfDigitos = campos.cpf.value.replace(/\D/g, '');
            if (!cpfDigitos) { mostrarErro('cpf', 'O CPF é obrigatório.'); ok = false; }
            else if (cpfDigitos.length !== 11) { mostrarErro('cpf', 'O CPF deve conter 11 dígitos.'); ok = false; }
            else if (!validarCPF(cpfDigitos)) { mostrarErro('cpf', 'CPF inválido. Verifique os números digitados.'); ok = false; }

            if (!campos.data_nascimento.value) { mostrarErro('data_nascimento', 'A data de nascimento é obrigatória.'); ok = false; }
            if (!campos.sexo.value) { mostrarErro('sexo', 'Selecione o sexo.'); ok = false; }
            const telDigitos = campos.telefone_celular.value.replace(/\D/g, '');
            if (!telDigitos) { mostrarErro('telefone_celular', 'O telefone celular é obrigatório.'); ok = false; }
            else if (telDigitos.length < 10) { mostrarErro('telefone_celular', 'Informe um telefone válido.'); ok = false; }
            if (campos.email.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(campos.email.value)) { mostrarErro('email', 'Informe um e-mail válido.'); ok = false; }

            // ── Validação do Responsável (se visível) ──
            const isMenor = document.getElementById('guardianArea').style.display !== 'none';

            if (isMenor) {
                if (!campos.nome_responsavel.value.trim()) { mostrarErro('nome_responsavel', 'O nome do responsável é obrigatório.'); ok = false; }
                const cpfRespDigitos = campos.cpf_responsavel.value.replace(/\D/g, '');
                if (!cpfRespDigitos) { mostrarErro('cpf_responsavel', 'O CPF do responsável é obrigatório.'); ok = false; }
                else if (!validarCPF(cpfRespDigitos)) { mostrarErro('cpf_responsavel', 'CPF do responsável inválido.'); ok = false; }
                // ── NOVA REGRA: CPF do responsável não pode ser igual ao do candidato ──
                else if (cpfDigitos === cpfRespDigitos) { mostrarErro('cpf_responsavel', 'O CPF do responsável não pode ser igual ao do candidato.'); ok = false; }

                if (!campos.grau_parentesco.value) { mostrarErro('grau_parentesco', 'Selecione o parentesco.'); ok = false; }
                if (!campos.termo_responsavel.checked) { mostrarErro('termo_responsavel', 'Você deve aceitar o termo de responsabilidade.'); ok = false; }
            }

            return ok;
        }

        // --- ENVIO DO FORMULÁRIO ---
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!validarForm()) { showToast('aviso', 'Campos inválidos', 'Verifique os campos marcados.'); form.querySelector('.error')?.focus(); return; }

            const isMenor = document.getElementById('guardianArea').style.display !== 'none';

            setLoading(true);
            try {
                const resp = await fetch(PRE_CADASTRO_URL, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({
                        nome_aluno: campos.nome_aluno.value.trim(),
                        nome_mae: campos.nome_mae.value.trim(), // NOVO
                        cpf: campos.cpf.value,
                        data_nascimento: campos.data_nascimento.value,
                        sexo: campos.sexo.value,
                        telefone_celular: campos.telefone_celular.value,
                        email: campos.email.value.trim() || null,
                        // Envia dados do responsável apenas se for menor de idade
                        ...(isMenor ? {
                            nome_responsavel: campos.nome_responsavel.value.trim(),
                            cpf_responsavel: campos.cpf_responsavel.value,
                            grau_parentesco: campos.grau_parentesco.value,
                            termo_responsavel: 'on',
                        } : {})
                    }),
                });
                const data = await resp.json();

                if (resp.ok && data.sucesso) {
                    document.getElementById('resumoNome').textContent = campos.nome_aluno.value.trim();
                    document.getElementById('resumoCPF').textContent = campos.cpf.value;
                    formArea.style.display = 'none';
                    successArea.style.display = 'block';
                    successArea.closest('.card-inner').style.padding = '3rem 2.5rem';
                    showToast('sucesso', 'Pré-cadastro realizado!', 'Seus dados foram registrados.');
                } else if (data.duplicado) { // ── NOVA LÓGICA: Aluno já cadastrado (Duplicata) ──
                    document.getElementById('resumoNomeDup').textContent = data.aluno.nome_aluno;
                    
                    // Formata o CPF para exibir bonitinho na tela
                    let cpfFormatado = data.aluno.cpf.replace(/\D/g, '');
                    if(cpfFormatado.length === 11) {
                        cpfFormatado = cpfFormatado.replace(/(\d{3})(\d)/, '$1.$2');
                        cpfFormatado = cpfFormatado.replace(/(\d{3})(\d)/, '$1.$2');
                        cpfFormatado = cpfFormatado.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    }
                    document.getElementById('resumoCPFDup').textContent = cpfFormatado;

                    formArea.style.display = 'none';
                    duplicadoArea.style.display = 'block';
                    duplicadoArea.closest('.card-inner').style.padding = '3rem 2.5rem';
                    
                    showToast('aviso', 'Cadastro localizado', 'Identificamos que você já está em nossa base.');
                } else if (data.errors) {
                    limparTodosErros();
                    let primeiro = null;
                    Object.entries(data.errors).forEach(([c, msgs]) => {
                        if (campos[c]) { mostrarErro(c, msgs[0]); if (!primeiro) primeiro = campos[c]; }
                    });
                    if (primeiro) primeiro.focus();
                    showToast('erro', 'Dados inválidos', data.mensagem || 'Corrija os campos destacados.');
                } else {
                    showToast('erro', 'Erro', data.mensagem || 'Tente novamente.');
                }
            } catch (err) {
                showToast('erro', 'Falha na conexão', 'Verifique sua internet.');
            } finally {
                setLoading(false);
            }
        });

        // --- NOVO PRÉ-CADASTRO ---
        btnNovoCadastro.addEventListener('click', () => { window.location.href = @json(route('precadastro.index')); });

        // --- NOVO PRÉ-CADASTRO (Vindo da tela de duplicata) ---
        btnNovoCadastroDup.addEventListener('click', () => { 
            window.location.href = @json(route('precadastro.index')); 
        });
        
        // --- FOCO INICIAL ---
        window.addEventListener('load', () => { setTimeout(() => { if (verifyArea.style.display !== 'none') holdBtn.focus(); else campos.nome_aluno.focus(); }, 800); });
        
        
    </script>
</x-layoutvaga>