<template>
    <article class="p-6 text-base rounded-lg dark:bg-gray-900">
        <footer class="flex justify-between items-center mb-2">
            <div class="flex items-center">
                <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                    <img class="mr-2 w-6 h-6 rounded-full" :src="comment.user.profile_photo_url" :alt="comment.user.name">
                    {{ comment.user.name }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <time pubdate :datetime="comment.created_at" title="February 8th, 2022">
                        {{ relativeDate(comment.created_at) }}
                    </time>
                </p>
            </div>
            <div class="mt-1 flex justify-end space-x-3 empty:hidden">
                <form v-if="comment.can?.update" @submit.prevent="emit('edit', comment.id)">
                    <button type="submit" class="font-mono text-sky-700 text-sm hover:font-bold">
                        Edit
                    </button>
                </form>
                <form v-if="comment.can?.delete" @submit.prevent="emit('delete', comment.id)">
                    <button type="submit" class="font-mono text-red-700 text-sm hover:font-bold">
                        Delete
                    </button>
                </form>
            </div>
        </footer>
        <p class="text-gray-500 dark:text-gray-400 break-all">
            {{ comment.body }}
        </p>
    </article>
</template>

<script setup>
import { relativeDate } from '@/Utilities/date';

const props = defineProps(['comment']);

const emit = defineEmits(['delete', 'update']);
</script>
