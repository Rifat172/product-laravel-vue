<template>
  <div class="max-w-md mx-auto mt-20 p-6 border rounded shadow">
    <h1 class="text-2xl mb-4">
      Привет, {{ user ? user : 'Гость' }}!
    </h1>
    <p>Добро пожаловать в Inertia приложение.</p>

    <div class="mt-4">
      <!-- Если пользователь авторизован -->
      <button v-if="user" @click="logout" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
        Выйти
      </button>

      <!-- Если гость -->
      <div v-else class="flex gap-3">
        <a href="/register" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Зарегистрироваться
        </a>

        <a href="/login" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
          Войти
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const axios = window.axios

const props = defineProps({
  user: String | null, // user может быть null для гостей
})

const logout = async () => {
  try {
    await axios.post('/logout')
    window.location.href = '/'
  } catch (err) {
    console.error('Ошибка при выходе:', err)
  }
}
</script>
