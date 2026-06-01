<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CarteirinhaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PreCadastroController;
use App\Http\Controllers\PwaController;
use App\Http\Controllers\SenhaController;
use App\Http\Controllers\VagaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Rotas de controle das vagas para realizacao da matricula
Route::get('/vaga', [VagaController::class, 'index'])->name('vaga.find');
Route::get('/vaga/checkin', [VagaController::class, 'checkin'])->name('vaga.checkin');
Route::get('/vaga/{token}', [VagaController::class, 'getVaga'])->name('vaga_token');
//analisar a necessidade
Route::get('/validamatricula',  [VagaController::class, 'validaMatricula'])->name('vaga.validamatricula');
Route::post('/matricular/{token}', [MatriculaController::class, 'matricular'])->name('matricula.realizar');

//Rotas de controle de administracao das senhas
Route::get('/senha', [SenhaController::class, 'index'])->name('senha.index');
Route::get('/login', LoginController::class)->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::get('/imprimir', SenhaController::class);
Route::post('/imprimir', [SenhaController::class, 'list'])->name('senha.imprimir');

//Rotas de controle da adminsitracao do aluno
Route::get('/alunos', [AlunoController::class, 'index'])->name('aluno.index');
Route::get('/aluno/{cod_aluno}/carteirinha/{id?}', [AlunoController::class , 'carteirinha'])->name('aluno.carteirinha');
Route::put('aluno/carteirinha/invalidar/{id}', [CarteirinhaController::class, 'invalidar'] )->name('carteirinha.invalidar');

//Rotas do Aplicativo Carteirinha
Route::get('/app/{uuid}', [CarteirinhaController::class, 'index'])
    ->name('carteirinha.app')
    ->where('uuid', '[a-f0-9\-]{36}'); // Restrição de segurança;
Route::post('/app/{uuid}/gerar-token', [CarteirinhaController::class, 'gerarToken'])
    ->name('carteirinha.gerarToken')
    ->where('uuid', '[a-f0-9\-]{36}'); // Restrição de segurança;
Route::get('/app/{uuid}/matricula/{cod_turma_aluno}/comprovante', [CarteirinhaController::class, 'comprovante'])
    ->name('carteirinha.comprovante')
    ->where('uuid', '[a-f0-9\-]{36}'); // NOVA ROTA DO COMPROVANTE

//Precadastro de aluno
Route::get('/precadastro', [PreCadastroController::class, 'index'])->name('precadastro.index');
Route::post('/precadastro/verificar', [PreCadastroController::class, 'verificarHumano'])->name('precadastro.verificar');
Route::post('/precadastro', [PreCadastroController::class, 'store'])->name('precadastro.store');
Route::get('/informe-pre-cadastro', [AlunoController::class, 'informePrecadastro'])->name('aluno.informePrecadastro');

//Garante o mainfest para instalacao do APP em Celulares
Route::get('/manifest.json', [PwaController::class, 'manifest']);    
