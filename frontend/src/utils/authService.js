
const KEY_FOR_TOKEN = 'RNBj6SdRylyGssMk7dEYyUfRR2JPF2BU';
const localStorage = window.localStorage;


export function saveToken(value) {
  localStorage.setItem(KEY_FOR_TOKEN, JSON.stringify(value))
}

export function getToken() {
  return JSON.parse(localStorage.getItem(KEY_FOR_TOKEN))
}

export function removeToken() {
  return !!localStorage.removeItem(KEY_FOR_TOKEN)
}

export function signOut() {
  return removeToken();
}

export function isLogin() {
  return !!JSON.parse(localStorage.getItem(KEY_FOR_TOKEN))
}