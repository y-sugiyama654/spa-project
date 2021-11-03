import React, { useEffect } from 'react'
import {
    BrowserRouter,
    Switch,
    Route,
    Link,
    RouteProps,
    Redirect
} from "react-router-dom";
import TaskPage from "./pages/tasks/index"
import LoginPage from "./pages/login/index"
import HelpPage from "./pages/help/index"
import { useLogout, useUser } from "./queries/AuthQuery";
import { useAuth } from "./hooks/AuthContext"
import NotFoundPage from "./pages/error";

const Router = () => {
    const logout = useLogout()
    const { isAuth, setIsAuth } = useAuth()
    const { isLoading, data: authUser } = useUser()

    useEffect(() => {
        if (authUser) {
            setIsAuth(true)
        }
    }, [authUser])

    const GardRoute = (props: RouteProps) => {
        if (!isAuth) return <Redirect to={"/login"} />
        return <Route {...props} />
    }

    const LoginRoute = (props: RouteProps) => {
        if (isAuth) return <Redirect to={"/"} />
        return <Route {...props} />
    }

    const navigation = (
        <header className="global-head">
            <ul>
                <li><Link to="/">ホーム</Link></li>
                <li><Link to="/help">ヘルプ</Link></li>
                <li onClick={() => logout.mutate()}><span>ログアウト</span></li>
            </ul>
        </header>
    )

    const loginNavigation = (
        <header className="global-head">
            <ul>
                <li><Link to="/help">ヘルプ</Link></li>
                <li><Link to="/login">ログイン</Link></li>
            </ul>
        </header>
    )

    if (isLoading) return <div className={"loader"}></div>

    return (
        <BrowserRouter>
            { isAuth ? navigation : loginNavigation }
            <Switch>
                <Route path="/help">
                    <HelpPage />
                </Route>
                <LoginRoute path="/login">
                    <LoginPage />
                </LoginRoute>
                <GardRoute exact path="/">
                    <TaskPage />
                </GardRoute>
                <Route component={NotFoundPage} />
            </Switch>
        </BrowserRouter>
    );
}

export default Router
