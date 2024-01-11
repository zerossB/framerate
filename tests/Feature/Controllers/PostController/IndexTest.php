<?php

use App\Http\Resources\PostResource;
use App\Models\Post;
use Inertia\Testing\AssertableInertia;

it('should return the corret component', function () {
    $this->get(route('posts.index'))
        ->assertInertia(
            fn (AssertableInertia $inertia) => $inertia
                ->component('Posts/Index')
        );
});

it('passes posts to the view', function () {
    $posts = Post::factory()->count(3)->create();

    $this->get(route('posts.index'))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts));
});
