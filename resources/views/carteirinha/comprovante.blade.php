<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Comprovante de Matrícula — Cidade do Saber</title>
    
    <!-- PWA Tags -->
    <meta name="theme-color" content="#1E293B">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Sora:wght@200;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { verde: '#8BBD47', dourado: '#FFAD02', escuro: '#1E293B' },
                    fontFamily: { display: ['Sora','sans-serif'], body: ['Space Grotesk','sans-serif'] }
                }
            }
        }
    </script>
    <style>
        :root { --verde: #8BBD47; --dourado: #FFAD02; --escuro: #1E293B; --txt-primary: #F1F5F9; --txt-secondary: #CBD5E1; --txt-muted: #64748B; }
        body { font-family: 'Space Grotesk', sans-serif; background: var(--escuro); color: var(--txt-primary); }
        
        .detail-card { background: rgba(15,23,42,0.5); border: 1px solid rgba(139,189,71,0.08); border-radius: 0.875rem; padding: 1rem; }
        .detail-label { font-size: 0.688rem; color: var(--txt-muted); text-transform: uppercase; letter-spacing: 0.06em; font-weight: 500; }
        .detail-value { font-family: 'Sora', sans-serif; font-weight: 600; font-size: 0.938rem; color: var(--txt-primary); line-height: 1.3; }

        /* ==========================================
           MAGICA DO PDF: ESTILOS DE IMPRESSÃO
           ========================================== */
        @media print {
            body { background: white !important; color: black !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; } /* Esconde botões ao imprimir */
            .print-area { box-shadow: none !important; border: 2px solid #333 !important; background: white !important; padding: 2rem !important; }
            .detail-card { background: #f9f9f9 !important; border: 1px solid #ddd !important; }
            .detail-label { color: #666 !important; }
            .detail-value { color: #111 !important; }
            .stamp { border-color: #8BBD47 !important; color: #8BBD47 !important; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- CABEÇALHO FIXO (Botões de ação) -->
    <header class="no-print sticky top-0 z-50 px-4 py-3 flex items-center justify-between" style="background: rgba(30,41,59,0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(139,189,71,0.1);">
        <!-- Seta de Voltar -->
        <a href="{{ route('carteirinha.app', $uuid) }}" class="flex items-center gap-2 text-sm font-600" style="color: var(--verde); text-decoration: none;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Voltar</span>
        </a>

        <!-- Botão Compartilhar / PDF -->
        <button onclick="gerarPdf()" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-700" style="background: rgba(139,189,71,0.15); color: var(--verde); border: 1px solid rgba(139,189,71,0.3);">
            <i class="fa-solid fa-share-from-square"></i>
            <span>Comprovante</span>
        </button>
    </header>

    <!-- CONTEÚDO DO COMPROVANTE -->
    <main class="flex-1 flex items-start justify-center p-4 sm:p-6 pb-20">
        <div class="print-area w-full max-w-lg rounded-2xl overflow-hidden" style="background: linear-gradient(165deg,rgba(30,41,59,0.98) 0%,rgba(30,41,59,1) 100%); border: 1px solid rgba(139,189,71,0.15);">
            
            <div class="p-6 sm:p-8 relative">
                
                <!-- Cabeçalho do Documento -->
                <div class="text-center mb-6 pb-6" style="border-bottom: 1px dashed rgba(255,255,255,0.1);">
                    <h1 class="font-display font-800 text-xl mb-1" style="color: var(--txt-primary);">Comprovante de Matrícula</h1>
                    <p class="text-xs" style="color: var(--txt-muted);">Cidade do Saber</p>
                </div>

                <!-- Selo de Validação Visual -->
                <div class="stamp absolute top-6 right-6 font-display font-800 text-xs px-3 py-1.5 rounded-md border-2 transform rotate-6 opacity-80" style="border-color: var(--verde); color: var(--verde);">
                    CONFIRMADA
                </div>

                <!-- Dados do Aluno -->
                <div class="mb-6">
                    <h2 class="detail-label mb-3">Dados do Aluno</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                        <div>
                            <p class="text-xs" style="color: var(--txt-muted);">Nome Completo</p>
                            <p class="detail-value text-base">{{ $aluno->nome_aluno }}</p>
                        </div>
                        <div>
                            <p class="text-xs" style="color: var(--txt-muted);">CPF</p>
                            <p class="detail-value">{{ $aluno->cpf }}</p>
                        </div>
                    </div>
                </div>

                <!-- Dados do Curso -->
                <div class="detail-card mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(255,173,2,0.1);">
                            <i class="fa-solid fa-graduation-cap text-sm" style="color: var(--dourado);"></i>
                        </div>
                        <h2 class="detail-label" style="margin:0;">Informações do Curso</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        <div class="flex justify-between">
                            <span class="text-sm" style="color: var(--txt-muted);">Curso / Módulo</span>
                            <span class="text-sm font-600 text-right" style="max-width: 60%;">{{ $matricula->nome_curso }} - {{ $matricula->nome_modulo }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm" style="color: var(--txt-muted);">Coordenação</span>
                            <span class="text-sm font-600">{{ $matricula->nome_coordenacao }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm" style="color: var(--txt-muted);">Período Letivo</span>
                            <span class="text-sm font-700 px-2 py-0.5 rounded" style="background:rgba(139,189,71,0.1); color:var(--verde);">{{ $matricula->nome_periodo_letivo }}</span>
                        </div>
                    </div>
                </div>

                <!-- Detalhes da Turma -->
                <div class="detail-card mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(139,189,71,0.1);">
                            <i class="fa-solid fa-calendar-days text-sm" style="color: var(--verde);"></i>
                        </div>
                        <h2 class="detail-label" style="margin:0;">Detalhes da Turma</h2>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p style="color: var(--txt-muted);" class="text-xs">Turma</p>
                            <p class="font-600">{{ $matricula->nome_turma }}</p>
                        </div>
                        <div>
                            <p style="color: var(--txt-muted);" class="text-xs">Turno</p>
                            <p class="font-600">{{ $matricula->turno }}</p>
                        </div>
                        <div>
                            <p style="color: var(--txt-muted);" class="text-xs">Horário</p>
                            <p class="font-600">{{ substr($matricula->hora_inicio, 0, 5) }} - {{ substr($matricula->hora_termino, 0, 5) }}</p>
                        </div>
                        <div>
                            <p style="color: var(--txt-muted);" class="text-xs">Início</p>
                            <p class="font-600">{{ date('d/m/Y', strtotime($matricula->data_inicio_turma)) }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.05);">
                        <p style="color: var(--txt-muted);" class="text-xs mb-1">Dias de Aula</p>
                        <p class="font-600 text-sm">{{ $matricula->dias_de_aula }}</p>
                    </div>
                </div>

                <!-- Rodapé de Autenticidade -->
                <div class="text-center mt-8 pt-6" style="border-top: 1px dashed rgba(255,255,255,0.1);">
                    <p class="text-xs" style="color: var(--txt-muted);">
                        Matrícula registrada em: <strong style="color: var(--txt-secondary);">{{ date('d/m/Y', strtotime($matricula->data_matricula)) }}</strong>
                    </p>
                    <p class="text-xs mt-2" style="color: var(--txt-muted);">
                        Autenticação: <span class="font-mono" style="color: var(--verde);">{{ $matricula->autenticacao }}</span>
                    </p>
                    <p class="text-[0.65rem] mt-4 italic" style="color: var(--txt-muted); opacity: 0.6;">
                        Documento emitido por meio digital. Verifique a autenticidade pelo código acima.
                    </p>
                </div>

            </div>
        </div>
    </main>

    <script>
        function gerarPdf() {
            // No celular, isso abre a tela de compartilhamento nativa do Android/iOS,
            // permitindo salvar como PDF ou enviar no WhatsApp/Email.
            // No computador, abre a caixa de diálogo "Salvar como PDF".
            window.print();
        }
    </script>
</body>
</html>