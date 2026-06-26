<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatorio de Matriculas — Atende XP</title>
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
            --verde: #8BBD47; --verde-dark: #6a9a2f; --verde-light: #a8d465;
            --dourado: #FFAD02; --laranja: #EF8E26; --escuro: #1E293B;
            --claro: #F9F9F9; --branco: #FFFFFF;
            --txt-dark: #0F172A; --txt-body: #334155; --txt-muted: #64748B;
            --border: #CBD5E1; --border-light: #E2E8F0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--claro); color: var(--txt-body);
            min-height: 100vh; display: flex; flex-direction: column;
        }

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
        .btn-ghost {
            display: inline-flex; align-items: center; gap: 0.375rem;
            padding: 0.4rem 0.875rem; border-radius: 0.5rem;
            font-size: 0.8rem; font-weight: 600; font-family: 'Space Grotesk', sans-serif;
            color: var(--txt-muted); background: transparent;
            border: 1.5px solid transparent; cursor: pointer;
            text-decoration: none; transition: all 0.25s cubic-bezier(0.22,1,0.36,1);
            min-height: 36px; white-space: nowrap;
        }
        .btn-ghost:hover { color: var(--txt-dark); background: rgba(15,23,42,0.04); border-color: var(--border-light); }
        .btn-logout:hover { color: #dc2626; background: rgba(239,68,68,0.05); border-color: rgba(239,68,68,0.15); }
        .btn-export-excel { color: #15803d; background: rgba(22,163,74,0.08); border: 1.5px solid rgba(22,163,74,0.2); }
        .btn-export-excel:hover {
            background: #16a34a; color: white; border-color: #16a34a;
            transform: translateY(-1px); box-shadow: 0 4px 12px rgba(22,163,74,0.3);
        }
        .btn-screen-print { color: #4d7c0f; background: rgba(139,189,71,0.08); border: 1.5px solid rgba(139,189,71,0.2); }
        .btn-screen-print:hover {
            background: var(--verde); color: white; border-color: var(--verde);
            transform: translateY(-1px); box-shadow: 0 4px 12px rgba(139,189,71,0.35);
        }
        .topbar-divider { width: 1px; height: 24px; background: var(--border-light); margin: 0 0.125rem; }

        .report-wrap {
            flex: 1; width: 100%; max-width: 1500px;
            margin: 0 auto; padding: 1.25rem; position: relative; z-index: 1;
        }

        /* ===== CARDS ===== */
        .summary-row { display: grid; grid-template-columns: repeat(5, 1fr); gap: 0.75rem; margin-bottom: 1rem; }
        .summary-card {
            background: var(--branco); border: 1px solid var(--border-light);
            border-radius: 1rem; padding: 1rem 0.875rem;
            position: relative; overflow: hidden;
            animation: fadeUp 0.4s cubic-bezier(0.22,1,0.36,1) both;
        }
        .summary-card:nth-child(1) { animation-delay: 0.03s; }
        .summary-card:nth-child(2) { animation-delay: 0.06s; }
        .summary-card:nth-child(3) { animation-delay: 0.09s; }
        .summary-card:nth-child(4) { animation-delay: 0.12s; }
        .summary-card:nth-child(5) { animation-delay: 0.15s; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .summary-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
        .sc-verde::before { background: linear-gradient(90deg, var(--verde), var(--verde-light)); }
        .sc-dourado::before { background: linear-gradient(90deg, var(--dourado), #fbbf24); }
        .sc-laranja::before { background: linear-gradient(90deg, var(--laranja), #f59e0b); }
        .sc-vermelho::before { background: linear-gradient(90deg, #ef4444, #f87171); }
        .sc-escuro::before { background: linear-gradient(90deg, var(--escuro), #475569); }
        .sc-icon {
            width: 32px; height: 32px; border-radius: 0.5rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; margin-bottom: 0.5rem;
        }
        .sc-verde .sc-icon { background: rgba(139,189,71,0.1); color: var(--verde-dark); }
        .sc-dourado .sc-icon { background: rgba(255,173,2,0.1); color: #b45309; }
        .sc-laranja .sc-icon { background: rgba(239,142,38,0.1); color: #c2410c; }
        .sc-vermelho .sc-icon { background: rgba(239,68,68,0.1); color: #dc2626; }
        .sc-escuro .sc-icon { background: rgba(30,41,59,0.08); color: var(--txt-body); }
        .sc-value { font-family: 'Sora', sans-serif; font-weight: 800; font-size: 1.35rem; color: var(--txt-dark); line-height: 1; }
        .sc-label { font-size: 0.65rem; color: var(--txt-muted); margin-top: 0.2rem; font-weight: 500; }

        /* ===== FILTROS ===== */
        .filter-bar {
            background: var(--branco); border: 1px solid var(--border-light);
            border-radius: 1rem; padding: 0.75rem 1rem; margin-bottom: 0.75rem;
            animation: fadeUp 0.4s cubic-bezier(0.22,1,0.36,1) 0.18s both;
        }
        .filter-row { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
        .filter-row + .filter-row { margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px solid var(--border-light); }
        .filter-search { position: relative; flex: 1; min-width: 180px; }
        .filter-search i {
            position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%);
            color: var(--txt-muted); font-size: 0.75rem; pointer-events: none;
        }
        .filter-input, .filter-select {
            min-height: 38px; border: 1.5px solid var(--border); border-radius: 0.5rem;
            font-family: 'Space Grotesk', sans-serif; font-size: 0.8rem;
            color: var(--txt-dark); background: var(--claro);
            transition: all 0.2s; outline: none;
        }
        .filter-input { width: 100%; padding: 0 0.75rem 0 2.25rem; }
        .filter-input:focus, .filter-select:focus {
            border-color: var(--verde); box-shadow: 0 0 0 3px rgba(139,189,71,0.1);
        }
        .filter-input::placeholder { color: #94a3b8; }
        .filter-select {
            padding: 0 2rem 0 0.625rem;
            appearance: none; -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 0.5rem center;
            cursor: pointer; white-space: nowrap;
        }
        .filter-select option { background: white; }
        .btn-filter {
            min-height: 38px; padding: 0 1rem; border-radius: 0.5rem; border: none;
            background: linear-gradient(135deg, var(--verde), var(--verde-dark));
            color: white; font-family: 'Space Grotesk', sans-serif;
            font-weight: 700; font-size: 0.8rem; cursor: pointer;
            display: flex; align-items: center; gap: 0.375rem;
            transition: all 0.25s cubic-bezier(0.22,1,0.36,1); white-space: nowrap;
        }
        .btn-filter:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(139,189,71,0.35); }
        .btn-clear {
            min-height: 38px; padding: 0 0.75rem; border-radius: 0.5rem;
            border: 1.5px solid var(--border); background: white;
            color: var(--txt-muted); font-family: 'Space Grotesk', sans-serif;
            font-weight: 600; font-size: 0.8rem; cursor: pointer;
            text-decoration: none; transition: all 0.2s; white-space: nowrap;
        }
        .btn-clear:hover { border-color: var(--border); color: var(--txt-dark); background: var(--claro); }
        .filter-count {
            font-size: 0.7rem; color: var(--txt-muted); font-weight: 500;
            white-space: nowrap; margin-left: auto;
        }
        .filter-count strong { color: var(--txt-dark); font-weight: 700; }

        /* ===== TABELA ===== */
        .table-section {
            background: var(--branco); border: 1px solid var(--border-light);
            border-radius: 1rem; overflow: hidden;
            animation: fadeUp 0.4s cubic-bezier(0.22,1,0.36,1) 0.22s both;
        }
        .table-scroll {
            overflow-x: auto; scrollbar-width: thin;
            scrollbar-color: var(--border) transparent;
        }
        .table-scroll::-webkit-scrollbar { height: 6px; }
        .table-scroll::-webkit-scrollbar-track { background: transparent; }
        .table-scroll::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
        .report-table { width: 100%; min-width: 1200px; border-collapse: collapse; font-size: 0.775rem; }
        .report-table thead { position: sticky; top: 0; z-index: 2; }
        .report-table th {
            background: var(--escuro); color: rgba(255,255,255,0.8);
            font-family: 'Sora', sans-serif; font-weight: 600; font-size: 0.625rem;
            text-transform: uppercase; letter-spacing: 0.05em;
            padding: 0.625rem 0.625rem; text-align: left;
            white-space: nowrap; border-bottom: 2px solid var(--verde);
        }
        .report-table th.th-center { text-align: center; }
        .report-table td {
            padding: 0.5rem 0.625rem; border-bottom: 1px solid var(--border-light);
            vertical-align: middle; white-space: nowrap;
        }
        .report-table tbody tr { transition: background 0.15s; }
        .report-table tbody tr:hover { background: rgba(139,189,71,0.03); }
        .report-table tbody tr:last-child td { border-bottom: none; }

        /* --- Coluna turma (sticky + link) --- */
        .col-turma {
            position: sticky; left: 0; z-index: 1; background: inherit;
        }
        .report-table thead .col-turma { background: var(--escuro); z-index: 3; }
        .report-table tbody tr:hover .col-turma { background: rgba(139,189,71,0.03); }
        .col-turma a.turma-link,
        .col-curso a.curso-link {
            color: inherit; text-decoration: none; cursor: pointer;
            display: block; border-radius: 0.25rem;
            transition: all 0.15s;
        }
        .col-turma a.turma-link {
            font-family: 'Sora', sans-serif; font-weight: 700;
            font-size: 0.8rem; color: var(--txt-dark);
            padding: 0.125rem 0.375rem; margin: -0.125rem -0.625rem;
        }
        .col-curso a.curso-link {
            font-weight: 500; color: var(--txt-dark);
            max-width: 180px; overflow: hidden; text-overflow: ellipsis;
            padding: 0.125rem 0.375rem; margin: -0.125rem -0.625rem;
        }
        .col-turma a.turma-link:hover,
        .col-curso a.curso-link:hover {
            color: var(--verde-dark);
            background: rgba(139,189,71,0.1);
        }
        .col-turma a.turma-link .link-icon,
        .col-curso a.curso-link .link-icon {
            font-size: 0.55rem; opacity: 0; margin-left: 0.25rem;
            transition: opacity 0.15s, transform 0.15s; display: inline-block;
        }
        .col-turma a.turma-link:hover .link-icon,
        .col-curso a.curso-link:hover .link-icon {
            opacity: 0.7; transform: translateX(1px);
        }

        /* --- Headers ordenáveis --- */
        .th-sortable {
            display: inline-flex; align-items: center; gap: 0.25rem;
            cursor: pointer; color: rgba(255,255,255,0.8);
            text-decoration: none; user-select: none;
            transition: color 0.15s; border-radius: 3px;
            padding: 0.125rem 0.25rem; margin: -0.125rem -0.375rem;
        }
        .th-sortable:hover { color: white; background: rgba(255,255,255,0.06); }
        .th-sortable .sort-arrow { font-size: 0.5rem; opacity: 0.35; transition: opacity 0.15s; }
        .th-sortable.th-sorted .sort-arrow { opacity: 1; }
        .th-sortable.th-sorted { color: white; }

        .badge-seg {
            display: inline-flex; padding: 0.1rem 0.4rem; border-radius: 4px;
            font-size: 0.55rem; font-weight: 700; letter-spacing: 0.03em;
            font-family: 'Sora', sans-serif;
        }
        .badge-cultura { background: rgba(139,189,71,0.12); color: #4d7c0f; }
        .badge-sejuv { background: rgba(255,173,2,0.12); color: #92400e; }
        .badge-outro { background: rgba(100,116,139,0.1); color: #475569; }

        .oc-bar-wrap { display: flex; align-items: center; gap: 0.375rem; }
        .oc-bar-track { flex: 1; height: 7px; min-width: 50px; background: rgba(15,23,42,0.06); border-radius: 4px; overflow: hidden; }
        .oc-bar-fill { height: 100%; border-radius: 4px; transition: width 0.4s; }
        .oc-ideal { background: linear-gradient(90deg, var(--verde), var(--verde-light)); }
        .oc-bom { background: linear-gradient(90deg, var(--dourado), #fbbf24); }
        .oc-atencao { background: linear-gradient(90deg, var(--laranja), #f59e0b); }
        .oc-baixo { background: #94a3b8; }
        .oc-excesso { background: linear-gradient(90deg, #ef4444, #f87171); }
        .oc-pct { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 0.7rem; min-width: 35px; text-align: right; }
        .pct-ideal { color: #4d7c0f; }
        .pct-bom { color: #92400e; }
        .pct-atencao { color: #c2410c; }
        .pct-baixo { color: var(--txt-muted); }
        .pct-excesso { color: #dc2626; }

        .vagas-text { font-size: 0.7rem; color: var(--txt-body); }
        .vagas-text strong { color: var(--txt-dark); }
        .vagas-sobra { color: var(--verde-dark); font-size: 0.6rem; display: block; }

        .badge-pcd {
            display: inline-flex; align-items: center; gap: 0.15rem;
            padding: 0.1rem 0.35rem; border-radius: 4px;
            background: rgba(99,102,241,0.08); color: #4f46e5;
            font-size: 0.65rem; font-weight: 700; font-family: 'Sora', sans-serif;
        }
        .dash { color: var(--border); }

        .gender-wrap { display: flex; flex-direction: column; gap: 0.1rem; }
        .gender-bar-track { height: 4px; border-radius: 2px; overflow: hidden; background: var(--escuro); display: flex; }
        .gender-bar-f { background: var(--verde); transition: width 0.4s; }
        .gender-bar-m { background: #475569; transition: width 0.4s; }
        .gender-labels { font-size: 0.6rem; color: var(--txt-muted); display: flex; gap: 0.4rem; }

        .saude-icon {
            display: inline-flex; align-items: center; gap: 0.2rem;
            padding: 0.1rem 0.35rem; border-radius: 4px;
            font-size: 0.65rem; font-weight: 700; font-family: 'Sora', sans-serif;
            background: rgba(239,68,68,0.08); color: #dc2626;
        }
        .saude-icon i { font-size: 0.55rem; }

        .report-table tfoot td {
            background: rgba(15,23,42,0.03); font-family: 'Sora', sans-serif;
            font-weight: 700; font-size: 0.725rem; color: var(--txt-dark);
            padding: 0.625rem; border-top: 2px solid var(--border); position: relative;
        }
        .report-table tfoot .col-turma { background: rgba(15,23,42,0.03); }
        .report-table tfoot tr:hover td { background: rgba(15,23,42,0.03); }
        .total-label { font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.06em; color: var(--txt-muted); font-weight: 600; }

        .empty-state { text-align: center; padding: 3rem 1rem; }
        .empty-state i { font-size: 2rem; color: var(--border); margin-bottom: 0.75rem; }
        .empty-state p { font-size: 0.875rem; color: var(--txt-muted); }

        :focus-visible { outline: none; box-shadow: 0 0 0 3px white, 0 0 0 5px var(--verde); border-radius: 4px; }

        @media print {
            @page { size: A4 landscape; margin: 6mm; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; color-adjust: exact !important; }
            body { background: white !important; }
            .screen-only { display: none !important; }
            .report-wrap { max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
            .summary-row { grid-template-columns: repeat(5, 1fr) !important; gap: 2mm !important; margin-bottom: 3mm !important; }
            .summary-card { border: 0.5pt solid var(--border-light) !important; border-radius: 1.5mm !important; padding: 2mm 2.5mm !important; box-shadow: none !important; animation: none !important; }
            .summary-card::before { height: 1pt !important; }
            .sc-icon { width: 4mm; height: 4mm; font-size: 5pt; margin-bottom: 0.5mm; border-radius: 1mm; }
            .sc-value { font-size: 9pt !important; }
            .sc-label { font-size: 5pt !important; }
            .filter-bar { display: none !important; }
            .table-section { border: 0.5pt solid var(--border-light) !important; border-radius: 0 !important; box-shadow: none !important; animation: none !important; }
            .report-table { font-size: 5.5pt !important; min-width: 0 !important; }
            .report-table th { padding: 1.5mm 1.5mm !important; font-size: 4.5pt !important; }
            .report-table td { padding: 1mm 1.5mm !important; }
            .col-turma { position: static !important; }
            .report-table thead .col-turma { position: static !important; }
            .col-turma a.turma-link, .col-curso a.curso-link { color: inherit !important; background: none !important; padding: 0 !important; margin: 0 !important; }
            .col-turma a.turma-link .link-icon, .col-curso a.curso-link .link-icon { display: none !important; }
            .oc-bar-track { height: 2.5mm !important; min-width: 15mm !important; }
            .gender-bar-track { height: 1.5mm !important; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }
        @media (max-width: 1100px) { .summary-row { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) {
            .app-topbar { padding: 0.5rem 0.75rem; }
            .topbar-title { font-size: 0.875rem; }
            .topbar-subtitle { display: none; }
            .user-chip span { display: none; }
            .btn-ghost .btn-text { display: none; }
            .topbar-divider { display: none; }
            .report-wrap { padding: 0.75rem; }
            .summary-row { grid-template-columns: repeat(2, 1fr); gap: 0.5rem; }
            .filter-row { gap: 0.375rem; }
            .filter-search { min-width: 100%; }
            .sc-value { font-size: 1.1rem; }
        }
        @media (max-width: 480px) {
            .summary-row { grid-template-columns: 1fr 1fr; }
            .summary-card:last-child { grid-column: span 2; }
        }
    </style>
</head>
<body>
    @php
    $sortUrl = function($field) use ($filtros) {
        $fb = $filtros['sort_by'] ?? '';
        $fd = $filtros['sort_dir'] ?? 'asc';
        $isCurrent = $fb === $field;
        $dir = $isCurrent && $fd === 'asc' ? 'desc' : 'asc';
        $arrow = $isCurrent ? ($dir === 'asc' ? 'fa-sort-up' : 'fa-sort-down') : 'fa-sort';
        $p = array_merge($filtros, ['sort_by' => $field, 'sort_dir' => $dir]);
        return ['url' => route('relatorio.matriculas', $p), 'arrow' => $arrow, 'active' => $isCurrent];
    };
@endphp
    {{-- Form oculto para POST --}}
    <form id="formGoSenha" method="POST" action="{{ route('senha.imprimir') }}" style="display:none;">
        @csrf
        <input type="hidden" name="cod_turma" id="inputGoSenha">
    </form>

    <header class="app-topbar screen-only">
        <div class="topbar-left">
            <a href="{{ route('senha.index') }}" class="btn-back-topbar" title="Voltar">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="topbar-logo" aria-hidden="true"><i class="fa-solid fa-graduation-cap"></i></div>
            <div>
                <h1 class="topbar-title">Atende XP</h1>
                <p class="topbar-subtitle">Relatorios</p>
            </div>
        </div>
        <div class="topbar-right">
            <a href="{{ route('relatorio.matriculas.excel', request()->query()) }}"
               class="btn-ghost btn-export-excel" aria-label="Exportar para Excel" title="Exportar CSV para Excel">
                <i class="fa-solid fa-file-excel text-xs" aria-hidden="true"></i>
                <span class="btn-text">Excel</span>
            </a>
            <button onclick="window.print()" class="btn-ghost btn-screen-print" aria-label="Imprimir relatorio">
                <i class="fa-solid fa-print text-xs" aria-hidden="true"></i>
                <span class="btn-text">PDF</span>
            </button>
            <div class="topbar-divider" aria-hidden="true"></div>
            <div class="user-chip" aria-label="Usuario logado">
                <i class="fa-solid fa-user"></i>
                <span>{{ session('login')['nome_completo'] ?? '' }}</span>
            </div>
            <a href="{{ route('login') }}" class="btn-ghost btn-logout" title="Sair">
                <i class="fa-solid fa-right-from-bracket"></i><span>Sair</span>
            </a>
        </div>
    </header>

    <div class="report-wrap">

        {{-- CARDS RESUMO --}}
        <div class="summary-row">
            <div class="summary-card sc-escuro">
                <div class="sc-icon"><i class="fa-solid fa-layer-group"></i></div>
                <div class="sc-value">{{ number_format($resumo['total_turmas'], 0, ',', '.') }}</div>
                <div class="sc-label">Turmas ativas</div>
            </div>
            <div class="summary-card sc-verde">
                <div class="sc-icon"><i class="fa-solid fa-user-graduate"></i></div>
                <div class="sc-value">{{ number_format($resumo['total_matriculados'], 0, ',', '.') }}</div>
                <div class="sc-label">Matriculados</div>
            </div>
            <div class="summary-card sc-dourado">
                <div class="sc-icon"><i class="fa-solid fa-chair"></i></div>
                <div class="sc-value">{{ number_format($resumo['total_vagas'], 0, ',', '.') }}</div>
                <div class="sc-label">Vagas oferecidas</div>
            </div>
            <div class="summary-card sc-laranja">
                <div class="sc-icon"><i class="fa-solid fa-chart-pie"></i></div>
                <div class="sc-value">{{ number_format($resumo['ocupacao_media'], 1, ',', '.') }}%</div>
                <div class="sc-label">Ocupacao media</div>
            </div>
            <div class="summary-card sc-vermelho">
                <div class="sc-icon"><i class="fa-solid fa-heart-pulse"></i></div>
                <div class="sc-value">{{ number_format($resumo['total_alertas'], 0, ',', '.') }}</div>
                <div class="sc-label">Alertas de saude</div>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="filter-bar screen-only">
            <form method="GET" action="{{ route('relatorio.matriculas') }}" id="formFiltros">
                <div class="filter-row">
                    <div class="filter-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="busca" class="filter-input"
                            placeholder="Curso ou turma..."
                            value="{{ $filtros['busca'] ?? '' }}">
                    </div>

                    <select name="coordenacao" class="filter-select">
                        <option value="todos" {{ ($filtros['coordenacao'] ?? 'todos') === 'todos' ? 'selected' : '' }}>Coordenacao</option>
                        @foreach($coordenacoes as $nome => $val)
                            <option value="{{ $nome }}" {{ ($filtros['coordenacao'] ?? '') === $nome ? 'selected' : '' }}>{{ $nome }}</option>
                        @endforeach
                    </select>

                    <select name="periodo_letivo" class="filter-select">
                        <option value="todos" {{ ($filtros['periodo_letivo'] ?? 'todos') === 'todos' ? 'selected' : '' }}>Periodo letivo</option>
                        @foreach($periodos as $cod => $nome)
                            <option value="{{ $cod }}" {{ ($filtros['periodo_letivo'] ?? '') == $cod ? 'selected' : '' }}>{{ $nome }}</option>
                        @endforeach
                    </select>

                    <select name="curso" class="filter-select" style="max-width:200px;">
                        <option value="todos" {{ ($filtros['curso'] ?? 'todos') === 'todos' ? 'selected' : '' }}>Curso</option>
                        @foreach($cursos as $nome => $val)
                            <option value="{{ $nome }}" {{ ($filtros['curso'] ?? '') === $nome ? 'selected' : '' }}>{{ $nome }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-filter">
                        <i class="fa-solid fa-filter" style="font-size:0.7rem;" aria-hidden="true"></i> Filtrar
                    </button>
                    <a href="{{ route('relatorio.matriculas') }}" class="btn-clear">
                        <i class="fa-solid fa-rotate-left" style="font-size:0.65rem;" aria-hidden="true"></i> Limpar
                    </a>

                    <div class="filter-count">
                        <strong>{{ $dados->count() }}</strong> turma{{ $dados->count() != 1 ? 's' : '' }}
                    </div>
                </div>

                <div class="filter-row">
                    <select name="faixa_etaria" class="filter-select" style="max-width:160px;">
                        <option value="todos" {{ ($filtros['faixa_etaria'] ?? 'todos') === 'todos' ? 'selected' : '' }}>Faixa etaria</option>
                        <option value="ate17" {{ ($filtros['faixa_etaria'] ?? '') === 'ate17' ? 'selected' : '' }}>Ate 17 anos</option>
                        <option value="18a29" {{ ($filtros['faixa_etaria'] ?? '') === '18a29' ? 'selected' : '' }}>18 a 29 anos</option>
                        <option value="30a44" {{ ($filtros['faixa_etaria'] ?? '') === '30a44' ? 'selected' : '' }}>30 a 44 anos</option>
                        <option value="45a59" {{ ($filtros['faixa_etaria'] ?? '') === '45a59' ? 'selected' : '' }}>45 a 59 anos</option>
                        <option value="60plus" {{ ($filtros['faixa_etaria'] ?? '') === '60plus' ? 'selected' : '' }}>60+ anos</option>
                    </select>

                    <select name="saude" class="filter-select" style="max-width:140px;">
                        <option value="todos" {{ ($filtros['saude'] ?? 'todos') === 'todos' ? 'selected' : '' }}>Saude</option>
                        <option value="com" {{ ($filtros['saude'] ?? '') === 'com' ? 'selected' : '' }}>Com alerta</option>
                        <option value="sem" {{ ($filtros['saude'] ?? '') === 'sem' ? 'selected' : '' }}>Sem alerta</option>
                    </select>

                    <select name="pcd" class="filter-select" style="max-width:120px;">
                        <option value="todos" {{ ($filtros['pcd'] ?? 'todos') === 'todos' ? 'selected' : '' }}>PCD</option>
                        <option value="com" {{ ($filtros['pcd'] ?? '') === 'com' ? 'selected' : '' }}>Com PCD</option>
                        <option value="sem" {{ ($filtros['pcd'] ?? '') === 'sem' ? 'selected' : '' }}>Sem PCD</option>
                    </select>

                    <select name="tem_vaga" class="filter-select" style="max-width:130px;">
                        <option value="todos" {{ ($filtros['tem_vaga'] ?? 'todos') === 'todos' ? 'selected' : '' }}>Vagas</option>
                        <option value="sim" {{ ($filtros['tem_vaga'] ?? '') === 'sim' ? 'selected' : '' }}>Tem vaga</option>
                        <option value="nao" {{ ($filtros['tem_vaga'] ?? '') === 'nao' ? 'selected' : '' }}>Sem vaga</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- TABELA --}}
        <div class="table-section">
            <div class="table-scroll">
                @if($dados->isEmpty())
                    <div class="empty-state">
                        <i class="fa-solid fa-chart-column"></i>
                        <p>Nenhum dado encontrado para os filtros selecionados.</p>
                    </div>
                @else
                <table class="report-table" role="table">
                    <thead>
                        <tr>
                            @php $s = $sortUrl('cod_turma'); @endphp
                            <th class="col-turma">
                                <a href="{{ $s['url'] }}" class="th-sortable {{ $s['active'] ? 'th-sorted' : '' }}">
                                    Turma <i class="fa-solid {{ $s['arrow'] }} sort-arrow"></i>
                                </a>
                            </th>
                            @php $s = $sortUrl('nome_curso'); @endphp
                            <th>
                                <a href="{{ $s['url'] }}" class="th-sortable {{ $s['active'] ? 'th-sorted' : '' }}">
                                    Curso <i class="fa-solid {{ $s['arrow'] }} sort-arrow"></i>
                                </a>
                            </th>
                            @php $s = $sortUrl('coordenacao'); @endphp
                            <th>
                                <a href="{{ $s['url'] }}" class="th-sortable {{ $s['active'] ? 'th-sorted' : '' }}">
                                    Coord. <i class="fa-solid {{ $s['arrow'] }} sort-arrow"></i>
                                </a>
                            </th>
                            @php $s = $sortUrl('periodo_letivo'); @endphp
                            <th>
                                <a href="{{ $s['url'] }}" class="th-sortable {{ $s['active'] ? 'th-sorted' : '' }}">
                                    Periodo <i class="fa-solid {{ $s['arrow'] }} sort-arrow"></i>
                                </a>
                            </th>
                            <th>Horario</th>
                            <th>Turno</th>
                            <th>Dias</th>
                            <th>Faixa</th>
                            @php $s = $sortUrl('indice_ocupacao'); @endphp
                            <th style="min-width:155px;">
                                <a href="{{ $s['url'] }}" class="th-sortable {{ $s['active'] ? 'th-sorted' : '' }}">
                                    Ocupacao <i class="fa-solid {{ $s['arrow'] }} sort-arrow"></i>
                                </a>
                            </th>
                            @php $s = $sortUrl('matriculados'); @endphp
                            <th class="th-center">
                                <a href="{{ $s['url'] }}" class="th-sortable {{ $s['active'] ? 'th-sorted' : '' }}">
                                    Vagas <i class="fa-solid {{ $s['arrow'] }} sort-arrow"></i>
                                </a>
                            </th>
                            <th class="th-center">PCD</th>
                            <th style="min-width:105px;">Genero</th>
                            <th class="th-center">Saude</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $row)
                        @php
                            $oc = (float)($row->indice_ocupacao ?? 0);
                            if ($oc > 100)       { $ocC = 'oc-excesso'; $pC = 'pct-excesso'; }
                            elseif ($oc >= 85)  { $ocC = 'oc-ideal';   $pC = 'pct-ideal'; }
                            elseif ($oc >= 60)  { $ocC = 'oc-bom';      $pC = 'pct-bom'; }
                            elseif ($oc >= 40)  { $ocC = 'oc-atencao';  $pC = 'pct-atencao'; }
                            else                { $ocC = 'oc-baixo';    $pC = 'pct-baixo'; }
                            $barW = min($oc, 100);
                            $mat = (int)$row->matriculados;
                            $fPct = $mat > 0 ? round(($row->qtd_mulheres / $mat) * 100) : 0;
                            $seg = $row->coordenacao;
                            $segC = str_contains(strtoupper($seg), 'CULTURA') ? 'badge-cultura'
                                  : (str_contains(strtoupper($seg), 'SEJUV') ? 'badge-sejuv' : 'badge-outro');
                        @endphp
                        <tr>
                            <td class="col-turma">
                                <a href="javascript:void(0)" onclick="goSenha('{{ $row->cod_turma }}')" class="turma-link" title="Ver senhas desta turma">
                                    {{ $row->cod_turma }}<i class="fa-solid fa-arrow-up-right-from-square link-icon" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="col-curso" title="{{ $row->nome_curso }}">
                                <a href="javascript:void(0)" onclick="goSenha('{{ $row->cod_turma }}')" class="curso-link">
                                    {{ $row->nome_curso }}<i class="fa-solid fa-arrow-up-right-from-square link-icon" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td><span class="badge-seg {{ $segC }}">{{ $row->coordenacao }}</span></td>
                            <td><span style="font-size:0.7rem;color:var(--txt-muted);">{{ $row->periodo_letivo ?? '—' }}</span></td>
                            <td><span style="font-size:0.7rem;">{{ substr($row->hora_inicio ?? '00:00',0,5) }} — {{ substr($row->hora_termino ?? '00:00',0,5) }}</span></td>
                            <td><span style="font-size:0.7rem;font-weight:600;color:var(--txt-dark);">{{ $row->turno ?? '—' }}</span></td>
                            <td><span style="font-size:0.675rem;color:var(--txt-muted);">{{ $row->dias_de_aula }}</span></td>
                            <td><span style="font-size:0.7rem;">{{ $row->faixa_etaria }}</span></td>
                            <td>
                                <div class="oc-bar-wrap">
                                    <div class="oc-bar-track"><div class="oc-bar-fill {{ $ocC }}" style="width:{{ $barW }}%;"></div></div>
                                    <span class="oc-pct {{ $pC }}">{{ number_format($oc,1,',','.') }}%</span>
                                </div>
                            </td>
                            <td class="th-center">
                                <span class="vagas-text"><strong>{{ $row->matriculados }}</strong>/{{ $row->oferta_vagas }}</span>
                                @if($row->sobra_vagas > 0)
                                    <span class="vagas-sobra">+{{ $row->sobra_vagas }}</span>
                                @endif
                            </td>
                            <td class="th-center">
                                @if($row->qtd_pcd > 0)
                                    <span class="badge-pcd"><i class="fa-solid fa-wheelchair" style="font-size:0.5rem;"></i> {{ $row->qtd_pcd }}</span>
                                @else
                                    <span class="dash">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="gender-wrap">
                                    <div class="gender-bar-track">
                                        <div class="gender-bar-f" style="width:{{ $fPct }}%;"></div>
                                        <div class="gender-bar-m" style="width:{{ 100 - $fPct }}%;"></div>
                                    </div>
                                    <div class="gender-labels">
                                        <span style="color:var(--verde-dark);">F:{{ $row->qtd_mulheres }}</span>
                                        <span>M:{{ $row->qtd_homens }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="th-center">
                                @if($row->qtd_alerta_saude > 0)
                                    <span class="saude-icon"><i class="fa-solid fa-triangle-exclamation"></i> {{ $row->qtd_alerta_saude }}</span>
                                @else
                                    <span class="dash">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php
                            $tOc = (float)($totais['indice_ocupacao'] ?? 0);
                            if ($tOc > 100)       { $tOC = 'oc-excesso'; $tPC = 'pct-excesso'; }
                            elseif ($tOc >= 85)  { $tOC = 'oc-ideal';   $tPC = 'pct-ideal'; }
                            elseif ($tOc >= 60)  { $tOC = 'oc-bom';      $tPC = 'pct-bom'; }
                            elseif ($tOc >= 40)  { $tOC = 'oc-atencao';  $tPC = 'pct-atencao'; }
                            else                { $tOC = 'oc-baixo';    $tPC = 'pct-baixo'; }
                            $tFP = ($totais['matriculados'] ?? 0) > 0 ? round((($totais['qtd_mulheres'] ?? 0) / $totais['matriculados']) * 100) : 0;
                        @endphp
                        <tr>
                            <td class="col-turma"><span class="total-label">Total</span></td>
                            <td colspan="7"></td>
                            <td>
                                <div class="oc-bar-wrap">
                                    <div class="oc-bar-track"><div class="oc-bar-fill {{ $tOC }}" style="width:{{ min($tOc,100) }}%;"></div></div>
                                    <span class="oc-pct {{ $tPC }}">{{ number_format($tOc,1,',','.') }}%</span>
                                </div>
                            </td>
                            <td class="th-center"><span class="vagas-text"><strong>{{ number_format($totais['matriculados'],0,',','.') }}</strong>/{{ number_format($totais['oferta_vagas'],0,',','.') }}</span></td>
                            <td class="th-center">
                                @if($totais['qtd_pcd'] > 0)
                                    <span class="badge-pcd"><i class="fa-solid fa-wheelchair" style="font-size:0.5rem;"></i> {{ number_format($totais['qtd_pcd'],0,',','.') }}</span>
                                @else <span class="dash">—</span> @endif
                            </td>
                            <td>
                                <div class="gender-wrap">
                                    <div class="gender-bar-track">
                                        <div class="gender-bar-f" style="width:{{ $tFP }}%;"></div>
                                        <div class="gender-bar-m" style="width:{{ 100-$tFP }}%;"></div>
                                    </div>
                                    <div class="gender-labels">
                                        <span style="color:var(--verde-dark);">F:{{ number_format($totais['qtd_mulheres'],0,',','.') }}</span>
                                        <span>M:{{ number_format($totais['qtd_homens'],0,',','.') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="th-center">
                                @if($totais['qtd_alerta_saude'] > 0)
                                    <span class="saude-icon"><i class="fa-solid fa-triangle-exclamation"></i> {{ number_format($totais['qtd_alerta_saude'],0,',','.') }}</span>
                                @else <span class="dash">—</span> @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>
                @endif
            </div>
        </div>

    </div>

    <script>
    // POST para rota de senha
    function goSenha(codTurma) {
        document.getElementById('inputGoSenha').value = codTurma;
        document.getElementById('formGoSenha').submit();
    }

    // Enter no campo de busca submete o formulário
    document.getElementById('formFiltros').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.classList.contains('filter-input')) {
            e.preventDefault();
            this.submit();
        }
    });
    </script>
</body>
</html>