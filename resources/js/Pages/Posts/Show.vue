<template>
    <AppLayout :title="post.title">
        <Container>
            <h1 class="text-2xl font-bold">{{ post.title }}</h1>
            <span class="block mt-1 text-small text-gray-600">{{ formattedDate }} ago by {{ post.user.name }}</span>

            <article class="mt-6">
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>

            <div class="mt-12 mt-4">
                <h2 class="text-xl font-semibold">Comments</h2>

                <form @submit.prevent="addComment" class="mt-4" v-if="$page.props.auth.user">
                    <div>
                        <InputLabel for="body" value="Comment" class="sr-only" />
                        <TextAreaInput id="body" class="mt-1" v-model="commentForm.body"
                            placeholder="Speak your mind Spock..." rows="4" />
                        <InputError :message="commentForm.errors.body" class="mt-2" />
                    </div>

                    <PrimaryButton type="submit" class="mt-4" :disable="commentForm.processing">
                        Add Comment
                    </PrimaryButton>
                </form>

                <ul class="divide-y">
                    <li v-for="comment in comments.data" :key="comment.id" class="px-2 py-4">
                        <Comment :comment="comment" />
                    </li>
                </ul>

                <Pagination :meta="comments.meta" :only="['comments']" />
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed } from 'vue';
import { relativeDate } from '@/Utilities/date';
import Pagination from '@/Components/Pagination.vue';
import Comment from '@/Components/Comment.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps(['post', 'comments'])

const formattedDate = computed(() => relativeDate(props.post.created_at));

const commentForm = useForm({
    body: '',
});

const addComment = () => commentForm.post(route('posts.comments.store', props.post.id), {
    preserveScroll: true,
    onSuccess: () => {
        commentForm.reset();
    },
});

</script>
