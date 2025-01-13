export interface Users {
  id: string
  name: string
  email: string
  created_at: string
  updated_at: string
}

export interface Articles {
  id: string
  admin_id: string
  title: string
  content: string
  image_url: string
  status: string
  created_at: string
}
