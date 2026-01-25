<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { usePage } from '@inertiajs/vue3'

const product = ref(null)
const page = usePage()
const id = page.url.split('/').pop()

onMounted(async () => {
  const { data } = await axios.get(`/api/products/${id}`)
  product.value = data
})
</script>

<template>
  <div class="max-w-xl mx-auto p-6" v-if="product">
    <h1 class="text-3xl font-bold">{{ product.name }}</h1>
    <p class="text-gray-500">{{ product.category.name }}</p>
    <p class="text-xl mt-2">Цена: {{ product.price }} ₽</p>

    <p class="mt-4">{{ product.description }}</p>

    <a href="/main" class="text-blue-500 mt-4 inline-block">← Назад</a>
  </div>
</template>
