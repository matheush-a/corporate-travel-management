FROM node:20

# Set working directory
WORKDIR /app

# Copy package.json and install deps first (better caching)
COPY package*.json ./
RUN npm install vite && npm install

# Copy remaining source files
COPY . .

# Expose Vite dev server port
EXPOSE 5173

# Start Vite dev server
CMD ["npm", "run", "dev"]
