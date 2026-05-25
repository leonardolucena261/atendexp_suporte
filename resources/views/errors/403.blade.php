<!-- resources/views/errors/403.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Bloqueado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { escuro: '#1E293B' }, fontFamily: { display: ['Sora','sans-serif'] }}}}
    </script>
</head>
<body class="bg-escuro min-h-screen flex items-center justify-center p-4">
    <div class="text-center max-w-md">
        <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: rgba(239,68,68,0.1); border: 2px solid rgba(239,68,68,0.3);">
            <i class="fa-solid fa-ban text-3xl text-red-500"></i>
        </div>
        <h1 class="font-display font-800 text-2xl text-white mb-4">Carteirinha Bloqueada</h1>
        <p class="text-gray-400 text-base leading-relaxed mb-2">
            {{ $exception->getMessage() }}
        </p>
        <p class="text-gray-600 text-sm mt-6">
            <i class="fa-solid fa-lock text-xs mr-1"></i> Acesso restrito por medidas de segurança.
        </p>
    </div>
</body>
</html>