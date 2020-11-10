import {writable} from 'svelte/store';
const axios = require('axios');

export const threads = writable([]);

export const refresh = refreshBoards
// Custom function to perform async request to grab boards list
// When successful, the threads list is updated which should update any subscribed components
async function refreshBoards(board){
    let res = await axios.get("/api/boards/list/?board_slug=" + board);
    let data = res.data;
    console.log("within async", data);
    threads.set(data.data);
    return data;
}