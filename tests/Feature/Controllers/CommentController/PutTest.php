<?php

use App\Models\Comment;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

it('requires authentication', function () {
    put(route('comments.update', Comment::factory()->create()))
        ->assertRedirect(route('login'));
});

it('can update a comment', function () {
    $comment = Comment::factory()->create([
        'body' => 'The original comment body.',
    ]);

    $comment_body = 'Updated comment body';

    actingAs($comment->user)->put(route('comments.update', $comment), [
        'body' => $comment_body,
    ]);

    $this->assertDatabaseHas(Comment::class, [
        'id' => $comment->id,
        'body' => $comment_body,
    ]);
});

it('redirect to the post show page', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)->put(route('comments.update', $comment), [
        'body' => 'Updated comment body',
    ])->assertRedirect(route('posts.show', $comment->post));
});

it('redirect to the correct page of comments', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)->put(route('comments.update', ['comment' => $comment, 'page' => 2]), [
        'body' => 'Updated comment body',
    ])->assertRedirect(route('posts.show', ['post' => $comment->post, 'page' => 2]));
});

it('cannot update a comment from another user', function () {
    $comment = Comment::factory()->create();

    actingAs(User::factory()->create())->put(route('comments.update', ['comment' => $comment, 'page' => 2]), [
        'body' => 'Updated comment body',
    ])->assertForbidden();
});

it('requires a valid body', function ($body) {
    $comment = Comment::factory()->create();

    actingAs($comment->user)->put(route('comments.update', ['comment' => $comment, 'page' => 2]), [
        'body' => $body,
    ])->assertInvalid('body');
})->with([
    null,
    true,
    1,
    1.5,
    str_repeat('a', 25001),
]);
