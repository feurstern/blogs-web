import apiClient from './apiService'
import type { Users, Articles } from 'src/components/models/model'

export const fetchUsers = async (): Promise<Users[]> => {
  const res = await apiClient.get('/users')
  return res.data
}

export const fetchArticle = async (): Promise<Articles[]> => {
  const res = await apiClient.get('/article/list')
  return res.data
}

export const addNewArticle = async (newArticle: Articles): Promise<Articles> => {
  const res = await apiClient.post<Articles>('/article/create', newArticle)
  return res.data
}

export const editSelectedArticle = async (newArticle: Articles, id :string): Promise<Articles> => {
  const res = await apiClient.post<Articles>(`/article/edit/${id}`, newArticle)
  return res.data
}

export const deleteSelectedArticle = async (id: string): Promise<Articles> => {
  const res = await apiClient.get(`article/delete/${id}`)
  return res.data
}
