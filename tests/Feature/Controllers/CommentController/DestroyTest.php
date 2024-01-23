<?php

use App\Models\Comment;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;

it('requires authentications', function () {
    delete(route('comments.destroy', Comment::factory()->create()))
        ->assertRedirect(route('login'));
});

it('can delete a comment', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->delete(route('comments.destroy', $comment));

    $this->assertModelMissing($comment);
});

it('redirect to the post show page', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->delete(route('comments.destroy', $comment))
        ->assertRedirect(route('posts.show', $comment->post_id));
});

it('prevents deleting a comment you didnt create', function () {
    $comment = Comment::factory()->create();

    actingAs(User::factory()->create())
        ->delete(route('comments.destroy', $comment))
        ->assertForbidden();
});

it('prevents deleting a comment posted an hour ago', function () {
    $this->freezeTime();

    $comment = Comment::factory()->create();

    $this->travel(61)->minutes();

    actingAs($comment->user)
        ->delete(route('comments.destroy', $comment))
        ->assertForbidden();
});
