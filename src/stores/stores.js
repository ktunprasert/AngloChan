import {writable} from 'svelte/store';
const axios = require('axios');

export const threads = writable({data: []});
export const boards = writable({data: []});

// Async Function to deal with global variables
export const refresh_boards = refreshBoards;
export const refresh_threads = refreshThreads;
// Custom function to perform async request to grab boards list
// When successful, the threads list is updated which should update any subscribed components
async function refreshThreads(board){
    let res = await axios.get("/api/boards/list/?board_slug=" + board);
    let data = res.data;
    console.log("within async", data);
    threads.set(data);
    return data;
}

async function refreshBoards(){
    let res = await axios.get("/api/boards");
    let data = res.data;
    console.log("boards grabbed", data);
    boards.set(data);
    return data;
}