<script setup lang="ts">
import { ref, computed } from 'vue'
import type { WritableComputedRef } from 'vue'
import { addNewArticle } from 'src/service/apiiList'
import type { Articles } from './models/model'
const title = ref('')
const content = ref('')
const imageUrl = ref('')


const props = defineProps<{
  showModal: boolean
}>()

const emits = defineEmits<{
  (e: 'update:showModal', value: boolean): void
  (e: 'add:blog', value: Articles): void
}>()

const show: WritableComputedRef<boolean> = computed({
  get: () => {
    return props.showModal
  },
  set: (value: boolean) => {
    emits('update:showModal', value)
    // console.log('modal', value)
  },
})


const submitArticle = async () => {

  const newArticle = {
    id:"",
    title: title.value,
    content: content.value,
    image_url: imageUrl.value,
    status : "1",
    admin_id : "1",
    created_at : "",

  }

  try {

    const response = await addNewArticle(newArticle)
    alert("success adding the blog!")
    show.value = false
    title.value = ''
    content.value = ''
    imageUrl.value = ''
    emits('add:blog', newArticle);

  } catch (error) {
    console.error('Error adding article:', error)
    alert('Failed to add article. Please try again.')
  }
}
</script>

<template>
  <q-dialog v-model="show">
    <q-card style="width: 650px; max-width: 80vw">
      <q-card-section class="q-pa-md bg-red">
        <div class="text-h5 text-bold text-white">Insert the data</div>
      </q-card-section>
      <q-card-section>
        <div class="q-pa-md" style="max-width: 600px">
          <q-input
            label="Title"
            stack-label
            dense
            outlined
            color="v6-primary"
            type="text"
            v-model="title"
            :rules="[
              (val) =>
                (val !== undefined && val !== null && val !== '') ||
                'You should input the title before submit the data',
            ]"
          />
        </div>

        <div class="q-pa-md" style="max-width: 650px">
          <q-input
            label="Content"
            stack-label
            dense
            outlined
            color="v6-primary"
            type="textarea"
            v-model="content"
            rows="10"
            :rules="[
              (val) =>
                (val !== undefined && val !== null && val !== '') ||
                'You should input the content before submit the data',
            ]"
          />
        </div>
        <div class="q-pa-md">
          <q-input
            label="image link"
            color="v6-primary"
            dense
            outlined
            stack-label
            v-model="imageUrl"
            type="text"
          />
        </div>
      </q-card-section>

      <q-card-section align="right">
        <q-btn
          class="q-mr-md"
          label="Submit"
          color="red"
          @click="submitArticle"
        />
        <q-btn label="Cancel" @click="show = false" />
      </q-card-section>
    </q-card>
  </q-dialog>
</template>
