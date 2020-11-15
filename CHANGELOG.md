# Version Changes of AngloChan

## [0.9.0]

### **Svelte**

-   Lifecycle method changes on Boards list, when switching board the threads list is set to empty
-   Hotfix - When adding new thread(s) to a board the status message is changed to trigger a conditional render `message = empty` -> `message = ok`
-   Changed boards list to be a global variable provided by the store, subscribed by Nav and Homepage (Prevents 'async' rendering)
-   Adjusted components to be within the boards.index page rather than the boards.\_layout, the latter enforces inheritance which is unintended

## [0.8.0]

### **Svelte**

-   Threads now include images
-   Image upload is required
-   Threads list extra lifecycle based on response statuses [ok, empty, error]

### **Laravel**

-   Now support uploading/adding files
-   Migration changes
-   When clearing Uploads Model migration, the uploaded files will be cleared

## [0.7.3]

### **Svelte**

-   Fixed reference error within Stores regarding threads/boards reference
-   Clear form inputs after a successful request

### **Laravel**

-   Removed Threads and Threads controller, threads should be counted as "special post" instead to keep ID reference
-   Adjusted Posts Model to better reflect "thread" functionality

## [0.7.2]

### **Svelte**

-   Hotfix - When navigating away from the list of threads, the store is set to empty list

## [0.7.1]

### **Svelte**

-   Hotfix - Changing board view didn't correctly update thread due to unchanging variable in the life cycle - this will now follow the routify variable

## [0.7.0]

### **Svelte**

-   You can now add threads!
-   Added global store for a list of threads
-   Added a new `AddThread.svelte` component
-   Fully implemented the abiliity to post mixed-content requests (JSON + file-blob) to `/api/threads`
-   Adjusted board components layout
-   Added FontAwesome

### **Laravel**

-   Created ThreadsController@store to support POST request with validation
-   Added FontAwesome CDN to `views.layouts.app`

## [0.6.0]

### **Svelte**

-   Added Nav component
-   Added content on index page and single board view page

## [0.5.0]

-   Added Boards view and Thread view layout structure
-   Restructure threads listing to be part of BoardsController

## [0.4.0]

-   Added API Routes for Boards and Threads
-   Added Controllers for Boards and Threads
-   Added URL catching to all resolve to Svelte application

## [0.3.0]

-   Modified migration models to be nullable
-   Setting up Routify
-   Changed location of JavaScript file to support Routify
-   Modified package.json to support Routify

## [0.2.0]

-   Added Models and Migration files for [Board, Thread, Post, Upload]

## [0.1.0]

-   Initialised Repo with Svelte and Laravel
