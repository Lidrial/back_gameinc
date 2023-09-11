<?php

use App\Models\Comment;
use App\Models\User;
use function Pest\Laravel\postJson;

it('can create a comment', function () {
    //authentification
    $user = User::factory()->create();
    $this->actingAs($user);

    // Arrange: Create a valid comment data using factory or manually

    $commentData = [
        'content' => fake()->text(255),
        'game_id' => 1,
        'user_id' => 1,
        'rate' => 5,
    ];

    // Act: Send a POST request to the store endpoint with the comment data
    $response = postJson('/api/comments', $commentData);

    // Assert: Check the response status code
    $response->assertStatus(201);

    // Assert: Check the response structure and content
    $response->assertJson([
        'message' => 'Commentaire créé',
        'commentaire' => $commentData,
    ]);

    // Assert: Check that the comment is actually stored in the database
    expect(Comment::where($commentData)->count())->toBe(1);
});
