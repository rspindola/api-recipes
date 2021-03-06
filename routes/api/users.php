<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/**
 * @apiDefine UserResourceSuccess
 * @apiSuccess {Number} id ID do usuário.
 * @apiSuccess {String} name Nome do usuário.
 * @apiSuccess {String} email Email do usuário.
 * @apiSuccess {String} gender Gênero do usuário.
 * @apiSuccess {String} avatar URL do avatar do usuário.
 * @apiSuccess {String} phone Telefone do usuário.
 * @apiSuccess {String} origin Origem da criação do usuário.
 * @apiSuccess {String} status Situação do usuário.
 * @apiSuccess {Timestamp} created_at Momento de criação do usuário.
 */

Route::middleware('auth:api')->group(function () {

    /**
     * @api {get} /users/:user Obter Usuário
     * @apiDescription Obtém as informações do usuário
     * @apiName ObterUsuario
     * @apiGroup Usuário
     * @apiVersion 0.0.1
     *
     * @apiUse ApiAccessToken
     *
     * @apiParam (URL) {Number|String} user ID do usuário ou use `me` para utilizar o usuário autenticado
     *
     * @apiUse UserResourceSuccess
     */
    Route::get('/users/me', [UserController::class, 'getMe']);

    /**
     * @api {put} /users/:user/change-password Alterar Senha
     * @apiDescription Altera a senha do usuário
     * @apiName AlterarSenhaUsuario
     * @apiGroup Usuário
     * @apiVersion 0.0.1
     *
     * @apiUse ApiAccessToken
     *
     * @apiParam (URL) {Number} user ID do usuário ou use `me` para utilizar o usuário autenticado
     *
     * @apiParam {String} old_password Senha Antiga
     * @apiParam {String} new_password Nova Senha
     *
     * @apiSuccess {String} status Situação da atualização
     */
    Route::put('/users/me/change-password', [UserController::class, 'changePasswordMe']);

    /**
     * @api {put} /users/:user Editar Usuário
     * @apiDescription Edita um usuário
     * @apiName EditarUsuario
     * @apiGroup Usuário
     * @apiVersion 0.0.1
     *
     * @apiUse ApiAccessToken
     *
     * @apiParam (URL) {Number} user ID do usuário ou use `me` para utilizar o usuário autenticado
     *
     * @apiUse UserResourceSuccess
     */
    Route::put('/users/me', [UserController::class, 'editMe']);

    /**
     * @api {get} /users/:user/recipes Obter Receitas
     * @apiDescription Obtém as receitas do usuário
     * @apiName ObterReceitas
     * @apiGroup Usuário
     * @apiVersion 0.0.1
     *
     * @apiUse ApiAccessToken
     *
     * @apiParam (URL) {Number} user ID do usuário ou use `me` para utilizar o usuário autenticado
     *
     * @apiSuccess {Number}     user.id                      ID do usuário.
     * @apiSuccess {String}     user.name                    Nome do usuário.
     * @apiSuccess {String}     user.email                   Email do usuário.
     * @apiSuccess {String}     user.gender                  Gênero do usuário.
     * @apiSuccess {String}     user.avatar                  URL do avatar do usuário.
     * @apiSuccess {String}     user.phone                   Telefone do usuário.
     * @apiSuccess {String}     user.origin                  Origem da criação do usuário.
     * @apiSuccess {String}     user.status                  Situação do usuário.
     *
     * @apiSuccess {Object[]}   user.recipes                 Receitas.
     * @apiSuccess {Number}     user.recipes.id              ID da receita.
     * @apiSuccess {String}     user.recipes.name            Nome da receita.
     * @apiSuccess {String}     user.recipes.description     Descrição da receita.
     * @apiSuccess {String}     user.recipes.image           URL da imagem do icone da receita.
     * @apiSuccess {String}     user.recipes.slug            URL do caminho da receita.
     * @apiSuccess {Array}      user.recipes.ingredients     Listagem com os ingredientes da receita.
     * @apiSuccess {Timestamp}  user.recipes.created_at      Momento de criação da receita.
     *
     * @apiSuccess {Object}     user.recipes.category                Categoria da receita
     * @apiSuccess {Number}     user.recipes.category.id             ID da categoria.
     * @apiSuccess {String}     user.recipes.category.name           Nome da categoria.
     * @apiSuccess {String}     user.recipes.category.description    Descrição da categoria.
     * @apiSuccess {String}     user.recipes.category.icon           URL da imagem do icone da categoria.
     */
    Route::get('/users/me/recipes', [UserController::class, 'getRecipesMe']);
});


// APIs de aplicações (Machine-to-machine)

/**
 * @api {post} /users Cadastrar Usuário
 * @apiDescription Cadastra um novo usuário
 * @apiName CadastrarUsuario
 * @apiGroup Usuário
 * @apiVersion 0.0.1
 *
 * @apiUse ApiAccessToken
 *
 * @apiPermission users.create
 *
 * @apiParam {String} name Nome do usuário.
 * @apiParam {String} email Email do usuário.
 * @apiParam {String} password Senha do usuário.
 * @apiParam {String} [gender] Sexo do usuário. (M, F)
 * @apiParam {String} [avatar] Avatar do usuário.
 * @apiParam {String} [phone] Celular do usuário.
 *
 * @apiSuccess {String} name Nome do usuário.
 * @apiSuccess {String} gender Sexo do usuário. (M, F)
 * @apiSuccess {String} email Email do usuário.
 * @apiSuccess {String} avatar Avatar do usuário.
 * @apiSuccess {String} phone Celular do usuário.
 * @apiSuccess {String} origin Origem do registro do usuário.
 * @apiSuccess {String} status Status do usuário.
 * @apiSuccess {Timestamp} created_at Momento de criação do usuário.
 * @apiSuccess {Object} auth Informações de autenticação.
 * @apiSuccess {String} auth.access_token Token de acesso
 * @apiSuccess {String} auth.token_type Tipo do token
 * @apiSuccess {Number} auth.expires_in Tempo de validade do token
 */
Route::post('/users', [UserController::class, 'create']);
