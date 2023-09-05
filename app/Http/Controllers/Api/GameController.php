<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Game\StoreGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Models\Category;
use App\Models\Game;
use Illuminate\Http\Request;

//q: how can i write a test for this controller
//a: https://laravel.com/docs/8.x/http-tests#testing-json-apis

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Game $game)
    {
        //
        $games = $game->with('users:id', 'categories:id')->get();


        //retournes les données de la requête sous forme de tableau et rassemble les users et categories liée sous forme de tableau
        $gamesData = $games->map(function ($game) {
            return [
                'id' => $game->id,
                'name' => $game->name,
                'description' => $game->description,
                'company_id' => $game->company_id,
                'image' => $game->image,
                'link' => $game->link,
                'average_rate' => $game->average_rate,
                'created_at' => $game->created_at,
                'updated_at' => $game->updated_at,
                'users' => $game->users->pluck('id'),
                'categories' => $game->categories->pluck('id'),
            ];
        });

        return response()->json(['games' => $gamesData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $storeGameRequest)
    {
        //
        $validatedData = $storeGameRequest->validated();
        $gamePath = $storeGameRequest->file('game')->store('public/games');
        $game = Game::create($validatedData);

        $categories_ids = $validatedData['category_id'];
        $users_ids = $validatedData['user_id'];

        $game->path = $gamePath;

        $game->categories()->attach($categories_ids);
        $game->users()->attach($users_ids);

        return response()->json(['message' => 'Jeu créé avec succès', 'game' => $game], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::with('users:id', 'categories:id')->findOrFail($id);

        $gameData = [
            'id' => $game->id,
            'name' => $game->name,

            'description' => $game->description,
            'company_id' => $game->company_id,
            'image' => $game->image,
            'link' => $game->link,
            'average_rate' => $game->average_rate,
            'created_at' => $game->created_at,
            'updated_at' => $game->updated_at,
            'users' => $game->users->pluck('id'),
            'categories' => $game->categories->pluck('id'),
        ];

        return response()->json($gameData);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameRequest $updateGameRequest, string $id)
    {
        //
        $validatedData = $updateGameRequest->validated();
        $game = Game::findOrFail($id);
        if (!$game) {
            // User with the given ID not found
            return response()->json(['message' => 'Jeu inexistant'], 404);
        }

        if (isset($validatedData['category_id']) && is_array($validatedData['category_id'])) {
            // Detach related categories
            $game->categories()->sync($validatedData['category_id']);
        }

        if (isset($validatedData['user_id']) && is_array($validatedData['user_id'])) {
            // Detach related users
            $game->users()->sync($validatedData['user_id']);
        }

        $game->update($validatedData);
        return response()->json(['message' => 'Jeu mis à jour'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $game = Game::findOrFail($id);

        // Detach related categories and users
        $game->categories()->detach();
        $game->users()->detach();

        // Now you can safely delete the game
        $game->delete();
        return response()->json(['message' => 'Jeu supprimé avec succès'], 200);
    }

    public function indexByCategory(Category $category, string $id)
    {
        //
        try {
            //get game by category
            $games = $category->findOrFail($id)->games()->with('categories:id')->get();
            return response()->json(['games' => $games]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Categories not found!'], 404);
        }
    }

    public function getGameFile(string $id)
    {
        $game = Game::findOrFail($id);
        $path = storage_path('app/' . $game->path);
        return response()->download($path);
    }
}
