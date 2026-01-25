<template>
  <div class="max-w-md mx-auto mt-20 p-6 border rounded shadow">
    <h1 class="text-2xl mb-4">Регистрация</h1>

    <form @submit.prevent="submit">
      <!-- Name -->
      <div class="mb-4">
        <label class="block mb-1">Имя</label>
        <input
          v-model="form.name"
          type="text"
          class="w-full border px-3 py-2 rounded"
        />
        <p v-if="errors.name" class="text-red-500 text-sm">{{ errors.name[0] }}</p>
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label class="block mb-1">Email</label>
        <input
          v-model="form.email"
          type="email"
          class="w-full border px-3 py-2 rounded"
        />
        <p v-if="errors.email" class="text-red-500 text-sm">{{ errors.email[0] }}</p>
      </div>

      <!-- Password -->
      <div class="mb-4">
        <label class="block mb-1">Пароль</label>
        <input
          v-model="form.password"
          type="password"
          class="w-full border px-3 py-2 rounded"
        />
        <p v-if="errors.password" class="text-red-500 text-sm">{{ errors.password[0] }}</p>
      </div>

      <!-- Password Confirmation -->
      <div class="mb-4">
        <label class="block mb-1">Подтверждение пароля</label>
        <input
          v-model="form.password_confirmation"
          type="password"
          class="w-full border px-3 py-2 rounded"
        />
      </div>

      <button
        type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Зарегистрироваться
      </button>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
const axios = window.axios

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const errors = reactive({})

const submit = async () => {
  // Сброс ошибок перед новой отправкой
  Object.keys(errors).forEach(k => delete errors[k])

  try {
    // Получаем CSRF куку перед POST
    await axios.get('/sanctum/csrf-cookie')

    await axios.post('/register', form)
    // После успешной регистрации редирект на логин
    window.location.href = '/login'
  } catch (err) {
    if (err.response && err.response.status === 422) {
      // Laravel Validation Errors
      Object.assign(errors, err.response.data.errors)
    } else {
      console.error('Ошибка при регистрации:', err)
    }
  }
}
</script>
