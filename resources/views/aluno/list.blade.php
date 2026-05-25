<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunos — Cidade do Saber</title>
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
        /* ============================================ */

        .topbar-logo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--escuro);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-logo i { color: var(--verde); font-size: 1rem; }

        .topbar-title {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--txt-dark);
        }

        .topbar-subtitle { font-size: 0.75rem; color: var(--txt-muted); }

        .topbar-right { display: flex; align-items: center; gap: 0.75rem; }

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

        .user-chip i { color: var(--verde); font-size: 0.875rem; }

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

        .main-container { max-width: 960px; margin: 0 auto; padding: 1.5rem 1rem; width: 100%; }

        .page-header { margin-bottom: 1.5rem; }
        .page-header h2 { font-family: 'Sora', sans-serif; font-weight: 800; font-size: 1.5rem; color: var(--txt-dark); }
        .page-header p { font-size: 0.875rem; color: var(--txt-muted); margin-top: 0.125rem; }

        .control-card {
            background: white; border-radius: 1.25rem; padding: 1.25rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04); border: 1px solid var(--border-light); margin-bottom: 1.5rem;
        }

        .search-row { display: flex; gap: 0.75rem; }
        .search-label { display: block; font-size: 0.75rem; font-weight: 600; color: var(--txt-muted); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.06em; }
        .search-input-wrap { position: relative; flex: 1; }
        .search-input-wrap i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--txt-muted); font-size: 0.875rem; pointer-events: none; transition: color 0.2s; }
        
        .search-input {
            width: 100%; min-height: 52px; padding: 0 1rem 0 2.85rem; border: 1.5px solid var(--border);
            border-radius: 0.75rem; font-family: 'Sora', sans-serif; font-size: 0.938rem; font-weight: 600;
            color: var(--txt-dark); background: var(--claro); transition: all 0.2s ease;
        }
        .search-input:hover { border-color: #94a3b8; }
        .search-input:focus { outline: none; background: white; border-color: var(--verde); box-shadow: 0 0 0 4px rgba(139, 189, 71, 0.15); }
        .search-input:focus~i { color: var(--verde); }
        .search-input::placeholder { color: #94a3b8; font-weight: 400; font-size: 0.875rem; }

        .btn-buscar {
            min-height: 52px; padding: 0 1.5rem; border-radius: 0.75rem; border: none;
            background: var(--verde); color: white; font-weight: 700; font-family: 'Sora', sans-serif;
            font-size: 0.875rem; cursor: pointer; transition: all 0.2s ease; white-space: nowrap;
            box-shadow: 0 2px 8px rgba(139, 189, 71, 0.3);
        }
        .btn-buscar:hover { background: #7aa83d; box-shadow: 0 4px 12px rgba(139, 189, 71, 0.4); transform: translateY(-1px); }

        .list-container { display: flex; flex-direction: column; gap: 0.75rem; }

        .aluno-card {
            background: white; border: 1.5px solid var(--border-light); border-radius: 1rem; padding: 1.25rem;
            display: flex; align-items: center; gap: 1.25rem; transition: all 0.2s ease; position: relative; overflow: hidden;
        }
        .aluno-card:hover { box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05); transform: translateY(-1px); border-color: var(--border); }

        .aluno-avatar {
            width: 48px; height: 48px; border-radius: 12px; background: var(--claro); display: flex;
            align-items: center; justify-content: center; flex-shrink: 0; color: var(--verde);
            font-size: 1.25rem; border: 1px solid var(--border-light);
        }
        .aluno-info { flex: 1; min-width: 0; }
        .aluno-nome { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 0.938rem; color: var(--txt-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .aluno-detalhes { display: flex; gap: 1rem; margin-top: 0.25rem; flex-wrap: wrap; }
        .aluno-detalhe { font-size: 0.75rem; color: var(--txt-muted); display: flex; align-items: center; gap: 0.25rem; }
        .aluno-detalhe i { font-size: 0.625rem; color: var(--verde); }
        .aluno-actions { display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0; }

        .btn-action {
            padding: 0.5rem 0.875rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 600;
            font-family: 'Space Grotesk', sans-serif; border: 1px solid var(--border); background: white;
            color: var(--txt-body); cursor: pointer; text-decoration: none; display: inline-flex;
            align-items: center; gap: 0.375rem; transition: all 0.2s ease; white-space: nowrap;
        }
        .btn-action:hover { border-color: var(--verde); color: #4d7c0f; background: rgba(139, 189, 71, 0.05); }
        .btn-danger { border-color: #fecaca !important; color: #dc2626 !important; }
        .btn-danger:hover { background: #fef2f2 !important; border-color: #fca5a5 !important; color: #b91c1c !important; }

        .status-badge { font-size: 0.625rem; font-weight: 700; padding: 0.15rem 0.5rem; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.05em; }
        .status-ativo { background: rgba(139, 189, 71, 0.12); color: #4d7c0f; border: 1px solid rgba(139, 189, 71, 0.2); }
        .status-inativo { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .status-card-ativo { background: rgba(139, 189, 71, 0.12); color: #4d7c0f; border: 1px solid rgba(139, 189, 71, 0.2); }

        .empty-state { text-align: center; padding: 3rem 1rem; background: white; border-radius: 1rem; border: 1px dashed var(--border); }
        .empty-state i { font-size: 2.5rem; color: var(--border); margin-bottom: 1rem; }
        .empty-state h3 { font-family: 'Sora', sans-serif; font-weight: 700; color: var(--txt-dark); margin-bottom: 0.25rem; }
        .empty-state p { font-size: 0.875rem; color: var(--txt-muted); }

        .pagination-links { display: flex; justify-content: center; gap: 0.25rem; margin-top: 2rem; }
        .pagination-links a, .pagination-links span { padding: 0.5rem 0.75rem; border-radius: 0.5rem; font-size: 0.813rem; font-weight: 500; border: 1px solid var(--border-light); background: white; color: var(--txt-body); text-decoration: none; transition: all 0.2s; }
        .pagination-links a:hover { border-color: var(--verde); color: #4d7c0f; background: rgba(139, 189, 71, 0.05); }
        .pagination-links .active { background: var(--verde); color: white; border-color: var(--verde); }
        .pagination-links .disabled { opacity: 0.5; cursor: not-allowed; }

        /* ===== MENU DROPDOWN FLUTUANTE ===== */
        .history-dropdown {
            position: fixed; z-index: 1000; display: none; background: white; border: 1px solid var(--border-light);
            border-radius: 0.75rem; padding: 0.75rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            min-width: 280px; max-width: 320px; animation: fadeIn 0.15s ease;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: translateY(0); } }

        .dropdown-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.625rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-light); }
        .dropdown-title { font-size: 0.75rem; font-weight: 700; color: var(--txt-dark); display: flex; align-items: center; gap: 0.4rem; }
        .dropdown-close { background: none; border: none; color: var(--txt-muted); cursor: pointer; padding: 0.2rem; font-size: 0.875rem; border-radius: 4px; transition: all 0.2s; }
        .dropdown-close:hover { background: rgba(0, 0, 0, 0.05); color: var(--txt-dark); }
        .dropdown-list { display: flex; flex-direction: column; gap: 0.4rem; max-height: 200px; overflow-y: auto; }
        .dropdown-item { display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; padding: 0.4rem 0; border-bottom: 1px solid var(--border-light); }
        .dropdown-item:last-child { border-bottom: none; }
        .dropdown-item-num { font-weight: 600; color: var(--txt-dark); }
        .dropdown-item-date { font-size: 0.65rem; color: var(--txt-muted); }

        :focus-visible { outline: none; box-shadow: 0 0 0 3px white, 0 0 0 5px var(--verde); border-radius: 4px; }

        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; } }

        @media (max-width: 640px) {
            .app-topbar { padding: 0.5rem 1rem; }
            .topbar-title { font-size: 0.875rem; }
            .user-chip span.user-text { display: none; }
            .main-container { padding: 1rem 0.75rem; }
            .search-row { flex-direction: column; }
            .aluno-card { flex-wrap: wrap; }
            .aluno-actions { width: 100%; justify-content: flex-end; margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid var(--border-light); gap: 0.4rem; }
            .history-dropdown { position: fixed; left: 1rem; right: 1rem; min-width: auto; max-width: none; width: calc(100% - 2rem); }
        }
    </style>
</head>

<body>

    <header class="app-topbar">
        <div class="topbar-left">
            <!-- NOVO: Botão de retorno adicionado aqui -->
            <a href="{{ route('senha.index') }}" class="btn-back-topbar" title="Voltar para opções do sistema">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <!-- FIM DO NOVO -->

            <div class="topbar-logo" aria-hidden="true"><i class="fa-solid fa-user-graduate"></i></div>
            <div>
                <h1 class="topbar-title">Atende XP</h1>
                <p class="topbar-subtitle">Gestao de Alunos</p>
            </div>
        </div>
        <div class="topbar-right">
            <div class="user-chip" aria-label="Usuario logado">
                <i class="fa-solid fa-user"></i>
                <span class="user-text">{{ session('login')['nome_completo'] ?? '' }}</span>
            </div>
            <a href="{{ route('login') }}" class="btn-logout" title="Sair do sistema"><i class="fa-solid fa-right-from-bracket"></i><span>Sair</span></a>
        </div>
    </header>

    <main class="main-container">
        <div class="page-header">
            <h2>Alunos Matriculados</h2>
            <p>Localize um aluno, gere ou gerencie sua carteirinha de identificacao</p>
        </div>

        <div class="control-card">
            @php $buscaAtual = request('busca'); @endphp
            <form method="GET" action="{{ route('aluno.index') }}">
                <label for="busca" class="search-label">Buscar aluno</label>
                <div class="search-row">
                    <div class="search-input-wrap">
                        <input type="text" name="busca" id="busca" class="search-input" placeholder="Nome, CPF ou RG do aluno..." value="{{ $buscaAtual }}" aria-label="Buscar aluno por nome, cpf ou rg" autofocus>
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    </div>
                    <button type="submit" class="btn-buscar">Buscar</button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var container = document.querySelector('.pagination-links');
                    if (!container) return;
                    container.addEventListener('click', function (e) {
                        var link = e.target.closest('a');
                        if (!link) return;
                        e.preventDefault();
                        var href = link.getAttribute('href');
                        var urlObj;
                        var baseUrl = href.split('?')[0];
                        var queryString = href.split('?')[1] || '';
                        try { urlObj = new URL(href); } catch (err) { }
                        var baseUrlFinal = urlObj ? urlObj.origin + urlObj.pathname : baseUrl;
                        var params = new URLSearchParams(queryString);
                        var inputBusca = document.getElementById('busca');
                        var buscaValor = inputBusca ? inputBusca.value.trim() : '';
                        if (buscaValor) { params.set('busca', buscaValor); } else { params.delete('busca'); }
                        var novaUrl = baseUrlFinal + (params.toString() ? '?' + params.toString() : '');
                        setTimeout(function () { window.location.href = novaUrl; }, 100);
                    });
                });
            </script>
        </div>

        <div class="list-container">
            @forelse($alunos as $aluno)
                <div class="aluno-card" id="card-{{ $aluno->cod_aluno }}">
                    <div class="aluno-avatar" aria-hidden="true">{{ strtoupper(substr($aluno->nome_aluno, 0, 1)) }}</div>
                    <div class="aluno-info">
                        <div class="aluno-nome">{{ $aluno->nome_aluno }}</div>
                        <div class="aluno-detalhes">
                            @if($aluno->cpf)
                                <span class="aluno-detalhe"><i class="fa-solid fa-id-card" aria-hidden="true"></i> {{ $aluno->cpf }}</span>
                            @endif
                            @if($aluno->rg)
                                <span class="aluno-detalhe"><i class="fa-solid fa-address-card" aria-hidden="true"></i> {{ $aluno->rg }}</span>
                            @endif
                            @if($aluno->data_nascimento)
                                <span class="aluno-detalhe"><i class="fa-solid fa-cake-candles" aria-hidden="true"></i> {{ \Carbon\Carbon::parse($aluno->data_nascimento)->format('d/m/Y') }}</span>
                            @endif
                            @if($aluno->carteirinhaAtiva)
                                <span class="aluno-detalhe" style="color:#4d7c0f; font-weight:600;"><i class="fa-solid fa-id-badge" aria-hidden="true"></i> Carteira: {{ $aluno->carteirinhaAtiva->numero_carteirinha }}</span>
                            @else
                                <span class="aluno-detalhe" style="color:#dc2626;"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i> Sem carteira</span>
                            @endif
                        </div>
                    </div>
                    <div class="aluno-actions">
                        @if($aluno->carteirinhas->count() > 0)
                            <button type="button" class="btn-action" onclick="toggleHistory(event, {{ $aluno->cod_aluno }})" title="Historico de carteirinhas"><i class="fa-solid fa-clock-rotate-left"></i> Historico ({{ $aluno->carteirinhas->count() }})</button>
                        @endif
                        @if($aluno->carteirinhaAtiva)
                            <a href="{{ route('aluno.carteirinha', [$aluno->cod_aluno, $aluno->carteirinhaAtiva->id]) }}" class="btn-action" title="Ver carteirinha"><i class="fa-solid fa-print"></i> Ver</a>
                            <button type="button" onclick="invalidarCarteira({{ $aluno->carteirinhaAtiva->id }})" class="btn-action btn-danger" title="Invalidar esta carteirinha"><i class="fa-solid fa-ban"></i> Invalidar</button>
                        @else
                            <a href="{{ route('aluno.carteirinha', $aluno->cod_aluno) }}" class="btn-action" title="Gerar/Ver carteirinha"><i class="fa-solid fa-print"></i> Carteirinha</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fa-solid fa-users-slide"></i>
                    <h3>Nenhum aluno encontrado</h3>
                    <p>Tente alterar os termos da busca ou verifique se ha alunos cadastrados.</p>
                </div>
            @endforelse
        </div>

        @if($alunos->hasPages())
            <div class="pagination-links">{{ $alunos->links() }}</div>
        @endif
    </main>

    <div id="historyDropdown" class="history-dropdown" role="dialog" aria-label="Historico de carteirinhas">
        <div class="dropdown-header">
            <div class="dropdown-title"><i class="fa-solid fa-clock-rotate-left" style="font-size:0.65rem; color:var(--txt-muted);"></i> Historico de Carteirinhas</div>
            <button class="dropdown-close" onclick="closeHistory()" title="Fechar" aria-label="Fechar historico"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="dropdown-list" id="historyListContainer"></div>
    </div>

    <form id="formInvalidar" method="POST" style="display:none;">
        @csrf @method('PUT')
        <input type="hidden" name="motivo_invalidacao" id="inputMotivo" value="">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInput = document.getElementById('busca');
            var dropdown = document.getElementById('historyDropdown');
            var listContainer = document.getElementById('historyListContainer');
            var formInvalidar = document.getElementById('formInvalidar');
            var activeBtn = null;

            if (searchInput) {
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'escape' && document.activeElement === searchInput) {
                        searchInput.value = '';
                        searchInput.focus();
                    }
                });
            }

            document.addEventListener('click', function (e) {
                if (!dropdown.contains(e.target) && (!activeBtn || !activeBtn.contains(e.target))) {
                    closeHistory();
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'escape' && dropdown.style.display === 'block') {
                    closeHistory();
                }
            });
        });

        function toggleHistory(event, codAluno) {
            event.stopPropagation();
            closeHistory();
            var btn = event.currentTarget;
            activeBtn = btn;
            var rect = btn.getBoundingClientRect();
            dropdown.style.top = (rect.bottom + window.scrollY + 6) + 'px';
            dropdown.style.left = 'auto';
            dropdown.style.right = (window.innerWidth - rect.right) + 'px';
            dropdown.style.display = 'block';

            var historico = [
                { numero: 'CART-2025-0001', data: '15/01/2025', status: 'ATIVA', cod: '0001' },
                { numero: 'CART-2025-0002', data: '10/01/2025', status: 'INVALIDADA', cod: '0002' },
                { numero: 'CART-2024-0015', data: '05/12/2024', status: 'INVALIDADA', cod: '0015' }
            ];

            listContainer.innerHTML = historico.map(function (item) {
                return '<div class="dropdown-item">' +
                    '<span class="dropdown-item-num">' + item.numero + '</span>' +
                    '<span style="display:flex; align-items:center; gap:0.5rem;">' +
                    '<span class="status-badge ' + (item.status === 'ATIVA' ? 'status-ativo' : 'status-inativo') + '">' + item.status + '</span>' +
                    '<span class="dropdown-item-date">' + item.data + '</span>' +
                    '</span>' +
                    '</div>';
            }).join('');
        }

        function closeHistory() {
            dropdown.style.display = 'none';
            activeBtn = null;
        }

        function invalidarCarteira(idCarteira) {
            if (!confirm('Tem certeza que deseja INVALIDAR esta carteirinha?\nEsta ação não pode ser desfeita e o aluno precisará de uma nova carteira.')) return;
            var acao = prompt('Qual o motivo da invalidação?\n\nEx: Perda, Roubo, Dano físico', 'Perda pelo titular');
            if (acao !== null && acao.trim() !== '') {
                document.getElementById('inputMotivo').value = acao.trim();
                formInvalidar.action = '/aluno/carteirinha/invalidar/' + idCarteira;
                formInvalidar.submit();
            }
            closeHistory();
        }
    </script>
</body>

</html>