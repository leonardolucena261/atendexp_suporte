<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
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
            ->registration()                 // (Opcional) Remove se não quiser cadastro de admin
            ->passwordReset()                // Recuperação de senha
            ->emailVerification()            // Verificação de email (opcional)
            ->profile()                      // Perfil do usuário logado
            ->colors([
                'primary' => '#8BBD47',      // ✅ Verde Atende XP
                'gray' => '#334155',       // ✅ Mesmo tom de texto do sistema
            ])
            ->font('Space Grotesk')          // ✅ Fonte body do sistema
            ->brandName('Atende XP')         // ✅ Nome exibido no sidebar e login
            ->brandLogo(asset('images/logo-atendexp.svg'))   // ⬅️ Passo 4 cria esse arquivo
            ->brandLogoHeight('2rem')
            ->favicon(asset('images/favicon-atendexp.svg'))  // ⬅️ Passo 4 cria esse arquivo
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
                'panels::head.start',
                fn () => <<<'HTML'
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Sora:wght@200;400;600;800&display=swap" rel="stylesheet">
                <style>
                    /* Títulos do Filament com Sora */
                    h1, h2, h3, h4, h5, h6,
                    .fi-heading-text,
                    .filament-brand-name {
                        font-family: 'Sora', sans-serif !important;
                    }

                    /* Corpo com Space Grotesk */
                    body, p, span, label, td, th, li {
                        font-family: 'Space Grotesk', sans-serif !important;
                    }

                    /* Gradiente no topo do sidebar */
                    .fi-sidebar-container::before {
                        content: '';
                        position: absolute;
                        top: 0; left: 0; right: 0;
                        height: 4px;
                        background: linear-gradient(90deg, #8BBD47, #a8d465, #FFAD02);
                        z-index: 10;
                    }

                    /* Botão primário com gradiente verde */
                    .fi-btn-primary {
                        background: linear-gradient(135deg, #8BBD47, #6a9a2f) !important;
                        border-color: #6a9a2f !important;
                        box-shadow: 0 4px 14px rgba(139,189,71,0.35);
                        font-family: 'Sora', sans-serif;
                        font-weight: 600;
                        border-radius: 0.75rem !important;
                        transition: all 0.3s cubic-bezier(0.22,1,0.36,1);
                    }
                    .fi-btn-primary:hover {
                        box-shadow: 0 8px 24px rgba(139,189,71,0.45);
                        transform: translateY(-2px);
                    }

                    /* Cards com estilo glassmorphism suave */
                    .filament-card {
                        border-radius: 1rem !important;
                        border: 1px solid #E2E8F0 !important;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.04) !important;
                    }

                    /* Background do painel */
                    .fi-main-content {
                        background-color: #F9F9F9 !important;
                    }

                    /* Sidebar styling */
                    .fi-sidebar {
                        background-color: #1E293B !important;
                    }
                    .fi-sidebar-item-active {
                        background-color: rgba(139,189,71,0.15) !important;
                        color: #8BBD47 !important;
                    }
                </style>
            HTML,
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
