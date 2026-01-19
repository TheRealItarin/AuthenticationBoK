import {getBearerToken, getUsername, getServerUrl } from "@/config.js";
async function getDefaultHeaders() {
  return {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${getBearerToken()}`,
    'X-Username': await getUsername(),
  };
}

async function handleResponse(response) {
  let responseData;
  if (!response.ok) {
    try {
      responseData = await response.json();
    } catch (e) {
      console.error('Error parsing JSON:', e);
    }
    const errors = new Error("Something failed");
    errors.details = responseData;
    errors.status = response.status; 
    throw errors;
  }
  return response.json();
}

async function fetchData(endpoint, options = {}) {
  try {
    options.headers = await getDefaultHeaders();
    const serverUrl = await getServerUrl();
    const response = await fetch(`${serverUrl}${endpoint}`, options);
    return await handleResponse(response);
  } catch (error) {
    console.error('Fetch error:', error);
    throw error;
  }
}

async function get(endpoint, options = {}) {
  options.method = 'GET';
  return fetchData(endpoint, options);
}

async function post(endpoint, body, options = {}) {
  options.method = 'POST';
  options.body = JSON.stringify(body);
  return fetchData(endpoint, options);
}

async function put(endpoint, body, options = {}) {
  options.method = 'PUT';
  options.body = JSON.stringify(body);
  return fetchData(endpoint, options);
}

async function patch(endpoint, options = {}) {
  options.method = 'PATCH';
  return fetchData(endpoint, options);
}


export { get, post, put, patch};
