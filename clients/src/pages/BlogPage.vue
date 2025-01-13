<script setup lang="ts">
import type { Articles } from 'src/components/models/model'
import { fetchArticle, deleteSelectedArticle } from 'src/service/apiiList'
import { ref, onMounted, computed, defineAsyncComponent } from 'vue'
import type { Ref } from 'vue'

const addBlog = defineAsyncComponent(() => import('components/AddBlog.vue'))
const editBlog = defineAsyncComponent(() => import('components/EditBlog.vue'))
const showAddBlogModal = ref<boolean>(false)
const  showEditBlogModal = ref<boolean>(false)
const articleListData = ref<Articles[]>([])
const isLoading = ref(false)

const selectedId = ref("0");
const selectedData = ref();

const success: Ref<boolean> = ref(false)
const fetchArticleData = async () => {
  isLoading.value = true
  try {
    articleListData.value = await fetchArticle()
  } catch (error) {
    console.error('Error fetching blog sixi:', error)
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  fetchArticleData()
})
const rowsWithIndex = computed(() =>
  articleListData.value.map((row, index) => ({
    ...row,
    index: index + 1,
  })),
)

const columns = [
  { name: 'index', label: '#', field: 'index' },
  { name: 'title', label: 'Title', field: 'title', sortable: true },
  { name: 'content', label: 'Content', field: 'content', sortable: true },
  { name: 'created_at', label: 'Created At', field: 'created_at', sortable: true },
  { name: 'action', label: 'Actions', field: 'action' },
]

const deleteArticle = async (id: string) => {
  try {
    await deleteSelectedArticle(id)
    success.value = true
  } catch (error) {
    console.log(error)
  } finally {
    articleListData.value = articleListData.value.filter((x) => x.id != id)
  }
}

const editArticle = (id: string) => {
  // console.log('Editing article with id:', id)
  showEditBlogModal.value = true
  selectedId.value = id;
  selectedData.value = articleListData.value.filter(x=> x.id == id);
  
}

const showAddModalHandle = () => {
  showAddBlogModal.value = true
}

const handleNewArticle = (article: Articles) => {
  articleListData.value.push(article)
}
</script>

<template>


<!-- selected :{{ selectedData }} -->
  <div>
    <q-table
      style="height: 800px"
      flat
      bordered
      title="Articles"
      :rows="rowsWithIndex"
      :columns="columns"
      row-key="id"
      virtual-scroll
      :rows-per-page-options="[5, 10, 15]"
    >

      <template v-slot:body-cell-index="props">
        {{ props.row.index }}
      </template>
      <template v-slot:body-cell-action="props">
        <q-btn icon="edit" color="primary" size="sm" @click="editArticle(props.row.id)" />
        <q-btn icon="delete" color="red" size="sm" @click="deleteArticle(props.row.id)" />
      </template>
    </q-table>

    <div>
      <q-btn label="Add" color="primary" @click="showAddModalHandle" />

      <add-blog v-model:show-modal="showAddBlogModal" @add:blog="handleNewArticle" />

      <edit-blog v-model:show-modal="showEditBlogModal" :article="selectedData" :selected-id="selectedId" />
    </div>
  </div>

  <q-dialog v-model="success">
    <q-card>
      <q-card-section>
        <div class="text-h6">NOtificatiion</div>
      </q-card-section>

      <q-card-section class="q-pt-none"> Thee data has been deleted succesfully </q-card-section>

      <q-card-actions align="right">
        <q-btn flat label="OK" color="primary" v-close-popup />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>
