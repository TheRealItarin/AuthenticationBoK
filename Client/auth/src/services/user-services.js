import { post, get } from "./util/api-methods";

async function register(username, password) {
  return await post("/register", { username, password });
}

async function login(username, password) {
  const response = await post("/login", { username, password });
  if (response.token) {
    localStorage.setItem("token", response.token);
    return response;
  }
}

async function logout(username) {
  try {
    await post("/logout", {username});
    localStorage.removeItem('token');
    localStorage.removeItem('userRole');
    localStorage.removeItem('username');
    console.log("User logged out");
  } catch (error) {
    console.error(error);
  }
}

async function health(params) {
  return await get("/health", params);
}

export { login, register, health, logout };