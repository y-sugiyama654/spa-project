import React from "react";
import {useTasks} from "../../../queries/TaskQuery";
import TaskItem from "./TaskItem";

const TaskList: React.VFC = () => {

    const { data:tasks, status } = useTasks()

    if ( status === 'loading' ) {
        return <div className={"loader"} />
    } else if ( status === 'error' ) {
        return <div className="align-center" >データの読み込みに失敗しました。</div>
    } else if ( !tasks || tasks.length <= 0 ) {
        return <div className="align-center" >登録されたTODOはありません。</div>
    }

    return (
        <>
            <div className="inner">
                <ul className="task-list">
                    {tasks.map(task => (
                        <TaskItem key={task.id} task={task} />
                        // <li key={task.id}>
                        //     <label className="checkbox-label">
                        //         <input type="checkbox" className="checkbox-input"/>
                        //     </label>
                        //     <div><span>{task.title}</span></div>
                        //     <button className="btn is-delete">削除</button>
                        // </li>
                    ))}
                </ul>
            </div>
        </>
    )
}

export default TaskList

