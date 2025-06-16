import axios from 'axios'

const baseURL = `${import.meta.env.VITE_API_BASE_URL}/api`

const server = axios.create({
  baseURL,
  timeout: 7500,
  headers: {
    'Content-Type': 'application/json',
  }
});

export default server
