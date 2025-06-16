import server from '@/api/server';

const authService = {
  login: async (formData) => {
    const response = server.post('/login', {
      email: formData.email,
      password: formData.password
    })

    return response;
  },
  register: async (formData) => {
    const response = server.post('/register', {
      email: formData.email,
      password: formData.password,
      name: formData.name
    })
    
    return response;
  },
}

export default authService;
