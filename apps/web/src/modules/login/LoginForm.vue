<script setup lang="ts">
import Button from '@/components/ui/Button.vue'
import Field from '@/components/ui/form/Field.vue'
import Form from '@/components/ui/form/Form.vue'
import Alert from '@/components/ui/Alert.vue'
import * as z from 'zod'
import { useLogin } from '@/modules/login/useLogin'

const schema = z.object({
  email: z
    .string({
      message: 'This field is required.'
    })
    .email('Invalid email adress.'),
  password: z.string({
    message: 'This field is required.'
  })
})

const { isError, error, login, data } = useLogin()

const onSubmit = (values: z.infer<typeof schema>) => {
  login(values)
}
</script>

<template>
  <Form :schema="schema" :on-submit="onSubmit">
    <div class="space-y-6">
      <Alert v-show="isError" :content="error?.response.data.message" />
      <Field type="email" name="email" label="E-mail" placeholder="john.smith@gmail.com" />
      <Field type="password" name="password" label="Password" placeholder="********" />

      <div class="flex justify-end">
        <Button type="submit">Login</Button>
      </div>
    </div>
  </Form>
</template>
