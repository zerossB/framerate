<?php

use App\Http\Resources\PostResource;
use App\Models\Post;

it('should return the corret component', function () {
    $this->get(route('posts.index'))
        ->assertComponent('Posts/Index');
});

it('passes posts to the view', function () {
    $posts = Post::factory()->count(3)->create();

    $posts->load('user');

    $this->get(route('posts.index'))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts));
});
