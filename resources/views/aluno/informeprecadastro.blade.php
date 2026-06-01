<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Pre-Cadastro — Cidade do Saber</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Sora:wght@200;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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
            --dourado: #FFAD02; --laranja: #EF8E26; --escuro: #1E293B;
            --claro: #F9F9F9; --branco: #FFFFFF;
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

        /* ===== TOPBAR ===== */
        .app-topbar {
            background: rgba(255,255,255,0.85);
            border-bottom: 1px solid var(--border-light);
            padding: 0.625rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
        }
        .topbar-left { display: flex; align-items: center; gap: 0.75rem; }
        .btn-back-topbar {
            width: 36px; height: 36px; border-radius: 0.5rem;
            display: flex; align-items: center; justify-content: center;
            color: var(--txt-muted); background: rgba(15,23,42,0.04);
            border: 1.5px solid var(--border-light); text-decoration: none;
            transition: all 0.25s cubic-bezier(0.22,1,0.36,1); flex-shrink: 0;
        }
        .btn-back-topbar:hover {
            background: var(--escuro); color: white; border-color: var(--escuro);
            transform: translateY(-1px); box-shadow: 0 4px 12px rgba(30,41,59,0.2);
        }
        .topbar-logo {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, var(--escuro), #0f172a);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(30,41,59,0.25);
            position: relative; overflow: hidden;
        }
        .topbar-logo::after {
            content: ''; position: absolute; top: -50%; left: -50%;
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
        .topbar-subtitle { font-size: 0.7rem; color: var(--txt-muted); font-weight: 500; }
        .topbar-right { display: flex; align-items: center; gap: 0.5rem; }
        .user-chip {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.375rem 0.75rem 0.375rem 0.5rem;
            background: rgba(139,189,71,0.07); border: 1px solid rgba(139,189,71,0.15);
            border-radius: 999px; font-size: 0.8rem; color: var(--txt-dark); font-weight: 500;
        }
        .user-chip i { color: var(--verde); font-size: 0.875rem; }
        .btn-logout {
            display: inline-flex; align-items: center; gap: 0.375rem;
            padding: 0.4rem 0.875rem; border-radius: 0.5rem;
            font-size: 0.8rem; font-weight: 600; font-family: 'Space Grotesk', sans-serif;
            color: var(--txt-muted); background: transparent;
            border: 1px solid transparent; cursor: pointer;
            text-decoration: none; transition: all 0.2s ease; min-height: 36px;
        }
        .btn-logout:hover { color: #dc2626; background: rgba(239,68,68,0.05); border-color: rgba(239,68,68,0.15); }
        .btn-screen-print {
            display: inline-flex; align-items: center; gap: 0.375rem;
            padding: 0.4rem 0.875rem; border-radius: 0.5rem;
            font-size: 0.8rem; font-weight: 600; font-family: 'Space Grotesk', sans-serif;
            color: #4d7c0f; background: rgba(139,189,71,0.08);
            border: 1.5px solid rgba(139,189,71,0.2); cursor: pointer;
            transition: all 0.25s cubic-bezier(0.22,1,0.36,1);
            min-height: 36px; white-space: nowrap;
            position: relative; overflow: hidden;
        }
        .btn-screen-print::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
            opacity: 0; transition: opacity 0.25s;
        }
        .btn-screen-print:hover {
            background: var(--verde); color: white; border-color: var(--verde);
            transform: translateY(-1px); box-shadow: 0 4px 12px rgba(139,189,71,0.35);
        }
        .btn-screen-print:hover::before { opacity: 1; }
        .topbar-divider { width: 1px; height: 24px; background: var(--border-light); margin: 0 0.125rem; }

        /* ===== FOLDER ===== */
        .folder-wrap {
            flex: 1; width: 100%; max-width: 780px;
            margin: 1.5rem auto; padding: 0 1rem;
            position: relative; z-index: 1;
        }
        .folder-page {
            background: var(--branco);
            border-radius: 1.25rem;
            border: 1.5px solid var(--border-light);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- Header --- */
        .folder-header {
            background: linear-gradient(135deg, var(--escuro), #0f172a);
            color: white;
            padding: 1.5rem 2rem;
            display: flex; align-items: center; gap: 1rem;
            position: relative; overflow: hidden;
        }
        .folder-header::before {
            content: ''; position: absolute; top: 0; right: 0; bottom: 0;
            width: 50%;
            background: linear-gradient(135deg, transparent 30%, rgba(139,189,71,0.08) 100%);
            pointer-events: none;
        }
        .fh-icon {
            width: 44px; height: 44px; border-radius: 11px;
            background: linear-gradient(135deg, var(--verde), var(--verde-dark));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.125rem; flex-shrink: 0;
            position: relative; z-index: 1;
            box-shadow: 0 3px 10px rgba(139,189,71,0.3);
        }
        .fh-info { flex: 1; position: relative; z-index: 1; }
        .fh-name { font-family: 'Sora', sans-serif; font-weight: 800; font-size: 1.05rem; letter-spacing: 0.03em; }
        .fh-sub { font-size: 0.675rem; opacity: 0.7; font-weight: 400; }
        .fh-badge {
            position: relative; z-index: 1;
            padding: 0.2rem 0.625rem; border-radius: 999px;
            background: rgba(139,189,71,0.15); border: 1px solid rgba(139,189,71,0.25);
            font-size: 0.575rem; font-weight: 700; color: var(--verde-light);
            letter-spacing: 0.08em; text-transform: uppercase;
        }

        /* --- Body --- */
        .folder-body { padding: 1.75rem 2rem 1.5rem; }

        /* QR */
        .qr-hero {
            text-align: center;
            padding: 1.25rem 1.25rem 1rem;
            margin-bottom: 1.25rem;
            background: linear-gradient(135deg, rgba(139,189,71,0.04), rgba(255,173,2,0.03));
            border-radius: 0.875rem;
            border: 1.5px solid rgba(139,189,71,0.12);
        }
        .qr-hero-label {
            font-family: 'Sora', sans-serif;
            font-weight: 800; font-size: 0.675rem;
            color: var(--txt-muted); text-transform: uppercase;
            letter-spacing: 0.12em; margin-bottom: 0.75rem;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .qr-hero-label i { color: var(--verde); }
        .qr-hero-wrap {
            display: inline-block;
            padding: 0.75rem;
            background: white;
            border: 2.5px solid var(--border-light);
            border-radius: 0.75rem;
            box-shadow: var(--shadow-md);
            position: relative;
        }
        .qr-hero-wrap::before {
            content: ''; position: absolute; inset: -4px;
            border: 2px dashed rgba(139,189,71,0.18);
            border-radius: 1rem; pointer-events: none;
        }
        .qr-hero-wrap img, .qr-hero-wrap canvas { display: block; }
        .qr-hero-hint {
            font-size: 0.7rem; color: var(--txt-muted); margin-top: 0.75rem;
            display: flex; align-items: center; justify-content: center; gap: 0.375rem;
        }
        .qr-hero-hint i { color: var(--verde); font-size: 0.65rem; }
        .qr-hero-url { font-size: 0.55rem; color: var(--border); margin-top: 0.25rem; word-break: break-all; font-family: 'Space Grotesk', monospace; }

        /* Section Title */
        .fs-title {
            font-family: 'Sora', sans-serif;
            font-weight: 800; font-size: 0.85rem;
            color: var(--txt-dark);
            margin-bottom: 0.625rem;
            display: flex; align-items: center; gap: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-light);
            position: relative;
        }
        .fs-title::after {
            content: ''; position: absolute; bottom: -2px; left: 0;
            width: 35px; height: 2px; background: var(--verde); border-radius: 1px;
        }
        .fs-title-icon {
            width: 26px; height: 26px; border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; flex-shrink: 0;
        }
        .fs-title-icon.icon-verde { background: rgba(139,189,71,0.1); color: var(--verde-dark); }
        .fs-title-icon.icon-laranja { background: rgba(239,142,38,0.1); color: #c2410c; }
        .fs-title-icon.icon-escuro { background: rgba(30,41,59,0.08); color: var(--txt-body); }

        /* Steps */
        .steps-flow { margin-bottom: 1.25rem; }
        .step-row {
            display: flex; align-items: flex-start; gap: 0.625rem;
            padding: 0.5rem 0.625rem; border-radius: 0.5rem;
            border: 1px solid transparent; transition: all 0.2s;
        }
        .step-row:hover { background: rgba(139,189,71,0.03); border-color: rgba(139,189,71,0.1); }
        .step-num {
            width: 24px; height: 24px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Sora', sans-serif;
            font-weight: 800; font-size: 0.625rem;
            background: linear-gradient(135deg, var(--verde), var(--verde-dark));
            color: white; flex-shrink: 0;
            box-shadow: 0 2px 5px rgba(139,189,71,0.25);
        }
        .step-body { flex: 1; }
        .step-heading { font-weight: 700; font-size: 0.78rem; color: var(--txt-dark); margin-bottom: 0; }
        .step-detail { font-size: 0.7rem; color: var(--txt-muted); line-height: 1.45; margin-top: 0.1rem; }
        .step-connector { width: 2px; height: 6px; margin-left: 0.85rem; background: linear-gradient(to bottom, rgba(139,189,71,0.25), rgba(139,189,71,0.06)); border-radius: 1px; }

        /* Two-column layout: steps left, fields right */
        .content-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1rem;
        }

        /* Fields */
        .fields-grid {
            display: flex; flex-direction: column; gap: 0.3rem;
        }
        .field-chip {
            display: flex; align-items: center; gap: 0.4rem;
            padding: 0.3rem 0.5rem; border-radius: 0.375rem;
            background: rgba(15,23,42,0.02);
            border: 1px solid var(--border-light);
            font-size: 0.72rem; color: var(--txt-body);
        }
        .field-chip i { color: var(--verde); font-size: 0.6rem; width: 12px; text-align: center; }
        .field-chip .req { color: #c2410c; font-weight: 700; margin-left: auto; font-size: 0.525rem; font-family: 'Sora', sans-serif; }
        .field-chip .opt { color: var(--txt-muted); font-weight: 500; margin-left: auto; font-size: 0.55rem; }

        /* Minor */
        .minor-box {
            margin-top: 0.5rem; padding: 0.6rem 0.625rem;
            border-radius: 0.5rem;
            background: rgba(255,173,2,0.04);
            border: 1px solid rgba(255,173,2,0.12);
        }
        .minor-label {
            font-family: 'Sora', sans-serif;
            font-weight: 700; font-size: 0.6rem;
            color: var(--laranja); text-transform: uppercase;
            letter-spacing: 0.06em; margin-bottom: 0.375rem;
            display: flex; align-items: center; gap: 0.3rem;
        }
        .minor-label i { font-size: 0.55rem; }
        .minor-fields { display: flex; flex-direction: column; gap: 0.2rem; }
        .minor-field-chip {
            display: flex; align-items: center; gap: 0.3rem;
            padding: 0.2rem 0.4rem; border-radius: 0.25rem;
            background: rgba(255,173,2,0.04);
            border: 1px solid rgba(255,173,2,0.08);
            font-size: 0.65rem; color: var(--txt-body);
        }
        .minor-field-chip i { color: var(--laranja); font-size: 0.5rem; width: 10px; text-align: center; }

        /* Docs */
        .docs-row { display: flex; flex-direction: column; gap: 0.375rem; margin-bottom: 0.875rem; }
        .doc-row {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.45rem 0.625rem; border-radius: 0.5rem;
            background: rgba(239,142,38,0.03);
            border: 1px solid rgba(239,142,38,0.08);
            transition: all 0.2s;
        }
        .doc-row:hover { background: rgba(239,142,38,0.06); border-color: rgba(239,142,38,0.15); }
        .doc-row-icon {
            width: 26px; height: 26px; border-radius: 0.375rem;
            display: flex; align-items: center; justify-content: center;
            background: rgba(239,142,38,0.1); color: #c2410c;
            font-size: 0.7rem; flex-shrink: 0;
        }
        .doc-row-text { font-size: 0.72rem; color: var(--txt-body); font-weight: 500; }
        .doc-row-note { font-size: 0.6rem; color: var(--txt-muted); }

        /* Alerts */
        .alerts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 0; }
        .alert-folder {
            padding: 0.625rem 0.75rem; border-radius: 0.5rem;
            display: flex; align-items: flex-start; gap: 0.5rem;
        }
        .alert-folder.af-warning { background: #fffbeb; border: 1px solid #fde68a; }
        .alert-folder.af-info { background: rgba(139,189,71,0.05); border: 1px solid rgba(139,189,71,0.15); }
        .af-icon {
            width: 22px; height: 22px; border-radius: 0.375rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 0.6rem;
        }
        .af-warning .af-icon { background: rgba(239,142,38,0.1); color: #c2410c; }
        .af-info .af-icon { background: rgba(139,189,71,0.1); color: var(--verde-dark); }
        .af-title { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 0.675rem; margin-bottom: 0.1rem; line-height: 1.3; }
        .af-warning .af-title { color: #92400e; }
        .af-info .af-title { color: var(--txt-dark); }
        .af-text { font-size: 0.625rem; color: var(--txt-muted); line-height: 1.45; }

        /* Footer */
        .folder-footer {
            padding: 0.625rem 2rem;
            background: rgba(15,23,42,0.03);
            border-top: 1px solid var(--border-light);
            display: flex; align-items: center; justify-content: space-between;
        }
        .ff-left { font-size: 0.625rem; color: var(--txt-muted); display: flex; align-items: center; gap: 0.3rem; }
        .ff-left i { color: var(--verde); font-size: 0.55rem; }
        .ff-right { font-size: 0.55rem; color: var(--border); font-family: 'Space Grotesk', monospace; }

        :focus-visible { outline: none; box-shadow: 0 0 0 3px white, 0 0 0 5px var(--verde); border-radius: 4px; }

        /* ===== IMPRESSÃO — CABEÇA NA PÁGINA ===== */
        @media print {
            @page { size: A4 portrait; margin: 10mm; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; color-adjust: exact !important; }
            html, body { background: white !important; margin: 0 !important; padding: 0 !important; }
            .screen-only { display: none !important; }
            .folder-wrap { max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
            .folder-page {
                border: 1.5pt solid var(--verde) !important;
                border-radius: 4mm !important;
                box-shadow: none !important;
                animation: none !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Header */
            .folder-header {
                padding: 4mm 5mm !important;
                background: linear-gradient(135deg, var(--escuro) 0%, #0f172a 100%) !important;
                border-radius: 2.5mm 2.5mm 0 0 !important;
            }
            .folder-header::before { display: none !important; }
            .fh-icon { width: 7mm; height: 7mm; font-size: 5pt; border-radius: 1.5mm; }
            .fh-name { font-size: 10pt !important; }
            .fh-sub { font-size: 6pt !important; }
            .fh-badge { font-size: 5pt !important; padding: 0.3mm 1.5mm; }

            /* Body */
            .folder-body { padding: 4mm 5mm 3mm !important; }

            /* QR */
            .qr-hero {
                padding: 3mm 3mm 2mm !important; margin-bottom: 3mm !important;
                border: 1pt solid rgba(139,189,71,0.15) !important; border-radius: 2mm !important;
            }
            .qr-hero-label { font-size: 5.5pt !important; margin-bottom: 2mm !important; letter-spacing: 0.08em; }
            .qr-hero-wrap { padding: 2mm !important; border-width: 1pt !important; border-radius: 1.5mm !important; }
            .qr-hero-wrap::before { display: none !important; }
            .qr-hero-wrap canvas, .qr-hero-wrap img { width: 30mm !important; height: 30mm !important; }
            .qr-hero-hint { font-size: 5.5pt !important; margin-top: 1.5mm !important; }
            .qr-hero-url { display: none !important; }

            /* Split */
            .content-split { grid-template-columns: 1fr 1fr !important; gap: 3mm !important; margin-bottom: 2.5mm !important; }

            /* Steps */
            .steps-flow { margin-bottom: 0 !important; }
            .fs-title { font-size: 7pt !important; margin-bottom: 2mm !important; padding-bottom: 1.5mm !important; }
            .fs-title::after { width: 10mm !important; }
            .fs-title-icon { width: 4.5mm !important; height: 4.5mm !important; font-size: 4.5pt !important; border-radius: 1mm !important; }
            .step-row { padding: 1mm 2mm !important; gap: 1.5mm !important; }
            .step-num { width: 4mm !important; height: 4mm !important; font-size: 4pt !important; }
            .step-heading { font-size: 6.5pt !important; }
            .step-detail { font-size: 5.5pt !important; line-height: 1.35; }
            .step-connector { display: none !important; }

            /* Fields */
            .fields-grid { gap: 0.75mm !important; }
            .field-chip { padding: 0.8mm 1.5mm !important; font-size: 6pt !important; border-radius: 1mm !important; }
            .field-chip i { font-size: 4.5pt !important; }
            .field-chip .req { font-size: 4pt !important; }
            .field-chip .opt { font-size: 4pt !important; }
            .minor-box { padding: 1.5mm 2mm !important; margin-top: 1mm !important; }
            .minor-label { font-size: 5pt !important; margin-bottom: 1mm !important; }
            .minor-fields { gap: 0.5mm !important; }
            .minor-field-chip { padding: 0.5mm 1mm !important; font-size: 5.5pt !important; }
            .minor-field-chip i { font-size: 4pt !important; }

            /* Docs */
            .docs-row { gap: 1.5mm !important; margin-bottom: 2mm !important; }
            .doc-row { padding: 1mm 2mm !important; }
            .doc-row-icon { width: 4mm !important; height: 4mm !important; font-size: 4.5pt !important; border-radius: 0.5mm !important; }
            .doc-row-text { font-size: 6.5pt !important; }
            .doc-row-note { font-size: 5pt !important; }

            /* Alerts */
            .alerts-row { grid-template-columns: 1fr 1fr !important; gap: 2mm !important; margin-bottom: 0 !important; }
            .alert-folder { padding: 2mm 2.5mm !important; border-radius: 1mm !important; gap: 1.5mm !important; }
            .af-icon { width: 3.5mm !important; height: 3.5mm !important; font-size: 4pt !important; border-radius: 0.5mm !important; }
            .af-title { font-size: 5.5pt !important; line-height: 1.25; }
            .af-text { font-size: 5pt !important; line-height: 1.35; }

            /* Footer */
            .folder-footer { padding: 2mm 5mm !important; }
            .ff-left { font-size: 5pt !important; }
            .ff-right { font-size: 4.5pt !important; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }

        @media (max-width: 640px) {
            .app-topbar { padding: 0.5rem 0.75rem; }
            .topbar-title { font-size: 0.875rem; }
            .topbar-subtitle { display: none; }
            .user-chip span { display: none; }
            .btn-screen-print .btn-text { display: none; }
            .btn-logout span { display: none; }
            .topbar-divider { display: none; }
            .folder-wrap { margin: 1rem auto; padding: 0 0.75rem; }
            .folder-header { padding: 1rem 1.25rem; }
            .folder-body { padding: 1.25rem; }
            .content-split { grid-template-columns: 1fr; }
            .alerts-row { grid-template-columns: 1fr; }
            .folder-footer { flex-direction: column; align-items: flex-start; gap: 0.25rem; }
        }
    </style>
</head>
<body>

    {{-- TOPBAR --}}
    <header class="app-topbar screen-only">
        <div class="topbar-left">
            <a href="{{ route('senha.index') }}" class="btn-back-topbar" title="Voltar para opcoes do sistema">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="topbar-logo" aria-hidden="true"><i class="fa-solid fa-graduation-cap"></i></div>
            <div>
                <h1 class="topbar-title">Atende XP</h1>
                <p class="topbar-subtitle">Emissao de Senhas</p>
            </div>
        </div>
        <div class="topbar-right">
            <button onclick="window.print()" class="btn-screen-print" aria-label="Imprimir folder">
                <i class="fa-solid fa-print text-xs" aria-hidden="true"></i>
                <span class="btn-text">Imprimir</span>
            </button>
            <div class="topbar-divider" aria-hidden="true"></div>
            <div class="user-chip" aria-label="Usuario logado">
                <i class="fa-solid fa-user"></i>
                <span>{{ session('login')['nome_completo'] ?? '' }}</span>
            </div>
            <a href="{{ route('login') }}" class="btn-logout" title="Sair do sistema">
                <i class="fa-solid fa-right-from-bracket"></i><span>Sair</span>
            </a>
        </div>
    </header>

    {{-- FOLDER --}}
    <div class="folder-wrap">
        <div class="folder-page">

            {{-- HEADER --}}
            <div class="folder-header">
                <div class="fh-icon" aria-hidden="true"><i class="fa-solid fa-graduation-cap"></i></div>
                <div class="fh-info">
                    <div class="fh-name">CIDADE DO SABER</div>
                    <div class="fh-sub">Prefeitura de Camacari</div>
                </div>
                <span class="fh-badge">Folder Informativo</span>
            </div>

            <div class="folder-body">

                {{-- QR CODE --}}
                <div class="qr-hero">
                    <div class="qr-hero-label">
                        <i class="fa-solid fa-qrcode" aria-hidden="true"></i>
                        Escaneie para iniciar o pre-cadastro
                    </div>
                    <div class="qr-hero-wrap">
                        <div id="qrPreCadastro" data-url="{{ route('precadastro.index') }}" role="img" aria-label="QR Code de acesso ao formulario de pre-cadastro"></div>
                    </div>
                    <p class="qr-hero-hint">
                        <i class="fa-solid fa-camera" aria-hidden="true"></i>
                        Abra a camera do celular e aponte para o codigo acima
                    </p>
                    <p class="qr-hero-url">{{ route('precadastro.index') }}</p>
                </div>

                {{-- CONTEÚDO EM DUAS COLUNAS: PASSOS À ESQUERDA, CAMPOS À DIREITA --}}
                <div class="content-split">

                    {{-- COLUNA ESQUERDA: PASSO A PASSO --}}
                    <div class="steps-flow">
                        <div class="fs-title">
                            <div class="fs-title-icon icon-verde"><i class="fa-solid fa-list-ol"></i></div>
                            Como realizar
                        </div>
                        <div class="step-row">
                            <div class="step-num" aria-hidden="true">1</div>
                            <div class="step-body">
                                <div class="step-heading">Escaneie o QR Code</div>
                                <div class="step-detail">Use a camera do celular para acessar o formulario online. Nenhum app necessario.</div>
                            </div>
                        </div>
                        <div class="step-connector" aria-hidden="true"></div>
                        <div class="step-row">
                            <div class="step-num" aria-hidden="true">2</div>
                            <div class="step-body">
                                <div class="step-heading">Verificacao de seguranca</div>
                                <div class="step-detail">Pressione e segure o botao por 3 segundos para confirmar que voce e humano.</div>
                            </div>
                        </div>
                        <div class="step-connector" aria-hidden="true"></div>
                        <div class="step-row">
                            <div class="step-num" aria-hidden="true">3</div>
                            <div class="step-body">
                                <div class="step-heading">Preencha o formulario</div>
                                <div class="step-detail">Informe seus dados pessoais. Menores de 18 anos tambem precisam dados do responsavel.</div>
                            </div>
                        </div>
                        <div class="step-connector" aria-hidden="true"></div>
                        <div class="step-row">
                            <div class="step-num" aria-hidden="true">4</div>
                            <div class="step-body">
                                <div class="step-heading">Compareca presencialmente</div>
                                <div class="step-detail">Va a Coordenacao de Cursos com os documentos para retirar sua carteirinha de acesso ao App.</div>
                            </div>
                        </div>
                    </div>

                    {{-- COLUNA DIREITA: CAMPOS + MENORES --}}
                    <div>
                        <div class="fs-title">
                            <div class="fs-title-icon icon-escuro"><i class="fa-solid fa-pen-to-square"></i></div>
                            Dados solicitados
                        </div>
                        <div class="fields-grid">
                            <div class="field-chip"><i class="fa-solid fa-user"></i> Nome completo <span class="req">OBG</span></div>
                            <div class="field-chip"><i class="fa-solid fa-id-card"></i> CPF <span class="req">OBG</span></div>
                            <div class="field-chip"><i class="fa-solid fa-calendar"></i> Data de nascimento <span class="req">OBG</span></div>
                            <div class="field-chip"><i class="fa-solid fa-venus-mars"></i> Sexo <span class="req">OBG</span></div>
                            <div class="field-chip"><i class="fa-solid fa-mobile-screen"></i> Telefone celular <span class="req">OBG</span></div>
                            <div class="field-chip"><i class="fa-solid fa-person-dress"></i> Nome da mae <span class="req">OBG</span></div>
                            <div class="field-chip"><i class="fa-solid fa-envelope"></i> E-mail <span class="opt">opcional</span></div>
                        </div>
                        <div class="minor-box">
                            <div class="minor-label"><i class="fa-solid fa-user-tie"></i> Menor de 18 anos (extras)</div>
                            <div class="minor-fields">
                                <div class="minor-field-chip"><i class="fa-solid fa-user-shield"></i> Nome do responsavel</div>
                                <div class="minor-field-chip"><i class="fa-solid fa-id-card"></i> CPF do responsavel</div>
                                <div class="minor-field-chip"><i class="fa-solid fa-people-arrows"></i> Grau de parentesco</div>
                                <div class="minor-field-chip"><i class="fa-solid fa-check-square"></i> Aceite do termo (LGPD/ECA)</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DOCUMENTOS --}}
                <div class="docs-row">
                    <div class="fs-title" style="margin-bottom: 0.375rem;">
                        <div class="fs-title-icon icon-laranja"><i class="fa-solid fa-folder-open"></i></div>
                        Documentos para o atendimento presencial
                    </div>
                    <div class="doc-row">
                        <div class="doc-row-icon"><i class="fa-solid fa-id-card"></i></div>
                        <div>
                            <div class="doc-row-text">Documento de identificacao com foto</div>
                            <div class="doc-row-note">RG, CPF ou CNH — original</div>
                        </div>
                    </div>
                    <div class="doc-row">
                        <div class="doc-row-icon"><i class="fa-solid fa-house"></i></div>
                        <div>
                            <div class="doc-row-text">Comprovante de residencia</div>
                            <div class="doc-row-note">Conta de agua, luz ou telefone recente</div>
                        </div>
                    </div>
                </div>

                {{-- ALERTAS LADO A LADO --}}
                <div class="alerts-row">
                    <div class="alert-folder af-warning">
                        <div class="af-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <div>
                            <div class="af-title">Pre-cadastro online nao substitui o presencial</div>
                            <div class="af-text">Compareca a Coordenacao de Cursos com documentos para emissao da carteirinha e assinatura do Termo.</div>
                        </div>
                    </div>
                    <div class="alert-folder af-info">
                        <div class="af-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div>
                            <div class="af-title">Carteirinha e pessoal e intransferivel</div>
                            <div class="af-text">Com ela, acesse o App da Cidade do Saber para gerar tokens de matricula e acompanhar turmas.</div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="folder-footer">
                <div class="ff-left"><i class="fa-solid fa-seedling" aria-hidden="true"></i> Cidade do Saber — Prefeitura de Camacari</div>
                <div class="ff-right">Impresso em {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
            </div>

        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var qrEl = document.getElementById('qrPreCadastro');
        if (qrEl) {
            var url = qrEl.getAttribute('data-url');
            if (url) {
                try {
                    new QRCode(qrEl, {
                        text: url,
                        width: 150,
                        height: 150,
                        colorDark: '#1E293B',
                        colorLight: '#ffffff',
                        correctLevel: QRCode.CorrectLevel.M
                    });
                } catch (e) {
                    qrEl.innerHTML = '<div style="width:150px;height:150px;display:flex;align-items:center;justify-content:center;border:2px dashed var(--border);border-radius:0.75rem;font-size:0.7rem;color:var(--txt-muted);text-align:center;padding:0.75rem;">QR indisponivel</div>';
                }
            }
        }
    });
    </script>
</body>
</html>