<?php

namespace App\Providers\Filament;

use App\Filament\Coordenador\Resources\Cursos\CursoResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AtendexpPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('atendexp')
            ->path('atendexp')
            ->login()                        // Habilita tela de login do Filament
            //->registration()               // (Opcional) Remove se não quiser cadastro de admin
            ->passwordReset()                // Recuperação de senha
            ->emailVerification()            // Verificação de email (opcional)
            ->profile()                      // Perfil do usuário logado
            ->colors([
                'primary' => [   // escala completa do verde da marca (hover/dark perfeitos)
                '50' => '#f7fbef', '100' => '#edf7da', '200' => '#dbefb7',
                '300' => '#c3e58b', '400' => '#a3cf5f', '500' => '#8BBD47',
                '600' => '#6f9d36', '700' => '#587b2c', '800' => '#486227',
                '900' => '#3d5324', '950' => '#1c2c0e',
                ],      // ✅ Verde Atende XP
                'warning' => '#FFAD02',  // dourado
                'info'    => '#EF8E26',  // laranja
                'gray' => '#334155',         // ✅ Mesmo tom de texto do sistema
            ])
            ->font('Space Grotesk')          // ✅ Fonte body do sistema
            ->brandName('Atende XP')         // ✅ Nome exibido no sidebar e login
            ->brandLogo(asset('images/logo-atendexp.svg'))   // ⬅️ Passo 4 cria esse arquivo
            ->brandLogoHeight('2rem')
            ->favicon(asset('images/favicon-atendexp.svg'))  // ⬅️ Passo 4 cria esse arquivo
            ->resources([
            CursoResource::class,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => '
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@200;400;600;800&display=swap" rel="stylesheet">
                    <link rel="stylesheet" href="'.asset('css/atendexp.css').'">
                '
            )
            ->middleware([
                    EncryptCookies::class,
                    AddQueuedCookiesToResponse::class,
                    StartSession::class,
                    AuthenticateSession::class,
                    ShareErrorsFromSession::class,
                    PreventRequestForgery::class,
                    SubstituteBindings::class,
                    DisableBladeIconComponents::class,
                    DispatchServingFilamentEvent::class,
                ])
            ->authMiddleware([
                    Authenticate::class,
                ]);
    }
}
