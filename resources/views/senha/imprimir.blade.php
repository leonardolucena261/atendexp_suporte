<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Senhas — Cidade do Saber</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Sora:wght@200;400;600;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        verde: '#8BBD47', dourado: '#FFAD02', clarinho: '#BFFBAC',
                        laranja: '#EF8E26', escuro: '#1E293B', claro: '#F9F9F9',
                    },
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
            --claro: #F9F9F9;
            --txt-dark: #0F172A;
            --txt-body: #334155;
            --txt-muted: #64748B;
            --border: #CBD5E1;
            --border-light: #E2E8F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--claro);
            color: var(--txt-body);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .app-topbar {
            background: rgba(255, 255, 255, 0.9);
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

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

         /* ===== NOVO: BOTÃO VOLTAR NA TOPBAR ===== */
         .btn-back-topbar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(0,0,0,0.03);
            color: var(--txt-muted);
            text-decoration: none;
            transition: all 0.2s ease;
            margin-right: 0.25rem;
        }
        .btn-back-topbar:hover {
            background: rgba(139, 189, 71, 0.1);
            color: var(--verde);
        }

        .topbar-logo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--escuro);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-logo i {
            color: var(--verde);
            font-size: 1rem;
        }

        .topbar-title {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--txt-dark);
        }

        .topbar-subtitle {
            font-size: 0.75rem;
            color: var(--txt-muted);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.75rem 0.4rem 0.5rem;
            background: rgba(139, 189, 71, 0.08);
            border: 1px solid rgba(139, 189, 71, 0.2);
            border-radius: 999px;
            font-size: 0.813rem;
            color: var(--txt-dark);
            font-weight: 500;
        }

        .user-chip i {
            color: var(--verde);
            font-size: 0.875rem;
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.4rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.813rem;
            font-weight: 600;
            font-family: 'Space Grotesk', sans-serif;
            color: var(--txt-muted);
            background: transparent;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            min-height: 36px;
        }

        .btn-logout:hover {
            color: #dc2626;
            background: rgba(239, 68, 68, 0.05);
            border-color: rgba(239, 68, 68, 0.15);
        }

        .header-actions {
            display: flex;
            gap: 0.5rem;
        }

        .header-btn {
            padding: 0.4rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.813rem;
            font-weight: 600;
            font-family: 'Space Grotesk', sans-serif;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
            min-height: 36px;
            text-decoration: none;
        }

        .header-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .btn-print {
            background: rgba(139, 189, 71, 0.1);
            color: #4d7c0f;
            border: 1px solid rgba(139, 189, 71, 0.2);
        }

        .btn-print:hover:not(:disabled) {
            background: var(--verde);
            color: white;
            border-color: var(--verde);
        }

        .btn-pdf {
            background: rgba(239, 142, 38, 0.1);
            color: #c2410c;
            border: 1px solid rgba(239, 142, 38, 0.2);
        }

        .btn-pdf:hover:not(:disabled) {
            background: var(--laranja);
            color: white;
            border-color: var(--laranja);
        }

        .control-panel {
            max-width: 680px;
            margin: 1.5rem auto;
            padding: 0 1rem;
        }

        .control-card {
            background: white;
            border-radius: 1.25rem;
            padding: 1.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-light);
        }

        .search-row {
            display: flex;
            gap: 0.75rem;
        }

        .search-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--txt-muted);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .search-input-wrap {
            position: relative;
            flex: 1;
        }

        .search-input-wrap i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--txt-muted);
            font-size: 0.875rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .search-input {
            width: 100%;
            min-height: 52px;
            padding: 0 1rem 0 2.85rem;
            border: 1.5px solid var(--border);
            border-radius: 0.75rem;
            font-family: 'Sora', sans-serif;
            font-size: 0.938rem;
            font-weight: 600;
            color: var(--txt-dark);
            background: var(--claro);
            transition: all 0.2s ease;
        }

        .search-input:hover {
            border-color: #94a3b8;
        }

        .search-input:focus {
            outline: none;
            background: white;
            border-color: var(--verde);
            box-shadow: 0 0 0 4px rgba(139, 189, 71, 0.15);
        }

        .search-input:focus~i {
            color: var(--verde);
        }

        .search-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
            font-size: 0.875rem;
        }

        .btn-buscar {
            min-height: 52px;
            padding: 0 1.5rem;
            border-radius: 0.75rem;
            border: none;
            background: var(--verde);
            color: white;
            font-weight: 700;
            font-family: 'Sora', sans-serif;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(139, 189, 71, 0.3);
        }

        .btn-buscar:hover {
            background: #7aa83d;
            box-shadow: 0 4px 12px rgba(139, 189, 71, 0.4);
            transform: translateY(-1px);
        }

        .curso-info {
            margin-top: 1.25rem;
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            background: rgba(139, 189, 71, 0.06);
            border: 1px solid rgba(139, 189, 71, 0.15);
        }

        .inline-msg {
            margin-top: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 0.625rem;
            font-size: 0.813rem;
            display: none;
            align-items: center;
            gap: 0.5rem;
        }

        .inline-msg.visible {
            display: flex;
        }

        .inline-msg.msg-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .inline-msg.msg-empty {
            background: #f8fafc;
            border: 1px solid var(--border-light);
            color: #475569;
        }

        .senha-container {
            max-width: 680px;
            margin: 0 auto 2rem;
            padding: 0 1rem;
        }

        .page-letter-wrapper {
            display: block;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .fold-mark {
            display: none;
        }

        /* ===== NOVO DESIGN DA SENHA ===== */
        .senha-card {
            background: white;
            border: 2px solid var(--border-light);
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .senha-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
            border-color: rgba(139, 189, 71, 0.3);
        }

        .senha-header-bar {
            background: linear-gradient(135deg, var(--verde) 0%, #7aa83d 100%);
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }

        .senha-header-bar::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: skewX(-20deg) translateX(20px);
        }

        .senha-header-bar .inst-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .senha-header-bar .inst-info {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .senha-header-bar .inst-name {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 0.02em;
            line-height: 1.2;
        }

        .senha-header-bar .inst-sub {
            font-size: 0.75rem;
            opacity: 0.95;
            font-weight: 500;
        }

        .senha-body {
            padding: 1.5rem;
        }

        .senha-title-section {
            text-align: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 2px dashed var(--border-light);
        }

        .senha-title-section .t1 {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1.125rem;
            color: var(--txt-dark);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .senha-title-section .t2 {
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            font-size: 0.813rem;
            color: var(--txt-muted);
            letter-spacing: 0.1em;
        }

        .senha-curso-name {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--txt-dark);
            text-align: center;
            margin: 1.25rem 0;
            line-height: 1.3;
            padding: 0.75rem;
            background: rgba(139, 189, 71, 0.08);
            border-radius: 0.75rem;
            border-left: 4px solid var(--verde);
        }

        .senha-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }

        .badge-unico {
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.688rem;
            font-weight: 800;
            font-family: 'Sora', sans-serif;
            letter-spacing: 0.08em;
            background: linear-gradient(135deg, var(--laranja), #d97706);
            color: white;
            box-shadow: 0 2px 6px rgba(239, 142, 38, 0.3);
        }

        .meta-item {
            font-size: 0.813rem;
            color: var(--txt-body);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .meta-item strong {
            color: var(--txt-dark);
            font-weight: 700;
        }

        .senha-qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 1.5rem 0;
            padding: 1.25rem;
            background: linear-gradient(135deg, rgba(139, 189, 71, 0.05), rgba(255, 173, 2, 0.05));
            border-radius: 0.75rem;
            border: 1.5px solid rgba(139, 189, 71, 0.2);
        }

        .senha-qr-wrap {
            padding: 0.75rem;
            border: 2px solid var(--border);
            border-radius: 0.75rem;
            background: white;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .senha-qr-wrap img {
            display: block;
        }

        .senha-qr-label {
            font-size: 0.75rem;
            color: var(--txt-muted);
            margin-top: 0.625rem;
            text-align: center;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .senha-schedule {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .senha-schedule .sch-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.813rem;
            color: var(--txt-body);
            padding: 0.5rem 0.75rem;
            background: rgba(139, 189, 71, 0.06);
            border-radius: 0.5rem;
            border: 1px solid rgba(139, 189, 71, 0.15);
        }

        .senha-schedule .sch-item i {
            color: var(--verde);
            font-size: 0.875rem;
            width: 18px;
            text-align: center;
        }

        .senha-auth {
            text-align: center;
            padding: 1rem;
            background: rgba(15, 23, 42, 0.04);
            border-radius: 0.625rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(15, 23, 42, 0.08);
        }

        .senha-auth .auth-label {
            font-size: 0.75rem;
            color: var(--txt-muted);
            margin-bottom: 0.375rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .senha-auth strong {
            color: var(--txt-dark);
            font-family: 'Space Grotesk', monospace;
            font-size: 1.125rem;
            letter-spacing: 0.1em;
            font-weight: 800;
            display: block;
        }

        .senha-cut {
            border-top: 2px dashed var(--border);
            padding-top: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .senha-num {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 0.938rem;
            color: var(--txt-dark);
            background: var(--escuro);
            color: white;
            padding: 0.375rem 0.875rem;
            border-radius: 0.5rem;
        }

        .spinner-sm {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(30, 41, 59, 0.2);
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        :focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px white, 0 0 0 5px var(--verde);
            border-radius: 4px;
        }

        /* ===== IMPRESSÃO ===== */
        .qr-pre-offscreen {
            position: fixed;
            left: -9999px;
            top: 0;
            width: 50px;
            height: 50px;
        }

        /* ===== IMPRESSÃO (UMA SENHA POR PÁGINA) ===== */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                font-size: 10pt;
            }

            .screen-only {
                display: none !important;
            }

            .print-only {
                display: flex !important;
            }

            .page-letter-wrapper {
                position: relative !important;
                width: 100% !important;
                height: 277mm !important;
                page-break-after: always !important;
                break-after: page !important;
                margin: 0 !important;
                padding: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
            }

            .page-letter-wrapper:last-child {
                page-break-after: auto !important;
                break-after: auto !important;
            }

            .fold-mark {
                display: none !important;
            }

            .senha-container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 190mm !important;
            }

            .senha-card {
                width: 190mm !important;
                border: 2pt solid var(--verde) !important;
                border-radius: 5mm !important;
                box-shadow: 0 4px 16px rgba(139, 189, 71, 0.15) !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                margin-bottom: 8mm !important;
            }

            .senha-header-bar {
                padding: 6mm 7mm;
                background: linear-gradient(135deg, var(--verde) 0%, #7aa83d 100%) !important;
                border-radius: 3mm 3mm 0 0 !important;
            }

            .senha-header-bar .inst-icon {
                width: 10mm;
                height: 10mm;
                font-size: 7pt;
                border-radius: 2mm;
            }

            .senha-header-bar .inst-name {
                font-size: 11pt;
            }

            .senha-header-bar .inst-sub {
                font-size: 7.5pt;
            }

            .senha-body {
                padding: 7mm 7mm;
            }

            .senha-title-section {
                margin-bottom: 5mm;
                padding-bottom: 4mm;
                border-bottom: 2px dashed var(--border) !important;
            }

            .senha-title-section .t1 {
                font-size: 10pt;
                letter-spacing: 0.1em;
            }

            .senha-title-section .t2 {
                font-size: 7pt;
            }

            .senha-curso-name {
                font-size: 14pt;
                margin: 5mm 0;
                padding: 3mm;
                background: rgba(139, 189, 71, 0.08);
                border-left: 5px solid var(--verde);
            }

            .senha-meta {
                gap: 3mm;
                margin-bottom: 6mm;
                flex-wrap: wrap;
            }

            .badge-unico {
                font-size: 6pt;
                padding: 1mm 3mm;
            }

            .meta-item {
                font-size: 8pt;
            }

            .senha-qr-section {
                margin: 7mm 0;
                padding: 5mm;
                background: linear-gradient(135deg, rgba(139, 189, 71, 0.05), rgba(255, 173, 2, 0.05));
                border: 1.5pt solid rgba(139, 189, 71, 0.2);
                border-radius: 2mm;
            }

            .senha-qr-wrap {
                padding: 3mm;
                border-width: 1.5pt;
            }

            .senha-qr-wrap canvas,
            .senha-qr-wrap img {
                width: 38mm !important;
                height: 38mm !important;
            }

            .senha-qr-label {
                font-size: 7pt;
                margin-top: 2mm;
            }

            .senha-schedule {
                gap: 3mm;
                margin-bottom: 5mm;
                display: flex;
                flex-wrap: wrap;
            }

            .senha-schedule .sch-item {
                font-size: 8pt;
                padding: 2mm 3mm;
                background: rgba(139, 189, 71, 0.06);
                border: 1pt solid rgba(139, 189, 71, 0.15);
            }

            .senha-schedule .sch-item i {
                font-size: 7pt;
            }

            .senha-auth {
                font-size: 8pt;
                margin-bottom: 5mm;
                padding: 4mm;
                background: rgba(15, 23, 42, 0.04);
                border: 1pt solid rgba(15, 23, 42, 0.08);
            }

            .senha-auth .auth-label {
                font-size: 6.5pt;
                margin-bottom: 1.5mm;
            }

            .senha-auth strong {
                font-size: 12pt;
                letter-spacing: 0.12em;
            }

            .senha-cut {
                border-top: 2px dashed var(--border);
                padding-top: 4mm;
                margin-top: 4mm;
            }

            .senha-num {
                font-size: 9pt;
                padding: 2mm 4mm;
                background: var(--escuro);
                color: white;
            }

            /* INSTRUÇÕES DE MATRÍCULA */
            .msg-instrucoes {
                width: 190mm !important;
                margin: 0 auto !important;
                font-size: 7.5pt;
                line-height: 1.6;
                color: #333;
                font-family: 'Space Grotesk', sans-serif;
                padding: 5mm 6mm;
                background: rgba(139, 189, 71, 0.03);
                border: 1pt solid rgba(139, 189, 71, 0.15);
                border-radius: 2mm;
            }

            .msg-instrucoes .titulo-steps {
                font-family: 'Sora', sans-serif;
                font-weight: 800;
                font-size: 8.5pt;
                color: var(--escuro);
                margin-bottom: 3mm;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                border-bottom: 1.5pt solid var(--verde);
                padding-bottom: 2mm;
                display: flex;
                align-items: center;
                gap: 2mm;
            }

            .msg-instrucoes .titulo-steps::before {
                content: '\f059';
                font-family: 'Font Awesome 6 Free';
                font-weight: 900;
                color: var(--verde);
            }

            .msg-instrucoes .steps-list {
                margin: 0 0 4mm 0;
                padding-left: 0;
                list-style: none;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 3mm;
            }

            .msg-instrucoes .steps-list li {
                margin-bottom: 2mm;
                padding-left: 7mm;
                position: relative;
                font-size: 7.5pt;
                line-height: 1.5;
            }

            .msg-instrucoes .steps-list li::before {
                content: attr(data-step);
                position: absolute;
                left: 0;
                font-weight: 800;
                font-family: 'Sora', sans-serif;
                color: var(--verde);
                font-size: 7pt;
            }

            .msg-instrucoes .aviso-sem-carteira {
                margin-top: 3mm;
                padding: 4mm;
                background: #fffbeb;
                border: 1.5pt solid #fde68a;
                border-radius: 2mm;
                color: #92400e;
                font-size: 7pt;
            }

            .msg-instrucoes .aviso-sem-carteira strong {
                color: #c2410c;
                display: block;
                margin-bottom: 2mm;
                font-size: 8pt;
            }

            .qr-pre-offscreen {
                position: static !important;
                width: auto !important;
                height: auto !important;
                margin: 0 auto 3mm auto !important;
                padding: 2mm !important;
                border: 1pt solid #ddd !important;
                background: white !important;
                border-radius: 2mm !important;
                display: block !important;
            }

            .qr-pre-offscreen canvas,
            .qr-pre-offscreen img {
                width: 35mm !important;
                height: 35mm !important;
                display: block !important;
                margin: 0 auto !important;
            }

            .msg-carinho {
                position: static !important;
                width: 190mm !important;
                margin: 6mm auto 0 auto !important;
                font-size: 7pt;
                color: #64748b;
                text-align: center;
                align-items: center;
                justify-content: center;
                gap: 2mm;
                font-family: 'Space Grotesk', sans-serif;
                font-style: italic;
                padding: 3mm;
                border-top: 1pt dashed var(--border);
            }

            .msg-carinho i {
                color: var(--verde);
                font-size: 6.5pt;
            }

            .inline-msg {
                display: none !important;
            }
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
            .app-topbar {
                padding: 0.5rem 1rem;
            }

            .topbar-title {
                font-size: 0.875rem;
            }

            .user-chip span.user-text {
                display: none;
            }

            .control-panel {
                margin: 1rem auto;
                padding: 0 0.75rem;
            }

            .search-row {
                flex-direction: column;
            }

            .senha-container {
                padding: 0 0.75rem;
            }

            .senha-header-bar {
                padding: 0.75rem 1rem;
            }

            .senha-body {
                padding: 1rem;
            }

            .senha-curso-name {
                font-size: 1.25rem;
            }

            .senha-schedule {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <header class="app-topbar screen-only">
        <div class="topbar-left">
            <!-- NOVO: Botão de retorno adicionado aqui -->
            <a href="{{ route('senha.index') }}" class="btn-back-topbar" title="Voltar para opções do sistema">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <!-- FIM DO NOVO -->
            <div class="topbar-logo" aria-hidden="true"><i class="fa-solid fa-graduation-cap"></i></div>
            <div>
                <h1 class="topbar-title">Atende XP</h1>
                <p class="topbar-subtitle">Emissao de Senhas</p>
            </div>
        </div>
        <div class="topbar-right">
            @isset($senhas)
                @if($senhas->isNotEmpty())
                    <div class="header-actions">
                        <button id="btnPrint" class="header-btn btn-print" aria-label="Imprimir senhas"><i
                                class="fa-solid fa-print text-xs" aria-hidden="true"></i> Imprimir</button>
                    </div>
                @endif
            @endisset
            <div class="user-chip" aria-label="Usuario logado">
                <i class="fa-solid fa-user"></i>
                <span class="user-text">{{ session('login')['nome_completo'] ?? '' }}</span>
            </div>
            <a href="{{ route('login') }}" class="btn-logout" title="Sair do sistema"><i
                    class="fa-solid fa-right-from-bracket"></i><span>Sair</span></a>
        </div>
    </header>

    <section class="control-panel screen-only" aria-label="Busca de turma">
        <div class="control-card">
            <form method="POST" action="{{ route('senha.imprimir') }}" id="formBusca">
                @csrf
                <label for="codeInput" class="search-label">Codigo da turma</label>
                <div class="search-row">
                    <div class="search-input-wrap">
                        <input type="text" name="cod_turma" id="codeInput" class="search-input" placeholder="Ex: T001"
                            maxlength="5" value="{{ old('cod_turma', $codigo_turma ?? '') }}"
                            aria-label="Codigo da turma" autofocus>
                        <i class="fa-solid fa-hashtag" aria-hidden="true"></i>
                    </div>
                    <button type="submit" class="btn-buscar" aria-label="Buscar turma"><i
                            class="fa-solid fa-magnifying-glass text-xs" aria-hidden="true"></i> Buscar</button>
                </div>
            </form>
            @if($errors->any())
                <div class="inline-msg visible msg-error" role="alert" aria-live="assertive"><i
                        class="fa-solid fa-circle-exclamation" aria-hidden="true"></i> {{ $errors->first('cod_turma') }}
                </div>
            @endif
            @isset($senhas)
                @if($senhas->isNotEmpty())
                    <div class="curso-info" role="region" aria-label="Informacoes da turma">
                        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem;">
                            <div>
                                <p
                                    style="font-family:'Sora',sans-serif;font-weight:700;font-size:0.938rem;color:var(--txt-dark);">
                                    {{ $senhas->first()->nome_curso }}
                                </p>
                                <p style="font-size:0.75rem;color:var(--txt-muted);margin-top:1px;">
                                    {{ $senhas->first()->nome_modulo }}
                                    @if($senhas->first()->periodo)
                                        · Periodo: {{ $senhas->first()->periodo }}
                                    @endif
                                    · Turma: {{ $senhas->first()->nome_turma }}
                                </p>
                            </div>
                            <span
                                style="font-size:0.75rem;font-weight:600;padding:0.2rem 0.5rem;border-radius:4px;background:rgba(139,189,71,0.1);color:#4d7c0f;">{{ $senhas->count() }}
                                senha{{ $senhas->count() != 1 ? 's' : '' }}</span>
                        </div>
                    </div>
                @else
                    <div class="inline-msg visible msg-empty" role="alert" aria-live="assertive"><i
                            class="fa-solid fa-circle-info" aria-hidden="true"></i> Nenhuma senha disponivel encontrada para
                        esta turma.</div>
                @endif
            @endisset
        </div>
    </section>

    <div id="senhaContainer" class="senha-container" role="region" aria-label="Senhas geradas">
        @isset($senhas)
            @foreach($senhas as $index => $senha)
                <div class="page-letter-wrapper">
                    <div class="fold-mark fold-mark-1" aria-hidden="true">
                        <div class="fold-mark-icon"></div>
                    </div>
                    <div class="fold-mark fold-mark-2" aria-hidden="true">
                        <div class="fold-mark-icon"></div>
                    </div>
                    <div class="senha-card">
                        <div class="senha-header-bar">
                            <div class="inst-icon" aria-hidden="true"><i class="fa-solid fa-graduation-cap"></i></div>
                            <div class="inst-info">
                                <div class="inst-name">CIDADE DO SABER</div>
                                <div class="inst-sub">Prefeitura de Camacari</div>
                            </div>
                        </div>
                        <div class="senha-body">
                            <div class="senha-title-section">
                                <div class="t1">SENHA DE MATRICULA</div>
                                <div class="t2">AUTENTICAÇÃO</div>
                            </div>
                            <div class="senha-curso-name">{{ strtoupper($senha->nome_curso) }}</div>
                            <div class="senha-meta">
                                <span class="badge-unico">UNICO</span>
                                <span class="meta-item"><i class="fa-regular fa-clock"></i> <strong>Turno:</strong>
                                    {{ $senha->turno }}</span>
                                <span class="meta-item"><i class="fa-solid fa-layer-group"></i> <strong>Modulo:</strong>
                                    {{ $senha->nome_modulo }}</span>
                            </div>
                            <div class="senha-qr-section">
                                <div class="senha-qr-wrap">
                                    <div id="qr-{{ $loop->index }}" class="senha-qr-target"
                                        data-url="{{ url('/vaga/' . $senha->autenticacao) }}" role="img"
                                        aria-label="QR Code de verificacao: {{ $senha->autenticacao }}"></div>
                                </div>
                                <p class="senha-qr-label"><i class="fa-solid fa-camera"
                                        style="margin-right:3px;font-size:0.625rem;" aria-hidden="true"></i>Aponte a camera para
                                    verificar</p>
                            </div>
                            <div class="senha-schedule">
                                <span class="sch-item"><i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                    {{ \Carbon\Carbon::parse($senha->turma_data_inicio)->format('d/m/Y') }}</span>
                                <span class="sch-item"><i class="fa-regular fa-clock" aria-hidden="true"></i>
                                    {{ substr($senha->turma_hora_inicio ?? '00:00', 0, 5) }} —
                                    {{ substr($senha->turma_hora_termino ?? '00:00', 0, 5) }}</span>
                                <span class="sch-item"><i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                    {{ $senha->nome_local }}</span>
                            </div>
                            <div class="senha-schedule" style="margin-bottom:0.625rem;">
                                @if($senha->validade)
                                    <span class="sch-item"><i class="fa-solid fa-hourglass-half" aria-hidden="true"></i> Validade:
                                        {{ \Carbon\Carbon::parse($senha->validade)->format('d/m/Y') }}</span>
                                @else
                                    <span class="sch-item"
                                        style="color:#c2410c; background:rgba(239,68,68,0.08); border-color:rgba(239,68,68,0.2);"><i
                                            class="fa-solid fa-triangle-exclamation" aria-hidden="true"
                                            style="color:var(--laranja);"></i> Senha pode expirar a qualquer
                                        instante</span>
                                @endif
                            </div>
                            <div class="senha-auth">
                                <div class="auth-label">Codigo de Autenticacao</div>
                                <strong>{{ $senha->autenticacao }}</strong>
                            </div>
                            <div class="senha-cut">
                                <span style="font-size:0.75rem;color:var(--txt-muted);">Guarde este comprovante</span>
                                <span class="senha-num">Nº {{ $senha->numero_senha }}</span>
                            </div>
                        </div>
                    </div>
                    {{-- INSTRUÇÕES DE COMO USAR A SENHA (SÓ APARECE NA IMPRESSÃO) --}}
                    <div class="print-only msg-instrucoes">
                        <div class="titulo-steps">Como finalizar sua matricula</div>
                        <ol class="steps-list">
                            <li data-step="1.">Acesse o App da Cidade do Saber (escaneie o QR Code da sua Carteirinha).</li>
                            <li data-step="2.">No App, toque em "Gerar Token" e copie o codigo de 6 letras.</li>
                            <li data-step="3.">Retire presencialmente a "Senha Fisica" da turma em nossa unidade.</li>
                            <li data-step="4.">No App, escaneie o QR Code da Senha Fisica para concluir.</li>
                        </ol>
                        <div class="aviso-sem-carteira">
                            <div style="text-align: center; margin-bottom: 2.5mm;">
                                <div id="qr-pre-{{ $loop->index }}" class="qr-pre-offscreen"
                                    data-url="{{ route('precadastro.index') }}"
                                    style="width:50px;height:50px;margin:0 auto;border:1px solid #ddd;padding:2px;border-radius:2px;background:#fff;">
                                </div>
                            </div>
                            <div style="text-align:left;">
                                <strong style="color: var(--escuro); display:block; margin-bottom: 1mm;">NAO POSSUI
                                    CARTEIRINHA?</strong>
                                <strong>1.</strong> Acesse o QR Code acima pelo celular para fazer seu pre-cadastro rapido.<br>
                                <strong>2.</strong> Compareca a Coordenacao de Cursos com documento com foto para emitir a sua
                                carteira de acesso ao App e assinar o Termo de Responsabilidade.
                            </div>
                        </div>
                    </div>
                    <div class="print-only msg-carinho"><i class="fa-solid fa-seedling"></i><span>Desejamos muito sucesso na sua
                            jornada de aprendizado. Com carinho, equipe Cidade do Saber.</span></div>
                </div>
            @endforeach
        @endisset
    </div>

    <div id="toast" class="screen-only"
        style="position:fixed;top:5rem;right:1rem;z-index:1000;transform:translateX(120%);transition:transform 0.4s cubic-bezier(0.22,1,0.36,1);width:calc(100% - 2rem);max-width:360px;"
        role="alert" aria-live="assertive" aria-atomic="true">
        <div
            style="display:flex;align-items:center;gap:0.625rem;padding:0.75rem 1rem;border-radius:0.75rem;background:white;box-shadow:0 4px 20px rgba(0,0,0,0.12);border:1px solid var(--border-light);">
            <div id="toastIcon"
                style="width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:rgba(139,189,71,0.12);"
                aria-hidden="true"><i class="fa-solid fa-check text-xs" style="color:var(--verde);"></i></div>
            <div style="min-width:0;">
                <p id="toastTitle"
                    style="font-size:0.813rem;font-family:'Sora',sans-serif;font-weight:600;color:var(--txt-dark);"></p>
                <p id="toastMsg" style="font-size:0.75rem;color:var(--txt-muted);"></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var btnPrint = document.getElementById('btnPrint') || { disabled: true };
            var btnPdf = document.getElementById('btnPdf') || { disabled: true };
            var senhaContainer = document.getElementById('senhaContainer');
            var toastEl = document.getElementById('toast');
            var toastIcon = document.getElementById('toastIcon');
            var toastTitle = document.getElementById('toastTitle');
            var toastMsg = document.getElementById('toastMsg');
            var toastTimer = null;

            var qrTargets = document.querySelectorAll('.senha-qr-target');
            var temSenhas = qrTargets.length > 0;

            if (btnPrint) btnPrint.disabled = !temSenhas;
            if (btnPdf) btnPdf.disabled = !temSenhas;

            function optimizeForPrint() {
                var targets = document.querySelectorAll('.senha-qr-target');
                targets.forEach(function (target) {
                    var canvas = target.querySelector('canvas');
                    var img = target.querySelector('img');
                    if (canvas && img) {
                        canvas.remove();
                    }
                });

                var preCadTargets = document.querySelectorAll('.qr-pre-offscreen');
                preCadTargets.forEach(function (target) {
                    var canvas = target.querySelector('canvas');
                    var img = target.querySelector('img');
                    if (canvas && img) canvas.remove();
                });
            }

            if (btnPrint) btnPrint.addEventListener('click', function () {
                optimizeForPrint();
                window.print();
            });

            if (temSenhas) {
                qrTargets.forEach(function (el) {
                    var url = el.getAttribute('data-url');
                    if (!url) return;
                    try {
                        new QRCode(el, { text: url, width: 140, height: 140, colorDark: '#1E293B', colorLight: '#ffffff', correctLevel: QRCode.CorrectLevel.M });
                    } catch (e) {
                        el.innerHTML = '<div style="width:140px;height:140px;display:flex;align-items:center;justify-content:center;border:1px dashed var(--border);border-radius:4px;font-size:0.688rem;color:var(--txt-muted);text-align:center;padding:0.5rem;">QR indisponivel</div>';
                    }
                });

                var qrPreCadTargets = document.querySelectorAll('.qr-pre-offscreen');
                if (qrPreCadTargets.length > 0) {
                    qrPreCadTargets.forEach(function (el) {
                        var url = el.getAttribute('data-url');
                        if (!url) return;
                        try {
                            new QRCode(el, { text: url, width: 50, height: 50, colorDark: '#1E293B', colorLight: '#ffffff', correctLevel: QRCode.CorrectLevel.M });
                        } catch (e) {
                            el.innerHTML = '<div style="width:50px;height:50px;display:flex;align-items:center;justify-content:center;border:1px dashed var(--border);border-radius:4px;font-size:6px;color:var(--txt-muted);text-align:center;">ERRO</div>';
                        }
                    });
                }

                showToast('sucesso', 'Senhas carregadas', qrTargets.length + ' senha' + (qrTargets.length !== 1 ? 's' : '') + ' pronta' + (qrTargets.length !== 1 ? 's' : '') + '.');
            }

            function showToast(tipo, titulo, mensagem) {
                clearTimeout(toastTimer);
                var c = tipo === 'sucesso' ? { icon: 'fa-check', bg: 'rgba(139,189,71,0.12)', color: '#8BBD47' } : { icon: 'fa-xmark', bg: 'rgba(239,68,68,0.12)', color: '#ef4444' };
                toastIcon.style.background = c.bg;
                toastIcon.innerHTML = '<i class="fa-solid ' + c.icon + ' text-xs" style="color:' + c.color + '"></i>';
                toastTitle.textContent = titulo;
                toastMsg.textContent = mensagem;
                toastEl.style.transform = 'translateX(0)';
                toastTimer = setTimeout(function () { toastEl.style.transform = 'translateX(120%)'; }, 4000);
            }
        });

        var codeInput = document.getElementById('codeInput');
        if (codeInput) {
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && document.activeElement === codeInput) { codeInput.value = ''; codeInput.focus(); }
            });
        }
    </script>
</body>

</html>