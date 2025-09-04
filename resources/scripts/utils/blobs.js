/**
 * More info
 * https://azure.github.io/azure-storage-node/BlobService.html
 */

const storageAccount = 'https://sacuksprodnrdigital0001.blob.core.windows.net'

function getFileType(str) {
  if ( str.includes('.') ) {
    let type = str.split('.')

    return type[type.length - 1].toLowerCase()
  }

  return 'unknown'
}

function getFileName(str) {
  let name = str.split('/')

  return name[name.length - 1]
}

function getFolderName(str) {
  let name = str.split('/')

  return name[name.length - 2]
}

function bytesToSize(bytes) {
   let sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Byte';
   let i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

function getFiles(results, folder) {
  let files = []

  let url = `${storageAccount}/${folder}/`;

  for (let i = 0; i < results.entries.length; i++) {
    files.push({
      name: getFileName(results.entries[i].name),
      fullName: results.entries[i].name,
      type: getFileType(results.entries[i].name),
      path: url + results.entries[i].name,
      size: bytesToSize(results.entries[i].contentLength),
    })
  }

  return files
}

/**
 * get folders from a prefix
 * @param  {object} response
 * @return {array}
 */
function getFolders(response) {
  let data = response.body.EnumerationResults.Blobs.BlobPrefix
  let folders = []

  // if there are no folders (BlobPrefix) return an empty array
  if (!data) {
    return folders
  }

  if (Array.isArray(data)) {
    for (var i = 0; i < data.length; i++) {
      folders.push({
        name: getFolderName(data[i].Name),
        fullName: data[i].Name,
        type: 'folder',
        path: data[i].Name,
      })
    }

    return folders
  }

  // if there is only one folder, data contains an object isntead of an array with one object
  folders.push({
    name: getFolderName(data.Name),
    fullName: data.Name,
    type: 'folder',
    path: data.Name,
  })

  return folders
}

function getList(results, response, containerBlob) {
  return getFolders(response).concat(getFiles(results, containerBlob))
}

function checkName(name, str) {
  let pattern = str.split("").map((x)=>{
      return `(?=.*${x})`
  }).join("")

  var regex = new RegExp(`${pattern}`, "g")
  return name.match(regex);
}

export default {
  getFiles: getFiles,
  getFolders: getFolders,
  getList: getList,
  getFileType: getFileType,
  getFileName: getFileName,
  getFolderName: getFolderName,
  checkName: checkName,
  storageAccount: storageAccount
}
