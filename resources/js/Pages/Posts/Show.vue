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
                <ul class="divide-y">
                    <li v-for="comment in comments.data" :key="comment.id" class="px-2 py-4">
                        <Comment :comment="comment" />
                    </li>
                </ul>

                <Pagination :meta="comments.meta" />
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

const props = defineProps(['post', 'comments'])

const formattedDate = computed(() => relativeDate(props.post.created_at));

</script>
