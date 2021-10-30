import axios from "axios";
import {Task} from "../types/Task";

const getTasks =async () => {
    const {data} = await axios.get<Task[]>('api/task')
    return data
}

export {
    getTasks
}
