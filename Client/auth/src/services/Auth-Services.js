import {getBearerToken, getServerUrl } from "@/config.js";
async function isUserLoggedIn() {
  const serverUrl = getServerUrl();
  const response = await fetch(`${serverUrl}/check-user-status`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${getBearerToken()}`
    }
  });
  return response.ok;
}


export { isUserLoggedIn };
