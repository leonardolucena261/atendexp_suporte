<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carteirinha — Cidade do Saber</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Sora:wght@200;400;600;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { verde: '#8BBD47', escuro: '#1E293B', claro: '#F9F9F9' }, fontFamily: { display: ['Sora', 'sans-serif'], body: ['Space Grotesk', 'sans-serif'] } } } }
    </script>
    <style>
        :root {
            --verde: #8BBD47;
            --escuro: #1E293B;
            --txt-dark: #0F172A;
            --txt-body: #334155;
            --txt-muted: #64748B;
            --border: #CBD5E1;
            --border-light: #E2E8F0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--claro);
            color: var(--txt-body);
        }

        .screen-only { display: block; }
        .print-only { display: none !important; }

        /* ===== BARRA DE AÇÕES ===== */
        .print-controls {
            max-width: 1200px; margin: 1.5rem auto; padding: 0 1rem;
            display: flex; justify-content: space-between; align-items: center; gap: 0.75rem;
        }
        .btn-voltar {
            padding: 0.6rem 1.2rem; border-radius: 0.5rem; border: 1.5px solid var(--border);
            background: white; color: var(--txt-body); font-family: 'Sora'; font-weight: 600;
            cursor: pointer; display: flex; align-items: center; gap: 0.5rem; text-decoration: none; transition: all 0.2s;
        }
        .btn-voltar:hover { border-color: var(--verde); color: #4d7c0f; background: rgba(139, 189, 71, 0.05); }
        .btn-print {
            padding: 0.6rem 1.2rem; border-radius: 0.5rem; border: none;
            background: var(--escuro); color: white; font-family: 'Sora'; font-weight: 600;
            cursor: pointer; display: flex; align-items: center; gap: 0.5rem;
        }
        .btn-print:hover { background: #152033; }

        /* ===== LAYOUT FLEX (TELA) ===== */
        .content-wrapper {
            max-width: 1200px; margin: 0 auto 2rem; padding: 0 1rem;
            display: flex; gap: 2rem; align-items: flex-start;
        }
        .cards-grid { flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .history-panel { width: 320px; flex-shrink: 0; position: sticky; top: 100px; }
        .history-card {
            background: white; border-radius: 1.25rem; padding: 1.25rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04); border: 1px solid var(--border-light);
        }
        .history-card h3 {
            font-family: 'Sora'; font-weight: 700; font-size: 0.875rem; color: var(--txt-dark);
            margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;
            padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-light);
        }
        .hist-item { display: flex; justify-content: space-between; align-items: center; padding: 0.6rem 0; border-bottom: 1px dashed var(--border-light); }
        .hist-item:last-child { border-bottom: none; }
        .hist-num { font-family: 'Sora'; font-weight: 700; font-size: 0.75rem; color: var(--txt-dark); }
        .hist-status { font-size: 0.625rem; font-weight: 700; padding: 0.15rem 0.5rem; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.05em; }
        .hist-status.ativa { background: rgba(139, 189, 71, 0.12); color: #4d7c0f; border: 1px solid rgba(139, 189, 71, 0.2); }
        .hist-status.invalidada { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .hist-date { font-size: 0.688rem; color: var(--txt-muted); }
        .hist-motivo { font-size: 0.625rem; color: #94a3b8; margin-top: 0.125rem; font-style: italic; }

        /* ===== CARD DA CARTEIRINHA ===== */
        .card-container {
            background: white; border-radius: 1.25rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 1.5rem; border: 1px solid #e2e8f0; position: relative; overflow: hidden;
        }
        .card-header {
            background: #f8fafc; border-bottom: 2px solid var(--escuro); padding: 1rem;
            display: flex; justify-content: space-between; align-items: center; margin: -1.5rem -1.5rem 1.5rem -1.5rem;
        }
        .inst-info h2 { font-family: 'Sora'; font-weight: 800; font-size: 0.95rem; color: var(--txt-dark); line-height: 1.1; letter-spacing: 0.02em; }
        .inst-info p { font-size: 0.7rem; color: var(--txt-body); font-weight: 500; letter-spacing: 0.05em; }
        .svg-brasao { width: 65px; height: auto; object-fit: contain; }
        .card-body { display: flex; flex-direction: column; align-items: center; text-align: center; }
        .card-title {
            font-family: 'Sora'; font-weight: 800; font-size: 0.8rem; color: var(--txt-dark);
            text-transform: uppercase; letter-spacing: 0.15em; margin: 1rem 0 1.25rem 0; padding: 0.4rem 0;
            border-bottom: 2px solid var(--escuro);
        }
        .qr-container { background: white; padding: 0.5rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; margin-bottom: 1rem; }
        .data-grid { width: 100%; text-align: left; font-size: 0.7rem; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 0.75rem 0; margin-bottom: 1rem; }
        .data-row { display: flex; justify-content: space-between; margin-bottom: 0.35rem; }
        .data-label { font-weight: 600; color: var(--txt-body); }
        .data-value { color: var(--txt-dark); font-weight: 700; text-transform: uppercase; }
        .card-footer {
            background: #f8fafc; border-top: 1px dashed #cbd5e1; padding: 0.75rem;
            margin: 1.5rem -1.5rem -1.5rem -1.5rem; border-radius: 0 0 1.25rem 1.25rem;
            display: flex; justify-content: space-between; align-items: flex-end;
        }
        .validade-box { text-align: left; }
        .validade-title { font-size: 0.6rem; font-weight: 600; color: var(--txt-body); text-transform: uppercase; }
        .validade-date { font-size: 0.85rem; font-weight: 800; color: var(--txt-dark); font-family: 'Sora'; }
        .aviso { font-size: 0.55rem; color: #dc2626; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; line-height: 1.3; text-align: right; max-width: 120px; }

        /* ===== TERMO JURÍDICO ===== */
        .termo-container {
            max-width: 1200px; margin: 2rem auto; padding: 0 1rem;
        }
        .termo-paper {
            background: white; padding: 2.5rem; border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid var(--border-light);
            font-size: 0.875rem; line-height: 1.6; color: var(--txt-body);
        }
        .termo-paper h2 {
            font-family: 'Sora'; font-weight: 800; font-size: 1.25rem; color: var(--txt-dark);
            text-align: center; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .termo-subtitulo {
            text-align: center; font-size: 0.8rem; color: var(--txt-muted); margin-bottom: 2rem;
            padding-bottom: 1rem; border-bottom: 2px solid var(--escuro);
        }
        .termo-paper h3 {
            font-family: 'Sora'; font-weight: 700; font-size: 0.95rem; color: var(--escuro);
            margin-top: 1.5rem; margin-bottom: 0.75rem;
        }
        .termo-paper p { margin-bottom: 0.75rem; text-align: justify; }
        .termo-paper ul { margin-left: 1.5rem; margin-bottom: 1rem; }
        .termo-paper li { margin-bottom: 0.5rem; }
        .termo-highlight {
            background: rgba(139, 189, 71, 0.08); border-left: 3px solid var(--verde);
            padding: 1rem 1.25rem; border-radius: 0 0.5rem 0.5rem 0; margin: 1rem 0;
        }
        .assinatura-area {
            margin-top: 3rem; padding-top: 1.5rem; border-top: 1px solid var(--border);
        }
        .grid-assinaturas {
            display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-top: 3rem;
        }
        .bloco-assinatura h4 { font-size: 0.8rem; font-weight: 600; color: var(--txt-dark); margin-bottom: 0.25rem; }
        .bloco-assinatura p { font-size: 0.75rem; color: var(--txt-muted); margin-bottom: 0; text-align: left; }
        .linha-assinatura { border-bottom: 1px solid var(--txt-dark); height: 50px; margin-top: 0.5rem; }

        /* ===== IMPRESSÃO ===== */
        @media print {
            @page { size: A4 portrait; margin: 10mm; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; color-adjust: exact !important; }
            body { background: white !important; margin: 0; padding: 0; }
            .screen-only { display: none !important; }
            .print-only { display: flex !important; }
            .print-controls { display: none !important; }
            .content-wrapper { display: block !important; max-width: 100%; margin: 0; padding: 0; gap: 0; }
            .history-panel { display: none !important; }
            
            .cards-grid { display: grid !important; grid-template-columns: repeat(2, 85.6mm); gap: 10mm; max-width: 100%; margin: 0 auto; }
            .card-container { box-shadow: none; border: 1.5pt solid #000; border-radius: 4mm; padding: 6mm; page-break-inside: avoid; break-inside: avoid; overflow: hidden; }
            .card-header { margin: -6mm -6mm 5mm -6mm; border-bottom-width: 2pt; }
            .inst-info h2 { font-size: 8.5pt; }
            .inst-info p { font-size: 6.5pt; }
            .svg-brasao { width: 20mm !important; height: auto !important; }
            .card-title { font-size: 7pt; margin-bottom: 3mm; }
            .card-body p { font-size: 5.5pt !important; margin: 1mm 0 3mm 0 !important; }
            .qr-container { border-width: 1pt; padding: 1.5mm; margin: 0 auto 4mm auto; display: inline-block; }
            .qr-container canvas, .qr-container img { width: 40mm !important; height: 40mm !important; display: block; }
            .data-grid { font-size: 7pt; padding: 2mm 0; margin-bottom: 3mm; }
            .card-footer { margin: -6mm -6mm -6mm -6mm; border-top-width: 0.5pt; padding: 4mm; }
            .validade-date { font-size: 8pt; }
            .aviso { font-size: 5pt; }

            /* ESTILO DO TERMO AO IMPRIMIR */
            .termo-container { margin: 0; padding: 0; page-break-before: always; }
            .termo-paper { box-shadow: none; border: none; padding: 0; font-size: 10pt; line-height: 1.5; }
            .termo-paper h2 { font-size: 14pt; margin-bottom: 0; }
            .termo-subtitulo { font-size: 9pt; }
            .termo-paper h3 { font-size: 11pt; margin-top: 1rem; }
            .termo-highlight { background: #f1f5f9 !important; border-left-width: 2pt; }
            .assinatura-area { margin-top: 2rem; }
            .grid-assinaturas { gap: 2rem; }
        }
    </style>
</head>

<body>

    {{-- BARRA DE AÇÕES (SÓ TELA) --}}
    <div class="print-controls screen-only">
        <a href="{{ route('aluno.index') }}" class="btn-voltar" title="Voltar para lista de alunos">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
        <h1 style="font-family:'Sora'; font-weight:800; font-size:1.2rem;">Emissão de Carteirinha</h1>
        <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print"></i> Imprimir Carteira e Termo</button>
    </div>

    {{-- LAYOUT FLEX (CARTÕES + HISTÓRICO) --}}
    <div class="content-wrapper">
        <div class="cards-grid">
            <div class="card-container">
                <div class="card-header">
                    <div class="inst-info">
                        <h2>PREFEITURA DE CAMAÇARI</h2>
                        <p>SECRETARIA DE CULTURA, ESPORTE E LAZER</p>
                    </div>
                    <img src="/images/brasao.png" alt="Brasao Prefeitura de Camacari" class="svg-brasao" crossorigin="anonymous">
                </div>
                <div class="card-body">
                    <div class="card-title">Carteira de Identificação Estudantil</div>
                    <div class="qr-container">
                        <div id="qr-{{ $carteirinha->id }}" data-url="{{ route('carteirinha.app', [$carteirinha->uuid]) }}" style="width:140px; height:140px;"></div>
                    </div>
                    <p style="font-size:0.6rem; color:#64748B; margin-bottom:1rem;">Aponte a câmera para verificar autenticidade</p>
                    <div class="data-grid">
                        <div class="data-row">
                            <span class="data-label">Nome</span>
                            <span class="data-value">{{ strtoupper($carteirinha->aluno->nome_aluno ?? $carteirinha->aluno->nome) }}</span>
                        </div>
                        @if($carteirinha->aluno->cpf)
                        <div class="data-row">
                            <span class="data-label">CPF</span>
                            <span class="data-value">{{ $carteirinha->aluno->cpf }}</span>
                        </div>
                        @endif
                        @if($carteirinha->aluno->nome_mae)
                        <div class="data-row">
                            <span class="data-label">Filiação materna</span>
                            <span class="data-value">{{ $carteirinha->aluno->nome_mae }}</span>
                        </div>
                        @endif
                        <div class="data-row">
                            <span class="data-label">Nascimento</span>
                            <span class="data-value">{{ \Carbon\Carbon::parse($carteirinha->aluno->data_nascimento)->format('d/m/Y') }}</span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Nº Carteira</span>
                            <span class="data-value">{{ $carteirinha->numero_carteirinha }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="validade-box">
                        <div class="validade-title">Validade</div>
                        <div class="validade-date">{{ \Carbon\Carbon::parse($carteirinha->data_validade)->format('d/m/Y') }}</div>
                    </div>
                    <div class="aviso">
                        <i class="fa-solid fa-lock" style="margin-right:3px; font-size:0.5rem;" aria-hidden="true"></i>
                        Pessoal e<br>Intransferível
                    </div>
                </div>
            </div>
        </div>

        <aside class="history-panel screen-only" aria-label="Historico de carteirinhas">
            <div class="history-card">
                <h3><i class="fa-solid fa-clock-rotate-left" style="color:var(--verde);" aria-hidden="true"></i> Historico de Carteirinhas</h3>
                @forelse($historico as $hist)
                    <div class="hist-item">
                        <div>
                            <div class="hist-num">{{ $hist->numero_carteirinha }}</div>
                            <div class="hist-date">{{ \Carbon\Carbon::parse($hist->created_at)->format('d/m/Y H:i') }}</div>
                        </div>
                        <span class="hist-status {{ $hist->situacao === 'ATIVA' ? 'ativa' : 'invalidada' }}">{{ $hist->situacao }}</span>
                    </div>
                    @if($hist->motivo_invalidacao)
                        <div class="hist-motivo"><i class="fa-solid fa-comment-slash" style="margin-right:3px; font-size:0.55rem;" aria-hidden="true"></i> Motivo: {{ $hist->motivo_invalidacao }}</div>
                    @endif
                @empty
                    <p style="font-size:0.813rem; color:var(--txt-muted); text-align:center; padding:1rem 0;">Nenhuma carteirinha emitida para este aluno.</p>
                @endforelse
            </div>
        </aside>
    </div>

    {{-- ==================================================================== --}}
    {{-- DOCUMENTO JURÍDICO: TERMO DE CONSENTIMENTO E USO DO APLICATIVO --}}
    {{-- ==================================================================== --}}
    <div class="termo-container">
        <div class="termo-paper">
            <h2>Termo de Consentimento e Uso</h2>
            <p class="termo-subtitulo">Carteira de Identificação Estudantil Digital — Cidade do Saber</p>

            <p><strong>Pelo presente instrumento particular,</strong> de um lado a <strong>Prefeitura Municipal de Camaçari</strong>, por intermédio da Secretaria de Cultura, Esporte e Lazer, doravante denominada simplesmente <strong>INSTITUIÇÃO</strong>; e de outro, o(a) aluno(a) ou seu Responsável Legal, identificado(a) abaixo, doravante denominado(a) <strong>USUÁRIO</strong>, firmam o presente Termo de Consentimento e Uso, conforme as seguintes cláusulas e condições:</p>

            <h3>1. Identificação e Consentimento para Menores de Idade (ECA Digital)</h3>
            <div class="termo-highlight">
                <strong>Atenção para menores de 18 anos:</strong> Nos termos do Art. 14 da Lei Geral de Proteção de Dados (LGPD) e do Marco Civil da Internet (ECA Digital), o tratamento de dados de crianças e adolescentes requer consentimento específico e em destaque. A emissão da Carteirinha Digital para menores será realizada <strong>exclusivamente ao Responsável Legal</strong>, que assina este termo assumindo total ciência e responsabilidade pelo uso do aplicativo e dos dados aqui tratados.
            </div>
            <p><strong>Responsável Legal Presente:</strong> Declaro que sou maior de 18 anos, possuo o poder familiar ou guarda legal do(a) aluno(a) identificado(a) na carteirinha anexa, e autorizo expressamente a coleta, utilização e o acesso via aplicativo mobile dos dados escolares do(a) menor, ciente de que posso revogar este consentimento a qualquer momento mediante solicitação formal à Coordenação de Cursos.</p>

            <h3>2. Mecanismos de Verificação e Assinatura</h3>
            <p>A autenticidade deste termo é validada mediante as seguintes verificações obrigatórias no ato da emissão presencial:</p>
            <ul>
                <li>Apresentação de documento de identificação com foto (RG ou CPF) do(a) USUÁRIO ou Responsável Legal;</li>
                <li>Cruzamento dos dados de identificação com o sistema de matrícula interno da Instituição;</li>
                <li>Assinatura física (manuscrita) ao final deste documento, atestando a ciência inequívoca dos termos.</li>
            </ul>

            <h3>3. Linguagem Clara e Acessível</h3>
            <p>A Instituição compromete-se a utilizar uma linguagem clara, acessível e livre de excessos técnicos neste e em demais documentos que tratem do uso de dados pessoais, cumprindo o princípio da transparência (Art. 6º, VI, LGPD), garantindo que o USUÁRIO compreenda exatamente como suas informações são utilizadas.</p>

            <h3>4. Gestão de Direitos e Deveres (Uso, Perda, Roubo e Invalidação)</h3>
            <p>O USUÁRIO tem total controle sobre a sua Carteirinha Digital e assume as seguintes responsabilidades:</p>
            <ul>
                <li><strong>Dever de Zelo:</strong> A Carteirinha e seu QR Code são <strong>pessoais e intransferíveis</strong>. O USUÁRIO é o único responsável por manter o documento em local seguro.</li>
                <li><strong>Perda, Roubo ou Extravio:</strong> Em caso de perda, roubo ou extravio, o USUÁRIO (ou Responsável Legal) <strong>deve adotar imediatamente as medidas legais cabíveis</strong> (ex: registro de boletim de ocorrência) e <strong>comunicar a Coordenação de Cursos de forma presencial ou oficial</strong>.</li>
                <li><strong>Invalidação de Segurança:</strong> Uma vez comunicada a perda, a Instituição executará a invalidação imediata da carteirinha no banco de dados. Isso <strong>impossibilitará definitivamente que terceiros acessarem o aplicativo exclusivo</strong> do aluno por meio daquele QR Code.</li>
                <li><strong>Nova Emissão:</strong> Após a invalidação por perda/roubo e comprovação de identidade do portador legal, uma nova carteirinha válida será gerada, garantindo a continuidade do acesso aos serviços sem prejuízo ao aluno.</li>
            </ul>

            <h3>5. Minimização de Dados</h3>
            <p>Em conformidade com o Art. 6º, III, da LGPD (Princípio da Necessidade), o sistema da Carteirinha Digital processa apenas o estritamente essencial para sua finalidade educacional: identificação básica, vínculo com matrículas ativas e geração de tokens temporários. Dados sensíveis (saúde, biometria, filiação detalhada além do necessário) não são captados por este módulo, sendo tratados em esferas específicas de saúde escolar mediante autorização distinta.</p>

            <h3>6. Segurança, Criptografia e Anonimização</h3>
            <p>As seguintes medidas técnicas e administrativas são aplicadas para proteger os dados do USUÁRIO:</p>
            <ul>
                <li><strong>Criptografia em Trânsito:</strong> Toda comunicação entre o aplicativo e os servidores utiliza certificados TLS/HTTPS, criptografando os dados enviados e recebidos.</li>
                <li><strong>Tokens Temporários:</strong> O acesso a funcionalidades sensíveis (matrícula) não utiliza senhas permanentes, mas tokens numéricos de 6 caracteres que expiram em poucas horas.</li>
                <li><strong>UUID de Acesso:</strong> O QR Code da carteirinha é gerado através de um identificador único universal (UUID) criptograficamente seguro, impossibilitando a adivinhação de carteirinhas de outros alunos.</li>
                <li><strong>Anonimização:</strong> Dados utilizados para fins estatísticos gerais da Prefeitura passam por processos de anonimização, tornando impossível a identificação do titular.</li>
            </ul>

            <h3>7. Termos de Uso do Aplicativo e Política de Vagas</h3>
            <p>Ao escanear o QR Code e acessar o ambiente digital, o USUÁRIO concorda que:</p>
            <ul>
                <li>O aplicativo atua apenas como interface de visualização de histórico e emissão de tokens de matrícula;</li>
                <li>A reserva de vagas em turmas ocorre mediante a retirada presencial de uma "Senha Física de Vaga" na unidade, que deve ser inserida no aplicativo;</li>
                <li>A Instituição reserva-se o direito de invalidar o acesso digital (bloqueio do QR Code) a qualquer tempo mediante indícios de fraude, uso indevido por terceiros ou determinação judicial.</li>
            </ul>

            <h3>8. Mapeamento de Dados (Data Mapping)</h3>
            <p>Para garantir a transparência do ciclo de vida das informações, documentamos abaixo a trajetória dos dados dentro deste sistema:</p>
            <ul>
                <li><strong>Entrada (Coleta):</strong> Dados inseridos via formulário web de pré-cadastro pelo próprio usuário, ou digitados presencialmente por atendentes autorizados da Coordenação de Cursos.</li>
                <li><strong>Armazenamento:</strong> Servidores banco de dados relacionais protegidos por firewall, localizados exclusivamente em data centers no Brasil, com backups diários criptografados.</li>
                <li><strong>Acesso:</strong> Restrito ao próprio USUÁRIO (via aplicativo, visualizando apenas seu próprio histórico), a servidores automatizados do sistema (para validação de tokens) e a funcionários públicos da Coordenação de Cursos devidamente autorizados para gestão administrativa.</li>
                <li><strong>Descarte:</strong> Os dados pessoais são mantidos pelo tempo estritamente necessário para o cumprimento das finalidades educacionais e obrigações legais (prazos prescricionais da Lei de Arquivos Públicos). Após esse período, os dados são eliminados de forma segura ou anonimizados para fins estatísticos permanentes.</li>
            </ul>

            <h3>9. Nomeação do Encarregado (DPO)</h3>
            <div class="termo-highlight">
                Em cumprimento ao Art. 41 da LGPD, a Instituição nomeia publicamente o seu Encarregado pelo Tratamento de Dados Pessoais (DPO), que atuará como canal oficial de comunicação entre os usuários, a Prefeitura e a Autoridade Nacional de Proteção de Dados (ANPD):
                <br><br>
                <strong>Antônio Jorge Lopes de Almeida Junior</strong><br>
                Cargo: Chefe do Departamento Jurídico — Secretaria de Cultura, Esporte e Lazer.<br>
                Matrícula Funcional nº: <strong>848581</strong>.<br>
                <em>Para exercer seus direitos de acesso, correção, eliminação ou revogação de consentimento, entre em contato pelos canais oficiais da Prefeitura de Camaçari solicitando falar com o DPO.</em>
            </div>

            <div class="assinatura-area">
                <p style="font-size: 0.8rem; margin-bottom: 0;">E, por estar de acordo com todos os termos acima, assinam o presente documento:</p>
                
                <div class="grid-assinaturas">
                    <div class="bloco-assinatura">
                        <h4>Camaçari - BA, ____ de ______________ de ______</h4>
                        <div class="linha-assinatura"></div>
                        <p><strong>USUÁRIO ou RESPONSÁVEL LEGAL</strong></p>
                        <p>Nome: {{ strtoupper($carteirinha->aluno->nome_aluno ?? $carteirinha->aluno->nome) }}</p>
                        <p>CPF: {{ $carteirinha->aluno->cpf ?? 'Não informado no cadastro' }}</p>
                    </div>
                    <div class="bloco-assinatura">
                        <h4>Camaçari - BA, ____ de ______________ de ______</h4>
                        <div class="linha-assinatura"></div>
                        <p><strong>COORDENAÇÃO DE CURSOS</strong></p>
                        <p>Nome do Responsável pela Entrega:</p>
                        <p>Matrícula Funcional:</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-url]').forEach(function (el) {
                new QRCode(el, {
                    text: el.getAttribute('data-url'),
                    width: 140, height: 140,
                    colorDark: '#0f172a', colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });
            });
        });
    </script>

</body>

</html>