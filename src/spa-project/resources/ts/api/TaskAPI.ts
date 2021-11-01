import axios from "axios";
import {Task} from "../types/Task";

const getTasks =async () => {
    const { data } = await axios.get<Task[]>('api/task')
    return data
}

const updateDoneTask =async ({ id, is_done }: Task) => {
    const { data } = await axios.patch<Task>(
        `/api/task/update-done/${id}`,
        { is_done: !is_done}
        )
    return data
}

const createTask =async (title: string) => {
    const { data } = await axios.post<Task>(
        `/api/task`,
        { title: title}
    )
    return data
}

export {
    getTasks,
    updateDoneTask,
    createTask
}
