<template>
  <h1>Привет, {{ user }}!</h1>
  <p>Добро пожаловать в Inertia приложение.</p>
</template>

<script setup>
defineProps({ user: String })
</script>