# Overview

---

- [Presentation](#section-1)
- [Requirements](#section-2)


<a name="section-1"></a>
## Presentation

The current project is a proof of work for `Laravel` and `VueJS`

This a clean installation of `Laravel 8.x` and `Vue 2.x`, adding `Bootstrap 4` to styling, the current desing uses only Bootstrap classes to style.

No aditional CSS is used in this project.

The GIT repository contains the full project with Laravel, this to allow quickly installation anywhere.

The project is intended to prevent user mistakes when uploading images, for example:
- Prevent the Upload Button to be clicked when no file has been selected.
- Prevent click the Upload Button and Select Input when another file its been uploading.
- Max file size added to prevent server errors.
- Image mime type validation both in frontend and backend added.
- Multiple error reponses depending on external API response.
- Alert message added on empty image list to invite user to upload something.
- The progress bar could hide after a period of time, however is intended to stay to prevent confusion to the user.

Note: The project requires only PNG to be returned, and the current API always returns PNG images, so no aditional validation was added.

<a name="section-2"></a>
## Project Requirements

####Upload and Display Images
Your task is to create a web page that allows users to upload images and then display them to the user. However because space is limited on your web server you will need to store the images in a remote image hosting service. The end-point for the service is:

```text
https://test.rxflodev.com
```
The image must be base64 encoded and posted to the end-point in the following format:

```text
imageData=base64-encoded-image-data
```

After receiving an image successfully the image service will return a json encoded result in the following format:
```json
{"status":"success","message":"Image saved successfully.","url":"https://test.rxflodev.com/image-store/55c4d2369010c.png"}
```

The image must then be displayed on the web page using the url from the result.

---
#### Requirements and Specifications
---
##### [BACKEND]

- Create an API endpoint on the backend to transfer the image to storage service.
- Images must be stored in the remote image service, not on your web server.
- The most recent image should be displayed first.
- Images must be in png format.
- For simplicity you may use the session for long term storage.

---
##### [FRONTEND]

- The most recent uploaded image should be displayed first.
- Uploaded images must be in png format.
- The user should be able to upload multiple images.
- A pure ajax solution is preferred (ie no page refresh).
- Progress bar and other user feedback such as error / success feedback are a plus.