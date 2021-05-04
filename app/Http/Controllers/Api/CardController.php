<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Card\{CardRecipeResource, CardResource};
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return CardResource::collection($user->cards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $card = $user->cards()->create($request->all());
        return new CardResource($card);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        $card = $card->load('recipes');
        return new CardRecipeResource($card);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        $card->update($request->all());
        $card->refresh();

        return new CardResource($card);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        $card->recipes()->detach();
        $card->delete();
        $response = 'Removido com sucesso';
        return response($response, 200);
    }

    /**
     * Adiciona a receita no card.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function addRecipe(Request $request, Card $card)
    {
        $data = $request->only('recipe_id');
        $card->recipes()->attach($data);
        $card->load('recipes');

        return new CardRecipeResource($card);
    }

    /**
     * Remove a receita no card.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function removeRecipe(Request $request, Card $card)
    {
        $data = $request->only('recipe_id');
        $card->recipes()->detach($data);
        $card->load('recipes');

        return new CardRecipeResource($card);
    }
}
