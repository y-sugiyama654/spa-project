import {useQuery} from "react-query"
import * as api from "../api/TaskAPI"

const useTasks = () => {
    return useQuery('tasks', () => api.getTasks())
}

export {
    useTasks
}
