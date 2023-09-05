<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Comment $comment)
    {
        return $comment->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $storeCommentRequest)
    {

        $validatedData = $storeCommentRequest->validated();
        $comment = Comment::create($validatedData);
//        dd($comment);

        return response()->json(['message' => 'Commentaire créé'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Comment::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $comment = Comment::findOrFail($id);
        if (!$comment) {
            // Comment with the given ID not found
            return response()->json(['message' => 'Commentaire inexistant'], 404);
        }

        $comment->update($request->all());

        // Comment successfully updated
        return response()->json(['message' => 'Commentaire mis à jour'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $comment = Comment::destroy($id);
        if (!$comment) {
            // Comment with the given ID not found
            return response()->json(['message' => 'Commentaire inexistant'], 404);
        }

        return response()->json(['message' => 'Commentaire supprimé'], 200);
    }

    public function getCommentsByGameId(string $game)
    {
        $comments = Comment::where('game_id', $game)->get();
        return response()->json($comments, 200);
    }
}
