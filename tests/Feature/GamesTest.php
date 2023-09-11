<?php

use App\Models\User;

it('has home page', function () {


    $response = $this->get('/api');

    $response->assertStatus(200);
});

it('has games page', function () {
    //authentification
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/api/games');

    $response->assertStatus(200);
});
