<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

const products = ref(null)
const categories = ref([])
const selectedCategory = ref('')
const loading = ref(false)

const fetchProducts = async (page = 1) => {
  loading.value = true

  const { data } = await axios.get('/api/products', {
    params: {
      category: selectedCategory.value,
      page,
    },
  })

  products.value = data
  loading.value = false
}

const fetchCategories = async () => {
  const { data } = await axios.get('/api/categories')
  categories.value = data
}

watch(selectedCategory, () => {
  fetchProducts()
})

onMounted(() => {
  fetchProducts()
  fetchCategories()
})
</script>

<template>
  <div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl mb-4">Каталог товаров</h1>

    <!-- Фильтр -->
    <select v-model="selectedCategory" class="border p-2 mb-4">
      <option value="">Все категории</option>
      <option v-for="cat in categories" :key="cat.id" :value="cat.id">
        {{ cat.name }}
      </option>
    </select>

    <!-- Загрузка -->
    <div v-if="loading">Загрузка...</div>

    <!-- Товары -->
    <div
      v-for="product in products?.data"
      :key="product.id"
      class="border p-4 mb-3 rounded"
    >
      <h2 class="text-xl font-bold">{{ product.name }}</h2>
      <p>Категория: {{ product.category.name }}</p>
      <p>Цена: {{ product.price }} ₽</p>
      <p>{{ product.description }}</p>

      <a :href="`/product/${product.id}`" class="text-blue-500">
        Подробнее
      </a>
    </div>

    <!-- Пагинация -->
    <div class="flex gap-2 mt-4" v-if="products">
      <button
        v-for="link in products.links"
        :key="link.label"
        :disabled="!link.url"
        v-html="link.label"
        class="px-3 py-1 border rounded"
        @click="fetchProducts(getPage(link.url))"
      />
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    getPage(url) {
      if (!url) return
      return new URL(url).searchParams.get('page')
    },
  },
}
</script>
