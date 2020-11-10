# Version Changes of AngloChan

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
