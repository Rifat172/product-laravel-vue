<template>
  <div class="max-w-md mx-auto mt-20 p-6 border rounded shadow">
    <h1 class="text-2xl mb-4">Вход в систему</h1>

    <form @submit.prevent="login">
      <div class="mb-4">
        <label class="block mb-1">Email</label>
        <input v-model="email" type="email" class="w-full border p-2 rounded" placeholder="Введите email" />
      </div>

      <div class="mb-4">
        <label class="block mb-1">Пароль</label>
        <input v-model="password" type="password" class="w-full border p-2 rounded" placeholder="Введите пароль" />
      </div>

      <p v-if="error" class="text-red-500 mb-4">{{ error }}</p>

      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Войти
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
const axios = window.axios

const email = ref('')
const password = ref('')
const error = ref('')

const login = async () => {
  try {
    await axios.get('/sanctum/csrf-cookie')
    await axios.post('/login', {
      email: email.value,
      password: password.value,
    })

    // Просто редирект на главную через window.location
    window.location.href = '/'
  } catch (err) {
    error.value = 'Неверный email или пароль'
    console.error(err)
  }
}
</script>
