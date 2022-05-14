import axios from "axios";

const instance =  axios.create({
    baseURL: "http://www.racsstudios.com/api/v1"
});

export default instance;