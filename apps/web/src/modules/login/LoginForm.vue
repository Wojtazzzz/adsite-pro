<script setup lang="ts">

import Button from "@/components/ui/Button.vue";
import Field from "@/components/ui/form/Field.vue";
import Form from "@/components/ui/form/Form.vue";
import * as z from "zod";
import {toast} from "@/components/ui-library/toast";
import {h} from "vue";

const schema = z.object({
  email: z.string({
    message: 'This field is required.'
  }).email('Invalid email adress.'),
  password: z.string({
    message:'This field is required.'
  })
})

const onSubmit = (values: z.infer<typeof schema>) => {
  toast({
    title: 'You submitted the following values:',
    description: h(
      'pre',
      { class: 'mt-2 w-[340px] rounded-md bg-slate-950 p-4' },
      h('code', { class: 'text-white' }, JSON.stringify(values, null, 2))
    )
  })
}
</script>

<template>
  <Form :schema="schema" :on-submit="onSubmit">
    <div class="space-y-6">
      <Field
          type="email"
          name="email"
          label="E-mail"
          placeholder="john.smith@gmail.com"
      />
      <Field type="password" name="password" label="Password" placeholder="********" />

      <div class="flex justify-end">
        <Button type="submit">Login</Button>
      </div>
    </div>
  </Form>
</template>