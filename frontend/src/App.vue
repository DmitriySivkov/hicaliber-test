<script setup>
import { ref, onMounted } from "vue"
import { api } from "src/plugins/axios.js"
import { ElNotification } from 'element-plus'

const defaultForm = {
  name: '',
  price: [100000, 900000],
  bedrooms: null,
  bathrooms: null,
  storeys: null,
  garages: null,
}

const form = ref({...defaultForm})

const bedroomOptions = [1,2,3,4,5]
const bathroomOptions = [1,2,3]
const storeyOptions = [1,2]
const garageOptions = [1,2,3]

const propertiesData = ref([])

const isLoading = ref(true)

const search = () => {
  isLoading.value = true
  fetchProperties()
}

const reset = () => {
  form.value = {...defaultForm}

  isLoading.value = true
  fetchProperties()
}

const fetchProperties = () => {
  const promise = api.get("search/properties", {
    params: form.value
  })

  promise.then((response) => {
    propertiesData.value = response.data
  })

  promise.catch((error) => {
    showError(error.response.data)
  })

  promise.finally(() =>
      isLoading.value = false
  )
}

const showError = (message) => {
  ElNotification({
    title: 'Error',
    message,
    type: 'error',
  })
}

onMounted(() => {
  fetchProperties()
})
</script>

<template>
  <el-row justify="center">
    <el-col :span="18">
      <el-row :gutter="20">
        <el-col :span="8">
          <el-card>
            <el-form :model="form" label-width="120px">
              <el-form-item label="Name">
                <el-input
                    v-model="form.name"
                    placeholder="Start typing property's name"
                    clearable
                />
              </el-form-item>
              <el-form-item label="Price">
                <el-slider
                    v-model="form.price"
                    range
                    :max="1000000"
                />
              </el-form-item>
              <el-form-item label="Bedrooms">
                <el-select
                    v-model="form.bedrooms"
                    placeholder="Select bedroom amount"
                    clearable
                >
                  <el-option
                      v-for="option in bedroomOptions"
                      :key="option"
                      :label="option"
                      :value="option"
                      clearable
                  />
                </el-select>
              </el-form-item>
              <el-form-item label="Bathrooms">
                <el-select
                    v-model="form.bathrooms"
                    placeholder="Select bathroom amount"
                    clearable
                >
                  <el-option
                      v-for="option in bathroomOptions"
                      :key="option"
                      :label="option"
                      :value="option"
                      clearable
                  />
                </el-select>
              </el-form-item>
              <el-form-item label="Storeys">
                <el-select
                    v-model="form.storeys"
                    placeholder="Select storey amount"
                    clearable
                >
                  <el-option
                      v-for="option in storeyOptions"
                      :key="option"
                      :label="option"
                      :value="option"
                      clearable
                  />
                </el-select>
              </el-form-item>
              <el-form-item label="Garages">
                <el-select
                    v-model="form.garages"
                    placeholder="Select garage amount"
                    clearable
                >
                  <el-option
                      v-for="option in garageOptions"
                      :key="option"
                      :label="option"
                      :value="option"
                  />
                </el-select>
              </el-form-item>
              <el-form-item>
                <el-button
                    type="primary"
                    @click="search"
                    :loading="isLoading"
                >
                  Find
                </el-button>
                <el-button
                    @click="reset"
                >
                  Reset
                </el-button>
              </el-form-item>
            </el-form>
          </el-card>
        </el-col>
        <el-col :span="16">
          <el-card style="height:100%">
            <el-table
                :data="propertiesData"
                stripe
                scrollbar-always-on
                style="width: 100%; height: 300px"
              >
              <template #default>
                <el-table-column v-for="prop in Object.keys(defaultForm)" :prop="prop" :label="prop" />
              </template>
              <template #empty>
                <span v-if="!isLoading && !propertiesData.length">No properties found</span>
                <span v-if="isLoading">Looking for properties ...</span>
              </template>
            </el-table>
          </el-card>
        </el-col>
      </el-row>
    </el-col>
  </el-row>
</template>

<style scoped>
.el-select {
  width: 100%
}
</style>
