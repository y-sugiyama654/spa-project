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

const updateTask =async ({ id, task }: { id: number, task: Task }) => {
    const { data } = await axios.put<Task>(
        `/api/task/${id}`,
        task
    )
    return data
}

const deleteTask =async (id: number) => {
    const { data } = await axios.delete<Task>(
        `/api/task/${id}`
    )
    return data
}

export {
    getTasks,
    updateDoneTask,
    createTask,
    updateTask,
    deleteTask
}
