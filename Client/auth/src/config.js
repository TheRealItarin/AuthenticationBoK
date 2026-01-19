async function getServerUrl() {
  return localHttpServer;
}

const localHttpServer = 'http://backendtest.test/api';

const DEFAULT_TOKEN = 'hihihihi';

function getBearerToken() {
  return localStorage.getItem('token') ? localStorage.getItem('token') : DEFAULT_TOKEN;
}

async function getUsername() {
  return localStorage.getItem('username');
}

export { localHttpServer, getBearerToken, getUsername, getServerUrl };
