let appUrl = document.location.origin

let PassportConfig = {
  clientId: 4,
  clientSecret: 'kXY8PESVRlafJVjDj9xLAVIyFSIQYRos8fPypNRx'
}

let Config = {
  baseUrl: appUrl + '/api/',
  apiTokenLogin: appUrl + '/oauth/token'
}

export {PassportConfig, Config, appUrl}
